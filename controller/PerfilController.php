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
                $descripcionPreg = $_POST['descripcion'];
                $categoriaPreg = $_POST['categoria'];
                $dificultad= $_POST['dificultad'];
                $es_correcta = $this->model->getPreguntasSugeridas();
                $respuestas = $this->model->getPreguntasSugeridas();
                
                $esCorrectaArray = array();
                $respuestasArray = array();
                
                foreach ($respuestas as $index => $respuesta) {
                    // Asegurarse de que el índice exista antes de acceder a él
                    if (isset($respuesta['respuesta_descripcion'])) {
                        $respuestasArray[] = $respuesta['respuesta_descripcion'];
                        var_dump($respuestasArray[$index]);
                    }
                }
                
                for ($i = count($es_correcta) - 4; $i < count($es_correcta); $i++) {
                    if (isset($es_correcta[$i]['es_correcta'])) {
                        $esCorrectaArray[] = $es_correcta[$i]['es_correcta'];
                        
                    }
                }
                $accion = $_POST['accion'];
                
                if ($accion === 'Eliminar') {
                    $this->model->eliminarPregSugerida($id);
                } elseif ($accion === 'Aprobar') {
                    $idPregunta = $this->model->aprobarPregSugerida($id, $dificultad);
                    foreach ($respuestasArray as $index => $respuesta) {
                        // Verificar si el índice es_correcta existe antes de acceder a él
                        $es_correcta_respuesta = isset($es_correcta[$index]['es_correcta']) ? $es_correcta[$index]['es_correcta'] : 0;
    
                        // Llamar a la función para insertar la relación PYR
                        $this->model->actualizarRelacionPYR($respuesta, $es_correcta_respuesta, $idPregunta[0][0]);
                        $this->model->eliminarPregSugerida($id);
                    }
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
            // if (is_string($fila['respuesta_descripcion'])) {
            //     $datos['respuestas'][] = htmlspecialchars($fila['respuesta_descripcion'], ENT_QUOTES, 'UTF-8');
            // }
            // if (is_numeric($fila['es_correcta'])) {
            //     $datos['respuestas'][] = htmlspecialchars($fila['es_correcta'], ENT_QUOTES, 'UTF-8');
            // }
            // var_dump($datos['respuestas']);
            // var_dump($datos['respuestas'][3][1]);
            $respuesta = [
                'descripcion' => htmlspecialchars($fila['respuesta_descripcion'], ENT_QUOTES, 'UTF-8'),
                'es_correcta' => htmlspecialchars($fila['es_correcta'], ENT_QUOTES, 'UTF-8')
            ];
            $datos['respuestas'][] = $respuesta;
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