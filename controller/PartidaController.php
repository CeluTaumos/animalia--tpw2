<?php

class PartidaController
{
    private $render;
    private $model;
    private $partidaJugada;


    public function __construct($render, $model)
    {
        $this->render = $render;
        $this->model = $model;
        $this->partidaJugada = array();
    }


    public function generarRandom()
    {

        return rand(1, 4);
    }

    public function mostrarPantallaPartida()
    {
        $idGenerado = $this->generarRandom();

        array_push($this->partidaJugada, $idGenerado);
        $datos['pregunta'] = $this->model->getPreguntaPorID($idGenerado);
        $datos['respuesta'] = $this->model->getRespuestaPorID($idGenerado);

        $this->render->printView('jugarPartida', $datos);
    }
}
