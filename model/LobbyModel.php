<?php

class LobbyModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getUser($usuario)
    {
        $query = "SELECT * from usuario where user_name like" . $usuario . "";
        return $this->database->query($query);
    }

}