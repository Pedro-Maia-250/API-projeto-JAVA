<?php

require_once __DIR__ . "/../core/Database.php";
require_once __DIR__ . "/../core/Response.php";

$conn = $db->getConnection();

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["numero"], $data["valor"], $data["datac"])) {
    Response::json(["error" => true, "message" => "Dados incompletos"], 400);
}

try {
    $stmt = $conn->prepare("INSERT INTO contratos(numero, valor, datac) VALUES (?, ?, ?)");
    $stmt->execute([
        $data["numero"],
        $data["valor"],
        $data["datac"]
    ]);

    Response::json(["success" => true, "message" => "Contrato inserido"]);
} catch (Exception $e) {
    Response::json(["error" => true, "message" => $e->getMessage()], 500);
}
