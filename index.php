<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once("config/Configuracion.php");
$configuracion = new Configuracion();
$router = $configuracion->getRouter();

$controller = $_GET['controller'] ?? "Animalia";
$method = $_GET['method'] ?? 'mostrarPantallaInicial';

$router->route($controller,$method);


?>