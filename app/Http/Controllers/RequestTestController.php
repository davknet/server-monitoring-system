<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Server;
use App\Health\Cls\ConnectorFactory;
use App\Health\Cls\HTTPConnector;
use App\Health\Cls\HTTPSConnector;
use App\Health\Cls\FTPConnector;
use App\Health\Cls\SSHConnector;
use App\Health\Factory\ConnectorFactory as FactoryConnectorFactory;
use App\Models\RequestTestModel;

class RequestTestController extends Controller
{
    //
        public function runChecks()
    {
        $servers = Server::all();

        foreach ($servers as $server) {
            $serverArray = $server->toArray();
            $status = 'not healthy';
            $message = null;

            try {
                // Use the factory to get the connector
                $connector = FactoryConnectorFactory::create($serverArray );

                if ($connector->connect()) {
                    $status = 'healthy';
                } else {
                    $message = 'Connection failed';
                }
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }

            // Save the result including snapshot fields
            RequestTestModel::create([
                'server_id' => $server->id,
                'server_name' => $server->name,
                'server_ip' => $server->ip_address,
                'status' => $status,
                'message' => $message,
            ]);
        }

        return response()->json(['message' => 'Server health checks completed']);
    }
}
