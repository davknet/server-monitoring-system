<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Server;
use App\Http\Resources\ServerResource;
use App\Http\Requests\StoreServerRequest;
use App\Http\Requests\UpdateServerRequest;

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
        $server = Server::create($request->validated());

        return new ServerResource($server);
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
    public function update(UpdateServerRequest $request, Server $server)
    {
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
