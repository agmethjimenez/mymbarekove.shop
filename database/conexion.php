<?php
class Database{
    private $servername = "localhost";
    private $database = "mymba";
    private $username = "root";
    private $password = "";
    private $port = 3306;
    private $charset = "utf8mb4"; 
    private $conn;

    public function connect(){
        $dsn = "mysql:host={$this->servername};port={$this->port};dbname={$this->database};charset={$this->charset}"; 
        try {
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $this->conn->exec("SET NAMES '{$this->charset}'");
            
            return $this->conn;
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            exit(); 
        }
    }
}

$database = new Database();
$conexion = $database->connect();
?>
