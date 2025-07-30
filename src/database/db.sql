CREATE DATABASE easylab;
USE easylab;

CREATE TABLE tipo_espaco (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL
);

CREATE TABLE espaco (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  capacidade INT NOT NULL,
  tipo_espaco_id INT NOT NULL,
  CONSTRAINT fk_espaco_tipo_espaco
    FOREIGN KEY (tipo_espaco_id)
    REFERENCES tipo_espaco (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

CREATE TABLE usuario (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  senha VARCHAR(100) NOT NULL,
  papel ENUM('admin', 'usuario') NOT NULL DEFAULT 'usuario'
);

CREATE TABLE curso (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL
);

CREATE TABLE disciplina (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(4100) NOT NULL,
  curso_id INT NOT NULL,
  CONSTRAINT fk_disciplina_curso
    FOREIGN KEY (curso_id)
    REFERENCES curso (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

CREATE TABLE evento (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL
);

CREATE TABLE reserva (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  data DATE NOT NULL,
  inicio_reserva DATETIME NOT NULL,
  fim_reserva DATETIME NOT NULL,
  observacao VARCHAR(200) NULL,
  espaco_id INT NOT NULL,
  usuario_id INT NOT NULL,
  disciplina_id INT NOT NULL,
  evento_id INT NOT NULL,
  CONSTRAINT fk_reserva_espaco
    FOREIGN KEY (espaco_id)
    REFERENCES espaco (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_reserva_usuario
    FOREIGN KEY (usuario_id)
    REFERENCES usuario (id)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT fk_reserva_disciplina
    FOREIGN KEY (disciplina_id)
    REFERENCES disciplina (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT fk_reserva_evento
    FOREIGN KEY (evento_id)
    REFERENCES evento (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


