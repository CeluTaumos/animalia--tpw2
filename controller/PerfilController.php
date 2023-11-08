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
        if(isset($_POST["user"])){
            $user= $_POST['user'];
        }else{
            $user= $_SESSION["user"];
        }
        $datos['usuario']= $this->model->buscarUsuario($user);
        $this->render->printView('perfil', $datos);
    }
    public function mostrarPantallaPerfilNuevo(){
        if(isset($_POST["user"])){
            $user= $_POST['user'];
            $datos['usuario']= $this->model->buscarUsuario($user);
        }
        
        $this->render->printView('perfilEstatico', $datos);
    }
    
}