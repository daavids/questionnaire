<?php

namespace App\Models;

use App\Models\Model;
use App\Helpers\Database;

class User extends Model
{
    public $name;
    protected $table = 'users';

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->connection = Database::getConnection();

        $stmt = $this->connection->prepare(
            "INSERT INTO users (name) VALUES (:name)"
        );
        $stmt->bindParam(':name', $this->name);
        $stmt->execute();

        $userId = $this->connection->lastInsertId();
        $this->id = $userId;
        
        return $this;
    }

    public static function findByName(string $name)
    {
        $connection = Database::getConnection();

        $stmt = $connection->prepare(
            "SELECT id, name FROM users WHERE name LIKE :name"
        );

        $stmt->bindParam(':name', $name);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

    public static function create(string $name): User
    {        
        return new User($name);        
    }
}