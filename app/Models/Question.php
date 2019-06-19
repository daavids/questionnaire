<?php

namespace App\Models;

use App\Models\Model;
use App\Helpers\Database;
use \PDO as PDO;

class Question extends Model
{
    public $test_id;
    public $question;
    public $answers = [];
    private $correctAnswer;
    public $sequence;

    public function __construct($id, $question, $test, $sequence)
    {
        $this->connection = Database::getConnection();
        $this->id = $id;
        $this->question = $question;
        $this->test_id = $test;
        $this->sequence = $sequence;
    }

    public static function find($id, $withAnswers = true)
    {
        $connection = Database::getConnection();
       
        $stmt = $connection->prepare(
            "SELECT id, question, test_id, sequence FROM questions WHERE id LIKE :id"
        );

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_OBJ);
        if (empty($data)) { return null; }

        $question = new Question($data->id, $data->question, $data->test_id, $data->sequence);

        if ($withAnswers) {
            $question->answers = $question->getAnswers();
            $question->correctAnswer = $question->getCorrectAnswer();
        }

        return $question;
    }

    public static function findByTest($test, $construct = false, $withAnswers = false)
    {
        $connection = Database::getConnection();

        $questions = $connection->query(
            "SELECT id, question, test_id, sequence FROM questions WHERE test_id LIKE {$test} ORDER BY sequence ASC"
        )->fetchAll(PDO::FETCH_OBJ);

        if (!$construct && !$withAnswers) { return $questions; }

        $arr = [];
        
        foreach ($questions as $q) {
            
            $obj = new Question($q->id, $q->question, $q->test_id, $q->sequence);
            
            if ($withAnswers) {
                $hasAnswers = $obj->hasAnswers();
                if (!$hasAnswers) { continue; }
            }
            
            $arr[] = $obj;
        }        

        return $arr;
    }

    public static function findFirstInTest($test, $withAnswers = true)
    {
        $connection = Database::getConnection();
        $question = $connection->query(
            "SELECT id, question, test_id, sequence FROM questions WHERE test_id LIKE {$test} ORDER BY sequence ASC"
        )->fetch(PDO::FETCH_OBJ);
        
        if (!$withAnswers) { return $question; }

        $obj = new Question($question->id, $question->question, $question->test_id, $question->sequence);

        return $obj->hasAnswers() ? $obj : null;
    }

    public static function findNextInTest($test, $previous, $withAnswers = true)
    {
        if (!$previous) { return self::findFirstInTest($test); }

        $connection = Database::getConnection();
        $questions = $connection->query(
            "SELECT id, question, test_id, sequence FROM questions WHERE test_id LIKE {$test} 
            AND sequence >= (SELECT sequence FROM questions WHERE id LIKE {$previous})
            AND id NOT LIKE {$previous} ORDER BY sequence ASC"
        )->fetchAll(PDO::FETCH_OBJ);
        
        if (!$withAnswers) { return $questions; }

        foreach ($questions as $question) {
            $obj = new Question($question->id, $question->question, $question->test_id, $question->sequence);
            if ($obj->hasAnswers()) { return $obj; }
        }
        return null;
    }

    public static function findAnyUnanswered($test, $idArray, $withAnswers = true)
    {
        $connection = Database::getConnection();
        $questions = $connection->query(
            "SELECT id, question, test_id, sequence FROM questions
            WHERE test_id LIKE {$test} AND id NOT IN ('".$idArray."')
            ORDER BY sequence ASC"
        )->fetchAll(PDO::FETCH_OBJ);

        if (empty($questions)) { return null; }

        if (!$withAnswers) { return $questions; }

        foreach ($questions as $question) {
            $obj = new Question($question->id, $question->question, $question->test_id, $question->sequence);
            if ($obj->hasAnswers()) { return $obj; }
        }        
        return null;
    }

    public function getAnswers()
    {
        return $this->connection->query(
            "SELECT id, answer FROM answers WHERE question_id LIKE {$this->id}"
        )->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCorrectAnswer()
    {
        return $this->connection->query(
            "SELECT id, answer_id FROM correct_answers WHERE question_id LIKE {$this->id}"
        )->fetch(PDO::FETCH_OBJ);
    }

    public function hasAnswers()
    {
        $answers = $this->getAnswers();
        $this->answers = $answers;
        $correctAnswer = $this->getCorrectAnswer();
        $this->correctAnswer = $correctAnswer;

        return count($answers) > 1 && !empty($correctAnswer);
    }
}