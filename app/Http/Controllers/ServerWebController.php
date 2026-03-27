<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Server;
use App\Models\Protocol;
use App\Models\Method;
use Illuminate\Support\Facades\Auth;

class ServerWebController extends Controller
{


   public function store(Request $request) // handle form submit
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
            'protocol_id' => 'required|exists:protocols,id',
            'method' => 'required|exists:methods,name',
            'description' => 'nullable|string',
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

}
