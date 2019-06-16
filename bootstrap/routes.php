<?php

use App\Helpers\Auth;
use App\Helpers\Response;
use App\Traits\TokenCheck;
use App\Models\Test;

$routes = [
    [
        'GET', '/', function() use ($twig) {

            $user = Auth::getAuthUser();
            
            echo $twig->render('default.htm', [
                'page' => 'pages/index.htm',
                'user' => $user
            ]);
        }
    ],
    [
        'POST', '/login', function() use ($twig) {

            $validToken = TokenCheck::validateToken();
            $login = Auth::login();

            if (!$validToken || !$login) {
                echo $twig->render('default.htm', [
                    'page' => 'pages/error.htm',
                    'error' => "Could not authenticate user.",
                    'title' => 'Error'
                ]);
                return;
            }

            return header('Location: /');
        }
    ],
    [
        'GET', '/logout', function() {
            Auth::logout();
        }
    ],
    [
        'GET', '/tests', function() {
            $tests = Test::getAll();
            Response::json($tests, count($tests) > 0);
        }
    ],
    [
        'GET', '/tests/[i:id]/[a:action]?', function($id, $action = null) use ($twig) {
            
            $user = Auth::getAuthUser();
            $test = Test::find($id, true);
            
            if (empty($action)) {
                echo $twig->render('default.htm', [
                    'page' => 'pages/index.htm',
                    'test' => $test,
                    'user' => $user
                ]);
                return;
            }

            if ($action == 'questions') {
                $nq = $test->nextQuestion();
                Response::json($nq, true);
                return;
            }
        }
    ],
    [
        'POST', '/tests/[i:id]', function($id) {

            $test = Test::find($id);
            $test->handleAnswer();
            $nq = $test->nextQuestion();
            
            Response::json($nq, true);
        }
    ]
];