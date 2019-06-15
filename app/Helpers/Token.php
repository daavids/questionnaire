<?php

namespace App\Helpers;

class Token
{
    public static function generate(): string
    {
        @session_start();
        $token = bin2hex(random_bytes(32));
        $_SESSION['token'] = $token;
        return $token;        
    }

    public static function get(): string
    {
        @session_start();
        return empty($_SESSION['token']) ? (self::generate()) : $_SESSION['token'];
    }
}