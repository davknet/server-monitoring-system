<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Server;
use App\Models\Protocol;
use App\Models\Method;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ServerWebController extends Controller
{


   public function store(Request $request) // handle form submit
    {
        Log::info('Attempting to create server', ['user_id' => Auth::id(), 'request_data' => $request->all()]);
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'protocol_id' => 'required|exists:protocols,id',
            'method' => 'required|exists:methods,name',
            'description' => 'nullable|string',
            'ip_address' => 'required|ip',
            'port' => 'nullable|integer|min:1|max:65535',
            'config' => 'nullable|json',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $userId = Auth::id();

        $request->merge([
            'user_id' => $userId  ,
        ]);

        Server::create($request->all());

        return redirect()->route('create-server')->with('success', 'Server added successfully!');
    }


     public function update(Server $server)
    {
         $protocols = Protocol::where('is_active', 1)->get();
         $methods  = Method::all();
         Log::info('Editing server', ['user_id' => Auth::id(), 'server_id' => $server->all]);
         return view('edit-server', compact('server', 'protocols', 'methods'));
     }


     public function save(Request $request, Server $server)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'protocol_id' => 'required|exists:protocols,id',
            'method' => 'required|exists:methods,name',
            'description' => 'nullable|string',
            'ip_address' => 'required|ip',
            'port' => 'nullable|integer|min:1|max:65535',
            'config' => 'nullable|json',
        ]);

        $userId = Auth::id();
            // Log::info('Updating server', ['user_id' => $userId, 'server_id' => $server->id, 'request_data' => $request->all()]);
        $request->merge([
            'user_id' => $userId  ,
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

}
