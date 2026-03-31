<?php
namespace App\Health\Abs;
use App\Health\Intr\ConnectorInterface;

/**
 * Class AbstractConnector
 *
 * Provides a base implementation for connectors to different protocols.
 * Implements shared logic for connection attempts and error handling.
 * Concrete subclasses must implement the `tryConnect()` method to define
 * how the actual connection is established.
 *
 * @property string $host The target host for the connection. Can be a domain name, IP address, or URL depending on protocol.
 * @property int $port The port to connect to. Defaults vary by protocol if not provided.
 */
abstract class AbstractConnector implements ConnectorInterface
{
    /**
     * @var string The host or URL to connect to.
     */
    protected string $host;

        /**
        * @var int Connection timeout in seconds. Default is 45 seconds.
        */
    protected int $timeout = 45;

    /**
     * @var int The port number for the connection.
     */
    protected int $port;

    /**
     * AbstractConnector constructor.
     *
     * @param string $host The target host (domain, IP, or URL) to connect to.
     * @param int $port Optional port number. Defaults to 0 and should be overridden by subclasses if needed.
     */
    public function __construct(string $host, int $port = 0)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * Attempt to establish a connection.
     *
     * This method wraps the protocol-specific `tryConnect()` method
     * and handles any exceptions, returning a boolean result.
     *
     * @return bool True if the connection was successful, false otherwise.
     */
        public function connect(): array
    {
        try {
            $start = microtime(true);

            $success = $this->tryConnect();

            $responseTime = round(microtime(true) - $start, 3);


            $success = $success && $responseTime < 45;

            return [
                'success'       => $success,
                'response_time' => $responseTime,
                'error_message' => $this->errorMessage ?? null,
            ];

        }catch(\Exception $e){
            return [
                'success' => false,
                'response_time' => null,
                'error_message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Protocol-specific connection logic.
     *
     * Subclasses must implement this method to perform the actual
     * connection attempt for their respective protocol.
     *
     * @return bool True if the connection was successful, false otherwise.
     */
    abstract protected function tryConnect(): bool;


    /**
     * @var string|null Stores last connection error message
     */
    protected ?string $errorMessage = null;

        public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }
}






