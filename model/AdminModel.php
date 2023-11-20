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
        (p.cant_preguntas_entregadas) AS total_preguntas,
        SUM(p.respuestas_correctas) AS respuestas_correctas,
        (SUM(p.respuestas_correctas) / (p.cant_preguntas_entregadas)) * 100 AS porcentaje_correctas
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
        $query = "SELECT descripcion FROM pregunta WHERE id = '$idRandom'";
        $result = $this->database->queryB($query);
        return $result;
    }

    public function getUser($usuario)
    {
        $query = "SELECT nivel FROM usuario WHERE user_name LIKE '" . $usuario . "'";
        return $this->database->queryB($query);
    }
    public function getCantidadMenores($filtro){
        //dia
        if($filtro==1){
            $query = "SELECT COUNT(*) AS cantidad_menores
            FROM usuario
            WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) < 18 AND fecha_registro >= NOW() - INTERVAL 1 DAY";
        //semana
        }else if($filtro==2){
            $query = "SELECT COUNT(*) AS cantidad_menores
            FROM usuario
            WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) < 18 AND fecha_registro >= NOW() - INTERVAL 1 WEEK";
        //mes
        }else if($filtro==3){
            $query = "SELECT COUNT(*) AS cantidad_menores
            FROM usuario
            WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) < 18 AND fecha_registro >= NOW() - INTERVAL 1 MONTH";
        //año
        }else{
            $query = "SELECT COUNT(*) AS cantidad_menores
            FROM usuario
            WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) < 18";
        }
        
        return $this->database->query($query);
    }
    public function getCantidadAdolescentes($filtro){
        if($filtro==1){
            $query = "SELECT COUNT(*) AS cantidad_adolescentes
            FROM usuario
            WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) BETWEEN 18 AND 21 AND fecha_registro >= NOW() - INTERVAL 1 DAY";
        }else if($filtro==2){
            $query = "SELECT COUNT(*) AS cantidad_adolescentes
            FROM usuario
            WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) BETWEEN 18 AND 21 AND fecha_registro >= NOW() - INTERVAL 1 WEEK";
        }else if($filtro==3){
            $query = "SELECT COUNT(*) AS cantidad_adolescentes
            FROM usuario
            WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) BETWEEN 18 AND 21 AND fecha_registro >= NOW() - INTERVAL 1 MONTH";
        }else{
            $query = "SELECT COUNT(*) AS cantidad_adolescentes
            FROM usuario
            WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) BETWEEN 18 AND 21";
        }
        return $this->database->query($query);
    }
    public function getCantidadMedio($filtro){
        if($filtro==1){
            $query = "SELECT COUNT(*) AS cantidad_medio
            FROM usuario
            WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) BETWEEN 22 AND 60 AND fecha_registro >= NOW() - INTERVAL 1 DAY";
        }else if($filtro==2){
            $query = "SELECT COUNT(*) AS cantidad_medio
            FROM usuario
            WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) BETWEEN 22 AND 60 AND fecha_registro >= NOW() - INTERVAL 1 WEEK";
        }else if($filtro==3){
            $query = "SELECT COUNT(*) AS cantidad_medio
            FROM usuario
            WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) BETWEEN 22 AND 60 AND fecha_registro >= NOW() - INTERVAL 1 MONTH";
        }else{
            $query = "SELECT COUNT(*) AS cantidad_medio
            FROM usuario
            WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) BETWEEN 22 AND 60";
        }     
        
        return $this->database->query($query);
    }
    public function getCantidadJubilados($filtro){
        if($filtro==1){
            $query = "SELECT COUNT(*) AS cantidad_jubilados
            FROM usuario
            WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) > 61 AND fecha_registro >= NOW() - INTERVAL 1 DAY";
        }else if($filtro==2){
            $query = "SELECT COUNT(*) AS cantidad_jubilados
            FROM usuario
            WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) > 61 AND fecha_registro >= NOW() - INTERVAL 1 WEEK";
        }else if($filtro==3){
            $query = "SELECT COUNT(*) AS cantidad_jubilados
            FROM usuario
            WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) > 61 AND fecha_registro >= NOW() - INTERVAL 1 MONTH";
        }else{
            $query = "SELECT COUNT(*) AS cantidad_jubilados
            FROM usuario
            WHERE TIMESTAMPDIFF(YEAR, anio_de_nacimiento, CURDATE()) > 61";
        }
        return $this->database->query($query);
    }
    public function getCantidadHombres($filtro){
        $query = "SELECT COUNT(*) AS cantidad_usuarios_masculinos
        FROM usuario
        WHERE sexo = 'm' AND fecha_registro >= NOW() - INTERVAL 1 $filtro";
        return $this->database->query($query);
    }
    public function getCantidadMujeres($filtro){
        $query = "SELECT COUNT(*) AS cantidad_usuarios_femeninos
        FROM usuario
        WHERE sexo = 'f' AND fecha_registro >= NOW() - INTERVAL 1 $filtro";
        return $this->database->query($query);
    }
    public function getCantidadDesconocidos($filtro){
        $query = "SELECT COUNT(*) AS cantidad_usuarios_desconocidos
        FROM usuario
        WHERE sexo = 'n' AND fecha_registro >= NOW() - INTERVAL 1 $filtro";
        return $this->database->query($query);
    }
}
