
<?php

class AdminModel {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }    
    public function obtenerCantidadJugadores() {
        $query = "SELECT COUNT(*) AS cantidad FROM usuario WHERE rol = 'jugador'";
        $result = $this->database->queryB($query);
        return $result;
    }

    public function obtenerCantidadPartidas() {
        $query = "SELECT COUNT(*) AS cantidad FROM partida";
        $result = $this->database->queryB($query);
        return $result;
    }

    public function obtenerCantidadPreguntas() {
        $query = "SELECT COUNT(*) AS cantidad FROM pregunta";
        $result = $this->database->queryB($query);
        return $result;
    }

    public function obtenerUsuariosNuevos() {
        $query = "SELECT COUNT(*) AS cantidad FROM usuario WHERE DATE(fecha_registro) = CURDATE()";
        $result = $this->database->queryB($query);
        return $result;
    }

    public function getDescripcion($idRandom){
        //return $this->database->query('SELECT * FROM pregunta WHERE id like ' .  $idRandom);
        $query = "SELECT descripcion FROM pregunta WHERE id = '$idRandom'";
        $result = $this->database->queryB($query);
        return $result;
    }
    public function reportar($descripcion, $id){
        $query = "INSERT INTO pregunta (descripcion_reporte, pregunta_id) VALUES ('$descripcion', '$id')";
        $result = $this->database->queryB($query);
    }
}
