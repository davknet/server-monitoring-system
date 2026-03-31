<?php
namespace App\Health\Cls;

use App\Health\Abs\AbstractConnector;

/**
 * Class HttpsConnector
 *
 * Provides a connector for HTTPS requests.
 * Extends AbstractConnector to implement secure HTTP connection logic.
 *
 * @package App\Health\Cls
 */
class HttPSConnector extends AbstractConnector
{
    private string $url;

    /**
     * HttpsConnector constructor.
     *
     * @param string $url The HTTPS URL to attempt a connection to.
     */
    public function __construct(string $url)
    {
        parent::__construct($url);
        $this->url = $url;
    }

    /**
     * Attempt to establish an HTTPS connection.
     *
     * Uses a GET request with a timeout. Sets $this->errorMessage on failure.
     *
     * @return bool True if connection successful, false otherwise
     */
    protected function tryConnect(): bool
    {
        $options = [
            "http" => [
                "method"  => "GET",
                "timeout" => $this->timeout,
                "header"  => "User-Agent: ServerMonitor/1.0\r\n",
                "ignore_errors" => true
            ],
            "ssl" => [
                "verify_peer"      => true,
                "verify_peer_name" => true,
            ]
        ];

        $context = stream_context_create($options);

        $result = file_get_contents($this->url, false, $context);

        if ($result === false) {
            $this->errorMessage = "Failed to connect to {$this->url} via HTTPS";
            return false;
        }

        
        if (isset($http_response_header)) {
            $statusLine = $http_response_header[0] ?? '';

            if (preg_match('/HTTP\/\d\.\d\s+(\d+)/', $statusLine, $matches)) {
                $statusCode = (int)$matches[1];

                if ($statusCode < 200 || $statusCode >= 300) {
                    $this->errorMessage = "Unexpected response: {$statusLine}";
                    return false;
                }
            }
        }

        return true;
    }
}
