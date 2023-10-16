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
        $datos['pregunta_y_respuestas'] = $this->model->getPreguntaYSuRespuesta();
        $this->render->printView('jugarPartida', $datos);
    }
}