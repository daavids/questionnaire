<?php

namespace App\Helpers;

class Database
{
    private $host;
    private $database;
    private $user;
    private $password;

    protected $connection;

    public function __construct(string $host, string $database, string $user, string $password)
    {
        $this->host = $host;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
    }

    public function connect(): bool
    {
        try {
            $conn = new \PDO("mysql:host={$this->host};dbname={$this->database}", $this->user, $this->password);
            $this->connection = $conn;
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
}