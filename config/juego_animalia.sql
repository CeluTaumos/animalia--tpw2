 create database animalia;
 use animalia;

/*CREACION DE TABLAS*/

CREATE TABLE usuario (
    user_name VARCHAR(10) PRIMARY KEY NOT NULL,
    contrasenia VARCHAR(10) NOT NULL,
    nombre_completo VARCHAR(20) NOT NULL,
    anio_de_nacimiento DATE NOT NULL,
    sexo CHAR(1) NOT NULL,
    mail VARCHAR(25) NOT NULL,
    foto_de_perfil BLOB NOT NULL
);

create table Categoria(
id int (11) primary key not null,
descripcion varchar(100) NOT NULL
);

CREATE TABLE pregunta (
  id int(11) PRIMARY KEY NOT NULL,
  descripcion varchar(100) NOT NULL,
  categoria int (11) not null,
  constraint categoria_fk foreign key (categoria) references categoria(id)
);

CREATE TABLE respuesta (
  id int(11) primary key NOT NULL,
  descripcion varchar(100) NOT NULL,
  es_correcta boolean not null, 
  pregunta int(11) not null,
  CONSTRAINT pregunta_fk FOREIGN KEY (pregunta) REFERENCES pregunta(id)
);

create table Partida (
id int(11) PRIMARY KEY not null,
user_name VARCHAR(10) NOT NULL,
constraint user_name_fk foreign key (user_name) references usuario(user_name),
puntaje int(11) not null
);

/*INSERCION DE DATOS*/

insert into categoria(id, descripcion)values(1, "Historia"), (2, "Cultura"), (3, "Deporte"), (4, "Geografía"), (5, "Ciencia");

insert into pregunta (id, descripcion, categoria) values (1, "¿Cuál es el mamífero más grande?", 5), (2, "¿Qué animal es conocido por su caparazón de placas y se encuentra en el Gran Chaco?", 5), (3, "¿Cuál es el ave más grande de Argentina?", 5), (4, "¿Cuál de estos animales es endémico de la región patagónica argentina?", 5);

insert into respuesta (id, descripcion, es_correcta, pregunta) values (1, "La ballena azul", true, 1), (2, "El bicho palo", false, 1), (3, "Elon Musk", false, 1), (4, "Nemo", false, 1);

insert into respuesta (id, descripcion, es_correcta, pregunta) values (5, "El armadillo", true, 2), (6, "El Chaqueño Palavecino", false, 2), (7, "Caracol gigante africano", false, 2), (8, "Almeja gigante", false, 2);

insert into respuesta (id, descripcion, es_correcta, pregunta) values (9, "El picaflor", false, 3), (10, "El cóndor andino", false, 3), (11, "El ñandu", true, 3), (12, "La paloma", false, 3);

insert into respuesta (id, descripcion, es_correcta, pregunta) values (13, "El guanaco", true, 4), (14, "El yacaré", false, 4), (15, "El coatí", false, 4), (16, "El caballo", false, 4);

/*preguntas de geo*/
insert into pregunta (id, descripcion, categoria) values 
(5, "¿Cuál es el punto más alto de Argentina y de toda América del Sur, y en qué provincia se encuentra?", 4), 
(6, "¿En qué provincia argentina se encuentra el desierto conocido como El Gran Seco?", 4), 
(7, "¿Cuál es la ciudad más grande de la Patagonia argentina?", 4), 
(8, "¿Cuál es la longitud del río Paraná?", 4);

/*preguntas de deportes*/
insert into pregunta (id, descripcion, categoria) values 
(9, "¿En qué año obtuvo la medalla de oro Delfina Pignatiello?", 3), 
(10, "¿Cuál es el deporte nacional de Argentina?", 3), 
(11, "¿De qué signo es Messi?", 3), 
(12, "¿Cuál es el primer campeón mundial de box argentino?", 3),
(13, "¿A qué edad obtuvo el título de Gran Maestra Femenina de ajedrez Candela Belén Francisco Guecamburu?", 3);

/*pregunta de cultura*/
insert into pregunta (id, descripcion, categoria) values
(14, "¿En qué año se realizó la última gira de Soda Stereo?", 2), 
(15, "¿Cuál es la icónica frase de Moria Casán?", 2), 
(16, "¿En qué año falleció Ricardo Fort?", 2),
(17, "¿Quién dijo 'Detrás del humo no se ve, no, no se ve'?", 2);

