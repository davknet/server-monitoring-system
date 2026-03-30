<?php

namespace App\Http\Controllers;

use App\Health\Cls\FTPConnector;
use App\Health\Cls\HttPSConnector;
use Illuminate\Http\Request;
use App\Health\Cls\HTTPConnector;
use App\Health\Cls\SSHConnector;
use Illuminate\Support\Facades\Log;
use App\Health\Factory\ConnectorFactory as FactoryConnectorFactory;
use App\Models\Server;

class DemoController extends Controller
{
    public function index()
    {
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
