<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Health\Cls\HTTPConnector;
use Illuminate\Support\Facades\Log;
use App\Health\Factory\ConnectorFactory as FactoryConnectorFactory;

class DemoController extends Controller
{
    public function index()
    {
        $url = 'https://httpbin.org/get'; // The HTTP URL you want to test

        

        try {
            $connector = new HTTPConnector($url);
            $success = $connector->connect();
            $message = $success ? 'Connection successful' : 'Connection failed';
        } catch (\Throwable $e) {
            $success = false;
            $message = 'Error: ' . $e->getMessage();
        }

        // Log for debugging
        Log::info('HTTP Test Result', [
            'url' => $url,
            'success' => $success,
            'message' => $message,
        ]);

        // Send result to a Blade view
        return view('server', compact('url', 'success', 'message'));
    }
}
