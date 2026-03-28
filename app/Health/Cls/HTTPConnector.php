<?php
namespace App\Health\Cls;

use App\Health\Abs\AbstractConnector;

/**
 * Class HTTPConnector
 *
 * Provides a connector for HTTP/HTTPS requests.
 * Extends the AbstractConnector to implement the protocol-specific
 * connection logic for HTTP(S) URLs.
 *
 * Example usage:
 * ```php
 * $http = new HTTPConnector('https://example.com');
 * if ($http->connect()) {
 *     echo "HTTP connection successful";
 * } else {
 *     echo "HTTP connection failed";
 * }
 * ```
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
     * @param string $url The URL (HTTP or HTTPS) to attempt a connection to.
     */
    public function __construct(string $url)
    {
        parent::__construct($url); // use host as url for simplicity
        $this->url = $url;
    }

    /**
     * Attempt to establish an HTTP/HTTPS connection.
     *
     * Uses a simple GET request with a timeout. Returns true if the
     * request succeeds, false otherwise.
     *
     * @return bool True if connection successful, false on failure.
     */
    protected function tryConnect(): bool
    {
        $options = ["http" => ["method" => "GET", "timeout" => 5]];
        $context = stream_context_create($options);
        $result = @file_get_contents($this->url, false, $context);
        return $result !== false;
    }
}

