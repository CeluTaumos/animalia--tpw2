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


    public function getPreguntas()
    {
        return $this->database->query('SELECT * FROM pregunta');
    }

    public function getPreguntaPorID($idRandom)
    {
        return $this->database->query('SELECT * FROM pregunta WHERE id like ' .  $idRandom);
    }

    public function getRespuestaPorID($idRandom)
    {
        return $this->database->query('SELECT * FROM respuesta WHERE pregunta like  ' . $idRandom);
    }

    public function getRespuesta($idRandom)
{
    $idRandom = (int)$idRandom; // Asegurarse de que $idRandom sea un entero válido
    $query = 'SELECT CAST(es_correcta AS SIGNED) AS es_correcta_int FROM respuesta WHERE id = ' . $idRandom;
    return $this->database->query($query);
}
}
