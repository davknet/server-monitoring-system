<?php

namespace App\Http\Controllers;

use App\Health\Cls\FTPConnector;
use App\Health\Cls\HttPSConnector;
use Illuminate\Http\Request;
use App\Health\Cls\HTTPConnector;
use App\Health\Cls\SSHConnector;
use Illuminate\Support\Facades\Log;
use App\Health\Factory\ConnectorFactory as FactoryConnectorFactory;
use App\Models\RequestTestModel;
use App\Models\Server;

class DemoController extends Controller
{
    public function index()
    {
        return view('server');
    }



    public function serverTests(Request $request)
    {
        $tests = RequestTestModel::with('server')
            ->orderBy('created_at', 'desc')
            ->paginate(10);


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



    public function testing(){

         $url = 'sftp.dlptest.com'; // The HTTP URL you want to test

        $server = Server::with('protocol')->where('protocol_id', 3)->first();

        try {
            $connector = FactoryConnectorFactory::create($server);
            $success = $connector->connect();
            $message = $success ? 'Connection successful' : 'Connection failed'; ;
              Log::info('HTTP Test Result', [
            'url' => $url,
            'success' => $success,
            'message' => $message,
        ]);
        } catch (\Throwable $e){

            $success = false;
            $message = 'Error: ' . $e->getMessage();

        }

        // Log for debugging


        // Send result to a Blade view
        return view('server', compact('url', 'success', 'message'));
    }
}
