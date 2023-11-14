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
    public function mostrarDatos() {
        $datos = [
            'user' => $_SESSION['user'], 
        ];
    
        return $this->render->printView('lobbyadmin', $datos);
    }
    
    public function estadisticas() {
        $cantidadJugadores = $this->model->obtenerCantidadJugadores();
        $cantidadPartidas = $this->model->obtenerCantidadPartidas();
        $cantidadPreguntas = $this->model->obtenerCantidadPreguntas();
        $usuariosNuevos = $this->model->obtenerUsuariosNuevos();
        
        $datos = [
            'cantidadJugadores' => $this->obtenerDato($cantidadJugadores),
            'cantidadPartidas' => $this->obtenerDato($cantidadPartidas),
            'cantidadPreguntas' => $this->obtenerDato($cantidadPreguntas),
            'usuariosNuevos' => $this->obtenerDato($usuariosNuevos),
        ];
    
        $_SESSION['estadisticas'] = $datos;
        var_dump($datos);
        $this->render->printView('verEstadisticas', $datos);
    }
    
    private function obtenerDato($result) {
        if ($result && is_object($result) && method_exists($result, 'fetch_assoc')) {
            $row = $result->fetch_assoc();
            return isset($row['cantidad']) ? $row['cantidad'] : 0;
        }
        return 0;
    }
    

    public function reportarPregunta(){
      
        if(isset($_POST['enviar']) && is_numeric($_POST['id'])){
            $id = $_POST['id'];
        }
    
        if ($id !== null) {
            $pregunta = $this->model->getDescripcion($id);
            if ($pregunta) {
                
                $row = $pregunta->fetch_assoc();
                if (isset($row['descripcion'])) {
                    $pregunta = $row['descripcion'];
                    
            $this->model->reportar($pregunta, $id);
        }
    }
        $datos['id'] = $_POST['id'];
        $this->render->printView('jugarPartida', $datos);
    }
}

public function cerrarSesion()
{
    $datos = null;
    session_destroy();
    $this->render->printView('index', $datos);
}
}
