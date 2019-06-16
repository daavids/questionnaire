<?php

namespace App\Helpers;

class Response
{
    public static function json($data, $success = false)
    {
        header('Content-type: application/json');
        echo json_encode([
            'success' => $success,
            'data' => $data
        ]);
    }
}