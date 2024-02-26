<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "mymba";
    private $port = 3306;
    private $connection;

    public function connect() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database, $this->port);

        if ($this->connection->connect_error) {
            die("Conexión fallida: " . $this->connection->connect_error);
        }
        return $this->connection;
    }
}
$database = new Database();

$database->connect();

?>
