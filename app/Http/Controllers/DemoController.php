<?php

namespace App\Http\Controllers;

use App\Health\Cls\FTPConnector;
use App\Health\Cls\HttPSConnector;
use Illuminate\Http\Request;
use App\Health\Cls\HTTPConnector;
use App\Health\Cls\SSHConnector;
use Illuminate\Support\Facades\Log;
use App\Health\Factory\ConnectorFactory as FactoryConnectorFactory;

class DemoController extends Controller
{
    public function index()
    {
        $url = 'sftp.dlptest.com'; // The HTTP URL you want to test

        $server = [
            'id'         => 1,
            'name'       => 'Demo Server',
            'url'        => $url ,
            'ip_address' =>  '123.23.189.123' ,
            'type'       => 'https',
            'port'       => 21 ,
            'username'   => 'dlpuser' ,
            'password'   => 'rNrKYTX9g7z3RgJRmxWuGHbeu' ,
            'method'    => 'PUT',
            'protocol_id'  => 3
        ];


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
