<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'vendor/autoload.php'; // Asegúrate de que la ruta sea correcta según la estructura de tu proyecto

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
        $datos = null;
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = $_POST["username"];
            $password = $_POST["pass"];
            $r_password = $_POST["r_pass"];
            $nombre = $_POST["nombre"];
            $fecha = $_POST["fecha"];
            $sexo = $_POST["sexo"];
            $mail = $_POST["email"];
            $imagen = $_FILES["file"];

            if (!empty($usuario) && !empty($password) && !empty($r_password) && !empty($nombre) && !empty($fecha) && !empty($sexo) && !empty($mail)) {
                if ($this->usuarioDisponible($usuario, $datos) && $this->contraseñaValida($password, $r_password, $datos)) {

                    if (isset($_FILES["file"])) {
                        $nombreArchivo = $_FILES["file"]["name"];
                        $rutaTemporal = $_FILES["file"]["tmp_name"];
                        $directorioDestino = "./public/img/" . $nombreArchivo;

                        if (move_uploaded_file($rutaTemporal, $directorioDestino)) {
                            $imagen = $directorioDestino;
                            $this->model->registrarUsuario($usuario, $password, $nombre, $fecha, $sexo, $mail, $imagen);
                            $this->model->subirFoto($usuario, $imagen);
                            $this->enviarCorreoConfirmacion($mail,$nombre);
                            $datos['mensaje-registro-exitoso'] = "Tu registro fue exitoso, en breves recibiras un mail con la confirmacion";
                        } else {
                            $datos['mensaje-error-registro'] = "Error al subir la imagen";
                        }
                    }
                }
            } else {
                $datos['mensaje-error-registro'] = 'los campos no pueden estar vacios';
            }
            $this->render->printView('index', $datos);
        }
    }

    public function validarLoginUsuario()
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
                $datos['foto_de_usuario']=$this->model->verFoto($usuario);
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
    public function usuarioDisponible($usuario, &$datos)
    {
        if ($this->model->usuarioRepetido($usuario)) {
            $datos['mensaje-error-registro'] = 'este nombre de usuario ya existe, elija otro';
            return false;
        }
        return true;
    }

    public function contraseñaValida($contra, $contraR, &$datos)
    {
        if ($contra == $contraR) {
            return true;
        } else {
            // Aquí estableces el mensaje de error específico para la contraseña
            $datos['mensaje-error-registro'] = 'Las contraseñas no coinciden.';
            return false;
        }
    }

    public function enviarCorreoConfirmacion($correoDestinatario, $nombreDestinatario)
    {
        $mail = new PHPMailer;
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp-mail.outlook.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'animaliaJuego@hotmail.com'; // Tu correo electrónico
        $mail->Password = 'animalia1234'; // Tu contraseña
        $mail->SMTPSecure = 'tls'; 
        $mail->Port = 587; 
        $mail->setFrom('animaliaJuego@hotmail.com', 'Animalia');
        $mail->addAddress($correoDestinatario, $nombreDestinatario); 
        $imagePath = 'public\horneroMail.png';
        $mail->addEmbeddedImage($imagePath, 'imagen_id'); 
        $mail->isHTML(true);
        $mail->Subject = 'Registro exitoso';
        $mail->Body = ' <img src="cid:imagen_id" width="500px">';
        $mail->send();
    }
    
}
