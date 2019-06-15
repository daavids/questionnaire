<?php

namespace App\Models;

class Model
{
    use App\Helpers\Database;

    public $table;
    
    public static function find($id)
    {
        $stmt = $this->connection("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

}