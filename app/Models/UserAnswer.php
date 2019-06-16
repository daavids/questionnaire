<?php

namespace App\Models;

use App\Models\Model;
use App\Helpers\Database;

class UserAnswer extends Model
{
    protected static $table = 'user_answers';

    public $answer;
    public $question;

    public function __construct($answer, $question)
    {
        $this->connection = Database::getConnection();
        $this->answer = $answer;
        $this->question = $question;        
    }

    public static function create($answer, $question)
    {
        $userAnswer = new UserAnswer($answer, $question);
        $userAnswer->save();
        return $userAnswer;
    }

    public function save()
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO user_answers (answer, question, user) VALUES (:answer, :question, :user)'
        );
        $stmt->bindParam(':answer', $this->answer, \PDO::PARAM_INT);
        $stmt->bindParam(':question', $this->question, \PDO::PARAM_INT);
        $stmt->bindParam(':user', $_SESSION['user_id'], \PDO::PARAM_INT);
        $stmt->execute();

        $id = $this->connection->lastInsertId();
        $this->id = $id;

        return;
    }
}