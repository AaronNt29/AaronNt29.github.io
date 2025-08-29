<?php

class Database {
    private $host = 'localhost';     // Servidor de BD
    private $db_name = 'rfdengue';   // Nombre de la base de datos
    private $username = 'root';      // Usuario MySQL
    private $password = '';          // Contraseña MySQL
    public $conn;

    public function __construct() {
        $this->conn = null;
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
    }
}
