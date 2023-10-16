<?php
include_once('helper/Database.php');
include_once('helper/MustacheRender.php');
include_once("helper/Router.php");
include_once("helper/Logger.php");
include_once('helper/Redirect.php');
include_once('model/AnimaliaModel.php');
<<<<<<< HEAD



=======
include_once('controller/AnimaliaController.php');
>>>>>>> 09ec306297ee0a4a3dba0b25fc8c1c937fbee547
include_once('third-party/mustache/src/Mustache/Autoloader.php');
include_once('model/PartidaModel.php');
include_once('controller/PartidaController.php');
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

    public function getRouter()
    {
        return new Router($this, "getAnimaliaController", "list");
    }

    public function getPartidaController()
    {
        $model = new PartidaModel($this->getDatabase());
        return new PartidaController($this->getRender(), $model);
    }
}
