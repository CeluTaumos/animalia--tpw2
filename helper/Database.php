<?php

class Database {
    private $conn;

    public function __construct($servername, $username, $password, $dbname, $port) {
        
        $this->conn = mysqli_connect($servername, $username, $password, $dbname, $port);
       // mysqli_options($this->conn, MYSQLI_CLIENT_SSL_DONT_VERIFY_SERVER_CERT, true);
        if(!$this->conn) {
            Logger::error("Tenemmos problemitas para ingresar a  la base de datos con: $servername, $username, $password, $dbname");
            exit();
        }
    }

    public function __destruct() {
        mysqli_close($this->conn);
    }

    public function query($sql) {
        Logger::info('Ejecutando query: ' . $sql);
        $result = mysqli_query($this->conn, $sql);
        return mysqli_fetch_all($result, MYSQLI_BOTH);
    }
}
