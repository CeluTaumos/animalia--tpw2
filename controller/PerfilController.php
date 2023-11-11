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
        if($_SESSION['rol']=='admin'){
            $datos['usuario']= $this->model->buscarUsuario($user);
            $this->render->printView('perfilEstatico', $datos);
        }else{
            $datos['usuario']= $this->model->buscarUsuario($user);
            $this->render->printView('perfil', $datos);
        }
        
    }
    public function mostrarPantallaPerfilNuevo(){
        if(isset($_POST["user"])){
            $user= $_POST['user'];
            $datos['usuario']= $this->model->buscarUsuario($user);
        }
        
        $this->render->printView('perfilEstatico', $datos);
    }
    public function mostrarPantallaSugerencias(){
        $datos['usuario'] = $_SESSION['user'];
        $this->render->printView('sugerencia', $datos);
    }
    public function sugerirCategoria(){
        if(isset($_POST['enviar'])){
            $categoria = $_POST['categoria'];
            $this->model-> agregarCategoria($categoria);
            $datos['usuario'] =  $_SESSION['user'];
            $this->render->printView('sugerencia', $datos);
        }else{
            $datos['usuario'] =  $_SESSION['user'];
            echo "Error al agregar categoria";
            $this->render->printView('perfil', $datos);
        }
        
    }

    public function sugerirPregunta(){
        if(isset($_POST['send'])){
            $pregunta = $_POST['pregunta'];
            $categoria = $_POST['categoria'];
            $this->model-> agregarPregunta($pregunta, $categoria);
            $id = $this->model-> obtenerIdPregunta($pregunta);
            
            $respuesta1 = $_POST['respuesta1'];
            $respuesta2 = $_POST['respuesta2'];
            $respuesta3 = $_POST['respuesta3'];
            $respuesta4 = $_POST['respuesta4'];
            $this->model->agregarRespuestas($respuesta1, $respuesta2 , $respuesta3, $respuesta4, $id[0]['id']);
        }

        $datos['usuario'] =  $_SESSION['user'];
        $this->render->printView('sugerencia', $datos);
    }

    public function mostrarPantallaEditarSugerencias(){
        $datos['usuario'] = $_SESSION['user'];
        $this->render->printView('editarSugerencias', $datos);
    }
    public function editarPreguntas(){
        $datos['pregunta'] = $this->model->obtenerPreguntas();
        $this->render->printView('editorPreguntas', $datos['pregunta']);
    }
}