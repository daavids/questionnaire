<?php

namespace App\Models;

use App\Models\Model;
use App\Helpers\Database;
use \PDO as PDO;

class UserAnswer extends Model
{
    public $answer;
    public $question;
    public $user;

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
        $this->user = $_SESSION['user_id'];

        $id = $this->checkIfAlreadyAnswered();
        if (!empty($id)) {
            $this->id = $id;
            return;
        }

        $stmt = $this->connection->prepare(
            'INSERT INTO user_answers (answer_id, question_id, user_id) VALUES (:answer, :question, :user)'
        );
        $stmt->bindParam(':answer', $this->answer, PDO::PARAM_INT);
        $stmt->bindParam(':question', $this->question, PDO::PARAM_INT);
        $stmt->bindParam(':user', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();

        $id = $this->connection->lastInsertId();
        $this->id = $id;

        return;
    }

    public function checkIfAlreadyAnswered()
    {
        $stmt = $this->connection->prepare(
            'SELECT id FROM user_answers WHERE question_id = :question AND user_id = :user'
        );
        $stmt->bindParam(':question', $this->question, PDO::PARAM_INT);
        $stmt->bindParam(':user', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}