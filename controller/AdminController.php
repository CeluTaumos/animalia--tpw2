<?php

class AdminController
{
    private $render;
    private $model;

    public function __construct($render, $model)
    {
        $this->render = $render;
        $this->model = $model;
    }

    public function estadisticas() {
     
        $cantidadJugadores = $this->model->obtenerCantidadJugadores();
        $cantidadPartidas = $this->model->obtenerCantidadPartidas();
        $cantidadPreguntas = $this->model->obtenerCantidadPreguntas();
        $usuariosNuevos = $this->model->obtenerUsuariosNuevos();

      
        $context = [
            'cantidadJugadores' => $cantidadJugadores['cantidad'],
            'cantidadPartidas' => $cantidadPartidas['cantidad'],
            'cantidadPreguntas' => $cantidadPreguntas['cantidad'],
            'usuariosNuevos' => $usuariosNuevos['cantidad'],
        ];

    
        $this->render->renderView('lobbyadmin', $context);
    }
}

