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
}