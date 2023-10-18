<?php
class RankingModel{

    private $database;

    public function __construct($database) {
        $this->database = $database;
    }
    public function getRanking(){
        // esto va en el modelo del ranking.
        return $this-> database->query('SELECT user_name, puntaje FROM Partida ORDER BY puntaje DESC');
    }
}

// arreglar el htaccess