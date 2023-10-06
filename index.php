<?php
<<<<<<< HEAD

=======
>>>>>>> 0185fce6ff757edab8c196415d1118eecf78285d
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();
include_once("config/Configuracion.php");
$configuracion = new Configuracion();
$router = $configuracion->getRouter();

// $controller = $_GET['controller'] ?? "Animalia";
// $method = $_GET['method'] ?? 'mostrarPantallaInicial';

$router->route("Animalia","mostrarPantallaInicial");


?>