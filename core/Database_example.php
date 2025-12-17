<?php
require_once __DIR__ . "/Response.php";

class Database {

    private static $instance = null;

    public static function connect() {
        if (self::$instance !== null) {
            return self::$instance;
        }

        $host = "localhost";
        $dbname = "nome do banco";
        $user = "nome do usuario";
        $pass = "senha";

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

        try {
            self::$instance = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,  
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
                PDO::ATTR_PERSISTENT => false,                
            ]);

            return self::$instance;

        } catch (PDOException $e) {
        
            Response::error("Falha ao conectar ao banco: " . $e->getMessage(), 500);
        }
    }
}
