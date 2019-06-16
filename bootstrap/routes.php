<?php

use App\Helpers\Auth;
use App\Traits\TokenCheck;

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
    ]
];