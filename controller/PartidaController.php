<?php

class PartidaController
{
    private $render;
    private $model;
    private $partidaJugada;
    private $puntaje;


    public function __construct($render, $model)
    {
        $this->render = $render;
        $this->model = $model;
        $this->partidaJugada = array();
        $this->puntaje = 0;
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
        $puntajeActual = 0;
        if (isset($_POST['id'])) {
            $id = $_POST['id']; // $id ahora contiene el ID de la respuesta seleccionada

            $respuesta = $this->model->getRespuesta($id);

            $resultado = $respuesta[0]["es_correcta_int"];

            if ($resultado == '1') {
                $puntajeActual = $this->puntaje + 1;
                $this->mostrarPantallaPartida();
            } else {

                $datos['puntaje'] = $puntajeActual;
                //PARA GUARDAR EN BDD
                //  guardarPuntaje($this->puntaje);
                // Si no se cumple la condición anterior, muestra la pantalla de perdedor
                $this->render->printView('pantallaPerdedor', $datos);
            }
        }
    }
}
