<?php

namespace App\Helpers;

use Token;
use App\Models\User;

class Auth
{
    public static function isAuth(): bool
    {
        if (!isset($_SESSION['user_id'])) { return false; }
        return !empty(User::find($_SESSION['user_id']));
    }

    public static function login(string $name)
    {
        // login/register

        Token::generate();
        return header('Location: /');
    }
}