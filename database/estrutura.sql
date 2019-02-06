CREATE DATABASE IF NOT EXISTS `facil_consulta`;

USE `facil_consulta`;

CREATE TABLE IF NOT EXISTS `medico` (
	`id` BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`email` VARCHAR(112) NOT NULL,
	`nome` VARCHAR(112) NOT NULL,
	`senha` VARCHAR(112) NOT NULL,
	`endereco_consultorio` VARCHAR(112) NOT NULL,
	`data_criacao` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
	`data_alteracao` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `agenda` (
	`id` BIGINT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`id_medico` BIGINT NOT NULL,
	`data` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
	`agendado` BOOLEAN NULL DEFAULT 0,
	FOREIGN KEY (`id_medico`) REFERENCES `medico` (`id`) ON DELETE CASCADE
);