<?php
class RankingModel{

    public function getRanking(){
        // esto va en el modelo del ranking.
        return $database->query('select * from usuario');
    }
}

// arreglar el htaccess