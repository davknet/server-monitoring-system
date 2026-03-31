<?php

namespace App\Http\Controllers;

use App\Models\Server;
use App\Models\RequestTestModel;
use App\Health\Factory\ConnectorFactory as FactoryConnectorFactory;
use Illuminate\Support\Facades\Log;


class RequestTestController extends Controller
{
    public function runChecks()
    {
        $servers = Server::with('protocol')->get();

        Log::info("Starting health checks for " . $servers->count() . " servers at " . now() );

        foreach ($servers as $server){
            $status = 'not healthy';
            $message = null;
            $responseTime = null; // initialize variable

            try {

                $connector = FactoryConnectorFactory::create($server);
                Log::info("conector -> ", ['conector' => $connector]);
                // connect() returns an array with 'success' and 'response_time'
                $result = $connector->connect();



                $success = $result['success'] ?? false;
                $responseTime = $result['response_time'] ?? null; // capture response time
                $message = $result['error_message'] ?? null;

                $status = $success ? 'healthy' : 'not healthy';

            } catch (\Exception $e) {
                Log::error("Connector error", [
                    'server_id'   => $server->id,
                    'server_name' => $server->name,
                    'error'       => $e->getMessage()
                ]);

                $message = $e->getMessage();
            }

            // Save result in requests table
            RequestTestModel::create([
                'server_id'     => $server->id,
                'server_name'   => $server->name,
                'server_ip'     => $server->ip_address,
                'status'        => $status,
                'response_time' => $responseTime,
                'description'   => $message,
            ]);
        }

        return response()->json([
            'message' => 'Server health checks completed'
        ]);
    }
}
