<?php
namespace App\Health\Abs;











abstract class Server
{
    protected $name;
    protected $ipAddress;
    protected $status;

    public function __construct($name, $ipAddress)
    {
        $this->name = $name;
        $this->ipAddress = $ipAddress;
        $this->status = 'unknown';
    }

    abstract public function checkStatus();
}













