<?php

class LobbyModel
{
    private $database;

    public function __construct($database)
    {
        $this->database = $database;
    }

    public function getPartida($usuario)
    {
        $query = "SELECT * FROM partida WHERE user_name LIKE '" . $usuario . "'";
        return $this->database->query($query);
    }
    public function getUser($usuario)
    {
        $query = "SELECT nivel FROM usuario WHERE user_name LIKE '" . $usuario . "'";
        return $this->database->queryB($query);
    }

}