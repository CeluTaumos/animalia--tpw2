<?php
class RankingController{
    private $render;
    private $model;

    public function __construct($render, $model) {
        $this->render = $render;
        $this->model = $model;
    }
    public function mostrarPantallaRanking(){
        $datos['partida']=$this->model->getRanking();
        //var_dump($datos['partida']);
        $this->render->printView('ranking', $datos);
    }

    
}