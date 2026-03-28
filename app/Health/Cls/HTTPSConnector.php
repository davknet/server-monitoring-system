<?php
namespace App\Health\Cls;

use App\Health\Abs\AbstractConnector;

/**
 * Class HttpsConnector
 *
 * Provides a connector for HTTPS requests.
 * Extends AbstractConnector to implement protocol-specific
 * connection logic for HTTPS URLs.
 *
 * This class can be customized in the future for SSL settings,
 * certificate verification, or additional headers.
 *
 * Example usage:
 * ```php
 * $https = new HttpsConnector('https://example.com');
 * if ($https->connect()) {
 *     echo "HTTPS connection successful";
 * } else {
 *     echo "HTTPS connection failed";
 * }
 * ```
 *
 * @package App\Health\Cls
 */
class HttpsConnector extends AbstractConnector
{
    /**
     * @var string The full HTTPS URL to connect to.
     */
    private string $url;

    /**
     * HttpsConnector constructor.
     *
     * @param string $url The HTTPS URL to attempt a connection to.
     */
    public function __construct(string $url)
    {
        parent::__construct($url); // use host as URL for simplicity
        $this->url = $url;
    }

    /**
     * Attempt to establish an HTTPS connection.
     *
     * Uses a simple GET request with a timeout.
     * Returns true if the request succeeds, false otherwise.
     *
     * @return bool True if connection successful, false on failure.
     */
    protected function tryConnect(): bool
    {
        // Optional: add SSL verification context in the future
        $options = [
            "http" => [
                "method" => "GET",
                "timeout" => 5
            ]
        ];

        $context = stream_context_create($options);
        $result = @file_get_contents($this->url, false, $context);
        return $result !== false;
    }
}
