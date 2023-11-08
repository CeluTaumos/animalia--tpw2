<?php
class RankingController{
    private $render;
    private $model;

    public function __construct($render, $model) {
        $this->render = $render;
        $this->model = $model;
    }
    public function mostrarPantallaRanking(){
        $datos['partida']=$this->model->getRanking();
        $datos['partidasPrevias']=$this->model->getPartidasPrevias();
        $datos['user'] = $_SESSION['user'];
        $this->render->printView('ranking', $datos);
    }
    public function imprimirQR($usuario) {
        //$datos = "Nombre:Cacho";
        //QRcode::png($datos,false,QR_ECLEVEL_L,8);


        //QRcode::png('xdlfjhsdfljghsfd','cacho.png');
        // Obtén el usuario desde el modelo
        $datosUsuario = $this->model->getUsuario($usuario);
    
        // Construye la URL con el parámetro del usuario
        $url = "http://localhost/Perfil/mostrarPantallaPerfil?usuario=" . urlencode($usuario);
    
        // Genera el código QR con la URL
        include('phpqrcode/qrlib.php');
        QRcode::png($url, 'public/qr.png', 'L', 4);
    
        // Paso los datos del usuario y la URL del código QR a la vista
        $datos['usuario'] = $datosUsuario;
        $datos['urlQR'] = $url;
    
        $this->render->printView('perfilEstatico', $datos);
    }
    
    
}