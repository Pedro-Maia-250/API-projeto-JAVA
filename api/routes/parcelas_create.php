<<?php

require_once __DIR__ . "/../core/Database.php";
require_once __DIR__ . "/../core/Response.php";

$conn = $db->getConnection();

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["numero"], $data["parcelas"])) {
    Response::json(["error" => true, "message" => "Dados incompletos"], 400);
}

$numero = $data["numero"];
$parcelas = $data["parcelas"]; // array gerado pelo seu JAVA

try {
    foreach ($parcelas as $p) {
        $stmt = $conn->prepare("
            INSERT INTO parcelas(numero, valor, datap, statusp)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->execute([
            $numero,
            $p["valor"],
            $p["datap"],
            $p["statusp"]
        ]);
    }

    Response::json(["success" => true, "message" => "Parcelas inseridas"]);
} catch (Exception $e) {
    Response::json(["error" => true, "message" => $e->getMessage()], 500);
}
