<?php

class PartidaController
{
    private $render;
    private $model;

    public function __construct($render, $model)
    {
        $this->render = $render;
        $this->model = $model;
    }

    public function mostrarPantallaPartida()
    {
        // array de preguntas y array de respuestas
        $datos = $this->model->getRespuestas();
        $this->render->printView('jugarPartida', $datos);
    }
}