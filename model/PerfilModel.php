<?php
class PerfilModel{

    private $database;

    public function __construct($database) {
        $this->database = $database;
    }
    public function getUsuario(){
        if(isset($_POST["user"])){
            $usuario = $_POST['user'];
        }else{
        $usuario= $_SESSION["user"];
        }
        $query = "SELECT * FROM usuario WHERE user_name =  '$usuario'";
        return $this->database->query($query);
    }
    public function buscarUsuario($user){
        $query = "SELECT * FROM usuario WHERE user_name =  '$user'";
        return $this->database->query($query);
    }
    public function agregarCategoria($categoria){
        $query = "INSERT INTO categoriaSugerida (tipo) 
              VALUES ('$categoria')";
        $resultado =$this->database->queryB($query);
    }
    public function agregarPregunta($pregunta, $categoria){
        $query = "INSERT INTO preguntaSugerida (descripcion, categoria) 
              VALUES ('$pregunta', '$categoria')";
        $resultado =$this->database->queryB($query);
    }
    public function obtenerIdPregunta($pregunta){
        $query = "SELECT id FROM preguntaSugerida WHERE descripcion = '$pregunta'";
        return $this->database->query($query);
    }
    public function agregarRespuestas($respuesta1, $respuesta2, $respuesta3, $respuesta4, $id){
        $query = "INSERT INTO respuestassugeridas (descripcion, pregunta) 
        VALUES ('$respuesta1', '$id'), ('$respuesta2', '$id'), ('$respuesta3', '$id'), ('$respuesta4', '$id')";
        $resultado =$this->database->queryB($query);
    }

    public function obtenerPreguntas() {
        $query = "SELECT descripcion FROM pregunta";
        $result = $this->database->queryB($query);
        if ($result && $result instanceof mysqli_result) {
            $preguntas = array();
            while ($row = $result->fetch_assoc()) {
                $preguntas[] = array('descripcion' => $row['descripcion']);
            }
            return array('pregunta' => $preguntas);
        } else {
            
            return array('pregunta' => array()); 
        }
    }
    public function getReportadas(){
        $query = "SELECT pregunta_id, descripcion_reporte FROM preguntasreportadas";
        return $result = $this->database->query($query);

    }
    public function getPreguntasSugeridas(){
        $query = "SELECT
        preguntaSugerida.descripcion AS pregunta_descripcion,
        respuestasSugeridas.descripcion AS respuesta_descripcion,
        respuestasSugeridas.pregunta
    FROM
        respuestasSugeridas
    JOIN
        preguntaSugerida ON respuestasSugeridas.pregunta = preguntaSugerida.id";
        return $result = $this->database->query($query);
    }
}

