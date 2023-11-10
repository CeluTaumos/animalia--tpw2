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
    public function registrarUsuario($usuario, $password, $nombre, $fecha, $sexo, $mail, $foto)
    {
        $query = "INSERT INTO usuario (user_name, contrasenia, nombre_completo, anio_de_nacimiento, sexo, mail, foto_de_perfil, rol, nivel) 
              VALUES ('$usuario', '$password', '$nombre', '$fecha', '$sexo', '$mail' , '$foto' , 'jugador', 'principiante')";
        $resultado = $this->database->queryB($query);
        
    }

    public function subirFoto($usuario, $imagen)
    {
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
}