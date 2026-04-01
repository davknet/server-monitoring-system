<?php
namespace App\Health\Cls;

use App\Health\Abs\AbstractConnector;
use Illuminate\Support\Facades\Log;

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
            $start = microtime(true);

            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL => $this->url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => $this->timeout,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_USERAGENT => 'ServerMonitor/1.0',
            ]);

            $result = curl_exec($ch);

            $this->responseTime = round((microtime(true) - $start) * 1000, 3);

            if ($result === false) {

                $this->errorMessage = curl_error($ch);
                Log::error("HTTP connection failed", [
                    'url'              => $this->url,
                    'error'            => $this->errorMessage,
                    'response_time_ms' => $this->responseTime,
                ]);

                return false;
            }

            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            Log::info('HTTP DEBUG', [
                'url' => $this->url,
                'status_code' => $statusCode,
                'response_time' => $this->responseTime,
                'error_message' => $this->errorMessage,
            ]);

            if ($statusCode >= 500){
                $this->errorMessage = "Server error: {$statusCode}";
                return false;
            }

            return true;
        }
}
