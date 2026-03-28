<?php
namespace App\Health\Intr;

/**
 * Interface ConnectorInterface
 *
 * Defines a contract for any type of network or protocol connector.
 * Implementing classes must provide a method to attempt a connection
 * and return whether the connection was successful.
 */
interface ConnectorInterface
{
    /**
     * Attempt to establish a connection.
     *
     * This method should handle the logic needed to connect to the
     * target host or service. It should not throw exceptions but
     * return a boolean indicating success or failure.
     *
     * @return bool True if the connection was successful, false otherwise.
     */
    public function connect(): bool;
}
