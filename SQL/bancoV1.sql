/*Código SQL de criação do Banco de Dados para o TCC.
Criado por: Rhuan Emmanuel*/

CREATE DATABASE tcc;

USE tcc;

CREATE TABLE Pessoa(
	id INT NOT NULL UNIQUE AUTO_INCREMENT,
    nome VARCHAR(50),
    cpf VARCHAR(14) NOT NULL UNIQUE,
	dt_nasc DATE,
    email VARCHAR(100) NOT NULL,
    telefone NUMERIC,
    PRIMARY KEY(id)
);

create table exames_tipo (
	id INT NOT NULL AUTO_INCREMENT,
    nome varchar(100) UNIQUE,
    PRIMARY KEY(id)
);

CREATE TABLE Especialidade(
	id INT NOT NULL UNIQUE AUTO_INCREMENT,
    nome VARCHAR(50) UNIQUE,
    PRIMARY KEY(id)
);

CREATE TABLE Login(
	id INT NOT NULL UNIQUE AUTO_INCREMENT,
    idpessoa INT,
    usuario VARCHAR(20) NOT NULL UNIQUE,
    senha VARCHAR(20) NOT NULL UNIQUE,
    PRIMARY KEY(id),
    FOREIGN KEY fk_login_pessoa (idpessoa) REFERENCES pessoa(id)
);

CREATE TABLE Feedback(
	id INT NOT NULL UNIQUE AUTO_INCREMENT,
    id_pessoa INT,
    texto LONGTEXT,
    PRIMARY KEY (id),
    FOREIGN KEY fk_feedback_pessoa (id_pessoa) REFERENCES pessoa(id)
);

CREATE TABLE Servico(
	id INT NOT NULL UNIQUE AUTO_INCREMENT,
    id_especialidade INT,
    nome VARCHAR(50),
    data DATE,
    hor_ini TIME,
    hor_fim TIME,
    PRIMARY KEY(id),
    FOREIGN KEY fk_servico_especialidade(id_especialidade) REFERENCES especialidade(id)
);

CREATE TABLE Paciente(
	id_pessoa INT NOT NULL,
    id_servico INT NOT NULL,
    PRIMARY KEY (id_pessoa),
    foreign key fk_paciente_pessoa (id_pessoa) REFERENCES Pessoa(id),
    foreign key fk_paciente_servico(id_servico) REFERENCES Servico(id)
);

CREATE TABLE Exame(
	id_servico INT NOT NULL,
    id_tipo INT NOT NULL,
    med_rec VARCHAR(100),
    PRIMARY KEY (id_servico),
    FOREIGN KEY fk_exame_servico (id_servico) REFERENCES Servico(id),
    FOREIGN KEY fk__exame__exame_tipo(id_tipo) REFERENCES exames_tipo(id)
);
/*Na tabela Exame, não foi implementado o atributo paciente, pois, não faz sentido*/

CREATE TABLE Consulta(
	id_servico INT NOT NULL,
	tipo VARCHAR(100),
	PRIMARY KEY(id_servico),
    FOREIGN KEY fk_consulta_servico (id_servico) REFERENCES Servico(id)
);

CREATE TABLE Cargo(
	id INT NOT NULL UNIQUE AUTO_INCREMENT,
    id_tipo INT,
    registro VARCHAR(100),
    PRIMARY KEY (id),
    FOREIGN KEY fk__cargo__cargo_tipo (id_tipo) REFERENCES cargo_tipo(id)
);

CREATE TABLE Cargo_tipo(
	id INT NOT NULL UNIQUE AUTO_INCREMENT,
    id_especialidade INT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY fk__cargo_tipo__especialidade (id_especialidade) REFERENCES especialidade(id)
);

CREATE TABLE Funcionario(
	id_pessoa INT NOT NULL,
    id_cargo INT,
    jorn_trab TIME,
    salario NUMERIC,
    PRIMARY KEY(id_pessoa),
    FOREIGN KEY fk_funcionario_pessoa (id_pessoa) REFERENCES Pessoa(id),
    FOREIGN KEY fk_funcionario_cargo (id_cargo) REFERENCES Cargo(id)
);

CREATE TABLE Funcionario_Servico(
	id_funcionario INT NOT NULL,
    id_servico INT NOT NULL,
    PRIMARY KEY(id_funcionario, id_servico),
    FOREIGN KEY fk__funcionario_servico__funcionario (id_funcionario) REFERENCES Funcionario (id_pessoa),
    FOREIGN KEY fk__funcionario_servico__servico (id_servico) REFERENCES Servico(id)
);

CREATE TABLE Escala(
	id INT NOT NULL UNIQUE AUTO_INCREMENT,
    id_funcionario INT NOT NULL,
    dataa DATE,
    hor_ini TIME,
    hor_fim TIME,
    PRIMARY KEY(id),
    FOREIGN KEY fk_escala_funcionario (id_funcionario) REFERENCES Funcionario(id_pessoa)
);
