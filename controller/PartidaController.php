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

    public function mostrarPantallaPartida()
    {

        if (!isset($_SESSION['preguntas_disponibles'])) {
            $_SESSION['preguntas_disponibles'] = array();
        }
        if (!isset($_SESSION['nivel_usuario'])) {
            $_SESSION['nivel_usuario'] = 'principiante';
        }
       
        if (!isset($_SESSION['preguntas_mostradas'])) {
            $_SESSION['preguntas_mostradas'] = array();
        }

        $preguntas_disponibles = $_SESSION['preguntas_disponibles'];
        $nivelUsuario = $_SESSION['nivel_usuario'];
        $idGenerado = null;
        $porcentajeRespuestasCorrectas = 0;

        $datos['dificultad'] = 'desconocida';

        while ($idGenerado === null) {

            if ($nivelUsuario === 'principiante' || $nivelUsuario === 'intermedio' || $nivelUsuario === 'experto') {
                $idGenerado = $this->model->getPreguntaSegunNivel($nivelUsuario);
            }
            if (in_array($idGenerado, $_SESSION['preguntas_mostradas'])) {

                $idGenerado = null;
            } else {

                $this->model->aumentarPreguntasEntregadas($_SESSION['user']);
                $_SESSION['preguntas_mostradas'][] = $idGenerado;
                $preguntaDificultad = $this->model->getDificultadPregunta($idGenerado);
                $datos['dificultad'] = $preguntaDificultad;
            }
            //}

            if ($idGenerado === null) {

                if (empty($_SESSION['preguntas_disponibles'])) {
                    $preguntas = $this->model->getPreguntas();
                    $_SESSION['preguntas_disponibles'] = array_column($preguntas, 'id');
                }
                $_SESSION['tiempo_entrega_pregunta'] = microtime(true);
                $preguntaAnteriorId = $_SESSION['pregunta_actual'];

                if ($preguntaAnteriorId) {
                    $tiempoInicioPreguntaAnterior = $_SESSION['tiempo_inicio'][$preguntaAnteriorId];
                    $tiempoActual = time();
                    $tiempoTranscurrido = $tiempoActual - $tiempoInicioPreguntaAnterior;
                }

                $idGenerado = $preguntas_disponibles[array_rand($preguntas_disponibles)];

                $_SESSION['preguntas_mostradas'][] = $idGenerado;

                $key = array_search($idGenerado, $preguntas_disponibles);
                if ($key !== false) {
                    unset($preguntas_disponibles[$key]);
                    $_SESSION['preguntas_disponibles'] = array_values($preguntas_disponibles);
                }

                $datos['pregunta'] = $this->model->getPreguntaPorID($idGenerado);
                $datos['respuesta'] = $this->model->getRespuestaPorID($idGenerado);
                $pregunta_id = uniqid();

                $_SESSION['tiempo_inicio'][$pregunta_id] = time();
                $_SESSION['pregunta_actual'] = $pregunta_id;
            }
            $this->render->printView('jugarPartida', $datos);

            if ($tiempoTranscurrido > 10 && !isset($_SESSION['pantalla_perdedor_mostrada'])) {
                $puntaje = $_SESSION['puntaje'];
                $user= $_SESSION['user'];
                //$respuestasCorrectas = 
                $this->model->actualizarPartida($puntaje, $user);
                $_SESSION['pantalla_perdedor_mostrada'] = true;
                $this->pantallaPerdedor();
                return;
            }
        }
    }

    public function verificarRespuesta()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];

            $respuesta = $this->model->getRespuesta($id);
            $resultado = $respuesta[0]["es_correcta_int"];

            $_SESSION['preguntas_respondidas'][] = $id;

            if (isset($_SESSION['tiempo_entrega_pregunta'])) {
                $tiempoEntregaPregunta = $_SESSION['tiempo_entrega_pregunta'];
                $tiempoActual = microtime(true);
                $tiempoTranscurrido = $tiempoActual - $tiempoEntregaPregunta;
                if ($tiempoTranscurrido <= 10) {
                    if ($resultado == '1') {

                        
                        $_SESSION['puntaje'] = $_SESSION['puntaje']+1;
                        $usuario = $_SESSION['user'];
                        $idPartida = $this->model->getIdPartida($usuario);

                        if ($idPartida !== null) {
                            $this->model->aumentarPuntuacionEnPartida($usuario, $idPartida);
                        } else {
                            $this->model->subirPuntuacionEnPartida($usuario);
                        }


                        $this->mostrarPantallaPartida();
                        return;
                    }
                }
            }
        }


        $this->pantallaPerdedor();
    }

    public function pantallaPerdedor()
    {
        $nivelUsuario = $this->model->actualizarNivelUsuario($_SESSION['user']);
        $_SESSION['nivel_usuario'] = $nivelUsuario;
        $datos['puntaje'] = $_SESSION['puntaje'];
        $this->render->printView('pantallaPerdedor', $datos);
    }
}
