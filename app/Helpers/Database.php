<?php

namespace App\Helpers;

class Database
{
    private $host;
    private $database;
    private $user;
    private $password;

    public static $connection;

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
            
            if (getenv('ENV') != 'prod') { $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING); }

            self::$connection = $conn;

            return true;

        } catch (\PDOException $e) {
            return false;
        }
    }

    public static function getConnection()
    {
        return self::$connection;
    }
}