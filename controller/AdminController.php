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
        if(isset($_POST['enviar']) && is_numeric($_POST['id'])){
            $id = $_POST['id'];
        }
    
        if ($id !== null) {
            $pregunta = $this->model->getDescripcion($id);
            if ($pregunta) {
                // Extraigo la fila asociada al resultado
                $row = $pregunta->fetch_assoc();
    
                // Verifico si la columna 'descripcion' existe en la fila
                if (isset($row['descripcion'])) {
                    $pregunta = $row['descripcion'];
                    
            $this->model->reportar($pregunta, $id);
        }
    }
        $datos['id'] = $_POST['id'];
        $this->render->printView('jugarPartida', $datos);
    }
}
}
