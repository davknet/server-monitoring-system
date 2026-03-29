<?php
namespace App\Health\Factory;

use App\Health\Intr\ConnectorInterface;
use App\Health\Cls\HTTPConnector;
use App\Health\Cls\HttpsConnector;
use App\Health\Cls\FTPConnector;
use App\Health\Cls\SSHConnector;

/**
 * Class ConnectorFactory
 *
 * Factory responsible for creating protocol-specific connector instances
 * based on the server configuration (typically retrieved from the database).
 *
 * This class centralizes the instantiation logic and ensures that the correct
 * connector is created according to the specified method (HTTP, HTTPS, FTP, SSH).
 *
 * Example usage:
 * ```php
 * $server = [
 *     'method' => 'FTP',
 *     'host' => 'ftp.example.com',
 *     'user' => 'username',
 *     'pass' => 'password',
 *     'port' => 21
 * ];
 *
 * $connector = ConnectorFactory::create($server);
 *
 * if ($connector->connect()) {
 *     echo "Connection successful";
 * } else {
 *     echo "Connection failed";
 * }
 * ```
 *
 * @package App\Health\Factory
 */
class ConnectorFactory
{
    /**
     * Create a connector instance based on server configuration.
     *
     * The method field determines which connector will be instantiated.
     *
     * Supported methods:
     * - HTTP
     * - HTTPS
     * - FTP
     * - SSH
     *
     * @param array $server Associative array containing server data:
     *                      - method (string): Protocol type
     *                      - url (string, required for HTTP/HTTPS)
     *                      - host (string, required for FTP/SSH)
     *                      - user (string, optional for FTP/SSH)
     *                      - pass (string, optional for FTP/SSH)
     *                      - port (int, optional)
     *
     * @return ConnectorInterface
     *
     * @throws \InvalidArgumentException If the method is unsupported or required fields are missing.
     */
    public static function create(array $server): ConnectorInterface
    {
        $method = strtoupper($server['method'] ?? '');

        return match ($method) {
            'HTTP' => new HTTPConnector(
                self::requireField($server, 'url')
            ),

            'HTTPS' => new HttpsConnector(
                self::requireField($server, 'url')
            ),

            'FTP' => new FTPConnector(
                self::requireField($server, 'url'),
                $server['username'] ?? 'anonymous',
                $server['pass'] ?? '',
                $server['port'] ?? 21
            ),

            'SSH' => new SSHConnector(
                self::requireField($server, 'url'),
                self::requireField($server, 'username'),
                self::requireField($server, 'password'),
                $server['port'] ?? 22
            ),

            default => throw new \InvalidArgumentException("Unsupported method: {$method}")
        };
    }

    /**
     * Ensure a required field exists in the server array.
     *
     * @param array $server
     * @param string $field
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    private static function requireField(array $server, string $field)
    {
        if (!isset($server[$field]) || $server[$field] === '') {
            throw new \InvalidArgumentException("Missing required field: {$field}");
        }

        return $server[$field];
    }
}
