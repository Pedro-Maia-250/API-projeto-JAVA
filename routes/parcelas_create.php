<?php

require_once __DIR__ . "/../core/Database.php";
require_once __DIR__ . "/../core/Response.php";

$db = Database::connect();

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["numero"], $data["valor"], $data["datap"], $data["statusp"])) {
    Response::json(["error" => true, "message" => "Dados incompletos"], 400);
}

$numero = $data["numero"];

try {
    
    $stmt = $db->prepare("
        INSERT INTO parcelas(numero, valor, datap, statusp)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->execute([
        $numero,
        $data["valor"],
        $data["datap"],
        $data["statusp"]
    ]);

    Response::json(["success" => true, "message" => "Parcelas inseridas"], 200);
} catch (Exception $e) {
    Response::json(["error" => true, "message" => $e->getMessage()], 500);
}
