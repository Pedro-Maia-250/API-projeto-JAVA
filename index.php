<?php
require_once __DIR__ . "/core/Router.php";

$router = new Router();

// ROTA DE TESTE (ping)
$router->add("GET", "/api/ping", function () {
    require __DIR__ . "/routes/ping.php";
});

$router->add("POST", "/api/contratos", function () {
    require __DIR__ . "/routes/contratos_create.php";
});

$router->add("POST", "/api/parcelas", function () {
    require __DIR__ . "/routes/parcelas_create.php";
});

$router->add("GET", "/api/parcelas/{numero}", function ($params) {
    require __DIR__ . "/routes/parcelas_list.php";
});


// Aqui você adicionaria outras rotas no futuro:
// $router->add("POST", "/api/login", ...etc);

$router->run();
