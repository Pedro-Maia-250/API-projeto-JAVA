<?php
require_once __DIR__ . "/../core/Database.php";

// Testa a conexão
$db = Database::connect();

// Se chegou aqui, a conexão funcionou
Response::json([
    "status" => "ok",
    "message" => "API funcionando",
    "database" => "connected",
    "server_time" => date("Y-m-d H:i:s")
], 200);
