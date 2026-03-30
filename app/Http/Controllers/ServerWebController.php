<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Server;
use App\Models\Protocol;
use App\Models\Method;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class ServerWebController extends Controller
{


   public function store(Request $request) // handle form submit
    {
        // Log::info('Attempting to create server', ['user_id' => Auth::id(), 'request_data' => $request->all()]);
            $request->validate([
            'name'        => 'required|string|max:255',
            'url'         => 'required|string|max:255',
            'protocol_id' => 'required|exists:protocols,id',
            'method'      => 'required|exists:methods,name',
            'description' => 'nullable|string',
            'ip_address'  => 'required|ip',
            'username'    => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    $protocol = \App\Models\Protocol::find($request->protocol_id);
                    if ($protocol && in_array(strtoupper($protocol->protocol), ['FTP', 'SSH']) && empty($value)) {
                        $fail('The username is required for FTP or SSH protocols.');
                    }
                }
            ],
            'password' => [
                'nullable',
                'string'  ,
                'max:255' ,
                function ($attribute, $value, $fail) use ($request) {
                    $protocol = \App\Models\Protocol::find($request->protocol_id);
                    if ($protocol && in_array(strtoupper($protocol->protocol), ['FTP', 'SSH']) && empty($value)) {
                        $fail('The password is required for FTP or SSH protocols.');
                    }
                }
            ],
            'port'    => 'nullable|integer|min:1|max:65535',
            'config'  => 'nullable|json',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $userId = Auth::id();

        $password = $request->input('password');

        if ($password === '123456789') {
            $password = null;
        }



        $request->merge([
            'user_id' => $userId ,
            'password' => $password,
        ]);

    
        Server::create($request->all());

        return redirect()->route('create-server')->with('success', 'Server added successfully!');
    }


     public function update(Server $server)
    {
         $protocols = Protocol::where('is_active', 1)->get();
         $methods   = Method::all();
         return view('edit-server', compact('server', 'protocols', 'methods'));
     }


     public function save(Request $request, Server $server)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'url'         => 'required|string|max:255',
            'protocol_id' => 'required|exists:protocols,id',
            'method'      => 'required|exists:methods,name',
            'description' => 'nullable|string',
            'ip_address'  => 'required|ip',
            'username'    => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    $protocol = \App\Models\Protocol::find($request->protocol_id);
                    if ($protocol && in_array(strtoupper($protocol->protocol), ['FTP', 'SSH']) && empty($value)) {
                        $fail('The username is required for FTP or SSH protocols.');
                    }
                }
            ],
            'password' => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    $protocol = \App\Models\Protocol::find($request->protocol_id);
                    if ($protocol && in_array(strtoupper($protocol->protocol), ['FTP', 'SSH']) && empty($value)) {
                        $fail('The password is required for FTP or SSH protocols.');
                    }
                }
            ],
            'port' => 'nullable|integer|min:1|max:65535',
            'config' => 'nullable|json',
        ]);

        $userId = Auth::id();

        $password = $request->input('password');

        if ($password === '123456789') {
            $password = null;
        }



        $request->merge([
            'user_id' => $userId  ,
            'password' => $password,
        ]);



        $server->update($request->all());

        return redirect()->route('servers.edit', $server )->with('success', 'Server updated successfully!');
    }


    public function destroy(Server $server)
    {
        $server->delete();

        return redirect()
            ->route('update-server')
            ->with('success', 'Server deleted successfully!');
    }




   public function search(Request $request)
{
    $query = $request->input('query');

    $servers = Server::query();

    // If query is numeric, search ID exactly
    if (is_numeric($query)) {
        $servers = $servers->where('id', $query)
            ->orWhere('name', 'like', "%{$query}%")
            ->orWhere('ip_address', 'like', "%{$query}%")
            ->orWhere('port', $query) // exact match for port
            ->orWhere('method', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%");
    } else {
        // Non-numeric query, search everything except ID/port exact
        $servers = $servers->where('name', 'like', "%{$query}%")
            ->orWhere('ip_address', 'like', "%{$query}%")
            ->orWhere('method', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%");
    }

    $servers = $servers->latest()->get();

    return view('update-server', compact('servers'));
}

}
