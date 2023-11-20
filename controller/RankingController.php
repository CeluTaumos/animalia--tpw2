<?php
class RankingController
{
    private $render;
    private $model;

    public function __construct($render, $model)
    {
        $this->render = $render;
        $this->model = $model;
    }
    public function mostrarPantallaRanking()
    {
        $datos['partida'] = $this->model->getRanking();
        $datos['partidasPrevias'] = $this->model->getPartidasPrevias();
        $datos['user'] = $_SESSION['user'];
        echo $this->render->printView('ranking', $datos);
    }
    public function imprimirQR()
    {
        //$datos = "Nombre:Cacho";
        //QRcode::png($datos,false,QR_ECLEVEL_L,8);
        if (isset($_POST['enviar'])) {
            $usuario = $_POST['user'];
        }
        //QRcode::png('xdlfjhsdfljghsfd','cacho.png');
        $datosUsuario = $this->model->getUsuario($usuario);
        // Construye la URL con el parámetro del usuario
        $url = "http://localhost/Perfil/mostrarPantallaPerfilNuevo?usuario=" . urlencode($usuario);

        // Genera el código QR con la URL
        //include('phpqrcode/qrlib.php');
        QRcode::png($url, 'public/qr.png', 'L', 4);
        // Paso los datos del usuario y la URL del código QR a la vista
        $datos['usuario'] = $datosUsuario;
        $datos['urlQR'] = $url;
        // Devolver los datos en formato JSON para que lo tome el ajax
        $this->render->printView('perfilEstatico', $datos);
    }
}