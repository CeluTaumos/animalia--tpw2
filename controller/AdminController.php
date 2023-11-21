<?php

require_once('./third-party/jpgraph/src/lib/jpgraph.php');
require_once('./third-party/jpgraph/src/lib/jpgraph_bar.php');
require_once('./third-party/jpgraph/src/lib/jpgraph_pie.php');
require_once('./third-party/jpgraph/src/lib/jpgraph_pie3d.php');
require_once('./third-party/fpdf/fpdf.php');

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
        $datos['porcentajeCorrectas'] = null;
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_a_buscar = $_POST['user_a_buscar'];
            $porcentajeCorrectas = $this->model->obtenerPreguntasRespondidasCorrectamentePorUsuario($user_a_buscar);
            $datos['porcentajeCorrectas'] = $porcentajeCorrectas[0];
        }
        $_SESSION['estadisticas'] = $datos;
        $this->render->printView('verEstadisticas', $_SESSION['estadisticas']);
    }

    private function obtenerDato($result)
    {
        if ($result && is_object($result) && method_exists($result, 'fetch_assoc')) {
            $row = $result->fetch_assoc();
            return isset($row['cantidad']) ? $row['cantidad'] : 0;
        }
        return 0;
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
    public function mostrarPantallaGraficos()
    {
        $datos = null;
        $this->render->printView('graficos', $datos);
    }

    public function graficoEdad()
    {
        $filtro = $_POST['filtro'];
        $menores = $this->model->getCantidadMenores($filtro);
        $adolescentes = $this->model->getCantidadAdolescentes($filtro);
        $medio = $this->model->getCantidadMedio($filtro);
        $jubilados = $this->model->getCantidadJubilados($filtro);
        //$datay=array(62,105,85,30); array original para usar si se rompe algo
        $datay = array($menores[0]['cantidad_menores'] * 10, $adolescentes[0]['cantidad_adolescentes'] * 10, $medio[0]['cantidad_medio'] * 10, $jubilados[0]['cantidad_jubilados'] * 10);
        // Create the graph. These two calls are always required
        $graph = new Graph(525, 330, 'auto');
        $graph->SetScale("textlin");
        //$theme_class="DefaultTheme";
        //$graph->SetTheme(new $theme_class());
        // set major and minor tick positions manually
        $graph->yaxis->SetTickPositions(array(0, 30, 60, 90, 120, 150), array(15, 45, 75, 105, 135));
        $graph->SetBox(false);
        //$graph->ygrid->SetColor('gray');
        $graph->ygrid->SetFill(false);
        $graph->xaxis->SetTickLabels(array('Menores', 'Adolescentes', 'Medio', 'Jubilados'));
        $graph->yaxis->HideLine(false);
        $graph->yaxis->HideTicks(false, false);
        // Create the bar plots
        $b1plot = new BarPlot($datay);
        // ...and add it to the graPH
        $graph->Add($b1plot);
        $b1plot->SetColor("white");
        $b1plot->SetFillGradient("#4B0082", "white", GRAD_LEFT_REFLECTION);
        $b1plot->SetWidth(45);
        $graph->title->Set("Cantidad de usuarios(Distribuidos por edad)");
        // Display the graph
        $graph->Stroke();
    }

    public function graficoGenero()
    {
        $filtro = $_POST['filtro'];
        $hombre = $this->model->getCantidadHombres($filtro);
        $mujeres = $this->model->getCantidadMujeres($filtro);
        $desconocido = $this->model->getCantidadDesconocidos($filtro);
        //$data = array(40,21,17);
        $data = array($hombre[0]['cantidad_usuarios_masculinos'] * 10, $mujeres[0]['cantidad_usuarios_femeninos'] * 10, $desconocido[0]['cantidad_usuarios_desconocidos'] * 10);
        // Create the Pie Graph. 
        $graph = new PieGraph(700, 500);
        $theme_class = "DefaultTheme";
        //$graph->SetTheme(new $theme_class());
        // Set A title for the plot
        $graph->title->Set("Cantidad de usuarios por género");
        $graph->SetBox(true);
        // Create
        $p1 = new PiePlot($data);
        $graph->Add($p1);
        $p1->ShowBorder();
        $p1->SetColor('black');
        $p1->SetSliceColors(array('#1E90FF', '#BA55D3', '#2E8B57')); //,'#DC143C','#BA55D3', 
        $graph->Stroke();
    }
    public function graficoMundial()
    {
        $filtro = $_POST['filtro'];
        if($filtro==1){
            $data = array(10, 0, 8, 5);
            $piepos = array( 0.2, 0.7, 0.85, 0.7);
            $titles = array('Latam', 'Canguros');
        }else if($filtro==2){
            $data = array(40, 60, 33);
            $piepos = array(0.2, 0.35, 0.3, 0.7, 0.85, 0.7);
            $titles = array('Europeos', 'Latam', 'Canguros');
        }
        else if($filtro==3){
            $data = array(1, 21, 33);
            $piepos = array( 0.2, 0.28, 0.3, 0.7, 0.85, 0.7);
            $titles = array('Yankees', 'Latam', 'Canguros');
        }
        else{
            $data = array(40, 60, 21, 33);
            $piepos = array(0.2, 0.35, 0.6, 0.28, 0.3, 0.7, 0.85, 0.7);
            $titles = array('Yankees', 'Europeos', 'Latam', 'Canguros');
        }
        
        
        
        $n = count($piepos) / 2;
        // A new graph
        $graph = new PieGraph(450, 300, 'auto');
        $theme_class = "VividTheme";
        $graph->SetTheme(new $theme_class());
        // Setup background
        $graph->SetBackgroundImage('./public/world_map.png', BGIMG_FILLFRAME);
        // Setup title
        $graph->title->Set("Usuarios en el mundo");
        $graph->title->SetFont(FF_DEFAULT, FS_BOLD);
        $graph->title->SetColor('white');
        $graph->SetTitleBackground('#004466@0.3', TITLEBKG_STYLE2, TITLEBKG_FRAME_FULL, '#004466@0.3', 10, 10, true);

        $p = array();
        // Position the four pies and change color
        for ($i = 0; $i < $n; ++$i) {
            $p[$i] = new PiePlot3D($data);
            $graph->Add($p[$i]);

            $p[$i]->SetCenter($piepos[2 * $i], $piepos[2 * $i + 1]);
            // Set the titles
            $p[$i]->title->Set($titles[$i]);
            $p[$i]->title->SetFont(FF_DEFAULT, FS_BOLD, 10);
            $p[$i]->title->SetColor('teal');
            // Size of pie in fraction of the width of the graph
            $p[$i]->SetSize(0.07);
            $p[$i]->SetHeight(5);
            $p[$i]->SetEdge(false);
            $p[$i]->ExplodeSlice(1, 7);
            $p[$i]->value->Show(true);
        }
        $graph->SetAntiAliasing(false);
        $graph->Stroke();
    }

    public function imprimirPDF1()
    {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Image('./public/graficoEdad.png');
        $pdf->Cell(20, 50, '         (Menos de 18)            (18-21)                (22-60)         (desde 61 en adelante)');
        $pdf->Ln(15);
        $pdf->Cell(20, 50, 'Este grafico ofrece una representacion visual de la diversidad generacional dentro de nuestra comunidad');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'de usuarios. Los datos se dividen en cuatro categorias principales: Menores de 18, Adolescentes, Adultos y Jubilados.');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'La seccion "Menores de 18" muestra la cantidad de usuarios que son menores de edad, destacando la presencia de ');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'jovenes en nuestra plataforma.');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, '"Adolescentes" representa la participacion activa de usuarios en la adolescencia, ofreciendo una vision sobre');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'la presencia de esta franja de edad en nuestra comunidad.');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'La categoria "Adultos" refleja la cantidad de usuarios que se encuentran en el grupo demografico adulto,');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'proporcionando informacion sobre la base principal de nuestra comunidad.');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'La seccion "Jubilados" destaca la inclusion de usuarios en la etapa de jubilacion, subrayando la diversidad');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'generacional y la accesibilidad de nuestra plataforma para todas las edades.');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'Este grafico es una herramienta valiosa para comprender la estructura demografica de nuestra comunidad, ');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'evidenciando nuestra dedicacion a la inclusion y la accesibilidad para usuarios de todas las edades.');
        $pdf->Output();
    }
    public function imprimirPDF2()
    {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Image('./public/graficoGenero.png');
        $pdf->Cell(40, 10, 'Este grafico presenta una visualizacion clara y concisa de la distribucion de jugadores en nuestra comunidad segun su genero. ');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'La informacion se clasifica en tres categorias principales: masculino, femenino y aquellos que han optado por no especificar su');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, ' genero. La porcion de color azul corresponde al genero masculino e indica la cantidad de jugadores que se identifican como ');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'hombres, ofreciendo una perspectiva de la participacion de este grupo en nuestra comunidad.');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'La porcion de color violeta corresponde al genero femenino, representa la cantidad de jugadoras que forman parte de nuestra ');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'comunidad. Este segmento destaca la presencia femenina en el contexto de juegos y entretenimiento.');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'La tercera categoria, de color verde, "Prefiere no decirlo", abarca a aquellos jugadores que han optado por no proporcionar ');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'informacion sobre su genero. Esta eleccion refleja nuestro respeto por la diversidad y la privacidad de nuestros miembros.');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Este grafico proporciona una vision general de la diversidad de genero en nuestra comunidad de jugadores, subrayando ');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'nuestro compromiso con la inclusion y el respeto a la identidad de cada individuo.');
        $pdf->Output();
    }
    public function imprimirPDF3()
    {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('./public/graficoMundial.png');
        $pdf->Cell(40, 10, 'Grafico que muestra la mayor distribucion de usuarios alrededor del mundo');
        $pdf->Output();
    }
    public function imprimirTodo()
    {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Image('./public/graficoEdad.png');
        $pdf->Cell(20, 50, '      (Menos de 18)    (18-21)             (22-60)       (desde 61 en adelante)');
        $pdf->Ln(30);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 50, 'Este grafico ofrece una representacion visual de la diversidad generacional dentro de nuestra comunidad');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'de usuarios. Los datos se dividen en cuatro categorias principales: Menores de 18, Adolescentes, Adultos y Jubilados.');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'La seccion "Menores de 18" muestra la cantidad de usuarios que son menores de edad, destacando la presencia de ');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'jovenes en nuestra plataforma.');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, '"Adolescentes" representa la participacion activa de usuarios en la adolescencia, ofreciendo una vision sobre');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'la presencia de esta franja de edad en nuestra comunidad.');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'La categoria "Adultos" refleja la cantidad de usuarios que se encuentran en el grupo demografico adulto,');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'proporcionando informacion sobre la base principal de nuestra comunidad.');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'La seccion "Jubilados" destaca la inclusion de usuarios en la etapa de jubilacion, subrayando la diversidad');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'generacional y la accesibilidad de nuestra plataforma para todas las edades.');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'Este grafico es una herramienta valiosa para comprender la estructura demografica de nuestra comunidad, ');
        $pdf->Ln(8);
        $pdf->Cell(20, 50, 'evidenciando nuestra dedicacion a la inclusion y la accesibilidad para usuarios de todas las edades.');
        $pdf->Ln(30);
        $pdf->Image('./public/graficoGenero.png');
        $pdf->Ln(30);
        $pdf->Cell(40, 10, 'El color violeta representa el sexo femenino, el azul el masculino y el verde');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'los desconocidos');
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Este grafico presenta una visualizacion clara y concisa de la distribucion de jugadores en nuestra comunidad segun su genero. ');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'La informacion se clasifica en tres categorias principales: masculino, femenino y aquellos que han optado por no especificar su');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, ' genero. La porcion de color azul corresponde al genero masculino e indica la cantidad de jugadores que se identifican como ');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'hombres, ofreciendo una perspectiva de la participacion de este grupo en nuestra comunidad.');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'La porcion de color violeta corresponde al genero femenino, representa la cantidad de jugadoras que forman parte de nuestra ');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'comunidad. Este segmento destaca la presencia femenina en el contexto de juegos y entretenimiento.');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'La tercera categoria, de color verde, "Prefiere no decirlo", abarca a aquellos jugadores que han optado por no proporcionar ');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'informacion sobre su genero. Esta eleccion refleja nuestro respeto por la diversidad y la privacidad de nuestros miembros.');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Este grafico proporciona una vision general de la diversidad de genero en nuestra comunidad de jugadores, subrayando ');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'nuestro compromiso con la inclusion y el respeto a la identidad de cada individuo.');
        $pdf->Ln(30);
        $pdf->Image('./public/graficoMundial.png');
        $pdf->Ln(10);
        $pdf->Cell(40, 10, 'Grafico que muestra la mayor distribucion de usuarios alrededor del mundo');
        $pdf->Output();
    }
}


