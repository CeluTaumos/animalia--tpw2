<?php

class Database {
    private $conn;

    public function __construct($servername, $username, $password, $dbname) {
        $this->conn = mysqli_connect($servername, $username, $password, $dbname);

        if(!$this->conn) {
            Logger::error("Tenemmos problemitas para ingresar a  la base de datos con: $servername, $username, $password, $dbname");
            exit();
        }
    }

    public function __destruct() {
        mysqli_close($this->conn);
    }

    public function query($sql) {
        Logger::info("Ejecutando Query $sql ");
        $result = mysqli_query($this->conn, $sql);

        if (!is_bool($result))
            return mysqli_fetch_all($result, MYSQLI_BOTH);
        else
            return [];
    }
}
