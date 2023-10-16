<?php

class PartidaModel
{

    private $database;

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


}