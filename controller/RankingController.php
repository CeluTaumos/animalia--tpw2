<?php
class RankingController{
    private $render;
    private $model;

    public function __construct($render, $model) {
        $this->render = $render;
        $this->model = $model;
    }

    public function mostrarPantallaRanking(){
        //$respuesta = $this->model->getRespuesta($id);
        $datos=$this->model->getRanking();
        var_dump($datos);
        $this->render->printView('ranking', $datos);
    }

    
}