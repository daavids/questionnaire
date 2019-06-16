<?php

namespace App\Models;

use App\Models\Model;
use App\Helpers\Database;

class Question extends Model
{
    protected static $table = 'questions';
    
    public $question;

    public function __construct($id, $question, $test)
    {
        $this->id = $id;
        $this->question = $question;
        $this->test_id = $test;
    }

    public static function find($id)
    {
        $connection = Database::getConnection();
       
        $stmt = $connection->prepare(
            "SELECT id, question, test_id FROM questions WHERE id LIKE :id"
        );

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(\PDO::FETCH_OBJ);

        $question = new Question($data->id, $data->question, $data->test_id);

        return $question;
    }

    public static function findByTest($id)
    {
        $connection = Database::getConnection();
       
        $stmt = $connection->prepare(
            "SELECT id, question, test_id FROM questions WHERE test_id LIKE :id"
        );

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(\PDO::FETCH_OBJ);

        $question = new Question($data->id, $data->name, $data->test_id);

        return $question;
    }

    public function getAnswers()
    {
        $stmt = $this->connection->query(
            "SELECT id, answer, sequence FROM answers WHERE question_id LIKE {$this->id} ORDER BY sequence ASC"
        );
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}