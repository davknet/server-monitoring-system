<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Server;
use App\Http\Resources\ServerResource;
use App\Http\Requests\StoreServerRequest;
use App\Http\Requests\UpdateServerRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return ServerResource::collection(Server::latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
     // POST /servers
    public function store(StoreServerRequest $request)
{
    // 1. Get the validated data from the StoreServerRequest class
    $data = $request->validated();

    // 2. Handle the password logic
    $password = $request->input('password');
    if ($password === '123456789') {
        $password = null;
    }

    // 3. Create the server using the authenticated user ID
    $server = Server::create([
        'name'        => $data['name'],
        'url'         => $data['url'],
        'protocol_id' => $data['protocol_id'],
        'description' => $data['description'] ?? null,
        'config'      => $data['config'] ?? null,
        'ip_address'  => $request->input('ip_address'),
        'port'        => $request->input('port'),
        'method'      => $request->input('method'),
        'user_name'   => $request->input('user_name'),
        'password'    => $password,
        'user_id'     => Auth::id(),
    ]);

    // 4. Return JSON (Never use redirect() in an API)
    return response()->json([
        'message' => 'Server added successfully!',
        'data'    => new ServerResource($server)
    ], 201);
}





    /**
     * Display the specified resource.
     */
   // GET /servers/{id}
    public function show(Server $server)
    {
        return new ServerResource($server);
    }

    /**
     * Update the specified resource in storage.
     */
     // PUT /servers/{id}
// ServerController.php
        public function update(UpdateServerRequest $request, $id) // Use $id instead of Server $server
        {
            $server = Server::findOrFail($id); // Manually find the server

            $server->update($request->validated());

            return new ServerResource($server);
        }


    /**
     * Remove the specified resource from storage.
     */

    /* DELETE /servers/{id} */
    public function destroy(Server $server)
    {
        $server->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
