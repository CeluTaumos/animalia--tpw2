create database Animalia;
use Animalia;
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:33067
-- Tiempo de generación: 18-11-2023 a las 20:07:01
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `animalia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `tipo` varchar(100) NOT NULL DEFAULT 'Cultura',
  `imagen` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `tipo`, `imagen`) VALUES
(1, 'Historia', '../public/img/historia.gif'),
(2, 'Cultura', '../public/img/cultura.gif'),
(3, 'Deporte', '../public/img/deporte.gif'),
(4, 'Geografía', '../public/img/geografia.gif'),
(5, 'Ciencia', '../public/img/ciencia.gif');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoriasugerida`
--

CREATE TABLE `categoriasugerida` (
  `id` int(11) NOT NULL,
  `tipo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dificultad`
--

CREATE TABLE `dificultad` (
  `id` int(10) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `dificultad`
--

INSERT INTO `dificultad` (`id`, `nombre`) VALUES
(1, 'principiante'),
(2, 'intermedio'),
(3, 'avanzado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE `partida` (
  `id` int(11) NOT NULL,
  `user_name` varchar(10) NOT NULL,
  `puntaje` int(11) NOT NULL,
  `fecha` datetime DEFAULT NULL,
  `respuestas_correctas` int(11) DEFAULT 0,
  `cant_preguntas_entregadas` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partida`
--

INSERT INTO `partida` (`id`, `user_name`, `puntaje`, `fecha`, `respuestas_correctas`, `cant_preguntas_entregadas`) VALUES
(1, 'micaa', 0, '2023-01-31 16:03:50', 0, 0),
(2, 'axell', 0, '2023-06-02 16:03:50', 0, 0),
(3, 'celu', 0, '2022-12-18 16:03:50', 0, 0),
(4, 'ludmii', 0, '2023-09-07 16:03:50', 0, 0),
(5, 'micaa', 0, '2023-11-18 20:04:52', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pregunta`
--

CREATE TABLE `pregunta` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `categoria` int(11) NOT NULL,
  `dificultad` int(10) NOT NULL,
  `respuestas_correctas` int(11) DEFAULT 0,
  `respuestas_totales` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pregunta`
--

INSERT INTO `pregunta` (`id`, `descripcion`, `categoria`, `dificultad`, `respuestas_correctas`, `respuestas_totales`) VALUES
(1, '¿Cuál es el mamífero más grande?', 5, 1, 0, 0),
(2, '¿Qué animal es conocido por su caparazón de placas y se encuentra en el Gran Chaco?', 5, 1, 0, 0),
(3, '¿Cuál es el ave más grande de Argentina?', 5, 1, 0, 0),
(4, '¿Cuál de estos animales es endémico de la región patagónica argentina?', 5, 1, 0, 0),
(5, '¿Cuál es el punto más alto de Argentina y de toda América del Sur, y en qué provincia se encuentra?', 4, 1, 0, 0),
(6, '¿En qué provincia argentina se encuentra el desierto conocido como El Gran Seco?', 4, 1, 0, 0),
(7, '¿Cuál es la ciudad más grande de la Patagonia argentina?', 4, 1, 0, 0),
(8, '¿Cuál es la longitud del río Paraná?', 4, 1, 0, 0),
(9, '¿En qué año obtuvo la medalla de oro Delfina Pignatiello?', 3, 1, 0, 0),
(10, '¿Cuál es el deporte nacional de Argentina?', 3, 1, 0, 0),
(11, '¿De qué signo es Messi?', 3, 1, 0, 0),
(12, '¿Cuál es el primer campeón mundial de box argentino?', 3, 1, 0, 0),
(13, '¿A qué edad obtuvo el título de Gran Maestra Femenina de ajedrez Candela Belén Francisco Guecamburu?', 3, 1, 0, 0),
(14, '¿En qué año se realizó la última gira de Soda Stereo?', 2, 1, 0, 0),
(15, '¿Cuál es la icónica frase de Moria Casán?', 2, 1, 0, 0),
(16, '¿En qué año falleció Ricardo Fort?', 2, 1, 0, 0),
(17, '¿Quién dijo \'Detrás del humo no se ve, no, no se ve\'?', 2, 1, 0, 0),
(18, '¿Cuál fue el nombre del primer presidente de Argentina, que asumió el cargo en 1862?', 1, 1, 0, 0),
(19, '¿En qué año se promulgó la Constitución Nacional de Argentina?', 1, 1, 0, 0),
(20, '¿Quién lideró la Revolución de Mayo en 1810?', 1, 1, 0, 0),
(21, '¿En qué año se promulgó la Ley de Divorcio en Argentina?', 1, 1, 0, 0),
(22, '¿De qué murió Favaloro?', 2, 1, 0, 0),
(23, '¿Cuál de los siguientes científicos argentinos es conocido por sus contribuciones a la medicina y la', 5, 1, 0, 0),
(24, '¿Cuál es el organismo argentino encargado de la investigación y desarrollo en el campo de la ciencia', 5, 1, 0, 0),
(25, '¿Cuál es el nombre de la agencia espacial argentina encargada de las actividades espaciales y sateli', 5, 1, 0, 0),
(26, '¿Cuál es el nombre del científico argentino famoso por sus investigaciones sobre la penicilina y la ', 5, 1, 0, 0),
(27, '¿Cuál es el rio que separa Argentina del Uruguay?', 4, 2, 0, 0),
(28, '¿Cuál es la provincia más poblada de Argentina?', 4, 2, 0, 0),
(29, '¿En qué provincia se encuentra la Quebrada de Humahuaca?', 4, 2, 0, 0),
(30, '¿Cuál es el río más importante de la provincia de Misiones?', 4, 2, 0, 0),
(31, '¿En qué deporte se utiliza una red y una pelota amarilla?', 3, 2, 0, 0),
(32, '¿Cuál es el equipo de fútbol más antiguo de Argentina?', 3, 2, 0, 0),
(33, '¿En qué país se originó el deporte del rugby?', 3, 2, 0, 0),
(34, '¿Cuál es el deporte acuático que se practica con una tabla y una vela?', 3, 2, 0, 0),
(35, '¿En qué año se firmó la Declaración de Independencia de Argentina?', 1, 2, 0, 0),
(36, '¿Quién fue el pintor argentino conocido por su obra \'Abaporu\'?', 2, 2, 0, 0),
(37, '¿Cuál es el equipo de fútbol más laureado de Argentina en torneos internacionales?', 3, 2, 0, 0),
(38, '¿Cuál es la capital de la provincia de Salta?', 4, 2, 0, 0),
(39, '¿Quién fue el científico argentino ganador del Premio Nobel de Química en 1970?', 5, 2, 0, 0),
(40, '¿Qué escritor argentino recibió el Premio Nobel de Literatura en 1945?', 2, 2, 0, 0),
(41, '¿Cuál es el equipo de rugby más antiguo de Argentina?', 3, 2, 0, 0),
(42, '¿En qué provincia argentina se encuentra la región de la Puna?', 4, 2, 0, 0),
(43, '¿Quién fue el matemático argentino que desarrolló la Teoría de los Espacios Métricos?', 5, 2, 0, 0),
(44, '¿Quién fue el líder del movimiento peronista en Argentina durante la década de 1950?', 1, 3, 0, 0),
(45, '¿Quién fue el director de la película argentina \'El secreto de sus ojos\'?', 2, 3, 0, 0),
(46, '¿Cuántas veces Argentina ha ganado la Copa Mundial de la FIFA en fútbol masculino hasta la fecha de ', 3, 3, 0, 0),
(47, '¿Cuál es el punto más alto de Argentina y de toda América del Sur?', 4, 3, 0, 0),
(48, '¿Cuál es el campo de estudio principal de la física teórica argentina Juan Martín Maldacena?', 5, 3, 0, 0),
(49, '¿Cuál fue la fecha de la Revolución de Mayo, que marcó el inicio del proceso de independencia de Arg', 1, 3, 0, 0),
(50, '¿Qué escritor argentino ganó el Premio Nobel de la Paz en 2010?', 2, 3, 0, 0),
(51, '¿Cuántas medallas de oro olímpicas ha ganado Argentina en su historia hasta la fecha de corte de mi ', 3, 3, 0, 0),
(52, '¿Cuál es la segunda ciudad más poblada de Argentina?', 4, 3, 0, 0),
(53, '¿Cuál fue la contribución más destacada del científico argentino René Favaloro?', 5, 3, 0, 0),
(54, '¿Quién fue el líder del movimiento revolucionario que derrocó a Juan Domingo Perón en 1955?', 1, 3, 0, 0),
(55, '¿Quién fue el arquitecto argentino que diseñó el Obelisco de Buenos Aires?', 2, 3, 0, 0),
(56, '¿Cuántas veces Argentina ha ganado la Copa América hasta la fecha de corte de mi conocimiento en ene', 3, 3, 0, 0),
(57, '¿Cuál es el nombre de la mayor región desértica de Argentina?', 4, 3, 0, 0),
(58, '¿Cuál fue la contribución más destacada de la científica argentina Cecilia Grierson?', 5, 3, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntasreportadas`
--

CREATE TABLE `preguntasreportadas` (
  `id` int(11) NOT NULL,
  `pregunta_id` int(11) NOT NULL,
  `descripcion_reporte` varchar(255) NOT NULL,
  `resuelto` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntasugerida`
--

CREATE TABLE `preguntasugerida` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `dificultad` int(10) NOT NULL DEFAULT 1,
  `categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuesta`
--

CREATE TABLE `respuesta` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(120) NOT NULL,
  `es_correcta` tinyint(1) NOT NULL,
  `pregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respuesta`
--

INSERT INTO `respuesta` (`id`, `descripcion`, `es_correcta`, `pregunta`) VALUES
(1, 'La ballena azul', 1, 1),
(2, 'El bicho palo', 0, 1),
(3, 'Elon Musk', 0, 1),
(4, 'Nemo', 0, 1),
(5, 'El armadillo', 1, 2),
(6, 'El Chaqueño Palavecino', 0, 2),
(7, 'Caracol gigante africano', 0, 2),
(8, 'Almeja gigante', 0, 2),
(9, 'El picaflor', 0, 3),
(10, 'El cóndor andino', 0, 3),
(11, 'El ñandu', 1, 3),
(12, 'La paloma', 0, 3),
(13, 'El guanaco', 1, 4),
(14, 'El yacaré', 0, 4),
(15, 'El coatí', 0, 4),
(16, 'El caballo', 0, 4),
(17, 'El Aconcagua', 1, 5),
(18, 'Ojos del Salado', 0, 5),
(19, 'Cerro Tupungato', 0, 5),
(20, 'Cerro Pissis', 0, 5),
(21, 'No se encuentra en Argentina', 1, 6),
(22, 'Misiones', 0, 6),
(23, 'Chubut', 0, 6),
(24, 'Neuquén', 0, 6),
(25, 'Mendoza', 0, 7),
(26, 'San Martín de los Andes', 0, 7),
(27, 'La Plata', 0, 7),
(28, 'Comodoro Rivadavia', 1, 7),
(29, '4990km', 0, 8),
(30, '4880km', 1, 8),
(31, '5000km', 0, 8),
(32, '3500km', 0, 8),
(33, '2023', 0, 9),
(34, '2020', 0, 9),
(35, '2017', 1, 9),
(36, '2018', 0, 9),
(37, 'El pato', 1, 10),
(38, 'El fútbol', 0, 10),
(39, 'El rugby', 0, 10),
(40, 'El tenis', 0, 10),
(41, 'Cáncer', 1, 11),
(42, 'Leo', 0, 11),
(43, 'Aries', 0, 11),
(44, 'Tauro', 0, 11),
(45, 'Pascual Pérez', 1, 12),
(46, 'Carlos Monzón', 0, 12),
(47, 'Marcos Maidana', 0, 12),
(48, 'Sergio \'Maravilla\' Martínez', 0, 12),
(49, '11 años', 0, 13),
(50, '9 años', 0, 13),
(51, '17 años', 1, 13),
(52, '7 años', 0, 13),
(53, '1997', 0, 14),
(54, '2003', 0, 14),
(55, '2007', 1, 14),
(56, '2017', 0, 14),
(57, 'Billetera mata galán', 0, 15),
(58, 'Cortala pipo', 0, 15),
(59, 'Es una nena...', 0, 15),
(60, '¿Quiénes son?', 1, 15),
(61, '2011', 0, 16),
(62, '2013', 1, 16),
(63, '2015', 0, 16),
(64, '2017', 0, 16),
(65, 'Emilia Mernes', 1, 17),
(66, 'Diego Maradona', 0, 17),
(67, 'Tini', 0, 17),
(68, 'Coscu', 0, 17),
(69, 'Bartolomé Mitre', 1, 18),
(70, 'Sarmiento', 0, 18),
(71, 'Rivadavia', 0, 18),
(72, 'Belgrano', 0, 18),
(73, '1853', 0, 19),
(74, '1862', 1, 19),
(75, '1880', 0, 19),
(76, '1890', 0, 19),
(77, 'Belgrano', 0, 20),
(78, 'San Martín', 0, 20),
(79, 'Saavedra', 1, 20),
(80, 'Castelli', 0, 20),
(81, '1987', 1, 21),
(82, '1978', 0, 21),
(83, '1992', 0, 21),
(84, '2000', 0, 21),
(85, 'Suicidio', 1, 22),
(86, 'Se comió un pez globo', 0, 22),
(87, 'Murió en el atentado a las torres gemelas', 0, 22),
(88, 'Lo balearon', 0, 22),
(89, 'René Favaloro', 1, 23),
(90, 'César Milstein', 0, 23),
(91, 'Margarita Salas', 0, 23),
(92, 'Peter Capusotto', 0, 23),
(93, 'CONICET', 1, 24),
(94, 'ANMAT', 0, 24),
(95, 'AFIP', 0, 24),
(96, 'MGM', 0, 24),
(97, 'CONAE', 1, 25),
(98, 'CONALEP', 0, 25),
(99, 'INVAP', 0, 25),
(100, 'NASA', 0, 25),
(101, 'Luis Federico Leloir', 1, 26),
(102, 'Juan Domingo Perón', 0, 26),
(103, 'Jorge Luis Borges', 0, 26),
(104, 'Juan Carlos Altavista', 0, 26),
(105, 'Rio Uruguay', 1, 27),
(106, 'Fitz Roy', 0, 27),
(107, 'Cerro Torre', 0, 27),
(108, 'Rio petuña', 0, 27),
(109, 'Buenos Aires', 1, 28),
(110, 'Córdoba', 0, 28),
(111, 'Santa Fe', 0, 28),
(112, 'Mendoza', 0, 28),
(113, 'Jujuy', 1, 29),
(114, 'Salta', 0, 29),
(115, 'Tucumán', 0, 29),
(116, 'Catamarca', 0, 29),
(117, 'Paraná', 0, 30),
(118, 'Uruguay', 1, 30),
(119, 'Paraguay', 0, 30),
(120, 'Bermejo', 0, 30),
(121, 'Tenis', 1, 31),
(122, 'Vóley', 0, 31),
(123, 'Bádminton', 0, 31),
(124, 'Polo acuático', 0, 31),
(125, 'Gimnasia y Esgrima La Plata', 0, 32),
(126, 'Club Atlético Newell\'s Old Boys', 0, 32),
(127, 'Club Atlético Rosario Central', 0, 32),
(128, 'Club Atlético de San Isidro', 1, 32),
(129, 'Inglaterra', 1, 33),
(130, 'Nueva Zelanda', 0, 33),
(131, 'Sudáfrica', 0, 33),
(132, 'Australia', 0, 33),
(133, 'Windsurf', 1, 34),
(134, 'Surf', 0, 34),
(135, 'Kitesurf', 0, 34),
(136, 'Esquí acuático', 0, 34),
(137, '1816', 1, 35),
(138, '1820', 0, 35),
(139, '1830', 0, 35),
(140, '1800', 0, 35),
(141, 'Tarsila do Amaral', 1, 36),
(142, 'Diego Rivera', 0, 36),
(143, 'Frida Kahlo', 0, 36),
(144, 'Antonio Berni', 0, 36),
(145, 'Club Atlético Independiente', 1, 37),
(146, 'Boca Juniors', 0, 37),
(147, 'River Plate', 0, 37),
(148, 'Racing Club', 0, 37),
(149, 'Salta', 1, 38),
(150, 'San Miguel de Tucumán', 0, 38),
(151, 'Jujuy', 0, 38),
(152, 'Mendoza', 0, 38),
(153, 'Luis Federico Leloir', 1, 39),
(154, 'César Milstein', 0, 39),
(155, 'Bernardo Houssay', 0, 39),
(156, 'Carlos Finlay', 0, 39),
(157, 'César Vallejo', 0, 40),
(158, 'Jorge Luis Borges', 0, 40),
(159, 'Gabriela Mistral', 0, 40),
(160, 'Alejandro Casona', 1, 40),
(161, 'Club Atlético de San Isidro', 1, 41),
(162, 'Hindú Club', 0, 41),
(163, 'Club Universitario de Buenos Aires', 0, 41),
(164, 'Club Atlético Belgrano', 0, 41),
(165, 'Jujuy', 1, 42),
(166, 'Salta', 0, 42),
(167, 'Catamarca', 0, 42),
(168, 'La Rioja', 0, 42),
(169, 'Félix Christian Klein', 0, 43),
(170, 'Federico García Lorca', 0, 43),
(171, 'Ángel Gallardo', 0, 43),
(172, 'Mauricio González Gordon', 1, 43),
(173, 'Juan Domingo Perón', 1, 44),
(174, 'Arturo Frondizi', 0, 44),
(175, 'Arturo Illia', 0, 44),
(176, 'Raúl Alfonsín', 0, 44),
(177, 'Juan José Campanella', 1, 45),
(178, 'Pablo Trapero', 0, 45),
(179, 'Lucrecia Martel', 0, 45),
(180, 'Gastón Duprat', 0, 45),
(181, 'Dos veces (1978 y 1986)', 1, 46),
(182, 'Una vez (1978)', 0, 46),
(183, 'Tres veces (1978, 1986 y 2014)', 0, 46),
(184, 'Nunca ha ganado la Copa Mundial', 0, 46),
(185, 'Cerro Aconcagua', 1, 47),
(186, 'Monte Fitz Roy', 0, 47),
(187, 'Volcán Lanín', 0, 47),
(188, 'Cerro Torre', 0, 47),
(189, 'Física de partículas', 1, 48),
(190, 'Astrofísica', 0, 48),
(191, 'Física cuántica', 0, 48),
(192, 'Física nuclear', 0, 48),
(193, '25 de mayo de 1810', 1, 49),
(194, '9 de julio de 1816', 0, 49),
(195, '20 de junio de 1820', 0, 49),
(196, '3 de febrero de 1813', 0, 49),
(197, 'Adolfo Pérez Esquivel', 1, 50),
(198, 'Jorge Luis Borges', 0, 50),
(199, 'Julio Cortázar', 0, 50),
(200, 'Gabriel García Márquez', 0, 50),
(201, '6', 1, 51),
(202, '3', 0, 51),
(203, '9', 0, 51),
(204, '12', 0, 51),
(205, 'Córdoba', 0, 52),
(206, 'Rosario', 0, 52),
(207, 'Mendoza', 0, 52),
(208, 'La Plata', 1, 52),
(209, 'Cirugía de bypass coronario', 1, 53),
(210, 'Desarrollo de la vacuna contra la polio', 0, 53),
(211, 'Descubrimiento de la penicilina', 0, 53),
(212, 'Teoría de la relatividad', 0, 53),
(213, 'Eduardo Lonardi', 1, 54),
(214, 'Arturo Frondizi', 0, 54),
(215, 'Armando Frondizi', 0, 54),
(216, 'Arturo Illia', 0, 54),
(217, 'Alberto Prebisch', 1, 55),
(218, 'César Pelli', 0, 55),
(219, 'Clorindo Testa', 0, 55),
(220, 'Amancio Williams', 0, 55),
(221, '15', 1, 56),
(222, '12', 0, 56),
(223, '18', 0, 56),
(224, '20', 0, 56),
(225, 'Desierto del Monte', 0, 57),
(226, 'Desierto del Atacama', 0, 57),
(227, 'Desierto del Chaco', 0, 57),
(228, 'Desierto del Patagones', 1, 57),
(229, 'Primera médica argentina', 1, 58),
(230, 'Descubrimiento de la penicilina', 0, 58),
(231, 'Desarrollo de la bomba atómica', 0, 58),
(232, 'Teoría de la relatividad', 0, 58);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestassugeridas`
--

CREATE TABLE `respuestassugeridas` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `es_correcta` tinyint(1) NOT NULL,
  `pregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `user_name` varchar(10) NOT NULL,
  `contrasenia` varchar(12) NOT NULL,
  `nombre_completo` varchar(20) NOT NULL,
  `anio_de_nacimiento` date NOT NULL,
  `sexo` char(1) NOT NULL,
  `mail` varchar(25) NOT NULL,
  `foto_de_perfil` varchar(40) NOT NULL,
  `rol` varchar(20) NOT NULL DEFAULT 'jugador',
  `nivel` varchar(255) DEFAULT 'principiante',
  `fecha_registro` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`user_name`, `contrasenia`, `nombre_completo`, `anio_de_nacimiento`, `sexo`, `mail`, `foto_de_perfil`, `rol`, `nivel`, `fecha_registro`) VALUES
('admin', '1234', 'Ludmila Pereyra', '2001-04-23', 'f', 'ludmila.pereyra543@gmail.', '', 'admin', 'principiante', '2023-11-18'),
('axell', '1234', 'Axel Leguero', '1996-04-02', 'm', 'axeelleguero@gmail.com', '', 'admin', 'principiante', '2023-11-18'),
('celu', '1234', 'Celena Moscovich', '2004-06-15', 'f', 'celu_mari_posa@gmail.com', '', 'jugador', 'intermedio', '2023-11-18'),
('ludmii', '1234', 'Ludmila Pereyra', '2001-04-23', 'f', 'ludmila.pereyra543@gmail.', '', 'editor', 'principiante', '2023-11-18'),
('micaa', '1234', 'Micaela Zara', '2003-07-21', 'f', 'm1ca3l4@hotmail.com', '', 'jugador', 'principiante', '2023-11-18');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categoriasugerida`
--
ALTER TABLE `categoriasugerida`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dificultad`
--
ALTER TABLE `dificultad`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_name_fk` (`user_name`);

--
-- Indices de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_fk` (`categoria`),
  ADD KEY `dificultad_fk` (`dificultad`);

--
-- Indices de la tabla `preguntasreportadas`
--
ALTER TABLE `preguntasreportadas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pregunta_id` (`pregunta_id`);

--
-- Indices de la tabla `preguntasugerida`
--
ALTER TABLE `preguntasugerida`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pregunta_fk` (`pregunta`);

--
-- Indices de la tabla `respuestassugeridas`
--
ALTER TABLE `respuestassugeridas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pregunta_sug_fk` (`pregunta`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`user_name`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoriasugerida`
--
ALTER TABLE `categoriasugerida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `partida`
--
ALTER TABLE `partida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `pregunta`
--
ALTER TABLE `pregunta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `preguntasreportadas`
--
ALTER TABLE `preguntasreportadas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `preguntasugerida`
--
ALTER TABLE `preguntasugerida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `respuesta`
--
ALTER TABLE `respuesta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT de la tabla `respuestassugeridas`
--
ALTER TABLE `respuestassugeridas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `user_name_fk` FOREIGN KEY (`user_name`) REFERENCES `usuario` (`user_name`);

--
-- Filtros para la tabla `pregunta`
--
ALTER TABLE `pregunta`
  ADD CONSTRAINT `categoria_fk` FOREIGN KEY (`categoria`) REFERENCES `categoria` (`id`),
  ADD CONSTRAINT `dificultad_fk` FOREIGN KEY (`dificultad`) REFERENCES `dificultad` (`id`);

--
-- Filtros para la tabla `preguntasreportadas`
--
ALTER TABLE `preguntasreportadas`
  ADD CONSTRAINT `preguntasreportadas_ibfk_1` FOREIGN KEY (`pregunta_id`) REFERENCES `pregunta` (`id`);

--
-- Filtros para la tabla `respuesta`
--
ALTER TABLE `respuesta`
  ADD CONSTRAINT `pregunta_fk` FOREIGN KEY (`pregunta`) REFERENCES `pregunta` (`id`);

--
-- Filtros para la tabla `respuestassugeridas`
--
ALTER TABLE `respuestassugeridas`
  ADD CONSTRAINT `pregunta_sug_fk` FOREIGN KEY (`pregunta`) REFERENCES `preguntasugerida` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
