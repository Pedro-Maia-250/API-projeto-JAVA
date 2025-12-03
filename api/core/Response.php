<?php

class Response {

    // Retorno JSON padronizado
    public static function json($data, $status = 200) {
        http_response_code($status);
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    // Retorno de erro padronizado
    public static function error($message, $status = 400) {
        self::json([
            "error" => true,
            "message" => $message
        ], $status);
    }
}
