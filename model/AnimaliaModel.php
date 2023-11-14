<?php

class AnimaliaModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function revisarUsuarioYPass($usuario, $password)
    {
        $query = ("SELECT user_name, contrasenia FROM usuario WHERE user_name = '$usuario' AND contrasenia = '$password'");
        return $this->database->query($query);
    }
    public function obtenerRolUsuario($usuario){
        $query = "SELECT rol FROM usuario WHERE user_name = '$usuario'";
        $result = $this->database->queryB($query);

        if ($result) {
            $row = $result->fetch_assoc(); 
            if ($row) {
                return $row['rol']; 
            }
        }
       
        return 'usuario'; 
    }   
    public function registrarUsuario($usuario, $password, $nombre, $fecha, $sexo, $mail){
        $query = "INSERT INTO usuario (user_name, contrasenia, nombre_completo, anio_de_nacimiento, sexo, mail) 
              VALUES ('$usuario', '$password', '$nombre', '$fecha', '$sexo', '$mail')";
        $resultado =$this->database->queryB($query);
    }

    public function subirFoto($usuario, $imagen)
    {
        if (!empty($imagen)) {
            $query = "UPDATE usuario
        SET foto_de_perfil = '$imagen'
        WHERE user_name = '$usuario'";
            $resultado = $this->database->queryB($query);
        }
    }

    public function usuarioRepetido($usuario)
    {
        $query = "SELECT * FROM usuario WHERE user_name = '" . $usuario . "'";
        $resultado = $this->database->query($query);
        if ($resultado == null) {
            return false;
        } else {
            return true;
        }

    }
// private function obtenerValorConsulta($query) {
//     $result = $this->database->query($query);
//     if ($result && is_object($result)) {
//         $row = $result->fetch_assoc();
//         if ($row) {
//             return $row['cantidad'];
//         }
//     }
    
//     return 1; // Valor por defecto en caso de que no se encuentren datos
// }
// public function obtenerEstadisticas(){
//     $datos = [];

//     $datos['cantidadJugadores'] = $this->obtenerValorConsulta("SELECT COUNT(*) AS cantidad FROM usuario WHERE rol = 'jugador'");
//     $datos['cantidadPartidas'] = $this->obtenerValorConsulta("SELECT COUNT(*) AS cantidad FROM partida");
//     $datos['cantidadPreguntas'] = $this->obtenerValorConsulta("SELECT COUNT(*) AS cantidad FROM pregunta");
//     $datos['usuariosNuevos'] = $this->obtenerValorConsulta("SELECT COUNT(*) AS cantidad FROM usuario WHERE DATE(fecha_registro) = CURDATE()");

//     return $datos;
//     }
    public function verFoto($usuario){
        $query = "SELECT foto_de_perfil FROM usuario WHERE user_name like '$usuario'";
        $resultado = $this->database->query($query);
        $foto_de_perfil = $resultado[0]['foto_de_perfil'];

        return $foto_de_perfil;
    }
    
}
