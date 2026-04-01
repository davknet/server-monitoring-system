<?php
namespace App\Health\Factory;

use App\Health\Intr\ConnectorInterface;
use App\Health\Cls\HTTPConnector;
use App\Health\Cls\HTTPSConnector;
use App\Health\Cls\FTPConnector;
use App\Health\Cls\SSHConnector;
use Illuminate\Support\Facades\Log;
use App\Models\Protocol;
use App\Models\Server;

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

    public static float $response_time = 0.0;
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
     * @param Server $server The server configuration object containing necessary connection details.
     *
     * @return ConnectorInterface
     *
     * @throws \InvalidArgumentException If the method is unsupported or required fields are missing.
     */
   public static function create(Server $server): ConnectorInterface
{
    $protocol = strtoupper($server->protocol->name ?? '');
    self::$response_time = $server->response_time ?? 0.0 ;

    // Log::info("Creating connector", [
    //     'protocol' => $protocol,
    //     'server_id' => $server->id
    // ]);



    return match ($protocol) {

        'HTTP' => new HTTPConnector(
            self::requireField($server, 'url')
        ),

        'HTTPS' => new HTTPSConnector(
            self::requireField($server, 'url')
        ),

        'FTP' => new FTPConnector(
            self::requireField($server, 'url'),
            $server->username ?? 'anonymous',
            $server->getDecryptedPassword()?? '',
            $server->port ?? 21
        ),

        'SSH' => new SSHConnector(
            self::requireField($server, 'url'),
            self::requireField($server, 'username'),
            $server->getDecryptedPassword()?? '' ,
            $server->port ?? 22
        ),

        default => throw new \InvalidArgumentException("Unsupported protocol: {$protocol}")
    };
}
    /**
     * Ensure a required field exists in the server array.
     *
     * @param Server $server
     * @param string $field
     * @return mixed
     *
     * @throws \InvalidArgumentException
     */
    private static function requireField(Server $server, string $field)
    {
        if (empty($server->$field)) {
            throw new \InvalidArgumentException("Missing required field: {$field}");
        }

        return (string)$server->$field;
    }
}
