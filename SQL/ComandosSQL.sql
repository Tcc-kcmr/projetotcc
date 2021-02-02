use tcc;

/*Obs.: a clínica fica aberta das 08:00 hrs às 18:00 hrs
São marcadas apenas 16 exames por dia, sendo marcadas de meia hora em meia hora*/

/*Quantos horários estão ocupados por exames entre as 08:00:00 horas e 18:00:00 horas do dia 20 de Jan. de 2021?*/
SELECT count(hor_ini) AS quantidade FROM servico AS s INNER JOIN exame AS e ON (s.id = e.id_servico) 
WHERE (hor_ini>='08:00:00' AND hor_fim<='18:00:00') AND s.data = '2021-01-20';

/*Quais horários estão ocupados por exames entre as 08:00:00 horas e 18:00:00 horas do dia 20 de Jan. de 2021?*/
SELECT hor_ini AS ocupado FROM servico AS s INNER JOIN exame AS e ON (s.id = e.id_servico) 
INNER JOIN exames_tipo AS et ON (et.id = e.id_tipo) WHERE (hor_ini>='09:00:00' AND hor_fim<='18:00:00') AND s.data = '2021-01-20';

/*Selecione se há alguma exame marcado para o dia 20 de jan. de 2021 às 10:30 hrs*/
SELECT*FROM servico AS s INNER JOIN exame as e ON (s.id=e.id_servico) INNER JOIN exames_tipo AS et ON (et.id=e.id_tipo) 
WHERE s.hor_ini = '10:30:00' AND s.data = '2021-01-20';

/*Quais são os tipos de exames disponíveis na clínica?*/
SELECT * FROM exames_tipo;

/*Exemplos de Insert's*/
INSERT INTO exames_tipo(nome) VALUES ('Hemograma'), ('Ultrassonografia'), ('Eletrocardiograma'), ('Tonoscopia');
INSERT INTO servico(id_especialidade, nome, data, hor_ini, hor_fim) VALUES (1, 'exame normal', '2021-01-20', '10:30:00', '11:00:00');
INSERT INTO exame VALUES (5, 1, 'fulano');
INSERT INTO especialidade (nome) VALUES ('Ortopedia'), ('Oftamologia'), ('Ginecologia'), ('Neurologia');
INSERT INTO pessoa(nome, cpf, dt_nasc, email, telefone) VALUES ('Fulaninho', '000.000.000-09', '1980-10-01', 'fulaninho@gmail.com', 000000);
INSERT INTO cargo(id_especialidade, nome, registro) VALUES (1, 'médico', '000.1');
INSERT INTO pessoa(nome, cpf, dt_nasc, email, telefone) VALUES ('Fulaninho Segundo', '000.004.000-09', '1980-10-01', 'fulaniho@gmail.com', 90800);
INSERT INTO cargo(id_especialidade, nome, registro) VALUES (14, 'médico', '003.1');
INSERT INTO funcionario VALUES (2, 3, '08:00:00', 3000);

/*Quais são as especialidades disponíveis na clínica?*/
SELECT * FROM especialidade;

/*Qual ou quais médicos são especilistas em Ortopedia?*/
SELECT p.nome AS Nome, c.nome AS Cargo, e.nome AS Especialidade FROM pessoa AS p INNER JOIN funcionario AS f ON (p.id = f.id_pessoa)
INNER JOIN cargo AS c ON (c.id=f.id_cargo) INNER JOIN especialidade AS e ON (c.id_especialidade = e.id) WHERE e.nome = 'Ortopedia';
