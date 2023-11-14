-- create database animalia;
 use animalia;

/*CREACION DE TABLAS*/

CREATE TABLE usuario (
    user_name VARCHAR(10) PRIMARY KEY NOT NULL,
    contrasenia VARCHAR(12) NOT NULL,
    nombre_completo VARCHAR(20) NOT NULL,
    anio_de_nacimiento DATE NOT NULL,
    sexo CHAR(1) NOT NULL,
    mail VARCHAR(25) NOT NULL,
    foto_de_perfil VARCHAR(40) NOT NULL,
    rol VARCHAR(20) DEFAULT 'jugador' NOT NULL
);

ALTER TABLE usuario
ADD COLUMN nivel VARCHAR(255) DEFAULT 'principiante';
ALTER TABLE usuario ADD COLUMN fecha_registro DATE NOT NULL DEFAULT CURRENT_DATE;

create table Categoria(
id int (11) primary key not null,
tipo varchar(100) DEFAULT 'Cultura' NOT NULL,
imagen varchar(50) NOT NULL
);

create table categoriaSugerida(
id int (11) AUTO_INCREMENT primary key not null,
tipo varchar(100) NOT NULL
);

create table dificultad(
id int (10) primary key not null,
nombre varchar(100) NOT NULL
);

CREATE TABLE pregunta (
  id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  descripcion varchar(100) NOT NULL,
  categoria int (11) not null,
  dificultad int (10) not null,
  constraint categoria_fk foreign key (categoria) references categoria(id),
  constraint dificultad_fk foreign key (dificultad) references dificultad(id)
);

CREATE TABLE respuesta (
  id int(11) primary key AUTO_INCREMENT NOT NULL,
  descripcion varchar(120) NOT NULL,
  es_correcta boolean not null, 
  pregunta int(11) not null,
  CONSTRAINT pregunta_fk FOREIGN KEY (pregunta) REFERENCES pregunta(id)
);
CREATE TABLE preguntaSugerida (
  id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  descripcion varchar(100) NOT NULL,
  dificultad int(10) DEFAULT 1 NOT NULL,
  categoria int (11) not null
);
CREATE TABLE respuestasSugeridas (
  id int(11) primary key AUTO_INCREMENT NOT NULL,
  descripcion varchar(100) NOT NULL,
  es_correcta boolean not null, 
  pregunta int(11) not null,
  CONSTRAINT pregunta_sug_fk FOREIGN KEY (pregunta) REFERENCES preguntaSugerida(id)
);
CREATE TABLE preguntasReportadas (
  id int(11) PRIMARY KEY AUTO_INCREMENT,
  pregunta_id int(11) NOT NULL,
  descripcion_reporte varchar(255) NOT NULL,
  resuelto boolean DEFAULT 0,
  FOREIGN KEY (pregunta_id) REFERENCES pregunta(id)
);
-- preguntas geo intermedio
ALTER TABLE pregunta
ADD COLUMN respuestas_correctas INT DEFAULT 0;

ALTER TABLE pregunta
ADD COLUMN respuestas_totales INT DEFAULT 0;



create table Partida (
id int(11) AUTO_INCREMENT PRIMARY KEY,
user_name VARCHAR(10) NOT NULL,
constraint user_name_fk foreign key (user_name) references usuario(user_name),
puntaje int(11) DEFAULT 0 not null,
fecha DATETIME
);
ALTER TABLE partida
ADD COLUMN respuestas_correctas INT DEFAULT 0;
ALTER TABLE partida
ADD COLUMN cant_preguntas_entregadas INT DEFAULT 0;

insert into usuario(user_name, contrasenia, nombre_completo, anio_de_nacimiento, sexo, mail, foto_de_perfil, rol, nivel)values
("micaa","1234", "Micaela Zara", "2003-07-21", "f", "m1ca3l4@hotmail.com", "", "jugador", "principiante"), 
("axell", "1234", "Axel Leguero", "1996-04-02", "m", "axeelleguero@gmail.com", "", "admin", "principiante"), 
("celu", "1234", "Celena Moscovich", "2004-06-15", "f", "celu_mari_posa@gmail.com", "", "jugador", "intermedio"), 
("ludmii", "1234", "Ludmila Pereyra", "2001-04-23", "f", "ludmila.pereyra543@gmail.com", "", "editor", "principiante");
insert into usuario(user_name, contrasenia, nombre_completo, anio_de_nacimiento, sexo, mail, foto_de_perfil, rol, nivel)values
("admin", "1234", "Ludmila Pereyra", "2001-04-23", "f", "ludmila.pereyra543@gmail.com", "", "admin", "principiante");

