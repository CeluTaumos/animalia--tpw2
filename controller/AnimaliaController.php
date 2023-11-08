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
    public function procesarFormulario()
    {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = $_POST["username"];
            $password = $_POST["pass"];
            $nombre = $_POST["nombre"];
            $fecha = $_POST["fecha"];
            $sexo = $_POST["nombre"];
            $mail = $_POST["user"];
            $imagen = $_POST["file"];
            if (!empty($usuario) && !empty($password) && !empty($nombre) && !empty($fecha) && !empty($sexo) && !empty($mail)) {
                $this->model->registrarUsuario($usuario, $password, $nombre, $fecha, $sexo, $mail);
                if (isset($_FILES["file"])) {
                    $nombreArchivo = $_FILES["file"]["name"];
                    $rutaTemporal = $_FILES["file"]["tmp_name"];
                    $directorioDestino = "config/images/" . $nombreArchivo;

                    if (move_uploaded_file($rutaTemporal, $directorioDestino)) {
                        $imagen = $directorioDestino;
                    } else {
                        echo "Error al subir la imagen.";
                    }
                }
                $this->model->subirFoto($usuario, $imagen);
                $this->enviarCorreo();
            }
            $datos = null;
            $this->render->printView('lobby', $datos);
        }
    }
    public function validarCorreo()
    {
        $datos = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = $_POST["username"];
            $password = $_POST["pass"];
            $datosObtenidos = $this->model->revisarUsuarioYPass($usuario, $password);
            $rol = $this->model->obtenerRolUsuario($usuario);


            if (!empty($datosObtenidos)) {
                $datos['user'] = $datosObtenidos[0]['user_name'];
                $_SESSION['user'] = $usuario;
                $_SESSION['rol'] = $rol;
                $_SESSION['puntaje'] = 0;
                $datos['puntaje'] = $_SESSION['puntaje'];
                //CHEQUEO SEGUN EL ROL A QUE VISTA LO LLEVO
                if ($rol == 'admin') {

                    $this->render->printView('lobbyadmin', $datos);
                } elseif ($rol == 'editor') {

                    $this->render->printView('lobbyeditor', $datos);
                } else {

                    $this->render->printView('lobby', $datos);
                }
            }
        }
    }
    public function enviarCorreo()
    {
        if (isset($_POST["enviar"])) {

            //  if ($_POST["user"] == "mica" && $_POST["pw"] == 123) {

            //$_SESSION["user"] = "user";
            //micaa-axell-ludmii-celu--MALC *^____^*
            //MICA->USER CELE->USER LU->EDITOR AXEL->ADMIN
        }
    }
}
