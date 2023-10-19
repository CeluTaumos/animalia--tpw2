<?php
class PerfilController{
    private $render;
    private $model;

    public function __construct($render, $model) {
        $this->render = $render;
        $this->model = $model;
    }
    public function mostrarPantallaPerfil(){
        $datos['usuario']=$this->model->getUsuario();
        $this->render->printView('perfil', $datos);
    }

    
}