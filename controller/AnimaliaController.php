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
            $usuario = $_POST["username"];
            $password= $_POST["pass"];
        }
        $this->iniciarSesion();

        $datos = null;
        //         //Si todo esta correcto envia el correo
        //         $exitoso = getCorreo($correo);

        $this->render->printView('lobby', $datos);
    }
    public function validarCorreo(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = $_POST["username"];
            $password= $_POST["pass"];
            $datos = $this->model->revisarUsuarioYPass($usuario, $password);
            //var_dump($datos);
            if($datos!=null){
                $this->render->printView('jugarPartida', $datos);
            }else{
                $this->render->printView('index', $datos);
            }
            
        }
    }
    public function iniciarSesion()
    {
        
        //$error = "";
        // si esta apretado el boton d enviar
        if (isset($_POST["enviar"])) {

            //  if ($_POST["user"] == "mica" && $_POST["pw"] == 123) {

            $_SESSION["user"] = "user";
            //mica-axel-ludmi-cele--MALC *^____^*
           
       
            // } else {
            //     //$error = "user o clave erroneos";
            //     session_destroy();
            // }
        }
    }
}
