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
        $servers = Server::all();

        foreach ($servers as $server) {
            $status = 'not healthy';
            $server = $server->toArray(); // Convert model to array for factory
            $message = null;

            try {
                // Use factory (pass model, not array)
                $connector = FactoryConnectorFactory::create($server);

                if ($connector->connect()) {
                    $status = 'healthy';
                } else {
                    $message = method_exists($connector, 'getErrorMessage')
                        ? 'Connection failed: '
                        : 'Connection failed';
                }

            } catch (\Exception $e) {
                // Only log real errors
                Log::error("Connector error", [
                    'server_id' => $server['id'],
                    'server_name' => $server['name'],
                    'error' => $e->getMessage()
                ]);

                $message = $e->getMessage();
            }

            // Save result
            RequestTestModel::create([
                'server_id'   => $server['id'],
                'server_name' => $server['name'],
                'server_ip'   => $server['ip_address'],
                'status'      => $status,
                'message'     => $message,
            ]);
        }

        return response()->json([
            'message' => 'Server health checks completed'
        ]);
    }
}
