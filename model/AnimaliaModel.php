<?php

class AnimaliaModel {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function revisarUsuarioYPass($usuario, $password){
        $query = ("SELECT user_name, contrasenia FROM usuario WHERE user_name = '$usuario' AND contrasenia = '$password'");
        return $this->database->query($query);
    }

    
    public function obtenerRolUsuario($usuario){
        $query = "SELECT rol FROM usuario WHERE user_name = '$usuario'";
        $result = $this->database->queryB($query);

        if ($result) {
            $row = $result->fetch_assoc(); // Obtener la primera fila de resultados
            if ($row) {
                return $row['rol']; // Devolver el valor del rol
            }
        }
        
        // Manejar el error o devolver un valor por defecto en caso de que no se encuentre el usuario
        return 'usuario'; // Valor por defecto si no se encuentra el usuario
    }   
    
    
    
    
    public function registrarUsuario($usuario, $password, $nombre, $fecha, $sexo, $mail){
        $query = "INSERT INTO usuario (user_name, contrasenia, nombre_completo, anio_de_nacimiento, sexo, mail) 
              VALUES ('$usuario', '$password', '$nombre', '$fecha', '$sexo', '$mail')";
        $resultado =$this->database->query($query);
        if ($resultado) {
            echo "Usuario registrado con éxito.";
        } else {
            echo "Error al registrar el usuario: " . mysqli_error($this->database);
        }
    }

    public function subirFoto($usuario, $imagen){
        if (!empty($imagen)) {
        $query = "UPDATE usuario
        SET foto_de_perfil = '$imagen'
        WHERE user_name = '$usuario'";
        $resultado = $this->database->query($query);
        if ($resultado) {
            echo "Foto subida con éxito.";
        } else {
            echo "Error al subir la foto: " . mysqli_error($this->database);
  }
    }
}
// 
private function obtenerValorConsulta($query) {
    $result = $this->database->query($query);
    if ($result && is_object($result)) {
        $row = $result->fetch_assoc();
        if ($row) {
            return $row['cantidad'];
        }
    }
    
    return 1; // Valor por defecto en caso de que no se encuentren datos
}
public function obtenerEstadisticas(){
    $datos = [];

    $datos['cantidadJugadores'] = $this->obtenerValorConsulta("SELECT COUNT(*) AS cantidad FROM usuario WHERE rol = 'jugador'");
    $datos['cantidadPartidas'] = $this->obtenerValorConsulta("SELECT COUNT(*) AS cantidad FROM partida");
    $datos['cantidadPreguntas'] = $this->obtenerValorConsulta("SELECT COUNT(*) AS cantidad FROM pregunta");
    $datos['usuariosNuevos'] = $this->obtenerValorConsulta("SELECT COUNT(*) AS cantidad FROM usuario WHERE DATE(fecha_registro) = CURDATE()");

    return $datos;
}
}