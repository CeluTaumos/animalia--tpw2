<?php

class LobbyController
{
    private $render;
    private $model;

    public function __construct($render, $model)
    {
        $this->render = $render;
        $this->model = $model;
    }
    public function mandarCorreo()
    {
        //Utiliza libreria phpmailer para enviar correo
    }

    public function mostrarPantallaLobby()
{
    $rol = $_SESSION['rol'];
    $datos = null;
    $user = $_SESSION['user'];

    if ($rol == 'admin') {
        // Aca deberia haber un metodo que le pase los datos de las estadisticas a lobbyAdmin
        $_SESSION['estadisticas'] = $this->model->obtenerEstadisticas();
        $datos = $_SESSION['estadisticas'];
        $this->render->printView('lobbyadmin', $datos);
    } elseif ($rol == 'editor') {
        $datos['user'] = $_SESSION['user'];
        $this->render->printView('lobbyeditor', $datos);
    } else {
        $userResult = $this->model->getUser($user);
        
        if ($userResult) {
            $userData = $userResult->fetch_assoc(); // Suponiendo que estás utilizando MySQLi
            $datos['puntaje'] = $_SESSION['puntaje'];
            $datos['user'] = $_SESSION['user'];
            $datos['nivel'] = $userData['nivel'];
        }
        
        $this->render->printView('lobby', $datos);
    }
}


    public function cerrarSesion()
    {
        $datos = null;
        session_destroy();
        $this->render->printView('index', $datos);
    }
}
