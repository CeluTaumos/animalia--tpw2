<?php
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
            $nombre= $_POST["nombre"];
            $fecha= $_POST["fecha"];
            $sexo= $_POST["nombre"];
            $mail= $_POST["user"];
            if (!empty($usuario) && !empty($password) && !empty($nombre) && !empty($fecha) && !empty($sexo) && !empty($mail)) {
            //registrarUsuario($usuario, $password, $nombre, $fecha, $sexo, $mail)
                $this->model->registrarUsuario($usuario, $password, $nombre, $fecha, $sexo, $mail);
            }
        $this->iniciarSesion();

        $datos = null;
        //         //Si todo esta correcto envia el correo
        //         $exitoso = getCorreo($correo);

        $this->render->printView('lobby', $datos);
    }
}
    public function validarCorreo(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = $_POST["username"];
            $password= $_POST["pass"];
            $datos = $this->model->revisarUsuarioYPass($usuario, $password);

            if(!empty($datos)){
                //para pasar los datos a mustache, debo guardar datos con elnombre entre []
                $datos['user'] = $datos[0]['user_name'];
                $this->render->printView('lobby', $datos);
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
           
       
          
        }
    }
}
