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

        return rand(1, 22);
    }

    public function mostrarPantallaPartida()
    {
        // $idGenerado = $this->generarRandom();
        // array_push($this->partidaJugada, $idGenerado);
        // $datos['pregunta'] = $this->model->getPreguntaPorID($idGenerado);
        // $datos['respuesta'] = $this->model->getRespuestaPorID($idGenerado);
        if (!isset($_SESSION['preguntas_mostradas'])) {
            $_SESSION['preguntas_mostradas'] = array();
        }
        // do {
        //     $idGenerado = $this->generarRandom();
        // } while (in_array($idGenerado, $_SESSION['preguntas_mostradas']));
        if (empty($_SESSION['preguntas_disponibles'])) {

            $preguntas = $this->model->getPreguntas();
            $_SESSION['preguntas_disponibles'] = array_column($preguntas, 'id');
        }


        $preguntas_disponibles = $_SESSION['preguntas_disponibles'];
        $idGenerado = $preguntas_disponibles[array_rand($preguntas_disponibles)];


        $_SESSION['preguntas_mostradas'][] = $idGenerado;


        $key = array_search($idGenerado, $preguntas_disponibles);
        if ($key !== false) {
            unset($preguntas_disponibles[$key]);
            $_SESSION['preguntas_disponibles'] = array_values($preguntas_disponibles);
        }

        $datos['pregunta'] = $this->model->getPreguntaPorID($idGenerado);
        $datos['respuesta'] = $this->model->getRespuestaPorID($idGenerado);

        $this->render->printView('jugarPartida', $datos);
    }

    public function verificarRespuesta()
    {
        $datos = array();
        if (isset($_POST['id'])) {
            $id = $_POST['id'];

            $respuesta = $this->model->getRespuesta($id);

            $resultado = $respuesta[0]["es_correcta_int"];

            if ($resultado == '1') {
                $this->puntaje++;
                $_SESSION['puntaje'] +=  $this->puntaje;
                $usuario = $_SESSION['user'];
                $id = $this->model-> getIdPartida($usuario);
                if ($id !== null) {
                    $this->model->aumentarPuntuacionEnPartida($usuario, $id);
                }else{
                    $this->model->subirPuntuacionEnPartida($usuario);
                }
                
                $this->mostrarPantallaPartida();
            } else {

                $datos['puntaje'] = $_SESSION['puntaje'];
                $_SESSION['puntaje'] =  $this->puntaje;
                $this->model->guardarPartida();
                //PARA GUARDAR EN BDD
                //  guardarPuntaje($this->puntaje);
                $this->render->printView('pantallaPerdedor', $datos);
            }
        }
    }
}