insert into Partida(id, user_name, puntaje, fecha)values(1, "micaa",0, DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 365) DAY)),(2, "axell",0, DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 365) DAY)), (3, "celu",0, DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 365) DAY)),(4, "ludmii",0, DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 365) DAY));

/*INSERCION DE DATOS*/

insert into categoria(id, tipo, imagen)values(1, "Historia", "./config/images/historia.gif"), (2, "Cultura", "config/images/cultura.gif"), (3, "Deporte", "./config/images/deporte.gif"), (4, "Geografía", "config/images/geografia.gif"), (5, "Ciencia", "config/images/ciencia.gif");

insert into dificultad(id, nombre)values(1, "principiante"), (2, "intermedio"), (3, "avanzado");

-- primeras preguntas de prueba con sus respuestas
insert into pregunta (descripcion, categoria,dificultad) values ("¿Cuál es el mamífero más grande?", 5,1), ( "¿Qué animal es conocido por su caparazón de placas y se encuentra en el Gran Chaco?", 5,1), ("¿Cuál es el ave más grande de Argentina?", 5,1), ("¿Cuál de estos animales es endémico de la región patagónica argentina?", 5,1);

insert into respuesta (descripcion, es_correcta, pregunta) values ("La ballena azul", true, 1), ("El bicho palo", false, 1), ("Elon Musk", false, 1), ("Nemo", false, 1);

insert into respuesta (descripcion, es_correcta, pregunta) values ("El armadillo", true, 2), ("El Chaqueño Palavecino", false, 2), ("Caracol gigante africano", false, 2), ("Almeja gigante", false, 2);

insert into respuesta (descripcion, es_correcta, pregunta) values ("El picaflor", false, 3), ("El cóndor andino", false, 3), ("El ñandu", true, 3), ("La paloma", false, 3);

insert into respuesta (descripcion, es_correcta, pregunta) values ("El guanaco", true, 4), ("El yacaré", false, 4), ("El coatí", false, 4), ("El caballo", false, 4);

/*preguntas de geo principiante*/

insert into pregunta (descripcion, categoria, dificultad) values 
("¿Cuál es el punto más alto de Argentina y de toda América del Sur, y en qué provincia se encuentra?", 4,1), 
("¿En qué provincia argentina se encuentra el desierto conocido como El Gran Seco?", 4,1), 
("¿Cuál es la ciudad más grande de la Patagonia argentina?", 4,1), 
("¿Cuál es la longitud del río Paraná?", 4,1);

/*preguntas de deportes principiante*/
insert into pregunta (descripcion, categoria, dificultad) values 
("¿En qué año obtuvo la medalla de oro Delfina Pignatiello?", 3,1), 
("¿Cuál es el deporte nacional de Argentina?", 3,1), 
("¿De qué signo es Messi?", 3,1), 
("¿Cuál es el primer campeón mundial de box argentino?", 3,1),
("¿A qué edad obtuvo el título de Gran Maestra Femenina de ajedrez Candela Belén Francisco Guecamburu?", 3,1);

/*pregunta de cultura principiante*/
insert into pregunta (descripcion, categoria, dificultad) values
("¿En qué año se realizó la última gira de Soda Stereo?", 2,1), 
("¿Cuál es la icónica frase de Moria Casán?", 2,1), 
("¿En qué año falleció Ricardo Fort?", 2,1),
("¿Quién dijo 'Detrás del humo no se ve, no, no se ve'?", 2,1);


/*preguntas de historia principiante*/
insert into pregunta (descripcion, categoria, dificultad) values 
("¿Cuál fue el nombre del primer presidente de Argentina, que asumió el cargo en 1862?", 1,1), 
("¿En qué año se promulgó la Constitución Nacional de Argentina?", 1,1), 
("¿Quién lideró la Revolución de Mayo en 1810?", 1,1), 
("¿En qué año se promulgó la Ley de Divorcio en Argentina?", 1,1); 

/* preguntas de ciencia principiante*/
insert into pregunta (descripcion, categoria, dificultad) values 
("¿De qué murió Favaloro?", 2,1),
("¿Cuál de los siguientes científicos argentinos es conocido por sus contribuciones a la medicina y la cirugía cardiovascular?",5,1),
("¿Cuál es el organismo argentino encargado de la investigación y desarrollo en el campo de la ciencia y tecnología?",5,1),
("¿Cuál es el nombre de la agencia espacial argentina encargada de las actividades espaciales y satelitales?",5,1),
("¿Cuál es el nombre del científico argentino famoso por sus investigaciones sobre la penicilina y la insulina?",5,1);

