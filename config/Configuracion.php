<?php
include_once('helper/Database.php');
include_once('helper/MustacheRender.php');
include_once("helper/Router.php");
include_once("helper/Logger.php");
include_once('helper/Redirect.php');
include_once('model/AnimaliaModel.php');
include_once('controller/AnimaliaController.php');
include_once('third-party/mustache/src/Mustache/Autoloader.php');
include_once('model/PartidaModel.php');
include_once('model/RankingModel.php');
include_once('controller/PartidaController.php');
include_once('controller/LobbyController.php');
include_once('model/LobbyModel.php');
include_once('controller/RankingController.php');
include_once('controller/PerfilController.php');
include_once('model/PerfilModel.php');
include("phpqrcode/qrlib.php");
//include_once('PHPMailer/Correo.php');

class Configuracion
{
    public function __construct()
    {
    }

    public function getDatabase()
    {
        $config = parse_ini_file('configuration.ini');
        $database = new Database(
            $config['servername'],
            $config['username'],
            $config['password'],
            $config['dbname'],
            $config['port']
        );
        return $database;
    }

    public function getRender()
    {
        return new MustacheRender();
    }


    public function getAnimaliaController()
    {
        $model = new AnimaliaModel($this->getDatabase());
        return new AnimaliaController($this->getRender(), $model);
    }
    public function getLobbyController()
    {
        $model = new LobbyModel($this->getDatabase());
        return new LobbyController($this->getRender(), $model);
    }
    public function getRouter()
    {
        return new Router($this, "getAnimaliaController", "list");
    }

    public function getPartidaController()
    {
        $model = new PartidaModel($this->getDatabase());
        return new PartidaController($this->getRender(), $model);
    }

    public function getRankingController()
    {
        $model = new RankingModel($this->getDatabase());
        return new RankingController($this->getRender(), $model);
    }
    public function getPerfilController()
    {
        $model = new PerfilModel($this->getDatabase());
        return new PerfilController($this->getRender(), $model);
    }
}
