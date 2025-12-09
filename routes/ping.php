<?php
require_once __DIR__ . "/../core/Database.php";

$db = Database::connect();

Response::json([
    "status" => "ok",
    "message" => "API funcionando",
    "database" => "connected",
    "server_time" => date("Y-m-d H:i:s")
], 200);
