<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Health\Cls\HTTPConnector;
use App\Health\Cls\HTTPSConnector;
use App\Health\Cls\FTPConnector;
use App\Health\Cls\SSHConnector;
use App\Health\Factory\HealthCheckFactory;
use App\Models\RequestTestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Homecontroller extends Controller
{
   public function index()
    {
        return view('home');
    }


        public function serverTests(Request $request)
    {
        $tests = RequestTestModel::with('server')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Transform each item
        $tests->getCollection()->transform(function ($test) {
            return [
                'server_name' => $test->server->name,
                'server_ip'   => $test->server->ip_address,
                'status'      => $test->status,
                'message'     => $test->message,
                'tested_at'   => $test->created_at->format('Y-m-d H:i:s'),
            ];
        });

        

        return response()->json([
            'data'         => $tests->items(),
            'current_page' => $tests->currentPage(),
            'last_page'    => $tests->lastPage(),
            'per_page'     => $tests->perPage(),
            'total'        => $tests->total(),
        ]);
    }
}
