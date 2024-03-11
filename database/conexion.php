<?php
class Database{
    private $servername = "localhost";
    private $database = "mymba2";
    private $username = "root";
    private $password = "";
    private $conn;

    public function connect(){
        $this->conn= new mysqli($this->servername,$this->username, $this->password, $this->database);
        return $this->conn;
    }
}

$database = new Database();
$conexion = $database->connect();
?>