<?php
require_once __DIR__ . "/core/Router.php";

$router = new Router();

// ROTA DE TESTE (ping)
$router->add("GET", "/ping", function () {
    require __DIR__ . "/routes/ping.php";
});

// Aqui você adicionaria outras rotas no futuro:
// $router->add("POST", "/api/login", ...etc);

$router->run();
