<?php

namespace App\Models;

use App\Models\Model;
use App\Models\UserAnswer;
use App\Models\Question;
use App\Helpers\Database;

class Test extends Model
{
    protected $table = 'tests';

    public $name;
    public $questions;

    public function __construct($id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
        $this->connection = Database::getConnection();
        $this->questions = [];
        return $this;
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
        $data = $stmt->fetch(\PDO::FETCH_OBJ);

        $test = new Test($data->id, $data->name);

        if ($withQuestions) {
            $test->questions = Question::findByTest($test->id);
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

        $tests = array_filter($stmt->fetchAll(\PDO::FETCH_OBJ), function($test) {
            return $test->questions_count > 0;
        });

        return $tests;
    }

    public function handleAnswer()
    {
        if (!empty($_POST['answer']) && !empty($_POST['question'])) {
            UserAnswer::create($_POST['question'], $_POST['answer']);
        }
    }

    public function nextQuestion()
    {
        //
    }
}