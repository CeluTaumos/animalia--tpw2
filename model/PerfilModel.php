<?php
class PerfilModel{

    private $database;

    public function __construct($database) {
        $this->database = $database;
    }
    public function getUsuario(){
        $usuario = $_SESSION['user'];
        $query = "SELECT * FROM usuario WHERE user_name =  '$usuario'";
        return $this->database->query($query);
    }
}
