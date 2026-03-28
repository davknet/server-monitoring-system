<?php
namespace App\Health\Cls;

use App\Health\Abs\AbstractConnector;

/**
 * Class SSHConnector
 *
 * Provides a connector for SSH protocol.
 * Extends AbstractConnector to implement SSH-specific
 * connection and authentication logic.
 *
 * Uses the PHP SSH2 extension to attempt a connection.
 *
 * @package App\Health\Cls
 */
class SSHConnector extends AbstractConnector
{
    /**
     * @var string Username for SSH authentication.
     */
    private string $user;

    /**
     * @var string Password for SSH authentication.
     */
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
     * Perform SSH connection attempt.
     *
     * @return bool True if connection and authentication succeed, false otherwise.
     */
    protected function tryConnect(): bool
    {
        if (!function_exists('ssh2_connect')) {
            return false;
        }

        $conn = @ssh2_connect($this->host, $this->port);
        if (!$conn) {
            return false;
        }

        return @ssh2_auth_password($conn, $this->user, $this->pass);
    }
}
