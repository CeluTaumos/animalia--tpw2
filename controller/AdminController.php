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

    public function reportarPregunta(){
        //Selecciono el id de la pregunta actual 
        if(isset($_POST['id'])){
            $id = $_POST['id'];
        }
        var_dump($id);
        $pregunta = $this->model->getDescripcion($id);
        //la busco y la copio para ingresarla a preguntas reportadas
        var_dump($pregunta);
        $this->model->reportar($pregunta, $id);
    }
}

