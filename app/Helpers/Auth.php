<?php

namespace App\Helpers;

use App\Helpers\Token;
use App\Models\User;

class Auth
{
    public static function isAuth(): bool
    {
        if (!isset($_SESSION['user_name'])) { return false; }
        return !empty(User::findByName($_SESSION['user_name']));
    }

    public static function getAuthUser()
    {
        if (!isset($_SESSION['user_name'])) { return null; }
        return User::findByName($_SESSION['user_name']);
    }

    public static function login(): bool
    {
        if (empty($_POST['name'])) { return false; }
        $name = $_POST['name'];

        $user = User::findByName($name);
        if (empty($user)) { 
            $user = User::create($name);
        }

        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_name'] = $user->name;


        Token::generate();

        return true;
    }

    public static function logout()
    {
        @session_start();
        session_unset();
        session_destroy();

        return header('Location: /');
    }
}