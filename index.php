<?php
session_start();
include_once("config/Configuracion.php");
$configuracion = new Configuracion();
$router = $configuracion->getRouter();

$controller = $_GET['controller'] ?? "AnimaliaController";
$method = $_GET['method'] ?? 'mostrarPantallaInicial';

$router->route($controller, $method);
?>