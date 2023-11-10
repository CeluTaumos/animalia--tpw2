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
    public function agregarRespuestas($respuestas){
        $query = "INSERT INTO respuestasSugeridas (descripcion) VALUES ()";
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
    
}

