<?php
namespace App\Health\Cls;

use App\Health\Abs\AbstractConnector;
use Illuminate\Support\Facades\Log;

/**
 * Class SSHConnector
 *
 * Provides a connector for SSH protocol.
 * Extends AbstractConnector to implement SSH-specific
 * connection and authentication logic using PHP's SSH2 extension.
 *
 * @package App\Health\Cls
 */
class SSHConnector extends AbstractConnector
{
    private string $user;
    private string $pass;

    /**
     * SSHConnector constructor.
     *
     * @param string $host Hostname or IP of the SSH server.
     * @param string $user SSH username.
     * @param string $pass SSH password.
     * @param int $port SSH port (default: 22)
     */
    public function __construct(string $host, string $user, string $pass, int $port = 22)
    {
        parent::__construct($host, $port);
        $this->user = $user;
        $this->pass = $pass;
    }

    /**
     * Attempt to establish an SSH connection.
     *
     * Returns true if connection and authentication succeed,
     * false otherwise. Sets $this->errorMessage on failure.
     *
     * @return bool
     */
     protected function tryConnect(): bool
    {
        $start = microtime(true);

        if (!function_exists('ssh2_connect')) {
            $this->errorMessage = "SSH2 PHP extension is not installed";
            return false;
        }

        // Open TCP socket without enforcing a timeout
        $socket = @fsockopen($this->host, $this->port, $errno, $errstr);
        if (!$socket) {
            $this->errorMessage = "Unable to connect to {$this->host}:{$this->port} ($errstr)";
            return false;
        }

        $conn = @ssh2_connect($this->host, $this->port, [], ['socket' => $socket]);
        if (!$conn) {
            fclose($socket);
            $this->errorMessage = "SSH2 connection failed for {$this->host}:{$this->port}";
            return false;
        }

        if (!@ssh2_auth_password($conn, $this->user, $this->pass)) {
            fclose($socket);
            $this->errorMessage = "SSH authentication failed for user '{$this->user}'";
            return false;
        }

        fclose($socket);

        // Measure connection time in seconds
        $this->responseTime = round(microtime(true) - $start, 2);

        Log::info('SSH connection', [
            'host' => $this->host,
            'port' => $this->port,
            'user' => $this->user,
            'response_time' => $this->responseTime,
        ]);

        return true;
    }
}
