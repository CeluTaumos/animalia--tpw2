<?php
class PerfilController{
    private $render;
    private $model;
    private $usuario;

    public function __construct($render, $model) {
        $this->render = $render;
        $this->model = $model;
        $this->usuario = $_SESSION['user'];
    }
    public function mostrarPantallaPerfil(){
        $datos['usuario']=$this->model->getUsuario($this->usuario);
        $this->render->printView('perfil', $datos);
    }

    
}