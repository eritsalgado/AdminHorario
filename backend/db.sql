CREATE DATABASE IF NOT EXISTS admin_empresa;
USE admin_empresa;

CREATE TABLE usuarios(
    id          int(255) auto_increment not null,
    no_empleado int(255),
    no_nomina   int(255),
    rol         varchar(255),  
    nombre      varchar(255),
    salario     float(8,2),
    ingreso     date,
    password    varchar(255),
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL,
    CONSTRAINT pk_usuario PRIMARY KEY(id)
)ENGINE=InnoDb;

CREATE TABLE obras(
    id              int(255) auto_increment not null,
    usuario_id      int(255) not null,
    ubicacion       varchar(255),  
    nombre_obra     varchar(255),
    fecha_inicio    date,
    fecha_termino   date,
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL,
    CONSTRAINT pk_obra PRIMARY KEY(id),
    CONSTRAINT fk_obra_usuario FOREIGN KEY(usuario_id) REFERENCES usuarios(id)
)ENGINE=InnoDb;

CREATE TABLE equipos(
    id          int(255) auto_increment not null,
    obra_id     int(255) not null,
    usuario_id  int(255) not null,
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL,
    CONSTRAINT pk_equipo PRIMARY KEY(id),
    CONSTRAINT fk_equipo_obra FOREIGN KEY(obra_id) REFERENCES obras(id),
    CONSTRAINT fk_usuario_obra FOREIGN KEY(usuario_id) REFERENCES usuarios(id)
)ENGINE=InnoDb;

CREATE TABLE horarios(
    id              int(255) auto_increment not null,
    usuario_id      int(255) not null,
    hora_ingreso    varchar(30),  
    hora_descanso   varchar(30),
    hora_regreso    varchar(30),
    hora_salida     varchar(30),
    fecha           date,
    notas           varchar(255),
    ubicacion       varchar(255),
    created_at datetime DEFAULT NULL,
    updated_at datetime DEFAULT NULL,
    CONSTRAINT pk_horario PRIMARY KEY(id),
    CONSTRAINT fk_horario_usuario FOREIGN KEY(usuario_id) REFERENCES usuarios(id)
)ENGINE=InnoDb;