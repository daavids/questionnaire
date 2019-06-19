<?php

namespace App\Models;

use App\Helpers\Database;

class Model
{
    protected $connection;

    public $id;
    public $created_at;
    public $updated_at;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }
}