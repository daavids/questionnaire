<?php

namespace App\Traits;

trait TokenCheck
{
    public static function validateToken(): bool
    {
        if (empty($_POST['_token'])) { return 0; }

        return strcmp($_POST['_token'], $_SESSION['token']) === 0;
    }
}