/*respuestas*/
insert into respuesta (descripcion, es_correcta, pregunta) values 
("El Aconcagua", true, 5), 
("Ojos del Salado", false, 5), 
("Cerro Tupungato", false, 5), 
("Cerro Pissis", false, 5);

insert into respuesta (descripcion, es_correcta, pregunta) values 
("No se encuentra en Argentina", true, 6), 
("Misiones", false, 6), 
("Chubut", false, 6), 
("Neuquén", false, 6);

insert into respuesta (descripcion, es_correcta, pregunta) values 
("Mendoza", false, 7), 
("San Martín de los Andes", false, 7), 
("La Plata", false, 7), 
("Comodoro Rivadavia", true, 7);

insert into respuesta (descripcion, es_correcta, pregunta) values 
("4990km", false, 8), 
("4880km", true, 8), 
("5000km", false, 8), 
("3500km", false, 8);

insert into respuesta (descripcion, es_correcta, pregunta) values 
("2023", false, 9), 
("2020", false, 9), 
("2017", true, 9), 
("2018", false, 9);

insert into respuesta (descripcion, es_correcta, pregunta) values 
("El pato", true, 10), 
("El fútbol", false, 10), 
("El rugby", false, 10), 
("El tenis", false, 10);

insert into respuesta (descripcion, es_correcta, pregunta) values 
("Cáncer", true, 11),
("Leo", false, 11),
("Aries", false, 11),
("Tauro", false, 11);
 
insert into respuesta (descripcion, es_correcta, pregunta) values
("Pascual Pérez", true, 12),
("Carlos Monzón", false, 12),
("Marcos Maidana", false, 12),
("Sergio 'Maravilla' Martínez", false, 12);

insert into respuesta (descripcion, es_correcta, pregunta) values
( "11 años", false, 13),
("9 años", false, 13),
("17 años", true, 13),
("7 años", false, 13);

insert into respuesta ( descripcion, es_correcta, pregunta) values
("1997", false, 14),
("2003", false, 14),
("2007", true, 14),
("2017", false, 14);

insert into respuesta (descripcion, es_correcta, pregunta) values
("Billetera mata galán", false, 15),
("Cortala pipo", false, 15),
("Es una nena...", false, 15),
("¿Quiénes son?", true, 15);

insert into respuesta (descripcion, es_correcta, pregunta) values
("2011", false, 16),
("2013", true, 16),
("2015", false, 16),
("2017", false, 16);

insert into respuesta (descripcion, es_correcta, pregunta) values
("Emilia Mernes", true, 17),
("Diego Maradona", false, 17),
("Tini", false, 17),
("Coscu", false, 17);

insert into respuesta ( descripcion, es_correcta, pregunta) values
("Bartolomé Mitre", true, 18),
("Sarmiento", false, 18),
("Rivadavia", false, 18),
("Belgrano", false, 18);

insert into respuesta (descripcion, es_correcta, pregunta) values
("1853", false, 19),
("1862", true, 19),
("1880", false, 19),
("1890", false, 19);

insert into respuesta ( descripcion, es_correcta, pregunta) values
( "Belgrano", false, 20),
("San Martín", false, 20),
("Saavedra", true, 20),
("Castelli", false, 20);

insert into respuesta (descripcion, es_correcta, pregunta) values
("1987", true, 21),
("1978", false, 21),
("1992", false, 21),
("2000", false, 21);

insert into respuesta (descripcion, es_correcta, pregunta) values 
("Suicidio", true, 22), 
("Se comió un pez globo", false, 22), 
("Murió en el atentado a las torres gemelas", false, 22), 
("Lo balearon", false, 22);

insert into respuesta (descripcion, es_correcta, pregunta) values 
("René Favaloro", true, 23), 
("César Milstein", false, 23), 
("Margarita Salas", false, 23), 
("Peter Capusotto", false, 23);

insert into respuesta (descripcion, es_correcta, pregunta) values 
("CONICET", true, 24), 
("ANMAT", false, 24), 
("AFIP", false, 24), 
("MGM", false, 24);

insert into respuesta (descripcion, es_correcta, pregunta) values 
("CONAE", true, 25), 
("CONALEP", false, 25), 
("INVAP", false, 25), 
("NASA", false, 25);

insert into respuesta (descripcion, es_correcta, pregunta) values 
("Luis Federico Leloir", true, 26), 
("Juan Domingo Perón", false, 26), 
("Jorge Luis Borges", false, 26), 
("Juan Carlos Altavista", false, 26);

-- preguntas intermedias

insert into pregunta (descripcion, categoria, dificultad) values ("¿Cuál es el rio que separa argenitna del uruguay?", 4, 2);

