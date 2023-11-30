<?php
class Database{
    private $servername = "localhost";
    private $database = "mymba";
    private $username = "root";
    private $password = "";
    private $conn;

    public function connect(){
        $this->conn= mysqli_connect($this->servername,$this->username, $this->password, $this->database);
        return $this->conn;
    }


}
/*$servername = "localhost";
$database = "mymba";
$username = "root";
$password = "";
// Create connection
$conexion = mysqli_connect($servername, $username, $password, $database);
// Check connection*/
$database = new Database();
$conexion = $database->connect();
?>