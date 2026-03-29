<?php
namespace App\Health\Cls;

use App\Health\Abs\AbstractConnector;

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
        if (!function_exists('ssh2_connect')) {
            $this->errorMessage = "SSH2 PHP extension is not installed";
            return false;
        }

        $conn = @ssh2_connect($this->host, $this->port);
        if (!$conn) {
            $this->errorMessage = "Failed to connect to {$this->host}:{$this->port}";
            return false;
        }

        $auth = @ssh2_auth_password($conn, $this->user, $this->pass);
        if (!$auth) {
            $this->errorMessage = "SSH authentication failed for user '{$this->user}'";
            return false;
        }

        return true;
    }
}
