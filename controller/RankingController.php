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
        $datos['partidasPrevias']=$this->model->getPartidasPrevias();
        $this->render->printView('ranking', $datos);
    }

    
}