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
        $datos = null;
        $cantidadJugadores = $this->model->obtenerCantidadJugadores();
        $cantidadPartidas = $this->model->obtenerCantidadPartidas();
        $cantidadPreguntas = $this->model->obtenerCantidadPreguntas();
        $usuariosNuevos = $this->model->obtenerUsuariosNuevos();
        $datos = [
            'cantidadJugadores' => $cantidadJugadores['cantidad'],
            'cantidadPartidas' => $cantidadPartidas['cantidad'],
            'cantidadPreguntas' => $cantidadPreguntas['cantidad'],
            'usuariosNuevos' => $usuariosNuevos['cantidad'],
        ];
        $_SESSION['estadisticas'] = $datos;
    
        $this->render->printView('lobbyadmin', $datos);
    }
}

