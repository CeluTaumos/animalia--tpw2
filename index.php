<?php
session_start();
include_once ("config/Configuracion.php");

$configuracion = new Configuracion();
$router = $configuracion->getRouter();

$controller = $_GET['controller'] ?? "home";
$method = $_GET['method'] ?? 'listar';

$router->route($controller, $method);