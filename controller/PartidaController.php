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

    $preguntaAnteriorId = $_SESSION['pregunta_actual'];

    if ($preguntaAnteriorId) {
        
        $tiempoInicioPreguntaAnterior = $_SESSION['tiempo_inicio'][$preguntaAnteriorId];
        $tiempoActual = time();
        $tiempoTranscurrido = $tiempoActual - $tiempoInicioPreguntaAnterior;

       
        $this->puntaje++;
        $_SESSION['puntaje'] += $this->puntaje;
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

    $pregunta_id = uniqid();

    $_SESSION['tiempo_inicio'][$pregunta_id] = time();
    $_SESSION['pregunta_actual'] = $pregunta_id;

    $this->render->printView('jugarPartida', $datos);
    if ($tiempoTranscurrido > 10) {
        $this->pantallaPerdedor();
        return;
    }

}

    //VERIFICACION DE LO QUE EL USUARIO RESPONDE 

    public function verificarRespuesta()
    {
        $datos = array();
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
    
            $respuesta = $this->model->getRespuesta($id);
    
            $resultado = $respuesta[0]["es_correcta_int"];
    
            if ($resultado == '1') {
                $preguntaActualId = $_SESSION['pregunta_actual'];
                if ($preguntaActualId && isset($_SESSION['tiempo_inicio'][$preguntaActualId])) {
                    $tiempoActual = time();
                    $tiempoInicioPregunta = $_SESSION['tiempo_inicio'][$preguntaActualId];
                    $tiempoTranscurrido = $tiempoActual - $tiempoInicioPregunta;
    
                    if ($tiempoTranscurrido <= 10) {
                        // El usuario respondió correctamente en menos de 10 segundos, se suma puntaje
                        $this->puntaje++;
                        $_SESSION['puntaje'] += $this->puntaje;
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
        $datos['puntaje'] = $_SESSION['puntaje'];
        $this->render->printView('pantallaPerdedor', $datos);
    }
}
