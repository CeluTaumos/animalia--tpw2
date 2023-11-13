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
            $correcta = $_POST['correcta'];
            $this->model-> agregarPregunta($pregunta, $categoria);
            $id = $this->model-> obtenerIdPregunta($pregunta);
            
            $respuesta1 = $_POST['respuesta1'];
            $respuesta2 = $_POST['respuesta2'];
            $respuesta3 = $_POST['respuesta3'];
            $respuesta4 = $_POST['respuesta4'];
            $this->model->agregarRespuestas($correcta, $respuesta1, $respuesta2 , $respuesta3, $respuesta4, $id[0]['id']);
        }

        $datos['usuario'] =  $_SESSION['user'];
        $this->render->printView('sugerencia', $datos);
    }
    public function actualizarSugerida(){
        //Aca debo recibir todo para eliminar o insertar la pregunta
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['accion'])) {
                $id = $_POST['id'];
                $descripcion = $_POST['descripcion'];
                $categoria = $_POST['categoria'];
                $dificultad= $_POST['dificultad'];
                $accion = $_POST['accion'];
                if ($accion === 'Eliminar') {
                    // Lógica para eliminar la pregunta
                    $this->model->eliminarPregSugerida($id);
                } elseif ($accion === 'Aprobar') {
                    //Necesito descripcion, es_correcta y la pregunta(1) para la respuesta
                    //Necesito descripcion(pregunta) para pregunta
                    //Debo hacer un metodo que inserte primero la descripcion y a la primera poner es_correcta
                    // Lógica para aprobar la pregunta
                    $this->model->aprobarPregSugerida($id, $dificultad);
                    // $pregunta = $this->model-> elegirPregunta($id);
                    // $idPreg = $this->model->obtenerIdPregunta($pregunta);
                    //$this->model->actualizarRelacionPYR();
                }
            }
        }
        $this->mostrarPantallaEditarSugerencias();
    }

    public function mostrarPantallaEditarSugerencias(){
        $datos['reportadas'] = $this->model->getReportadas();
        $resultado = $this->model->getPreguntasSugeridas();
        
        foreach ($resultado as $fila) {
            $datos['sugeridas']['descripcionPregunta'] = $fila['pregunta_descripcion'];
            if (is_string($fila['respuesta_descripcion'])) {
                $datos['respuestas'][] = htmlspecialchars($fila['respuesta_descripcion'], ENT_QUOTES, 'UTF-8');
            }
            if (is_numeric($fila['es_correcta'])) {
                $datos['respuestas'][] = htmlspecialchars($fila['es_correcta'], ENT_QUOTES, 'UTF-8');
            }
            $datos['sugeridas']['numeroPregunta'] = $fila['pregunta'];
            $datos['sugeridas']['categoria'] = $fila['pregunta_categoria'];
            $datos['sugeridas']['dificultad'] =1;
        }
        $datos['usuario'] = $_SESSION['user'];
        $this->render->printView('editarSugerencias', $datos);
    }
    public function editarPreguntas(){
        $datos['pregunta'] = $this->model->obtenerPreguntas();
        $this->render->printView('editorPreguntas', $datos['pregunta']);
    }
    public function modificarPregunta(){
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $pregunta = $_POST['pregunta'];
        }
        $this->model->actualizarPregunta($id, $pregunta);
        $this->editarPreguntas();
    }
    public function eliminarPreguntaReportada(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $this->model->eliminarPregunta($id);
        }
        $this->mostrarPantallaEditarSugerencias();
    }
}