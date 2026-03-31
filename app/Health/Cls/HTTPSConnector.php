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
            curl_close($ch);
            return false;
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($statusCode < 200 || $statusCode >= 300 || $statusCode >= 500){
            $this->errorMessage = "HTTP status: {$statusCode}";
            return false;
        }


        return true;
    }
}
