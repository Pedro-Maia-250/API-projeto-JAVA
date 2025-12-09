<?php

require_once __DIR__ . "/../core/Database.php";
require_once __DIR__ . "/../core/Response.php";

$db = Database::connect();

try {
    $stmt = $db->prepare("SELECT * FROM parcelas WHERE numero = ?");
    $stmt->execute([$numero]);

    $parcelas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    Response::json($parcelas);
} catch (Exception $e) {
    Response::json(["error" => true, "message" => $e->getMessage()], 500);
}
