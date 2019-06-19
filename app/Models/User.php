<?php

namespace App\Models;

use App\Models\Model;
use App\Helpers\Database;

class User extends Model
{    
    public $name;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->connection = Database::getConnection();        
    }

    public function save()
    {
        $stmt = $this->connection->prepare(
            "INSERT INTO users (name) VALUES (:name)"
        );
        $stmt->bindParam(':name', $this->name);
        $stmt->execute();

        $userId = $this->connection->lastInsertId();
        $this->id = $userId;

        return;
    }

    public static function findByName(string $name)
    {
        $connection = Database::getConnection();

        $stmt = $connection->prepare(
            "SELECT id, name FROM users WHERE name LIKE :name"
        );

        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $data = $stmt->fetch(\PDO::FETCH_OBJ);

        if (empty($data)) { return null; }

        $user = new User($data->name);
        $user->id = $data->id;

        return $user;
    }

    public static function create(string $name): User
    {        
        $user = new User($name);
        $user->save();

        return $user;
    }
}