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
insert into exames_tipo(nome)values ('Hemograma'), ('Ultrassonografia'), ('Eletrocardiograma'), ('Tonoscopia');
insert into servico(id_especialidade, nome, data, hor_ini, hor_fim) values (1, 'exame normal', '2021-01-20', '10:30:00', '11:00:00');
insert into exame values (5, 1, 'fulano');
