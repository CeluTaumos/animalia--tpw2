<?php
//include_once("../PHPMailer/Correo.php");

class AnimaliaController
{
    private $render;
    private $model;

    public function __construct($render, $model)
    {
        $this->render = $render;
        $this->model = $model;
    }

    public function mostrarPantallaInicial()
    {
        $datos = null;
        $this->render->printView('index', $datos);
    }

    //Validacion de los formularios
    public function procesarFormulario()
    {
        //LOGICA PARA DESPUES
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $correo = $_POST["correo"];
            $password= $_POST["pass"];
        }
        $this->iniciarSesion();

        $datos = null;
        //         //Si todo esta correcto envia el correo
        //         $exitoso = getCorreo($correo);

        $this->render->printView('lobby', $datos);
    }
    public function iniciarSesion()
    {
        //ARRANCA SESIÓN\(￣︶￣*\))
        session_start();
        //$error = "";
        // si esta apretado el boton d enviar
        if (isset($_POST["enviar"])) {

            //  if ($_POST["user"] == "mica" && $_POST["pw"] == 123) {

            $_SESSION["user"] = $_POST["username"];
            //mica-axel-ludmi-cele--MALC *^____^*
            //CREO LA COOKIE
            setcookie("malc", "users", time() + 1600);
            // lo q hace lo redirige a otra pag. --no lo ve el user
            exit();
            // } else {
            //     //$error = "user o clave erroneos";
            //     session_destroy();
            // }
        }
    }
}
