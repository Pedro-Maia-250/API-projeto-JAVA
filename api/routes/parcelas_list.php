<?php

require_once __DIR__ . "/../core/Database.php";
require_once __DIR__ . "/../core/Response.php";

$conn = $db->getConnection();

// parâmetro vindo da rota
$numero = $params["numero"];

try {
    $stmt = $conn->prepare("SELECT * FROM parcelas WHERE numero = ?");
    $stmt->execute([$numero]);

    $parcelas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    Response::json($parcelas);
} catch (Exception $e) {
    Response::json(["error" => true, "message" => $e->getMessage()], 500);
}
