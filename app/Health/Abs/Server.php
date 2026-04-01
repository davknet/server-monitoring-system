<?php

namespace App\Health\Abs;

/**
 * Base abstract class for all server health checks.
 */
abstract class Server{
    protected string $name;
    protected string $server_ip;
    protected string $status;
    protected int $id;
    protected string $protocol;
    protected float $response_time = 0;
    protected int $count = 0;


    /**
     * Server constructor.
     */
    public function __construct(
        int $id,
        string $name,
        string $ipAddress,
        string $status
    ) {
        $this->id          = $id;
        $this->name        = $name;
        $this->server_ip   = $ipAddress;
        $this->status      = $status;
    }

    /**
     * Each protocol must implement its own health check logic.
     */
    abstract public function checkStatus(object $server): array;

    /**
     * Evaluate server health based on last checks.
     */
    public function make(iterable $tests): array
    {
        $this->count = 0;

        foreach ($tests as $test) {

            $result = $this->checkStatus($test);

            if ($result['status']) {
                $this->count++;
            }
        }

        // Determine final health status
        if ($this->count >= 5) {
            $this->status = 'healthy';
        } elseif ($this->count <= 2) {
            $this->status = 'unhealthy';
        } else {
            $this->status = 'unknown';
        }

        return [
            'name'          => $this->name,
            'server_id'     => $this->id,
            'response_time' => $this->response_time,
            'status'        => $this->status,
            'ip_address'    => $this->server_ip,
            'timestamp'     => now()->toDateTimeString(),
        ];
    }
}












