<?php

class AnimaliaModel {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function revisarUsuarioYPass($usuario, $password){
        //return $this->database->query('SELECT * FROM usuario where user_name = ' .$usuario . " AND contrasenia = " . $password);
        $query = ("SELECT 1 FROM usuario WHERE user_name = '$usuario' AND contrasenia = '$password'");
        return $this->database->query($query);
    }
}