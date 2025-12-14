<?php

require_once __DIR__ . "/../core/Database.php";
require_once __DIR__ . "/../core/Response.php";

$db = Database::connect();

$data = json_decode(file_get_contents("php://input"), true);

if (
    !isset($data["contrato"]) ||
    !isset($data["parcelas"]) ||
    !is_array($data["contrato"]) ||
    !is_array($data["parcelas"]) ||
    count($data["parcelas"]) === 0
) {
    Response::json(
        ["error" => true, "message" => "Contrato ou parcelas inválidos"],
        400
    );
}

$contrato = $data["contrato"];

if (
    !isset($contrato["numero"]) ||
    !isset($contrato["datac"]) ||
    !isset($contrato["valorc"])
) {
    Response::json(
        [
            "error" => true,
            "message" => "Dados inválidos - contrato"
        ],
        400
    );
}

foreach ($data["parcelas"] as $index => $parcela) {
    if (
        !isset($parcela["valor"]) ||
        !isset($parcela["datap"]) ||
        !isset($parcela["statusp"])
    ) {
        Response::json(
            [
                "error" => true,
                "message" => "Parcela inválida no índice $index"
            ],
            400
        );
    }
}

$db->beginTransaction();

try {

    $stmt = $db->prepare(
        "INSERT INTO contratos (numero, valor, datac)
         VALUES (?, ?, ?)"
    );

    $stmt->execute([
        $contrato["numero"],
        $contrato["valorc"],
        $contrato["datac"]
    ]);

    $placeholders = [];
    $values = [];

    foreach ($data["parcelas"] as $parcela) {

        $placeholders[] = "(?, ?, ?, ?)";

        $values[] = $contrato["numero"];
        $values[] = $parcela["valor"];
        $values[] = $parcela["datap"];
        $values[] = $parcela["statusp"];
    }

    $sql = "
        INSERT INTO parcelas (numero, valor, datap, statusp)
        VALUES " . implode(", ", $placeholders);

    $stmt = $db->prepare($sql);
    $stmt->execute($values);

    $db->commit();

    Response::json(
        ["success" => true, "message" => "Contrato criado e parcelas inseridas"],
        200
    );

} catch (Exception $e) {

    try {
        $db->rollBack();
    } catch (Exception $rollbackError) {
        Response::json(
            ["error" => true, "message" => $rollbackError->getMessage()],
            500
        );
    }

    Response::json(
        ["error" => true, "message" => $e->getMessage()],
        500
    );
}
