create database animalia;
use animalia;

CREATE TABLE pregunta (
  id  int(11) PRIMARY KEY NOT NULL,
  descripcion varchar(100) NOT NULL,
	repuesta_correcta int(11) NOT NULL
);

CREATE TABLE respuesta (
  id int(11) primary key NOT NULL,
  descripcion varchar(100) NOT NULL,
  pregunta int(11) NOT NULL,
  constraint pregunta_a_respuesta_fk foreign key (pregunta) references pregunta (id)
);

CREATE TABLE usuario(
  nombre_de_usuario varchar(10) NOT NULL,
  contrasenia varchar(10) NOT NULL,
  nombre_completo varchar(20) NOT NULL,
  f_nac date NOT NULL,
  sexo char(1) NOT NULL,
  mail varchar(25) NOT NULL,
  foto_de_perfil blob NOT NULL
)



