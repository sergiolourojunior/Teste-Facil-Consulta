INSERT INTO medico (`id`, `nome`, `email`, `endereco_consultorio`, `senha`) VALUES 
(1, 'Anderson Fonseca', 'anderson_fonseca@gmail.com', 'Av. Brasil, 102 - Pelotas/RS', '5c2dbc1990e72c6782468cca9f3a5544'),
(2, 'Carla da Silva', 'carla_silva@gmail.com', 'Av. Bento Gonçalves, 1109 - Pelotas/RS', '5c2dbc1990e72c6782468cca9f3a5544'),
(3, 'Fernanda Moura', 'fernanda_moura@gmail.com', 'Av. Ferreira Viana, 7479 - Pelotas/RS', '5c2dbc1990e72c6782468cca9f3a5544'),
(4, 'Carlos Santiago', 'carlos_sant@gmail.com', 'Rua Padre Anchieta, 1009 - Pelotas/RS', '5c2dbc1990e72c6782468cca9f3a5544'),
(5, 'Rosana Lima', 'ro_lima@gmail.com', 'Av. Dom Joaquim, 1515 - Pelotas/RS', '5c2dbc1990e72c6782468cca9f3a5544');

INSERT INTO agenda (`id_medico`, `data`, `agendado`) VALUES 
(1, '2019-03-01 13:00:00', 0),
(1, '2019-03-01 13:30:00', 0),
(1, '2019-03-02 13:00:00', 0),
(1, '2019-03-02 14:00:00', 1),
(2, '2019-03-14 09:00:00', 0),
(2, '2019-03-15 10:30:00', 0),
(2, '2019-03-10 09:30:00', 1),
(3, '2019-03-22 14:00:00', 0),
(3, '2019-03-17 13:30:00', 1),
(3, '2019-03-16 14:00:00', 1),
(3, '2019-03-17 14:30:00', 0),
(3, '2019-03-17 15:00:00', 0),
(5, '2019-03-04 09:00:00', 1),
(5, '2019-03-04 10:00:00', 0),
(5, '2019-03-05 11:00:00', 1),
(5, '2019-03-05 11:30:00', 0);