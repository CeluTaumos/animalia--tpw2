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
        $query = "INSERT INTO preguntaSugerida (descripcion, categoria, dificultad) 
              VALUES ('$pregunta', '$categoria', 1)";
        $resultado =$this->database->queryB($query);
    }
    public function obtenerIdPregunta($pregunta){
        $query = "SELECT id FROM preguntaSugerida WHERE descripcion = '$pregunta'";
        return $this->database->query($query);
    }
    public function agregarRespuestas($correcta, $respuesta1, $respuesta2, $respuesta3, $respuesta4, $id){
        $query = "INSERT INTO respuestassugeridas (descripcion, pregunta, es_correcta) 
        VALUES ('$respuesta1', '$id', $correcta), ('$respuesta2', '$id', 0), ('$respuesta3', '$id',0), ('$respuesta4', '$id',0)";
        $resultado =$this->database->queryB($query);
    }
    public function elegirPregunta($id){
        $query = "SELECT descripcion FROM pregunta WHERE id = '$id'";
        return $this->database->queryB($query);
    }
    public function obtenerPreguntas() {
        $query = "SELECT id, descripcion FROM pregunta";
        $result = $this->database->queryB($query);
        if ($result && $result instanceof mysqli_result) {
            $preguntas = array();
            while ($row = $result->fetch_assoc()) {
                $preguntas[] = array(
                    'id' => $row['id'],
                    'descripcion' => $row['descripcion']
                );
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
    public function eliminarPregunta($id){
        $deleteRespuestasQuery = "DELETE FROM respuesta WHERE pregunta = '$id'";
        $this->database->queryB($deleteRespuestasQuery);
        $deleteReportadasQuery = "DELETE FROM preguntasreportadas WHERE pregunta_id = '$id'";
        $this->database->queryB($deleteReportadasQuery);
        $query = "DELETE FROM pregunta WHERE id = '$id'";
        $result = $this->database->queryB($query);
    }
    public function getPreguntasSugeridas(){
        $query = "SELECT
        preguntaSugerida.descripcion AS pregunta_descripcion,
        preguntaSugerida.categoria AS pregunta_categoria,
        respuestasSugeridas.descripcion AS respuesta_descripcion,
        respuestasSugeridas.pregunta, respuestasSugeridas.es_correcta
    FROM
        respuestasSugeridas
    JOIN
        preguntaSugerida ON respuestasSugeridas.pregunta = preguntaSugerida.id";
        return $result = $this->database->query($query);
    }
    public function actualizarPregunta($id, $pregunta){
        $query = "UPDATE pregunta SET descripcion = '$pregunta' WHERE id = '$id'";
        $result = $this->database->queryB($query);
    }
    public function eliminarPregSugerida($id){
        $deleteRespuestasQuery = "DELETE FROM respuestassugeridas WHERE pregunta = '$id'";
        $this->database->queryB($deleteRespuestasQuery);
        $query = "DELETE from preguntasugerida WHERE id = '$id'";
        $this->database->queryB($query);
    }
    public function aprobarPregSugerida($id){
        $query = "INSERT INTO pregunta (descripcion, categoria, dificultad) SELECT descripcion, categoria, dificultad FROM preguntaSugerida WHERE id = '$id'";

        $this->database->queryB($query);
        $query = "SELECT LAST_INSERT_ID()";
        return $this->database->query($query);
    }
    public function getEsCorrecta($id){
        $query = "SELECT es_correcta FROM respuestassugeridas WHERE pregunta = '$id'";
        return $this->database->query($query);
    }
    public function actualizarRelacionPYR($descr_respuesta, $es_correcta, $pregunta){
        $query = "INSERT INTO respuesta (descripcion, es_correcta, pregunta) VALUES ('$descr_respuesta', '$es_correcta', '$pregunta')";
        
        $this->database->queryB($query);
    
    }
}

