<?php
namespace App\Health\Cls;

use App\Health\Abs\AbstractConnector;

/**
 * Class FTPConnector
 *
 * Provides a connector for the FTP protocol.
 * Extends AbstractConnector to implement protocol-specific
 * connection and authentication logic for FTP servers.
 *
 * This class attempts to establish a connection to an FTP server
 * and authenticate using provided credentials.
 * Returns true if both connection and login succeed, false otherwise.
 *
 * Example usage:
 * ```php
 * $ftp = new FTPConnector('ftp.example.com', 'username', 'password');
 * if ($ftp->connect()) {
 *     echo "FTP connection successful";
 * } else {
 *     echo "FTP connection failed";
 * }
 * ```
 *
 * @package App\Health\Cls
 */
class FTPConnector extends AbstractConnector
{
    /**
     * @var string Username for FTP authentication.
     */
    private string $user;

    /**
     * @var string Password for FTP authentication.
     */
    private string $pass;

    /**
     * FTPConnector constructor.
     *
     * @param string $host Hostname or IP address of the FTP server.
     * @param string $user FTP username. Defaults to 'anonymous'.
     * @param string $pass FTP password. Defaults to empty string.
     * @param int $port FTP port number. Defaults to 21.
     */
    public function __construct(string $host, string $user = 'anonymous', string $pass = '', int $port = 21)
    {
        parent::__construct( $host , $port );
        $this->user = $user;
        $this->pass = $pass;
    }

    /**
     * Attempt to establish an FTP connection.
     *
     * Connects to the FTP server using the provided host and port,
     * then attempts to authenticate with the given credentials.
     * Suppresses warnings and returns a boolean result.
     *
     * @return bool True if connection and login succeed, false otherwise.
     */
    protected function tryConnect(): bool
    {
        $conn = @ftp_connect($this->host , $this->port, 45 );

        if (!$conn) {
            $this->errorMessage = "Unable to connect to FTP server {$this->host}:{$this->port}";
            return false;
        }

        $login = @ftp_login($conn, $this->user, $this->pass);

        if (!$login) {
            $this->errorMessage = "FTP login failed (user: {$this->user})";
            ftp_close($conn);
            return false;
        }

        ftp_close($conn);
        return true;
    }
}
