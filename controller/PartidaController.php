<?php

class PartidaController {
    private $render;
    private $model;

    public function __construct($render, $model) {
        $this->render = $render;
        $this->model = $model;
    }

    public function mostrarPantallaPartida() {
        $datos =null;
        $this->render->printView('jugarPartida', $datos);
}   
}