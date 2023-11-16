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
    public function mostrarDatos()
    {
        $datos = [
            'user' => $_SESSION['user'],
        ];

        return $this->render->printView('lobbyadmin', $datos);
    }

    public function estadisticas()
    {
        /*Por otro lado debe existir el usuario administrador, capaz de ver la 
         cantidad de preguntas creadas
         porcentaje de preguntas respondidas correctamente por usuario, 
         cantidad de usuarios por pais, 
         cantidad de usuarios por sexo, cantidad de usuarios por grupo de edad (menores, jubilados, medio). 
         Todos estos gráficos deben poder filtarse por día, semana, mes o año. 
         Estos reportes tienen que poder imprimirse (al menos las
tablas de datos)*/
        $cantidadJugadores = $this->model->obtenerCantidadJugadores();

        $cantidadPartidas = $this->model->obtenerCantidadPartidas();
        $cantidadPreguntas = $this->model->obtenerCantidadPreguntas();
        $usuariosNuevos = $this->model->obtenerUsuariosNuevos();
        $usuariosMujeres = $this->model->obtenerCantidadUsuariosMujeres();
        $usuariosHombres = $this->model->obtenerCantidadUsuariosHombres();
        
        $datos = [
            'cantidadJugadores' => $cantidadJugadores[0]['cantidad'],
            'cantidadMujeres' => $this->obtenerDato($usuariosMujeres),
            'cantidadHombres' => $this->obtenerDato($usuariosHombres),
            'cantidadPartidas' => $this->obtenerDato($cantidadPartidas),
            'cantidadPreguntas' => $this->obtenerDato($cantidadPreguntas),
            'usuariosNuevos' => $this->obtenerDato($usuariosNuevos)
         ];
            $datos['porcentajeCorrectas']=null;
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_a_buscar = $_POST['user_a_buscar'];
            $porcentajeCorrectas = $this->model->obtenerPreguntasRespondidasCorrectamentePorUsuario($user_a_buscar);
            $datos['porcentajeCorrectas'] = $porcentajeCorrectas[0];
        }
        $_SESSION['estadisticas'] = $datos;
        //var_dump($_SESSION['estadisticas']);
        $this->render->printView('verEstadisticas',$_SESSION['estadisticas']);
    }

    private function obtenerDato($result)
    {
        if ($result && is_object($result) && method_exists($result, 'fetch_assoc')) {
            $row = $result->fetch_assoc();
            return isset($row['cantidad']) ? $row['cantidad'] : 0;
        }
        return 0;
    }


    public function reportarPregunta()
    {

        if (isset($_POST['enviar']) && is_numeric($_POST['id'])) {
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
    public function mostrarPantallaLobby()
    {


        $datos = null;
        $this->render->printView('lobbyadmin', $datos);

    }
    public function mostrarPantallaGraficos(){
        $datos = null;
        
        $this->render->printView('graficos', $datos);
    }
}
