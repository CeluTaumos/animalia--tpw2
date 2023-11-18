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
    public function obtenerCantidadUsuariosMujeres()
    {
        $query = "SELECT COUNT(*) AS cantidad FROM usuario WHERE sexo = 'f'";
        $result = $this->database->queryB($query);
        return $result;
    }
    public function obtenerCantidadUsuariosHombres()
    {
        $query = "SELECT COUNT(*) AS cantidad FROM usuario WHERE sexo = 'm'";
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
        u.user_name = '$user_a_buscar' 
    GROUP BY
        u.user_name";
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
        $query = "INSERT INTO preguntasreportadas(descripcion_reporte, pregunta_id) VALUES ('$descripcion', '$id')";
        $result = $this->database->queryB($query);
    }
    public function getUser($usuario)
    {
        $query = "SELECT nivel FROM usuario WHERE user_name LIKE '" . $usuario . "'";
        return $this->database->queryB($query);
    }
    public function getCantidadMenores(){
        $query = "SELECT COUNT(*) AS cantidad_menores
        FROM usuario
        WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) < 18";
        return $this->database->query($query);
    }
    public function getCantidadAdolescentes(){
        $query = "SELECT COUNT(*) AS cantidad_adolescentes
        FROM usuario
        WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) BETWEEN 18 AND 21";
        return $this->database->query($query);
    }
    public function getCantidadMedio(){
        $query = "SELECT COUNT(*) AS cantidad_medio
        FROM usuario
        WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) BETWEEN 22 AND 60";
        return $this->database->query($query);
    }
    public function getCantidadJubilados(){
        $query = "SELECT COUNT(*) AS cantidad_jubilados
        FROM usuario
        WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) > 61";
        return $this->database->query($query);
    }
    public function getCantidadHombres(){
        $query = "SELECT COUNT(*) AS cantidad_usuarios_masculinos
        FROM usuario
        WHERE sexo = 'm'";
        return $this->database->query($query);
    }
    public function getCantidadMujeres(){
        $query = "SELECT COUNT(*) AS cantidad_usuarios_femeninos
        FROM usuario
        WHERE sexo = 'f'";
        return $this->database->query($query);
    }
    public function getCantidadDesconocidos(){
        $query = "SELECT COUNT(*) AS cantidad_usuarios_desconocidos
        FROM usuario
        WHERE sexo = 'n'";
        return $this->database->query($query);
    }
}
