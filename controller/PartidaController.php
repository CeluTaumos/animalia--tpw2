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
        if (!isset($_SESSION['preguntas_mostradas'])) {
            $_SESSION['preguntas_mostradas'] = array();
        }

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

        // Generar una clave única para esta pregunta
        $pregunta_id = uniqid();

        // Guardar el tiempo de inicio y la pregunta actual en la sesión
        $_SESSION['tiempo_inicio'][$pregunta_id] = time();
        $_SESSION['pregunta_actual'] = $pregunta_id;

        $this->render->printView('jugarPartida', $datos);
    }

    public function pantallaPerdedor()
    {
        $datos['puntaje'] = $_SESSION['puntaje'];
        $this->render->printView('pantallaPerdedor', $datos);
    }
    public function verificarRespuesta()
    {
        $datos = array();
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
     
            $respuesta = $this->model->getRespuesta($id);
     
            $resultado = $respuesta[0]["es_correcta_int"];
     
            if ($resultado == '1') {
                // Verificar si ha pasado menos de 10 segundos desde el inicio de la pregunta
                if (isset($_SESSION['tiempo_inicio'][$_SESSION['pregunta_actual']])) {
                    $tiempo_actual = time();
                    $tiempo_inicio_pregunta = $_SESSION['tiempo_inicio'][$_SESSION['pregunta_actual']];
                    if (($tiempo_actual - $tiempo_inicio_pregunta) <= 10) {
                        $this->puntaje++;
                        $_SESSION['puntaje'] += $this->puntaje;
                        $usuario = $_SESSION['user'];
                        $id = $this->model->getIdPartida($usuario);
                        if ($id !== null) {
                            $this->model->aumentarPuntuacionEnPartida($usuario, $id);
                        } else {
                            $this->model->subirPuntuacionEnPartida($usuario);
                        }
     
                        $this->mostrarPantallaPartida();
                    } else {
                        $datos['puntaje'] = $_SESSION['puntaje'];
                        $_SESSION['puntaje'] = $this->puntaje;
                        $this->model->guardarPartida();
                        $this->render->printView('pantallaPerdedor', $datos);
                    }
                }
            }
        }
    }
}
