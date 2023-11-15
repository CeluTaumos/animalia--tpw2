<?php

class AdminModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }
    public function obtenerCantidadJugadores()
    {
        $query = "SELECT COUNT(*) AS cantidad FROM usuario WHERE rol LIKE '%jugador%'";

        $result = $this->database->query($query);
        return $result;
    }


    public function obtenerCantidadPartidas()
    {
        $query = "SELECT COUNT(*) AS cantidad FROM partida";
        $result = $this->database->queryB($query);
        return $result;
    }

    public function obtenerCantidadPreguntas()
    {
        $query = "SELECT COUNT(*) AS cantidad FROM pregunta";
        $result = $this->database->queryB($query);
        return $result;
    }

    public function obtenerPreguntasRespondidasCorrectamentePorUsuario($user_a_buscar)
    {
        $query = "SELECT
        u.user_name,
        COUNT(p.id) AS total_preguntas,
        SUM(p.respuestas_correctas) AS respuestas_correctas,
        (SUM(p.respuestas_correctas) / COUNT(p.id)) * 100 AS porcentaje_correctas
    FROM
        usuario u
    JOIN
        partida p ON u.user_name = p.user_name
    WHERE
        u.user_name = 'user_a_buscar'  -- Reemplaza 'nombre_de_usuario' con el nombre del usuario que estás buscando
    GROUP BY
        u.user_name;
    ";
        $result = $this->database->query($query);
        return $result;
    }

    public function obtenerUsuariosNuevos()
    {
        $query = "SELECT COUNT(*) AS cantidad FROM usuario WHERE DATE(fecha_registro) = CURDATE()";
        $result = $this->database->queryB($query);
        return $result;
    }

    public function getDescripcion($idRandom)
    {
        //return $this->database->query('SELECT * FROM pregunta WHERE id like ' .  $idRandom);
        $query = "SELECT descripcion FROM pregunta WHERE id = '$idRandom'";
        $result = $this->database->queryB($query);
        return $result;
    }
    public function reportar($descripcion, $id)
    {
        $query = "INSERT INTO preguntasreportadas (descripcion_reporte, pregunta_id) VALUES ('$descripcion', '$id')";
        $result = $this->database->queryB($query);
    }
    public function getUser($usuario)
    {
        $query = "SELECT nivel FROM usuario WHERE user_name LIKE '" . $usuario . "'";
        return $this->database->queryB($query);
    }
}
