<?php
require_once ('./third-party/jpgraph/src/lib/jpgraph.php');
require_once ('./third-party/jpgraph/src/lib/jpgraph_bar.php');
require_once ('./third-party/jpgraph/src/lib/jpgraph_pie.php');
class AdminController
{
    private $render;
    private $model;

    public function __construct($render, $model)
    {
        $this->render = $render;
        $this->model = $model;
    }
    public function mostrarDatos()
    {
        $datos = [
            'user' => $_SESSION['user'],
        ];

        return $this->render->printView('lobbyadmin', $datos);
    }

    public function estadisticas()
    {
        /*Por otro lado debe existir el usuario administrador, capaz de ver la 
         cantidad de preguntas creadas
         porcentaje de preguntas respondidas correctamente por usuario, 
         cantidad de usuarios por pais, 
         cantidad de usuarios por sexo, cantidad de usuarios por grupo de edad (menores, jubilados, medio). 
         Todos estos gráficos deben poder filtarse por día, semana, mes o año. 
         Estos reportes tienen que poder imprimirse (al menos las
tablas de datos)*/
        $cantidadJugadores = $this->model->obtenerCantidadJugadores();

        $cantidadPartidas = $this->model->obtenerCantidadPartidas();
        $cantidadPreguntas = $this->model->obtenerCantidadPreguntas();
        $usuariosNuevos = $this->model->obtenerUsuariosNuevos();
        $usuariosMujeres = $this->model->obtenerCantidadUsuariosMujeres();
        $usuariosHombres = $this->model->obtenerCantidadUsuariosHombres();
        
        $datos = [
            'cantidadJugadores' => $cantidadJugadores[0]['cantidad'],
            'cantidadMujeres' => $this->obtenerDato($usuariosMujeres),
            'cantidadHombres' => $this->obtenerDato($usuariosHombres),
            'cantidadPartidas' => $this->obtenerDato($cantidadPartidas),
            'cantidadPreguntas' => $this->obtenerDato($cantidadPreguntas),
            'usuariosNuevos' => $this->obtenerDato($usuariosNuevos)
         ];
            $datos['porcentajeCorrectas']=null;
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_a_buscar = $_POST['user_a_buscar'];
            $porcentajeCorrectas = $this->model->obtenerPreguntasRespondidasCorrectamentePorUsuario($user_a_buscar);
            $datos['porcentajeCorrectas'] = $porcentajeCorrectas[0];
        }
        $_SESSION['estadisticas'] = $datos;
        //var_dump($_SESSION['estadisticas']);
        $this->render->printView('verEstadisticas',$_SESSION['estadisticas']);
    }

    private function obtenerDato($result)
    {
        if ($result && is_object($result) && method_exists($result, 'fetch_assoc')) {
            $row = $result->fetch_assoc();
            return isset($row['cantidad']) ? $row['cantidad'] : 0;
        }
        return 0;
    }


    public function reportarPregunta()
    {

        if (isset($_POST['enviar']) && is_numeric($_POST['id'])) {
            $id = $_POST['id'];
        }

        if ($id !== null) {
            $pregunta = $this->model->getDescripcion($id);
            if ($pregunta) {

                $row = $pregunta->fetch_assoc();
                if (isset($row['descripcion'])) {
                    $pregunta = $row['descripcion'];

                    $this->model->reportar($pregunta, $id);
                }
            }
            $datos['id'] = $_POST['id'];
            $this->render->printView('jugarPartida', $datos);
        }
    }

    public function cerrarSesion()
    {
        $datos = null;
        session_destroy();
        $this->render->printView('index', $datos);
    }
    public function mostrarPantallaLobby()
    {


        $datos = null;
        $this->render->printView('lobbyadmin', $datos);

    }
    public function mostrarPantallaGraficos(){
        $datos = null;
        //$this->graficoEdad();
        $this->render->printView('graficos', $datos);
    }

    public function graficoEdad(){
        $menores = $this->model->getCantidadMenores();
        $adolescentes = $this->model->getCantidadAdolescentes();
        $medio = $this->model->getCantidadMedio();
        $jubilados = $this->model->getCantidadJubilados();
        //$datay=array(62,105,85,30); array original para usar si se rompe algo
        $datay=array($menores[0]['cantidad_menores']*10,$adolescentes[0]['cantidad_adolescentes']*10, $medio[0]['cantidad_medio']*10, $jubilados[0]['cantidad_jubilados']*10);
        // Create the graph. These two calls are always required
        $graph = new Graph(525,330,'auto');
        $graph->SetScale("textlin");
        //$theme_class="DefaultTheme";
        //$graph->SetTheme(new $theme_class());
        // set major and minor tick positions manually
        $graph->yaxis->SetTickPositions(array(0,30,60,90,120,150), array(15,45,75,105,135));
        $graph->SetBox(false);
        //$graph->ygrid->SetColor('gray');
        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels(array('Menores','Adolescentes','Medio','Jubilados'));
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false,false);
        // Create the bar plots
        $b1plot = new BarPlot($datay);
        // ...and add it to the graPH
        $graph->Add($b1plot);
        $b1plot->SetColor("white");
        $b1plot->SetFillGradient("#4B0082","white",GRAD_LEFT_REFLECTION);
        $b1plot->SetWidth(45);
        $graph->title->Set("Cantidad de usuarios(Distribuidos por edad)");
        // Display the graph
        $graph->Stroke();
    }

    public function graficoGenero(){
        $hombre = $this->model->getCantidadHombres();
        $mujeres = $this->model->getCantidadMujeres();
        $desconocido = $this->model->getCantidadDesconocidos();
        // Some data
        //$data = array(40,21,17);
        $data = array($hombre[0]['cantidad_usuarios_masculinos']*10,$mujeres[0]['cantidad_usuarios_femeninos']*10,$desconocido[0]['cantidad_usuarios_desconocidos']*10);
        // Create the Pie Graph. 
        $graph = new PieGraph(700,500);
        $theme_class="DefaultTheme";
        //$graph->SetTheme(new $theme_class());
        // Set A title for the plot
        $graph->title->Set("Cantidad de usuarios por género");
        $graph->SetBox(true);
        // Create
        $p1 = new PiePlot($data);
        $graph->Add($p1);
        $p1->ShowBorder();
        $p1->SetColor('black');
        $p1->SetSliceColors(array('#1E90FF','#BA55D3','#2E8B57'));//,'#DC143C','#BA55D3', 
        $graph->Stroke();
    }
}