/*preguntas de historia*/
insert into pregunta (id, descripcion, categoria) values 
(18, "¿Cuál fue el nombre del primer presidente de Argentina, que asumió el cargo en 1862?", 1), 
(19, "¿En qué año se promulgó la Constitución Nacional de Argentina?", 1), 
(20, "¿Quién lideró la Revolución de Mayo en 1810?", 1), 
(21, "¿En qué año se promulgó la Ley de Divorcio en Argentina?", 1);

insert into Pregunta (id, descripcion, categoria) values (22, "¿De qué murió Favaloro?", 2);

/*respuestas*/
insert into respuesta (id, descripcion, es_correcta, pregunta) values 
(17, "El Aconcagua", true, 5), 
(18, "Ojos del Salado", false, 5), 
(19, "Cerro Tupungato", false, 5), 
(20, "Cerro Pissis", false, 5);

insert into respuesta (id, descripcion, es_correcta, pregunta) values 
(21, "No se encuentra en Argentina", true, 6), 
(22, "Misiones", false, 6), 
(23, "Chubut", false, 6), 
(24, "Neuquén", false, 6);

insert into respuesta (id, descripcion, es_correcta, pregunta) values 
(25, "Mendoza", false, 7), 
(26, "San Martín de los Andes", false, 7), 
(27, "La Plata", false, 7), 
(28, "Comodoro Rivadavia", true, 7);

insert into respuesta (id, descripcion, es_correcta, pregunta) values 
(29, "4990km", false, 8), 
(30, "4880km", true, 8), 
(31, "5000km", false, 8), 
(32, "3500km", false, 8);

insert into respuesta (id, descripcion, es_correcta, pregunta) values 
(33, "2023", false, 9), 
(34, "2020", false, 9), 
(35, "2017", true, 9), 
(36, "2018", false, 9);

insert into respuesta (id, descripcion, es_correcta, pregunta) values 
(37, "El pato", true, 10), 
(38, "El fútbol", false, 10), 
(39, "El rugby", false, 10), 
(40, "El tenis", false, 10);

insert into respuesta (id, descripcion, es_correcta, pregunta) values 
(41, "Cáncer", true, 11),
 (42, "Leo", false, 11),
 (43, "Aries", false, 11),
 (44, "Tauro", false, 11);
 
insert into respuesta (id, descripcion, es_correcta, pregunta) values
(45, "Pascual Pérez", true, 12),
(46, "Carlos Monzón", false, 12),
(47, "Marcos Maidana", false, 12),
(48, "Sergio 'Maravilla' Martínez", false, 12);

insert into respuesta (id, descripcion, es_correcta, pregunta) values
(49, "11 años", false, 13),
(50, "9 años", false, 13),
(51, "17 años", true, 13),
(52, "7 años", false, 13);

insert into respuesta (id, descripcion, es_correcta, pregunta) values
(53, "1997", false, 14),
(54, "2003", false, 14),
(55, "2007", true, 14),
(56, "2017", false, 14);

insert into respuesta (id, descripcion, es_correcta, pregunta) values
(57, "Billetera mata galán", false, 15),
(58, "Parala pipo", false, 15),
(59, "Es una nena...", false, 15),
(60, "¿Quiénes son?", true, 15);

insert into respuesta (id, descripcion, es_correcta, pregunta) values
(61, "2011", false, 16),
(62, "2013", true, 16),
(63, "2015", false, 16),
(64, "2017", false, 16);

insert into respuesta (id, descripcion, es_correcta, pregunta) values
(65, "Emilia Mernes", true, 17),
(66, "Diego Maradona", false, 17),
(67, "Tini", false, 17),
(68, "Coscu", false, 17);

insert into respuesta (id, descripcion, es_correcta, pregunta) values
(69, "Bartolomé Mitre", true, 18),
(70, "Sarmiento", false, 18),
(71, "Rivadavia", false, 18),
(72, "Belgrano", false, 18);

insert into respuesta (id, descripcion, es_correcta, pregunta) values
(73, "1853", false, 19),
(74, "1862", true, 19),
(75, "1880", false, 19),
(76, "1890", false, 19);

insert into respuesta (id, descripcion, es_correcta, pregunta) values
(77, "Belgrano", false, 20),
(78, "San Martín", false, 20),
(79, "Saavedra", true, 20),
(80, "Castelli", false, 20);

insert into respuesta (id, descripcion, es_correcta, pregunta) values
(81, "1987", true, 21),
(82, "1978", false, 21),
(83, "1992", false, 21),
(84, "2000", false, 21);




