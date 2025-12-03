<?php
require_once __DIR__ . "/Response.php";

class Router {

    private $routes = [];

    // Adiciona rota à lista
    public function add($method, $path, $callback) {
        $this->routes[] = [
            "method" => strtoupper($method),
            "path"   => $path,
            "callback" => $callback
        ];
    }

    // Executa o roteamento
    public function run() {

        $method = $_SERVER["REQUEST_METHOD"];
        $uri = strtok($_SERVER["REQUEST_URI"], "?"); // remove query string

        foreach ($this->routes as $route) {
            if ($route["method"] === $method && $route["path"] === $uri) {
                return $route["callback"]();
            }
        }

        Response::error("Endpoint não encontrado", 404);
    }
}
