create database animalia;
use animalia;

<<<<<<< HEAD


=======
>>>>>>> 3b0c3dfcbced6136ee2d9aa75ba05ba55dc4575b
CREATE TABLE pregunta (
  id int(11) PRIMARY KEY NOT NULL,
  descripcion varchar(100) NOT NULL
);

CREATE TABLE respuesta (
  id int(11) primary key NOT NULL,
  descripcion varchar(100) NOT NULL,
  es_correcta boolean not null, 
  pregunta int(11) not null,
  CONSTRAINT pregunta_fk FOREIGN KEY (pregunta) REFERENCES pregunta(id)
);
<<<<<<< HEAD
=======

>>>>>>> 3b0c3dfcbced6136ee2d9aa75ba05ba55dc4575b
CREATE TABLE usuario (
    user_name VARCHAR(10) PRIMARY KEY NOT NULL,
    contrasenia VARCHAR(10) NOT NULL,
    nombre_completo VARCHAR(20) NOT NULL,
    anio_de_nacimiento DATE NOT NULL,
    sexo CHAR(1) NOT NULL,
    mail VARCHAR(25) NOT NULL,
    foto_de_perfil BLOB NOT NULL
);

insert into pregunta (id, descripcion) values (1, "¿Cuál es el mamífero más grande"), (2, "¿Qué animal es conocido por su caparazón de placas y se encuentra en el Gran Chaco"), (3, "¿Cuál es el ave más grande de Argentina"), (4, "¿Cuál de estos animales es endémico de la región patagónica argentina");

insert into respuesta (id, descripcion, es_correcta, pregunta) values (1, "La ballena azul", true, 1), (2, "El bicho palo", false, 1), (3, "Elon Musk", false, 1), (4, "Nemo", false, 1);

insert into respuesta (id, descripcion, es_correcta, pregunta) values (5, "El armadillo", true, 2), (6, "El Chaqueño Palavecino", false, 2), (7, "Caracol gigante africano", false, 2), (8, "Almeja gigante", false, 3);

insert into respuesta (id, descripcion, es_correcta, pregunta) values (9, "El picaflor", false, 3), (10, "El cóndor andino", false, 3), (11, "El ñandu", true, 3), (12, "La paloma", false, 3);

insert into respuesta (id, descripcion, es_correcta, pregunta) values (13, "El guanaco", true, 4), (14, "El yacaré", false, 4), (15, "El coatí", false, 4), (16, "El caballo", false, 4);