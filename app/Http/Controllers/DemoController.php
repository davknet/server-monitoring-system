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

         $success = false;
         $server = Server::with('protocol')->where('protocol_id', 1 )->first();

        try {

            $connector     = new HTTPConnector($server->url)  ;
            $success       = $connector->connect();
            $message       = is_array($success) && $success['error_message'] === '' ? $success['error_message'] :   'Connection failed';
            $response_time = $success['response_time'] ?? null ;

        }catch(\Throwable $e){

            $success       = false;
            $message       = 'Error: ' . $e->getMessage();
            $response_time =   null ;

        }
         $url = $server->url ?? 'N/A';
        // Log for debugging


        // Send result to a Blade view
        return view('test-page', compact( 'url', 'response_time', 'message' ));
    }
}
