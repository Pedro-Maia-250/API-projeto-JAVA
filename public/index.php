<?php
require_once __DIR__ . "/../core/Database.php";
require_once __DIR__ . "/../core/Response.php";
require_once __DIR__ . "/../core/Router.php";

$apiKey = $_SERVER['HTTP_X_API_KEY'] ?? null;

if (!$apiKey) {
    Response::error("API Key não fornecida", 401);
    exit;
}

$db = Database::connect();

$stmt = $db->prepare("
    SELECT id 
    FROM api_keys 
    WHERE api_key = :key AND ativo = 1
    LIMIT 1
");

$stmt->execute([
    ':key' => $apiKey
]);

if ($stmt->rowCount() === 0) {
    Response::error("API Key inválida ou inativa", 401);
    exit;
}

$router = new Router();

// ROTA DE TESTE (ping)
$router->add("GET", "/ping", function () {
    require __DIR__ . "/../routes/ping.php";
});

$router->add("POST", "/string/t", function () {
    require __DIR__ . "/../routes/contar_string.php";
});
/*
$router->add("POST", "/contratos", function () {
    require __DIR__ . "/../routes/contratos_create.php";
});

$router->add("POST", "/parcelas", function () {
    require __DIR__ . "/../routes/parcelas_create.php";
});

$router->add("GET", "/parcelas/{numero}", function ($numero) {
    require __DIR__ . "/../routes/parcelas_list.php";
});

$router->add("POST","/contratos/parcelas", function (){
    require __DIR__ . "/../routes/contratos_parcelas_create.php";
});
*/


$router->run();
