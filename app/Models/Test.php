<?php

namespace App\Models;

use App\Models\Model;
use App\Models\UserAnswer;
use App\Models\Question;
use App\Helpers\Database;
use \PDO as PDO;

class Test extends Model
{
    public $name;
    public $questions = [];

    public function __construct($id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->connection = Database::getConnection();
        $this->questions = [];
    }

    public static function find($id, $withQuestions = true)
    {
        $connection = Database::getConnection();
       
        $stmt = $connection->prepare(
            "SELECT id, name,
            (SELECT COUNT(*) FROM questions WHERE questions.test_id = tests.id) AS questions_count
            FROM tests WHERE id LIKE :id"
        );
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_OBJ);

        $test = new Test($data->id, $data->name);

        if ($withQuestions) {
            $test->questions = Question::findByTest($test->id, true, true);
            $test->userAnswers = $test->getUserAnswers();
        }

        return $test;
    }

    public static function getAll(): array
    {
        $connection = Database::getConnection();

        $stmt = $connection->prepare(
            "SELECT id, name, 
            (SELECT COUNT(*) FROM questions WHERE questions.test_id = tests.id) AS questions_count
            FROM tests"
        );

        $stmt->bindParam(':name', $name);
        $stmt->execute();        

        $tests = array_filter($stmt->fetchAll(PDO::FETCH_OBJ), function($test) {
            return $test->questions_count > 0;
        });

        return $tests;
    }

    public function handleAnswer()
    {
        if (!empty($_POST['answer']) && !empty($_POST['question'])) {
            UserAnswer::create($_POST['answer'], $_POST['question']);
        }
    }

    /**
     * A false return means the test is complete,
     * as it normally returns an array
     */
    public function nextQuestion()
    {
        // If no questions have been answered, return the first one
        $userAnswers = $this->getUserAnswers();
        if (empty($userAnswers)) {
            $nextQuestion = Question::findFirstInTest($this->id);
            return $this->returnNextQuestion($nextQuestion, count($userAnswers));
        }
        // Otherwise look for the last answer
        $lastAnswer = end($userAnswers);
        $nextQuestion = Question::findNextInTest($this->id, $lastAnswer->question_id);
        // If can't find the next question, check if all have been answered
        if (empty($nextQuestion)) {
            $questions = Question::findByTest($this->id, true, true);
            // Test complete
            if (count($userAnswers) >= count($questions)) {
                return $this->returnNextQuestion(false, count($userAnswers));
            }
            // Else try to find one that hasn't been answered
            $answeredIDs = implode("','", array_column($userAnswers, 'question_id'));
            $nextQuestion = Question::findAnyUnanswered($this->id, $answeredIDs);
        }

        return $this->returnNextQuestion($nextQuestion, count($userAnswers));
    }

    public function getUserAnswers()
    {
        if (empty($this->questions)) { $this->questions = Question::findByTest($this->id, true, true); }
        $questionIDs = implode("','", array_column($this->questions, 'id'));
        $userID = $_SESSION['user_id'];

        return $this->connection->query(
            "SELECT * FROM user_answers WHERE user_id = {$userID} AND question_id IN ('".$questionIDs."')"
        )->fetchAll(PDO::FETCH_OBJ);        
    }

    public function getResults()
    {
        $userAnswers = $this->getUserAnswers();
        $allQuestions = Question::findByTest($this->id, true, true);
        
        // Not actually complete, redirect back to test
        if (count($allQuestions) > count($userAnswers)) {
            header("Location: /tests/{$this->id}");
            exit();
            return;
        }

        $questionIDs = implode("','", array_column($userAnswers, 'question_id'));
        $answerIDs = array_column($userAnswers, 'answer_id');

        $correctAnswers = $this->connection->query(
            "SELECT * FROM correct_answers WHERE question_id IN ('".$questionIDs."')"
        )->fetchAll(PDO::FETCH_OBJ);

        $totalCount = count($userAnswers);
        $correctCount = 0;
    
        foreach ($correctAnswers as $correct) {
            if (in_array($correct->answer_id, $answerIDs)) { $correctCount++; }
        }

        return [
            'total' => $totalCount,
            'correct' => $correctCount
        ];
    }

    public function returnNextQuestion($nextQuestion, $questionsAnswered)
    {
        return [
            'questionsAnswered' => $questionsAnswered,
            'question' => $nextQuestion
        ];
    }
}