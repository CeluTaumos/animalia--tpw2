<?php
session_start();
include_once("config/Configuracion.php");
$configuracion = new Configuracion();
$router = $configuracion->getRouter();

// $controller = $_GET['controller'] ?? "Animalia";
// $method = $_GET['method'] ?? 'mostrarPantallaInicial';

$router->route("Animalia","mostrarPantallaInicial");
?>