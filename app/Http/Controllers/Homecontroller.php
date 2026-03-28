<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Health\Cls\HTTPConnector;
use App\Health\Cls\HTTPSConnector;
use App\Health\Cls\FTPConnector;
use App\Health\Cls\SSHConnector;
use App\Health\Factory\HealthCheckFactory;
use App\Models\RequestTestModel;

class Homecontroller extends Controller
{
   public function index()
    {
        return view('home');
    }


    public function serverTests()
    {
        $tests = RequestTestModel::with('server') // eager load server info
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($test) {
                return [
                    'server_name' => $test->server->name,
                    'server_ip'   => $test->server->ip_address,
                    'status'      => $test->status,
                    'message'     => $test->message,
                    'tested_at'   => $test->created_at->format('Y-m-d H:i:s'),
                ];
            });
        return response()->json($tests);
    }
}
