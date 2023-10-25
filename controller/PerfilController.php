<?php
class PerfilController{
    private $render;
    private $model;
    private $usuario;

    public function __construct($render, $model) {
        $this->render = $render;
        $this->model = $model;
        $this->usuario = $this->model->getUsuario();
    }
    public function mostrarPantallaPerfil(){
        $user= $_POST['user'];
        $datos['usuario']= $this->model->buscarUsuario($user);
        $this->render->printView('perfil', $datos);
    }

    
}