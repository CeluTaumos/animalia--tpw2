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
}