insert into respuesta (descripcion, es_correcta, pregunta) values ("Rio Uruguay", true, 27), ("Fitz Roy", false, 27), ("Cerro Torre", false, 27), ("Rio petuña", false, 27);


insert into pregunta (descripcion, categoria, dificultad) values ("¿Cuál es la provincia más poblada de Argentina?", 4, 2);

insert into respuesta (descripcion, es_correcta, pregunta) values ("Buenos Aires", true, 28), ("Córdoba", false, 28), ("Santa Fe", false, 28), ("Mendoza", false, 28);


insert into pregunta (descripcion, categoria, dificultad) values ("¿En qué provincia se encuentra la Quebrada de Humahuaca?", 4, 2);

insert into respuesta (descripcion, es_correcta, pregunta) values ("Jujuy", true, 29), ("Salta", false, 29), ("Tucumán", false, 29), ("Catamarca", false, 29);


insert into pregunta (descripcion, categoria, dificultad) values ("¿Cuál es el río más importante de la provincia de Misiones?", 4, 2);

insert into respuesta (descripcion, es_correcta, pregunta) values ("Paraná", false, 30), ("Uruguay", true, 30), ("Paraguay", false, 30), ("Bermejo", false, 30);



insert into pregunta (descripcion, categoria, dificultad) values ("¿En qué deporte se utiliza una red y una pelota amarilla?", 3, 2);

insert into respuesta (descripcion, es_correcta, pregunta) values ("Tenis", true, 31), ("Vóley", false, 31), ("Bádminton", false, 31), ("Polo acuático", false, 31);


insert into pregunta (descripcion, categoria, dificultad) values ("¿Cuál es el equipo de fútbol más antiguo de Argentina?", 3, 2);

insert into respuesta (descripcion, es_correcta, pregunta) values ("Gimnasia y Esgrima La Plata", false, 32), ("Club Atlético Newell's Old Boys", false, 32), ("Club Atlético Rosario Central", false, 32), ("Club Atlético de San Isidro", true, 32);


insert into pregunta (descripcion, categoria, dificultad) values ("¿En qué país se originó el deporte del rugby?", 3, 2);

insert into respuesta (descripcion, es_correcta, pregunta) values ("Inglaterra", true, 33), ("Nueva Zelanda", false, 33), ("Sudáfrica", false, 33), ("Australia", false, 33);


insert into pregunta (descripcion, categoria, dificultad) values ("¿Cuál es el deporte acuático que se practica con una tabla y una vela?", 3, 2);

insert into respuesta (descripcion, es_correcta, pregunta) values ("Windsurf", true, 34), ("Surf", false, 34), ("Kitesurf", false, 34), ("Esquí acuático", false, 34);


insert into pregunta (descripcion, categoria, dificultad) values ("¿En qué año se firmó la Declaración de Independencia de Argentina?", 1, 2);

insert into respuesta (descripcion, es_correcta, pregunta) values ("1816", true, 35), ("1820", false, 35), ("1830", false, 35), ("1800", false, 35);


insert into pregunta (descripcion, categoria, dificultad) values ("¿Quién fue el pintor argentino conocido por su obra 'Abaporu'?", 2, 2);

insert into respuesta (descripcion, es_correcta, pregunta) values ("Tarsila do Amaral", true, 36), ("Diego Rivera", false, 36), ("Frida Kahlo", false, 36), ("Antonio Berni", false, 36);


insert into pregunta (descripcion, categoria, dificultad) values ("¿Cuál es el equipo de fútbol más laureado de Argentina en torneos internacionales?", 3, 2);

insert into respuesta (descripcion, es_correcta, pregunta) values ("Club Atlético Independiente", true, 37), ("Boca Juniors", false, 37), ("River Plate", false, 37), ("Racing Club", false, 37);


insert into pregunta (descripcion, categoria, dificultad) values ("¿Cuál es la capital de la provincia de Salta?", 4, 2);

insert into respuesta (descripcion, es_correcta, pregunta) values ("Salta", true, 38), ("San Miguel de Tucumán", false, 38), ("Jujuy", false, 38), ("Mendoza", false, 38);


insert into pregunta (descripcion, categoria, dificultad) values ("¿Quién fue el científico argentino ganador del Premio Nobel de Química en 1970?", 5, 2);

insert into respuesta (descripcion, es_correcta, pregunta) values ("Luis Federico Leloir", true, 39), ("César Milstein", false, 39), ("Bernardo Houssay", false, 39), ("Carlos Finlay", false, 39);




-- ALTER TABLE pregunta
-- ADD COLUMN dificultad VARCHAR(255) DEFAULT 'desconocida';

