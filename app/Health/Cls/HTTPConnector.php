<?php
namespace App\Health\Cls;

use App\Health\Abs\AbstractConnector;

/**
 * Class HTTPConnector
 *
 * Provides a connector for HTTP/HTTPS requests.
 * Extends AbstractConnector to implement protocol-specific
 * connection logic using a simple HTTP request.
 *
 * This connector performs a lightweight GET request to verify
 * that the target URL is reachable and responding.
 *
 * @package App\Health\Cls
 */
class HTTPConnector extends AbstractConnector
{
    /**
     * @var string The full URL to connect to.
     */
    private string $url;
    
    /**
     * HTTPConnector constructor.
     *
     * @param string $url The URL (HTTP or HTTPS) to test.
     */
    public function __construct(string $url)
    {
        parent::__construct($url); // using URL as host for simplicity
        $this->url = $url;
    }

    /**
     * Attempt to establish an HTTP/HTTPS connection.
     *
     * Sends a GET request with a timeout. If the request fails,
     * sets an appropriate error message.
     *
     * @return bool True if connection is successful, false otherwise.
     */
    protected function tryConnect(): bool
    {
        $options = [
            "http" => [
                "method"  => "GET",
                "timeout" => $this->timeout,
                "ignore_errors" => true
            ]
        ];

        $context = stream_context_create($options);

        $result = file_get_contents($this->url, false, $context);

        if ($result === false) {
            $this->errorMessage = "HTTP request failed for {$this->url}";
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
