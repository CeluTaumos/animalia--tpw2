<?php

class AnimaliaController {
    private $render;
    private $model;

    public function __construct($render, $model) {
        $this->render = $render;
        $this->model = $model;
    }

    public function mostrarPantallaInicial() {
        $datos =null;
        $this->render->printView('index', $datos);
    }

    //Validacion de los formularios
    public function procesarFormulario() {

        //LOGICA PARA DESPUES
//     if ($_SERVER["REQUEST_METHOD"] == "POST") {
//         $nombre = $_POST["nombre"];
//         $fecha = $_POST["fecha"];
//         $sexo = $_POST["sexo"];

//         echo "Nombre: " . $nombre . "<br>";
//         echo "Fecha: " . $fecha . "<br>";
//         echo "Sexo: " . $sexo . "<br>";
// }
$datos =null;
        $this->render->printView('lobby', $datos);
}   
}