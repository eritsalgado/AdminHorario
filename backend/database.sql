CREATE DATABASE IF NOT EXIST apilaravel;

CREATE TABLE users(
id      int(255) auto_increment not null,
email   varchar(255),
role    varchar(20),
name    varchar(255),
surname varchar(255),
password varchar(255),
no_empleado int(255),
check_in int(255),
created_at datetime DEFAULT NULL,
updated_at datetime DEFAULT NULL,  
remember_token varchar(255),
CONSTRAINT pk_users PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE horarios(
id      int(255) auto_increment not null,
user_id   int(255) not null,
hora_ingreso datetime,
hora_inicio_comida datetime,
hora_termino_comida datetime,
hora_salida datetime,
created_at datetime DEFAULT NULL,
updated_at datetime DEFAULT NULL, 
notas text,
geo_ubicacion varchar(255),
CONSTRAINT pk_horarios PRIMARY KEY(id),
CONSTRAINT fk_horarios_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;