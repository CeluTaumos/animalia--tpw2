<?php
class RankingModel{

    private $database;

    public function __construct($database) {
        $this->database = $database;
    }
    public function getRanking(){
        $query = 'SELECT user_name, puntaje FROM Partida ORDER BY puntaje DESC LIMIT 7';
        return $this->database->query($query);
    }
}

// arreglar el htaccess