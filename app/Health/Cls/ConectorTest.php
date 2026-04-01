<?php

namespace App\Health\Cls;

use App\Health\Abs\Server;

/**
 * Example implementation for a connector-based health check.
 */
class ConectorTest extends Server
{
    /**
     * Check server status based on response time and previous status.
     */
    public function checkStatus(object $server): array
    {
        return [
            'id'     => $server->id,
            'status' => $server->status && $server->response_time < 45,
        ];
    }
}








