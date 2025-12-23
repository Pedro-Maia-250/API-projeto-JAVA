<?php

    require_once __DIR__ . "/../core/Response.php";

    $data = json_decode(file_get_contents("php://input"), true);

    if(!isset($data["texto"])){
        Response::json(["error" => true,"message" => "falta dados na requisição", "resultado" => ""], 400);
        exit;
    }

    if (!is_string($data["texto"])) {
        Response::json(["error" => true, "message" => "O campo texto deve ser uma string", "resultado" => ""],400);
        exit;
    }

    $string = $data["texto"];
    $tamanho = strlen($string);

    Response::json(["error" => false,"message" => "sucesso", "resultado" => "{$string} - {$tamanho}"],200);
?>