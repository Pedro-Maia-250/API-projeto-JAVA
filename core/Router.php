<?php
require_once __DIR__ . "/Response.php";

class Router {

    private $routes = [];

    public function add($method, $path, $callback) {
        $regex = preg_replace('#\{[a-zA-Z_]+\}#', '([a-zA-Z0-9_-]+)', $path);
        $regex = '#^' . $regex . '$#';

        $this->routes[] = [
            "method" => strtoupper($method),
            "path"   => $path,
            "regex"  => $regex,
            "callback" => $callback
        ];
    }

    public function run() {

        $method = $_SERVER["REQUEST_METHOD"];
        $uri = strtok($_SERVER["REQUEST_URI"], "?");

        foreach ($this->routes as $route) {

            if ($route["method"] !== $method) continue;

            if (preg_match($route["regex"], $uri, $matches)) {

                array_shift($matches); // remove o match completo

                return ($route["callback"])(...$matches);
            }
        }

        Response::error("Endpoint não encontrado", 404);
    }
}
