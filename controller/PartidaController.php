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
        // Verificar si la partida ha terminado
        if ($_SESSION['puntaje'] < 0) {
            $this->terminarPartida();
            return;
        }

        $idGenerado = $this->getPregunta();

        if (!$this->verificarPreguntaRepetida()) {
            $_SESSION['preguntas_mostradas'][] = $idGenerado;

            $datos['pregunta'] = $this->model->getPreguntaPorID($idGenerado);
            $datos['respuesta'] = $this->model->getRespuestaPorID($idGenerado);

            // Generar una clave única para esta pregunta
            $pregunta_id = uniqid();

            // Guardar el tiempo de inicio en la sesión
            $_SESSION['tiempo_inicio'][$pregunta_id] = time();

            $this->render->printView('jugarPartida', $datos);
        } else {
            // La pregunta se repite, mostrar otra pregunta
            $this->mostrarPantallaPartida();
        }
    }



    public function pantallaPerdedor()
    {
        $datos['puntaje'] = $_SESSION['puntaje'];
        $this->render->printView('pantallaPerdedor', $datos);
    }



    public function verificarRespuesta() {
    if ($this->verificarTrampa()) {
        // El usuario intentó hacer trampa
        $this->terminarPartida();
        return;
    }

    $datos = array();

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $respuesta = $this->model->getRespuesta($id);

        if ($respuesta) {
            $esCorrecta = (int)$respuesta[0]['respuesta_correcta'];
            if ($esCorrecta === 1) {
                if (!$this->verificarTiempoLimite()) {
                    // El usuario respondió correctamente, pero se pasó del tiempo límite
                    $this->terminarPartida();
                    return;
                }

                // Respuesta correcta y dentro del tiempo límite
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
                // Respuesta incorrecta
                $this->terminarPartida();
            }
        }
    }
}

    private function terminarPartida()
    {
        $datos['puntaje'] = $_SESSION['puntaje'];
        $this->render->printView('pantallaPerdedor', $datos);

        // Reiniciar el puntaje y limpiar las variables de sesión relacionadas con la partida
        $_SESSION['puntaje'] = 0;
        unset($_SESSION['pregunta_actual']);
        unset($_SESSION['tiempo_inicio']);
        unset($_SESSION['ultima_pregunta_mostrada']);
    }

    private function verificarTrampa()
    {
        if (isset($_SESSION['ultima_pregunta_mostrada'])) {
            $tiempo_actual = time();
            $tiempo_transcurrido = $tiempo_actual - $_SESSION['ultima_pregunta_mostrada'];
            if ($tiempo_transcurrido < 10) {
                return true; // El usuario intentó hacer trampa recargando la página antes de tiempo
            }
        }
        return false;
    }

    private function verificarPreguntaRepetida()
    {
        if (!isset($_SESSION['preguntas_mostradas'])) {
            $_SESSION['preguntas_mostradas'] = array();
        }

        if (empty($_SESSION['preguntas_disponibles'])) {
            $preguntas = $this->model->getPreguntas();
            $_SESSION['preguntas_disponibles'] = array_column($preguntas, 'id');
        }

        $preguntas_disponibles = $_SESSION['preguntas_disponibles'];
        $idGenerado = $this->getPregunta();

        return in_array($idGenerado, $_SESSION['preguntas_mostradas']);
    }

    private function verificarTiempoLimite()
    {
        if (isset($_SESSION['tiempo_inicio'][$_SESSION['pregunta_actual']])) {
            $tiempo_actual = time();
            $tiempo_inicio_pregunta = $_SESSION['tiempo_inicio'][$_SESSION['pregunta_actual']];
            $tiempo_transcurrido = $tiempo_actual - $tiempo_inicio_pregunta;
            return $tiempo_transcurrido <= 10;
        }
        return false;
    }

    private function getPregunta()
    {
        // Verificar si hay preguntas disponibles
        if (empty($_SESSION['preguntas_disponibles'])) {
            return null; // No hay preguntas disponibles
        }

        $preguntas_disponibles = $_SESSION['preguntas_disponibles'];
        $idGenerado = $preguntas_disponibles[array_rand($preguntas_disponibles)];

        $_SESSION['preguntas_mostradas'][] = $idGenerado;

        $key = array_search($idGenerado, $preguntas_disponibles);
        if ($key !== false) {
            unset($preguntas_disponibles[$key]);
            $_SESSION['preguntas_disponibles'] = array_values($preguntas_disponibles);
        }

        return $idGenerado;
    }
}
    

