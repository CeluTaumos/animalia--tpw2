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
        $usuario = $_SESSION['user'];
        $partida = $this->model->getPartida($usuario);
        $datos['puntaje'] = $partida[0]['puntaje'];
        $this->render->printView('lobby', $datos);
    }
}