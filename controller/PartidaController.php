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

    public function verificarRespuesta()
    {
        $datos = array();
        if (isset($_POST['opcion'])) {
            $id = $_POST['opcion']; // $id ahora contiene el ID de la respuesta seleccionada
            $respuesta = $this->model->getRespuesta($id);

            if ($respuesta == 1) {
                $this->mostrarPantallaPartida();
                return; // Agrega un return para evitar que el código siguiente se ejecute
            } else {


                // Si no se cumple la condición anterior, muestra la pantalla de perdedor
                $this->render->printView('pantallaPerdedor', $datos);
            }
        }
    }
}
