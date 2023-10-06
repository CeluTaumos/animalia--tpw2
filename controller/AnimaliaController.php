<?php

class AnimaliaController {
    private $render;
    private $model;

    public function __construct($render, $model) {
        $this->render = $render;
        $this->model = $model;
    }

    public function mostrarPantallaInicial() {
        $datos =null;
        $this->render->printView('home', $datos);
    }



    
}