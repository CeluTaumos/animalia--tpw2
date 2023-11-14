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

  

    //ESTA ME TRAE UN ARRAY
    public function query($sql, $params = array()) {
        Logger::info('Ejecutando query: ' . $sql);
        $stmt = mysqli_prepare($this->conn, $sql);
    
        if ($stmt) {
            if (!empty($params)) {
                $types = str_repeat('s', count($params)); // Tipos de datos: 's' para cadenas
                mysqli_stmt_bind_param($stmt, $types, ...$params);
            }
    
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            return mysqli_fetch_all($result, MYSQLI_BOTH);
        } else {
            Logger::error('Error al preparar la consulta: ' . $sql);
            return false;
        }
    }
    //ESTA ME TRAE UNSOLO RESULTADO
    public function queryB($sql) {
        Logger::info('Ejecutando query: ' . $sql);
        $result = mysqli_query($this->conn, $sql);
    
        if ($result) {
            return $result;
        } else {
            echo "Error en la consulta SQL: " . mysqli_error($this->conn);
            return false;
        }
    }
}
    
