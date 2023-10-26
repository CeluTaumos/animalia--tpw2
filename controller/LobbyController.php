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
        $datos['puntaje'] = $_SESSION['puntaje'];
        $this->render->printView('lobby', $datos);
    }

    public function cerrarSesion()
    {
        $datos = null;
        session_destroy();
        $this->render->printView('index', $datos);
    }
}
