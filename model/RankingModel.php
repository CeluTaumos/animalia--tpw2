<?php
class RankingModel{

    private $database;

    public function __construct($database) {
        $this->database = $database;
    }
    public function getRanking(){
        $query = 'SELECT user_name, MAX(puntaje) FROM Partida 
        GROUP BY user_name
        ORDER BY MAX(puntaje) DESC LIMIT 7';
        return $this->database->query($query);
    }
    public function getPartidasPrevias() {
        $query = "SELECT  user_name, puntaje, fecha FROM Partida WHERE user_name = '" . $_SESSION['user'] . "' ORDER BY fecha DESC LIMIT 10";
        return $this->database->query($query);
    }
    
}

// arreglar el htaccess