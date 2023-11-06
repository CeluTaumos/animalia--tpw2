<?php

class PartidaModel
{

    private $database;

    // $idRandom = rand(1, 100); // Genera un número aleatorio entre 1 y 100


    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getPreguntaYSuRespuesta()
    {
        return $this->database->query(
            'select * 
        from (SELECT *
        FROM pregunta
        ORDER BY RAND()
        LIMIT 1) a
        left join respuesta
        on a.id = respuesta.pregunta'
        );
    }


    public function getRespuestas()
    {
        return $this->database->query('SELECT * FROM respuesta');
    }
 public function subirPuntuacionEnPartida($usuario)
    {
        $this->database->queryB("UPDATE partida SET puntaje = puntaje + 1 where user_name like '" . $usuario . "'");
    }
public function aumentarPuntuacionEnPartida($usuario, $id)
{
    if($id!==NULL)
        $this->database->queryB("UPDATE partida SET puntaje = puntaje + 1 WHERE user_name = '" . $usuario . "' AND id = " . $id);
    else{
        $this->database->queryB("UPDATE partida SET puntaje = puntaje + 1 where user_name like '" . $usuario . "'");
    }    
}


    public function getPreguntas()
    {
        return $this->database->query('SELECT * FROM pregunta');
    }

    public function getPreguntaPorID($idRandom)
    {
        //return $this->database->query('SELECT * FROM pregunta WHERE id like ' .  $idRandom);
        $query = 'SELECT p.descripcion, c.tipo, c.imagen
              FROM pregunta p
              JOIN categoria c ON p.categoria = c.id
              WHERE p.id = ' . $idRandom;

        return $this->database->query($query);
    }

    public function getRespuestaPorID($idRandom)
    {
        return $this->database->query('SELECT * FROM respuesta WHERE pregunta like  ' . $idRandom);
    }

    public function getRespuesta($idRandom)
    {
        $idRandom = (int) $idRandom; // Asegurarse de que $idRandom sea un entero válido
        $query = 'SELECT CAST(es_correcta AS SIGNED) AS es_correcta_int FROM respuesta WHERE id = ' . $idRandom;
        return $this->database->query($query);
    }
    public function guardarPartida(){
        $usuario = $_SESSION['user'];
        $puntaje = $_SESSION['puntaje'];
        $this->database->queryB("INSERT INTO partida(user_name, puntaje, fecha) VALUES('$usuario', '$puntaje', NOW())");
    }
    public function getIdPartida($usuario){
        $query = "SELECT MAX(id) AS max_id FROM partida WHERE user_name = '" . $usuario . "'";
        $result = $this->database->query($query);
    
      
    
       return null;

    }
    
    public function getPorcentajeRespuestasCorrectas($usuario)
    {
        $porcentajeRespuestasCorrectas = 0;
        $query = "SELECT SUM(respuestas_correctas) AS total_respuestas_correctas, SUM(cant_preguntas_entregadas) AS total_preguntas_entregadas FROM partida WHERE user_name = '" . $usuario . "'";
        $result = $this->database->query($query);
    
        //if ($result && $result->num_rows > 0) {
        if ($result && $result instanceof mysqli_result && $result->num_rows > 0) {    
            $row = $result->fetch_assoc();
            $totalRespuestasCorrectas = $row['total_respuestas_correctas'];
            $totalPreguntasEntregadas = $row['total_preguntas_entregadas'];
    
            if ($totalPreguntasEntregadas > 0) {
                $porcentajeRespuestasCorrectas = ($totalRespuestasCorrectas / ($totalPreguntasEntregadas)) * 100;
            } else {
                $porcentajeRespuestasCorrectas = 0;
            }
        }
    
        return $porcentajeRespuestasCorrectas;
    }
    
    public function aumentarPreguntasEntregadas($usuario)
    {
        $query = "UPDATE partida SET cant_preguntas_entregadas = cant_preguntas_entregadas + 1 WHERE user_name = '" . $usuario . "'";
        $this->database->queryB($query);
    }


public function actualizarPreguntaRespuestaCorrecta($idPregunta)
{
    $this->database->queryB("UPDATE pregunta SET respuestas_correctas = respuestas_correctas + 1, respuestas_totales = respuestas_totales + 1 WHERE id = " . $idPregunta);
}

public function getDificultadPregunta($idPregunta)
{
    if (!is_numeric($idPregunta) || $idPregunta <= 0) {
        return 'desconocida'; // Otra respuesta predeterminada o manejo del error.
    }
    $query = "SELECT respuestas_correctas, respuestas_totales FROM pregunta WHERE id = " . $idPregunta;
    $result = $this->database->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $respuestasCorrectas = $row['respuestas_correctas'];
        $respuestasTotales = $row['respuestas_totales'];

        if ($respuestasTotales > 0) {
            $porcentajeCorrectas = ($respuestasCorrectas / $respuestasTotales) * 100;

            if ($porcentajeCorrectas > 70) {
                return 'fácil';
            } elseif ($porcentajeCorrectas < 30) {
                return 'difícil';
            } else {
                return 'intermedia';
            }
        }
    }

    return 'desconocida'; 
}
public function getPreguntaSegunNivel($nivelUsuario)
{
    $dificultad = '';
    
    if ($nivelUsuario == 'principiante') {
        $dificultad = 'fácil';
    } elseif ($nivelUsuario == 'intermedio') {
        $dificultad = 'intermedia';
    } elseif ($nivelUsuario == 'experto') {
        $dificultad = 'difícil';
    }

    $query = "SELECT id FROM pregunta WHERE dificultad = '" . $dificultad . "' LIMIT 10";
    
    $result = $this->database->query($query);

    if ($result && $result->num_rows > 0) {
        $preguntas = $result->fetch_all(MYSQLI_ASSOC);

       
        $preguntaElegida = $preguntas[array_rand($preguntas)];
        
        return $preguntaElegida['id'];
    }
   
    return null;
}
public function actualizarNivelUsuario($usuario)
{
    $porcentajeRespuestasCorrectas = $this->getPorcentajeRespuestasCorrectas($usuario);

    $umbralPrincipiante = 30;
    $umbralIntermedio = 70;
    $nuevoNivel = 'desconocido';

    if ($porcentajeRespuestasCorrectas >= 0 && $porcentajeRespuestasCorrectas <= $umbralPrincipiante) {
        $nuevoNivel = 'principiante';
    } elseif ($porcentajeRespuestasCorrectas > $umbralPrincipiante && $porcentajeRespuestasCorrectas <= $umbralIntermedio) {
        $nuevoNivel = 'intermedio';
    } elseif ($porcentajeRespuestasCorrectas > $umbralIntermedio && $porcentajeRespuestasCorrectas <= 100) {
        $nuevoNivel = 'experto';
    }

    $query = "UPDATE usuario SET nivel = '" . $nuevoNivel . "' WHERE user_name = '" . $usuario . "'";
    $this->database->queryB($query);

    return $nuevoNivel;
}


}
