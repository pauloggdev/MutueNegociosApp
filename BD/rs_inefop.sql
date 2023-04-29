-- --------------------------------------------------------
-- Anfitrião:                    127.0.0.1
-- Versão do servidor:           5.7.24 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Versão:              10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for rs_inefop
CREATE DATABASE IF NOT EXISTS `rs_inefop` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `rs_inefop`;

-- Dumping structure for table rs_inefop.ano_lectivo
CREATE TABLE IF NOT EXISTS `ano_lectivo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ano` int(10) unsigned NOT NULL,
  `estado` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.ano_lectivo: ~2 rows (approximately)
/*!40000 ALTER TABLE `ano_lectivo` DISABLE KEYS */;
INSERT INTO `ano_lectivo` (`id`, `ano`, `estado`) VALUES
	(1, 2020, 1),
	(2, 2021, 1);
/*!40000 ALTER TABLE `ano_lectivo` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.auxiliares_didaticos
CREATE TABLE IF NOT EXISTS `auxiliares_didaticos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `meios_ensino_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `curso_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_auxiliares_curso` (`curso_id`),
  KEY `FK_auxiliares_user` (`user_id`),
  KEY `FK_auxiliares_status` (`status_id`),
  KEY `FK_auxiliares_canal` (`canal_id`),
  KEY `FK_auxiliares_meios` (`meios_ensino_id`),
  CONSTRAINT `FK_auxiliares_canal` FOREIGN KEY (`canal_id`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_auxiliares_curso` FOREIGN KEY (`curso_id`) REFERENCES `curso_centro` (`id`),
  CONSTRAINT `FK_auxiliares_meios` FOREIGN KEY (`meios_ensino_id`) REFERENCES `meios_ensino` (`id`),
  CONSTRAINT `FK_auxiliares_status` FOREIGN KEY (`status_id`) REFERENCES `estado_sistema` (`id`),
  CONSTRAINT `FK_auxiliares_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.auxiliares_didaticos: ~0 rows (approximately)
/*!40000 ALTER TABLE `auxiliares_didaticos` DISABLE KEYS */;
/*!40000 ALTER TABLE `auxiliares_didaticos` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.black_list
CREATE TABLE IF NOT EXISTS `black_list` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.black_list: ~0 rows (approximately)
/*!40000 ALTER TABLE `black_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `black_list` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.canal_comunicacao
CREATE TABLE IF NOT EXISTS `canal_comunicacao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.canal_comunicacao: ~2 rows (approximately)
/*!40000 ALTER TABLE `canal_comunicacao` DISABLE KEYS */;
INSERT INTO `canal_comunicacao` (`id`, `designacao`) VALUES
	(1, 'Portal INEFOP'),
	(2, 'Base de Dados');
/*!40000 ALTER TABLE `canal_comunicacao` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.centro_formacao
CREATE TABLE IF NOT EXISTS `centro_formacao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_centro_id` int(10) unsigned NOT NULL,
  `publico_alvo_id` int(10) unsigned NOT NULL,
  `sector_actividade_id` int(10) unsigned NOT NULL,
  `municipio_id` int(11) DEFAULT NULL,
  `nome_director` varchar(450) NOT NULL,
  `nome_centro` varchar(500) NOT NULL,
  `habilitacao_academica_id` int(10) unsigned NOT NULL,
  `telefone1` varchar(45) NOT NULL,
  `telefone2` varchar(45) DEFAULT NULL,
  `email` varchar(400) NOT NULL,
  `logotipo` varchar(450) DEFAULT NULL,
  `fax` varchar(45) DEFAULT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nif` varchar(45) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_centro_tipo_centro` (`tipo_centro_id`),
  KEY `FK_centro_publico_alvo` (`publico_alvo_id`),
  KEY `FK_centro_sector` (`sector_actividade_id`),
  KEY `FK_centro_habilitacao` (`habilitacao_academica_id`),
  KEY `FK_centro_municipio` (`municipio_id`),
  KEY `FK_centro_formacao_status` (`status_id`),
  KEY `FK_centro_canal` (`canal_id`),
  KEY `FK_centro_formacao_user` (`user_id`),
  CONSTRAINT `FK_centro_canal` FOREIGN KEY (`canal_id`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_centro_formacao_status` FOREIGN KEY (`status_id`) REFERENCES `estado_sistema` (`id`),
  CONSTRAINT `FK_centro_formacao_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_centro_habilitacao` FOREIGN KEY (`habilitacao_academica_id`) REFERENCES `habilitacao_academica` (`id`),
  CONSTRAINT `FK_centro_municipio` FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`),
  CONSTRAINT `FK_centro_publico_alvo` FOREIGN KEY (`publico_alvo_id`) REFERENCES `publico_alvo` (`id`),
  CONSTRAINT `FK_centro_sector` FOREIGN KEY (`sector_actividade_id`) REFERENCES `sector_actividade` (`id`),
  CONSTRAINT `FK_centro_tipo_centro` FOREIGN KEY (`tipo_centro_id`) REFERENCES `tipo_centro_formacao` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.centro_formacao: ~1 rows (approximately)
/*!40000 ALTER TABLE `centro_formacao` DISABLE KEYS */;
INSERT INTO `centro_formacao` (`id`, `tipo_centro_id`, `publico_alvo_id`, `sector_actividade_id`, `municipio_id`, `nome_director`, `nome_centro`, `habilitacao_academica_id`, `telefone1`, `telefone2`, `email`, `logotipo`, `fax`, `status_id`, `canal_id`, `created_at`, `updated_at`, `nif`, `bairro`, `website`, `user_id`) VALUES
	(36, 2, 2, 1, 132, 'Patricio Neto', 'Patrisoft Developper', 1, '+244 947-467-767', '+244 976-546-678', 'patrisoft@gmail.com', 'utilizadores/avatar/vLhgeVN5D9jYCiXCR9ioE2LqBAhzwa0kZhvzjt2P.jpeg', '222-975-097-900', 1, 1, '2020-08-25 21:31:41', '2020-08-25 21:31:41', '123456789LA042', 'fffffffffffffffffff', 'https://www.patrisosft.develpper.com', 82),
	(37, 2, 1, 3, 19, 'daqqqqqqqqqqqqqqqqqqqqqq', 'dddddddddddddddd', 2, '+244 437-678-789', '+244 009-812-347', 'bbgghhjkk@ggg.om', 'utilizadores/avatar/8zPM3JL8VjlH6JppZIL21nvYHXdkSYgYhQfQQMdL.jpeg', NULL, 1, 1, '2020-08-26 15:05:40', '2020-08-26 15:05:40', '12346789087667', 'ddddddddddddd', 'http://www.hhh.on', 83);
/*!40000 ALTER TABLE `centro_formacao` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.curso_centro
CREATE TABLE IF NOT EXISTS `curso_centro` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `centro_id` int(10) unsigned NOT NULL,
  `designacao` varchar(450) NOT NULL,
  `carga_horaria_teorica` int(10) unsigned DEFAULT NULL,
  `carga_horaria_pratica` int(10) unsigned DEFAULT NULL,
  `conteudo_programatico` varchar(450) DEFAULT NULL,
  `obj_geral` text NOT NULL,
  `obj_especifico` text NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `estado_credencial_id` int(10) unsigned NOT NULL,
  `lotacao` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_curso_centro` (`centro_id`),
  KEY `FK_curso_centro_canal` (`canal_id`),
  KEY `FK_curso_centro_status` (`status_id`),
  KEY `FK_curso_centro_user` (`user_id`),
  KEY `FK_curso_centro_estado_creencial` (`estado_credencial_id`),
  CONSTRAINT `FK_curso_centro` FOREIGN KEY (`centro_id`) REFERENCES `centro_formacao` (`id`),
  CONSTRAINT `FK_curso_centro_canal` FOREIGN KEY (`canal_id`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_curso_centro_estado_creencial` FOREIGN KEY (`estado_credencial_id`) REFERENCES `estado_credencias` (`id`),
  CONSTRAINT `FK_curso_centro_status` FOREIGN KEY (`status_id`) REFERENCES `estado_sistema` (`id`),
  CONSTRAINT `FK_curso_centro_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.curso_centro: ~1 rows (approximately)
/*!40000 ALTER TABLE `curso_centro` DISABLE KEYS */;
INSERT INTO `curso_centro` (`id`, `centro_id`, `designacao`, `carga_horaria_teorica`, `carga_horaria_pratica`, `conteudo_programatico`, `obj_geral`, `obj_especifico`, `canal_id`, `created_at`, `updated_at`, `status_id`, `user_id`, `estado_credencial_id`, `lotacao`) VALUES
	(43, 36, 'Programação Não Procedimental(PNP)', 23, 15, NULL, 'Aprender Linguagens não Funcionais', 'Aprender sobre Declarações de Linguagens', 1, '2020-08-25 21:31:41', '2020-08-25 21:31:41', 1, 82, 2, 13),
	(44, 36, 'Linguagens Formais e Automátos', 12, 56, NULL, 'Aprender Linguagens de estados', 'Ensinar Linguagens não Funcionais', 1, '2020-08-25 21:31:43', '2020-08-25 21:31:43', 1, 82, 2, 67),
	(45, 37, 'aaaaaaaaaaaaaaaaa', 8, 11, NULL, 'vvvvvvvvvvvvvvvvv', '12', 1, '2020-08-26 15:05:41', '2020-08-26 15:05:41', 1, 83, 2, 17);
/*!40000 ALTER TABLE `curso_centro` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.documentos_centro
CREATE TABLE IF NOT EXISTS `documentos_centro` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(450) NOT NULL,
  `centro_id` int(10) unsigned NOT NULL,
  `tipo_documento_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `canal_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_documentos_centro_canal` (`canal_id`),
  KEY `FK_documentos_centro` (`centro_id`),
  KEY `FK_documentos_centro_tipo` (`tipo_documento_id`),
  KEY `FK_documentos_centro_user` (`user_id`),
  CONSTRAINT `FK_documentos_centro` FOREIGN KEY (`centro_id`) REFERENCES `centro_formacao` (`id`),
  CONSTRAINT `FK_documentos_centro_canal` FOREIGN KEY (`canal_id`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_documentos_centro_tipo` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipo_documento` (`id`),
  CONSTRAINT `FK_documentos_centro_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=208 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.documentos_centro: ~39 rows (approximately)
/*!40000 ALTER TABLE `documentos_centro` DISABLE KEYS */;
INSERT INTO `documentos_centro` (`id`, `designacao`, `centro_id`, `tipo_documento_id`, `created_at`, `updated_at`, `canal_id`, `user_id`) VALUES
	(169, 'documentos/centros/36/credenciamento/hPvDP6AbZ9bwOf0uLwiZ7hQRq1U5Em8EUVNyZYFo.pdf', 36, 5, '2020-08-25 21:31:41', '2020-08-25 21:31:41', 1, 82),
	(170, 'documentos/centros/36/credenciamento/1i9GBYNbBxWZpmsdaxMAbaKFyuqPRx4XhZVhlTAQ.pdf', 36, 6, '2020-08-25 21:31:41', '2020-08-25 21:31:41', 1, 82),
	(171, 'documentos/centros/36/credenciamento/oKcw7SNFcGepmNEuY8n3Y05onqnKt5HkSYdkTYLB.pdf', 36, 7, '2020-08-25 21:31:41', '2020-08-25 21:31:41', 1, 82),
	(172, 'documentos/centros/36/credenciamento/0iJ9Neiysn7XjxKkkG3WaPuKPsG2HthPBHNw6323.pdf', 36, 8, '2020-08-25 21:31:42', '2020-08-25 21:31:42', 1, 82),
	(173, 'documentos/centros/36/credenciamento/Yziv647JXV11DrpdnvpOUbEj7YDd6CRvapbXXpMK.pdf', 36, 9, '2020-08-25 21:31:42', '2020-08-25 21:31:42', 1, 82),
	(174, 'documentos/centros/36/credenciamento/l1ZE4tXb95f9gSuUPYPS5a1EqYVRDBwyPU578hSo.pdf', 36, 10, '2020-08-25 21:31:42', '2020-08-25 21:31:42', 1, 82),
	(175, 'documentos/centros/36/credenciamento/rRzpyzPhAJ6MFf0kuoeuuD2u1YE6s4UKTWUz0i33.pdf', 36, 11, '2020-08-25 21:31:42', '2020-08-25 21:31:42', 1, 82),
	(176, 'documentos/centros/36/credenciamento/8gotHRVKrqKFYoU2lCpzyM7bbGhtayC5k1KZ0KEI.pdf', 36, 12, '2020-08-25 21:31:42', '2020-08-25 21:31:42', 1, 82),
	(177, 'documentos/centros/36/credenciamento/bNSO2EfAJocQ5gDL2IXOStQNLTTM6PfJhp2paIKo.pdf', 36, 13, '2020-08-25 21:31:42', '2020-08-25 21:31:42', 1, 82),
	(178, 'documentos/centros/36/director/NOfLvxegQdCXtiuX6TsPU8k2Z9CAZMeqL5a7iYkP.pdf', 36, 1, '2020-08-25 21:31:42', '2020-08-25 21:31:42', 1, 82),
	(179, 'documentos/centros/36/director/2cql1rJbdHzqSSzapabEdKPIIIi2eMWyf2pEY6Fh.pdf', 36, 2, '2020-08-25 21:31:42', '2020-08-25 21:31:42', 1, 82),
	(180, 'documentos/centros/36/director/3NJduz6P5KalEeiTkZ1HRylrsWZz1vtknGM2pVsQ.pdf', 36, 3, '2020-08-25 21:31:42', '2020-08-25 21:31:42', 1, 82),
	(181, 'documentos/centros/36/director/PYx4WwxqHxXJP2E97WqzawSMl2ztyAVUxVh275yD.pdf', 36, 4, '2020-08-25 21:31:42', '2020-08-25 21:31:42', 1, 82),
	(182, 'documentos/centros/36/credenciamento/hPvDP6AbZ9bwOf0uLwiZ7hQRq1U5Em8EUVNyZYFo.pdf', 36, 5, '2020-08-25 21:31:43', '2020-08-25 21:31:43', 1, 82),
	(183, 'documentos/centros/36/credenciamento/1i9GBYNbBxWZpmsdaxMAbaKFyuqPRx4XhZVhlTAQ.pdf', 36, 6, '2020-08-25 21:31:43', '2020-08-25 21:31:43', 1, 82),
	(184, 'documentos/centros/36/credenciamento/oKcw7SNFcGepmNEuY8n3Y05onqnKt5HkSYdkTYLB.pdf', 36, 7, '2020-08-25 21:31:43', '2020-08-25 21:31:43', 1, 82),
	(185, 'documentos/centros/36/credenciamento/0iJ9Neiysn7XjxKkkG3WaPuKPsG2HthPBHNw6323.pdf', 36, 8, '2020-08-25 21:31:43', '2020-08-25 21:31:43', 1, 82),
	(186, 'documentos/centros/36/credenciamento/Yziv647JXV11DrpdnvpOUbEj7YDd6CRvapbXXpMK.pdf', 36, 9, '2020-08-25 21:31:43', '2020-08-25 21:31:43', 1, 82),
	(187, 'documentos/centros/36/credenciamento/l1ZE4tXb95f9gSuUPYPS5a1EqYVRDBwyPU578hSo.pdf', 36, 10, '2020-08-25 21:31:43', '2020-08-25 21:31:43', 1, 82),
	(188, 'documentos/centros/36/credenciamento/rRzpyzPhAJ6MFf0kuoeuuD2u1YE6s4UKTWUz0i33.pdf', 36, 11, '2020-08-25 21:31:43', '2020-08-25 21:31:43', 1, 82),
	(189, 'documentos/centros/36/credenciamento/8gotHRVKrqKFYoU2lCpzyM7bbGhtayC5k1KZ0KEI.pdf', 36, 12, '2020-08-25 21:31:43', '2020-08-25 21:31:43', 1, 82),
	(190, 'documentos/centros/36/credenciamento/bNSO2EfAJocQ5gDL2IXOStQNLTTM6PfJhp2paIKo.pdf', 36, 13, '2020-08-25 21:31:43', '2020-08-25 21:31:43', 1, 82),
	(191, 'documentos/centros/36/director/NOfLvxegQdCXtiuX6TsPU8k2Z9CAZMeqL5a7iYkP.pdf', 36, 1, '2020-08-25 21:31:43', '2020-08-25 21:31:43', 1, 82),
	(192, 'documentos/centros/36/director/2cql1rJbdHzqSSzapabEdKPIIIi2eMWyf2pEY6Fh.pdf', 36, 2, '2020-08-25 21:31:43', '2020-08-25 21:31:43', 1, 82),
	(193, 'documentos/centros/36/director/3NJduz6P5KalEeiTkZ1HRylrsWZz1vtknGM2pVsQ.pdf', 36, 3, '2020-08-25 21:31:43', '2020-08-25 21:31:43', 1, 82),
	(194, 'documentos/centros/36/director/PYx4WwxqHxXJP2E97WqzawSMl2ztyAVUxVh275yD.pdf', 36, 4, '2020-08-25 21:31:43', '2020-08-25 21:31:43', 1, 82),
	(195, 'documentos/centros/37/credenciamento/C59cXW4PDx1LeGEWA68KVBy55bmhba7mKUO5orRG.pdf', 37, 5, '2020-08-26 15:05:41', '2020-08-26 15:05:41', 1, 83),
	(196, 'documentos/centros/37/credenciamento/iRdBsbuIZteX4IjoVMrDepMxluU8pK6086E3wJFT.pdf', 37, 6, '2020-08-26 15:05:41', '2020-08-26 15:05:41', 1, 83),
	(197, 'documentos/centros/37/credenciamento/p1G4YvdFhkR54rGY9E8cXohFDSxTnPGZjgaQPSVT.pdf', 37, 7, '2020-08-26 15:05:41', '2020-08-26 15:05:41', 1, 83),
	(198, 'documentos/centros/37/credenciamento/2OmnE25lWrVll6vSrEb2ur5DAAe3sPCehrwEjPDi.pdf', 37, 8, '2020-08-26 15:05:42', '2020-08-26 15:05:42', 1, 83),
	(199, 'documentos/centros/37/credenciamento/mwv8edA0A4tvrAlYtC6fOXRNRH39199WoABxQHIb.pdf', 37, 9, '2020-08-26 15:05:42', '2020-08-26 15:05:42', 1, 83),
	(200, 'documentos/centros/37/credenciamento/VDgDACDF37O1V53fd4TTRBw9xtiPqPRuWi9xHVzY.pdf', 37, 10, '2020-08-26 15:05:42', '2020-08-26 15:05:42', 1, 83),
	(201, 'documentos/centros/37/credenciamento/N2htjmI3ORz06LbKSKIUD2g9JqEn0D6Wi4uCcVQx.pdf', 37, 11, '2020-08-26 15:05:42', '2020-08-26 15:05:42', 1, 83),
	(202, 'documentos/centros/37/credenciamento/7k6uDYEGtOvRj9d1bBM7cDsJi6q7Shwole77EIGq.pdf', 37, 12, '2020-08-26 15:05:42', '2020-08-26 15:05:42', 1, 83),
	(203, 'documentos/centros/37/credenciamento/yXX2Rc9j9aVWBwybKsRtKqKBnr1grvgH3Xpu1ZNy.pdf', 37, 13, '2020-08-26 15:05:42', '2020-08-26 15:05:42', 1, 83),
	(204, 'documentos/centros/37/director/6N7H5Cs8jWH6w0FksOxM0uTzontFMIasOYX8GECo.pdf', 37, 1, '2020-08-26 15:05:43', '2020-08-26 15:05:43', 1, 83),
	(205, 'documentos/centros/37/director/TcKwrYUrtBSPyBYlakGM3REEXVX01VJgciCr0xaA.pdf', 37, 2, '2020-08-26 15:05:43', '2020-08-26 15:05:43', 1, 83),
	(206, 'documentos/centros/37/director/qarRIeNQ5LSIrd8jM2KJRVOAqiATV1xZH5sWVMlx.pdf', 37, 3, '2020-08-26 15:05:43', '2020-08-26 15:05:43', 1, 83),
	(207, 'documentos/centros/37/director/bkOOwU9o8axuAknRZmfzyWkb7rSwq5yQSrgU4C65.pdf', 37, 4, '2020-08-26 15:05:43', '2020-08-26 15:05:43', 1, 83);
/*!40000 ALTER TABLE `documentos_centro` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.documentos_centro_credencias
CREATE TABLE IF NOT EXISTS `documentos_centro_credencias` (
  `id` int(11) NOT NULL,
  `designacao` varchar(100) DEFAULT NULL,
  `centro_id` int(10) unsigned NOT NULL DEFAULT '0',
  `tipo_documento_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `canal_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_documentos_centro_credencias` (`centro_id`),
  KEY `FK_documentos_centro_tipo_cocuemto` (`tipo_documento_id`),
  KEY `FK_documentos_centro_canall` (`canal_id`),
  KEY `FK_documentos_centro_credencias_user` (`user_id`),
  CONSTRAINT `FK_documentos_centro_canall` FOREIGN KEY (`canal_id`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_documentos_centro_credencias` FOREIGN KEY (`centro_id`) REFERENCES `centro_formacao` (`id`),
  CONSTRAINT `FK_documentos_centro_credencias_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_documentos_centro_tipo_cocuemto` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipo_documento` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.documentos_centro_credencias: ~0 rows (approximately)
/*!40000 ALTER TABLE `documentos_centro_credencias` DISABLE KEYS */;
/*!40000 ALTER TABLE `documentos_centro_credencias` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.documentos_centro_funcionario
CREATE TABLE IF NOT EXISTS `documentos_centro_funcionario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_funcionario` int(10) unsigned NOT NULL,
  `tipo_documento` int(10) unsigned NOT NULL,
  `centro_id` int(10) unsigned NOT NULL,
  `designacao` varchar(450) NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_documentos_centro_funcionario` (`centro_id`),
  KEY `FK_documentos_centro_funcionario_tipo_fun` (`tipo_funcionario`),
  KEY `FK_documentos_centro_funcionario_tipo_doc` (`tipo_documento`),
  KEY `FK_documentos_centro_funcionario_canal` (`canal_id`),
  KEY `FK_documentos_centro_funcionario_user` (`user_id`),
  CONSTRAINT `FK_documentos_centro_funcionario` FOREIGN KEY (`centro_id`) REFERENCES `centro_formacao` (`id`),
  CONSTRAINT `FK_documentos_centro_funcionario_canal` FOREIGN KEY (`canal_id`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_documentos_centro_funcionario_tipo_doc` FOREIGN KEY (`tipo_documento`) REFERENCES `tipo_documento` (`id`),
  CONSTRAINT `FK_documentos_centro_funcionario_tipo_fun` FOREIGN KEY (`tipo_funcionario`) REFERENCES `tipo_funcionario` (`id`),
  CONSTRAINT `FK_documentos_centro_funcionario_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.documentos_centro_funcionario: ~0 rows (approximately)
/*!40000 ALTER TABLE `documentos_centro_funcionario` DISABLE KEYS */;
/*!40000 ALTER TABLE `documentos_centro_funcionario` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.estado_credencias
CREATE TABLE IF NOT EXISTS `estado_credencias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `desgnacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.estado_credencias: ~3 rows (approximately)
/*!40000 ALTER TABLE `estado_credencias` DISABLE KEYS */;
INSERT INTO `estado_credencias` (`id`, `desgnacao`) VALUES
	(1, 'Activo'),
	(2, 'Pendente'),
	(3, 'Cancelado');
/*!40000 ALTER TABLE `estado_credencias` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.estado_homologacao
CREATE TABLE IF NOT EXISTS `estado_homologacao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.estado_homologacao: ~3 rows (approximately)
/*!40000 ALTER TABLE `estado_homologacao` DISABLE KEYS */;
INSERT INTO `estado_homologacao` (`id`, `designacao`) VALUES
	(1, 'Activo'),
	(2, 'Pendente'),
	(3, 'Cancelado');
/*!40000 ALTER TABLE `estado_homologacao` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.estado_sistema
CREATE TABLE IF NOT EXISTS `estado_sistema` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.estado_sistema: ~0 rows (approximately)
/*!40000 ALTER TABLE `estado_sistema` DISABLE KEYS */;
INSERT INTO `estado_sistema` (`id`, `designacao`) VALUES
	(1, 'ativo');
/*!40000 ALTER TABLE `estado_sistema` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.factura
CREATE TABLE IF NOT EXISTS `factura` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DataFactura` datetime NOT NULL,
  `TotalPreco` double NOT NULL DEFAULT '0',
  `Referencia` varchar(9) DEFAULT '000000000',
  `ValorEntregue` double DEFAULT NULL,
  `Desconto` double DEFAULT NULL,
  `ValorAPagar` double DEFAULT NULL,
  `Troco` double DEFAULT NULL,
  `ValorAPagarExtenso` varchar(245) DEFAULT NULL,
  `Descricao` varchar(500) DEFAULT NULL,
  `ValorEntregueMltCX` double DEFAULT '0',
  `totalIVA` double DEFAULT '0',
  `NextFactura` varchar(45) DEFAULT '',
  `dataVencimento` date DEFAULT NULL,
  `obs` varchar(45000) DEFAULT NULL,
  `hashValor` varchar(200) DEFAULT NULL,
  `contaCorrente` varchar(45) DEFAULT NULL,
  `faturaReference` varchar(45) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_factura_canal` (`canal_id`),
  KEY `FK_factura_user` (`user_id`),
  KEY `FK_factura_status` (`status_id`),
  CONSTRAINT `FK_factura_canal` FOREIGN KEY (`canal_id`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_factura_status` FOREIGN KEY (`status_id`) REFERENCES `estado_sistema` (`id`),
  CONSTRAINT `FK_factura_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.factura: ~0 rows (approximately)
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.factura_items
CREATE TABLE IF NOT EXISTS `factura_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Quantidade` double DEFAULT NULL,
  `Total` double DEFAULT NULL,
  `OBS` varchar(45) DEFAULT NULL,
  `TotalIva` double NOT NULL DEFAULT '0',
  `preco` double NOT NULL DEFAULT '0',
  `descontoProduto` double DEFAULT '0',
  `factura_id` int(10) unsigned NOT NULL,
  `curso_id` int(10) unsigned DEFAULT NULL,
  `tipo_servico_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_factura_items_factura` (`factura_id`),
  KEY `FK_factura_items_curso` (`curso_id`),
  KEY `FK_factura_items_servico` (`tipo_servico_id`),
  CONSTRAINT `FK_factura_items_curso` FOREIGN KEY (`curso_id`) REFERENCES `curso_centro` (`id`),
  CONSTRAINT `FK_factura_items_factura` FOREIGN KEY (`factura_id`) REFERENCES `factura` (`id`),
  CONSTRAINT `FK_factura_items_servico` FOREIGN KEY (`tipo_servico_id`) REFERENCES `tipo_servico` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.factura_items: ~0 rows (approximately)
/*!40000 ALTER TABLE `factura_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `factura_items` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rs_inefop.failed_jobs: ~0 rows (approximately)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.formador_centro
CREATE TABLE IF NOT EXISTS `formador_centro` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `centro_id` int(10) unsigned NOT NULL,
  `nome` varchar(450) NOT NULL,
  `bi` varchar(45) NOT NULL,
  `email` varchar(450) NOT NULL,
  `telefone` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_formador_centro_1` (`canal_id`),
  KEY `FK_formador_centro_2` (`status_id`),
  KEY `FK_formador_centro_3` (`centro_id`),
  CONSTRAINT `FK_formador_centro_1` FOREIGN KEY (`canal_id`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_formador_centro_2` FOREIGN KEY (`status_id`) REFERENCES `estado_sistema` (`id`),
  CONSTRAINT `FK_formador_centro_3` FOREIGN KEY (`centro_id`) REFERENCES `centro_formacao` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.formador_centro: ~0 rows (approximately)
/*!40000 ALTER TABLE `formador_centro` DISABLE KEYS */;
/*!40000 ALTER TABLE `formador_centro` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.formando_centro
CREATE TABLE IF NOT EXISTS `formando_centro` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `centro_id` int(10) unsigned NOT NULL,
  `nome` varchar(450) NOT NULL,
  `bi` varchar(45) NOT NULL,
  `telefone` varchar(45) NOT NULL,
  `email` varchar(405) NOT NULL,
  `pai` varchar(450) NOT NULL,
  `mae` varchar(450) NOT NULL,
  `data_nascimento` date NOT NULL,
  `data_emissao_bi` date NOT NULL,
  `data_validacao_bi` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_formando_centro` (`centro_id`),
  KEY `FK_formando_centro_2` (`canal_id`),
  KEY `FK_formando_centro_3` (`status_id`),
  CONSTRAINT `FK_formando_centro` FOREIGN KEY (`centro_id`) REFERENCES `centro_formacao` (`id`),
  CONSTRAINT `FK_formando_centro_2` FOREIGN KEY (`canal_id`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_formando_centro_3` FOREIGN KEY (`status_id`) REFERENCES `estado_sistema` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.formando_centro: ~0 rows (approximately)
/*!40000 ALTER TABLE `formando_centro` DISABLE KEYS */;
/*!40000 ALTER TABLE `formando_centro` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.forma_pagamento
CREATE TABLE IF NOT EXISTS `forma_pagamento` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  `codigo_status` int(10) unsigned NOT NULL,
  `canal` int(10) unsigned NOT NULL,
  `codigo_utilizador` bigint(20) unsigned NOT NULL,
  `data_cadastro` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_forma_pagamento_utilizador` (`codigo_utilizador`),
  KEY `FK_forma_pagamento_canal` (`canal`),
  CONSTRAINT `FK_forma_pagamento_canal` FOREIGN KEY (`canal`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_forma_pagamento_status` FOREIGN KEY (`id`) REFERENCES `estado_sistema` (`id`),
  CONSTRAINT `FK_forma_pagamento_utilizador` FOREIGN KEY (`codigo_utilizador`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.forma_pagamento: ~0 rows (approximately)
/*!40000 ALTER TABLE `forma_pagamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `forma_pagamento` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.galeria_centro
CREATE TABLE IF NOT EXISTS `galeria_centro` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `centro_id` int(10) unsigned NOT NULL,
  `designacao_imagem` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK__centro_formacao` (`centro_id`),
  CONSTRAINT `FK__centro_formacao` FOREIGN KEY (`centro_id`) REFERENCES `centro_formacao` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.galeria_centro: ~12 rows (approximately)
/*!40000 ALTER TABLE `galeria_centro` DISABLE KEYS */;
INSERT INTO `galeria_centro` (`id`, `centro_id`, `designacao_imagem`) VALUES
	(34, 36, 'documentos/centros/36/galerias/XTBeAaj01HrWUDJylhOZwssLLmwbQmpOEBfdF98n.jpeg'),
	(35, 36, 'documentos/centros/36/galerias/AuNA1NjuBuk1AMGDTGFSyhyerygX6xydDRsLiZi1.jpeg'),
	(36, 36, 'documentos/centros/36/galerias/E3y389cUoAFjB1Fvry9JCZ2KhrbrORPlkjkIWNg6.jpeg'),
	(37, 36, 'documentos/centros/36/galerias/l7PHiuiNRm702N4vmKsWqCq3Ic1jYncCQY3wpG9J.jpeg'),
	(38, 36, 'documentos/centros/36/galerias/xJXlpQuNZU9FFbFhRByzIhtNs9lTl4vX0nclkILh.jpeg'),
	(39, 36, 'documentos/centros/36/galerias/QnL55mOoHGl0Vkdv0iiO080BM05VeqMvNH2uCHqk.jpeg'),
	(40, 36, 'documentos/centros/36/galerias/XTBeAaj01HrWUDJylhOZwssLLmwbQmpOEBfdF98n.jpeg'),
	(41, 36, 'documentos/centros/36/galerias/AuNA1NjuBuk1AMGDTGFSyhyerygX6xydDRsLiZi1.jpeg'),
	(42, 36, 'documentos/centros/36/galerias/E3y389cUoAFjB1Fvry9JCZ2KhrbrORPlkjkIWNg6.jpeg'),
	(43, 36, 'documentos/centros/36/galerias/l7PHiuiNRm702N4vmKsWqCq3Ic1jYncCQY3wpG9J.jpeg'),
	(44, 36, 'documentos/centros/36/galerias/xJXlpQuNZU9FFbFhRByzIhtNs9lTl4vX0nclkILh.jpeg'),
	(45, 36, 'documentos/centros/36/galerias/QnL55mOoHGl0Vkdv0iiO080BM05VeqMvNH2uCHqk.jpeg'),
	(46, 37, 'documentos/centros/37/galerias/ifjZ6IcD9UxxEr35CAq3FcAhlw19iyX0rA6DZAZR.jpeg');
/*!40000 ALTER TABLE `galeria_centro` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.grau_academico
CREATE TABLE IF NOT EXISTS `grau_academico` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.grau_academico: ~0 rows (approximately)
/*!40000 ALTER TABLE `grau_academico` DISABLE KEYS */;
/*!40000 ALTER TABLE `grau_academico` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.habilitacao_academica
CREATE TABLE IF NOT EXISTS `habilitacao_academica` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.habilitacao_academica: ~3 rows (approximately)
/*!40000 ALTER TABLE `habilitacao_academica` DISABLE KEYS */;
INSERT INTO `habilitacao_academica` (`id`, `designacao`) VALUES
	(1, 'Manhã'),
	(2, 'Tarde'),
	(3, 'Noite');
/*!40000 ALTER TABLE `habilitacao_academica` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.homologacao_formando_turma
CREATE TABLE IF NOT EXISTS `homologacao_formando_turma` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `formando_id` int(10) unsigned NOT NULL,
  `turma_id` int(10) unsigned NOT NULL,
  `centro_id` int(10) unsigned NOT NULL,
  `utilizador_id` bigint(20) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `estado_homologacao_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_homologacao_formando` (`formando_id`),
  KEY `FK_homologacao_turma` (`turma_id`),
  KEY `FK_homologacao_centro` (`centro_id`),
  KEY `FK_homologacao_user` (`utilizador_id`),
  KEY `FK_homologacao_canal` (`canal_id`),
  KEY `FK_homologacao_estado_homologacao` (`estado_homologacao_id`),
  CONSTRAINT `FK_homologacao_canal` FOREIGN KEY (`canal_id`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_homologacao_centro` FOREIGN KEY (`centro_id`) REFERENCES `centro_formacao` (`id`),
  CONSTRAINT `FK_homologacao_estado_homologacao` FOREIGN KEY (`estado_homologacao_id`) REFERENCES `estado_homologacao` (`id`),
  CONSTRAINT `FK_homologacao_formando` FOREIGN KEY (`formando_id`) REFERENCES `formando_centro` (`id`),
  CONSTRAINT `FK_homologacao_turma` FOREIGN KEY (`turma_id`) REFERENCES `turmas_centros` (`id`),
  CONSTRAINT `FK_homologacao_user` FOREIGN KEY (`utilizador_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.homologacao_formando_turma: ~0 rows (approximately)
/*!40000 ALTER TABLE `homologacao_formando_turma` DISABLE KEYS */;
/*!40000 ALTER TABLE `homologacao_formando_turma` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.indicacoes_metodologias_curso
CREATE TABLE IF NOT EXISTS `indicacoes_metodologias_curso` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `curso_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `metodos_didaticos_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_indicacoes_curso` (`curso_id`),
  KEY `FK_indicacoes_user` (`user_id`),
  KEY `FK_indicacoes_canal` (`canal_id`),
  KEY `FK_indicacoes_status` (`status_id`),
  KEY `FK_indicacoes_metodos` (`metodos_didaticos_id`),
  CONSTRAINT `FK_indicacoes_canal` FOREIGN KEY (`canal_id`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_indicacoes_curso` FOREIGN KEY (`curso_id`) REFERENCES `curso_centro` (`id`),
  CONSTRAINT `FK_indicacoes_metodos` FOREIGN KEY (`metodos_didaticos_id`) REFERENCES `metodos_didaticos` (`id`),
  CONSTRAINT `FK_indicacoes_status` FOREIGN KEY (`status_id`) REFERENCES `estado_sistema` (`id`),
  CONSTRAINT `FK_indicacoes_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.indicacoes_metodologias_curso: ~0 rows (approximately)
/*!40000 ALTER TABLE `indicacoes_metodologias_curso` DISABLE KEYS */;
/*!40000 ALTER TABLE `indicacoes_metodologias_curso` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table rs_inefop.jobs: ~2 rows (approximately)
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
	(1, 'default', '{"uuid":"f7364660-34f8-4a40-bbfc-98c8d8e5c0ca","displayName":"App\\\\Notifications\\\\CadastroCentro","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":13:{s:11:\\"notifiables\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":4:{s:5:\\"class\\";s:8:\\"App\\\\User\\";s:2:\\"id\\";a:1:{i:0;i:82;}s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";}s:12:\\"notification\\";O:32:\\"App\\\\Notifications\\\\CadastroCentro\\":10:{s:43:\\"\\u0000App\\\\Notifications\\\\CadastroCentro\\u0000infoEmail\\";a:3:{s:10:\\"nomeCentro\\";s:20:\\"Patrisoft Developper\\";s:11:\\"senhaCentro\\";s:60:\\"$2y$10$uc5gJipsmR9SdMPw80mnqupkh1aPTQr4Age\\/5.f0RST82JuUoibS.\\";s:3:\\"url\\";s:27:\\"http:\\/\\/localhost:8000\\/login\\";}s:2:\\"id\\";s:36:\\"e3cf9943-2ec9-48e8-a6f7-db8e183d9f56\\";s:6:\\"locale\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}s:8:\\"channels\\";a:1:{i:0;s:4:\\"mail\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:3:\\"job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598387503, 1598387503),
	(2, 'default', '{"uuid":"cda0f9d2-b14a-4403-b855-c0086f19d360","displayName":"App\\\\Notifications\\\\CadastroCentro","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":13:{s:11:\\"notifiables\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":4:{s:5:\\"class\\";s:8:\\"App\\\\User\\";s:2:\\"id\\";a:1:{i:0;i:82;}s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";}s:12:\\"notification\\";O:32:\\"App\\\\Notifications\\\\CadastroCentro\\":10:{s:43:\\"\\u0000App\\\\Notifications\\\\CadastroCentro\\u0000infoEmail\\";a:3:{s:10:\\"nomeCentro\\";s:20:\\"Patrisoft Developper\\";s:11:\\"senhaCentro\\";s:60:\\"$2y$10$Hoj4Ko4TvhkxwyYP9ZpQC.Pawda9Lg.eGUalnZDB0TQMFwGTZtFL6\\";s:3:\\"url\\";s:27:\\"http:\\/\\/localhost:8000\\/login\\";}s:2:\\"id\\";s:36:\\"5d257159-4ce4-4f06-b324-6f0da17a7ae2\\";s:6:\\"locale\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}s:8:\\"channels\\";a:1:{i:0;s:4:\\"mail\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:3:\\"job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598387504, 1598387504),
	(3, 'default', '{"uuid":"80d55759-7dde-4dbe-9c91-5858aadf1dc8","displayName":"App\\\\Notifications\\\\CadastroCentro","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"Illuminate\\\\Notifications\\\\SendQueuedNotifications","command":"O:48:\\"Illuminate\\\\Notifications\\\\SendQueuedNotifications\\":13:{s:11:\\"notifiables\\";O:45:\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\":4:{s:5:\\"class\\";s:8:\\"App\\\\User\\";s:2:\\"id\\";a:1:{i:0;i:83;}s:9:\\"relations\\";a:0:{}s:10:\\"connection\\";s:5:\\"mysql\\";}s:12:\\"notification\\";O:32:\\"App\\\\Notifications\\\\CadastroCentro\\":10:{s:43:\\"\\u0000App\\\\Notifications\\\\CadastroCentro\\u0000infoEmail\\";a:3:{s:10:\\"nomeCentro\\";s:16:\\"dddddddddddddddd\\";s:11:\\"senhaCentro\\";s:60:\\"$2y$10$tnZG0dcYJcTeJhuaVZUD7eoCIV4\\/Mw0LwoRsBQbBB2633\\/\\/RqmVRC\\";s:3:\\"url\\";s:27:\\"http:\\/\\/localhost:8000\\/login\\";}s:2:\\"id\\";s:36:\\"051a30b2-be1b-4d87-9313-8a8a62405353\\";s:6:\\"locale\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}s:8:\\"channels\\";a:1:{i:0;s:4:\\"mail\\";}s:5:\\"tries\\";N;s:7:\\"timeout\\";N;s:3:\\"job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";N;s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598450745, 1598450745);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.local_pagamento
CREATE TABLE IF NOT EXISTS `local_pagamento` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  `codigo_status` int(10) unsigned NOT NULL,
  `canal` int(10) unsigned NOT NULL,
  `codigo_utilizador` bigint(20) unsigned NOT NULL,
  `data_cadastro` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_local_pagamento_utilizador` (`codigo_utilizador`),
  KEY `FK_local_pagamento_canal` (`canal`),
  CONSTRAINT `FK_local_pagamento_canal` FOREIGN KEY (`canal`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_local_pagamento_status` FOREIGN KEY (`id`) REFERENCES `estado_sistema` (`id`),
  CONSTRAINT `FK_local_pagamento_utilizador` FOREIGN KEY (`codigo_utilizador`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.local_pagamento: ~0 rows (approximately)
/*!40000 ALTER TABLE `local_pagamento` DISABLE KEYS */;
/*!40000 ALTER TABLE `local_pagamento` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.logs
CREATE TABLE IF NOT EXISTS `logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(45) NOT NULL,
  `nome_pc` varchar(145) DEFAULT NULL,
  `descricao` varchar(345) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_logs_1` (`user_id`),
  KEY `FK_logs_2` (`canal_id`),
  CONSTRAINT `FK_logs_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_logs_2` FOREIGN KEY (`canal_id`) REFERENCES `canal_comunicacao` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.logs: ~0 rows (approximately)
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.meios_ensino
CREATE TABLE IF NOT EXISTS `meios_ensino` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(450) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.meios_ensino: ~6 rows (approximately)
/*!40000 ALTER TABLE `meios_ensino` DISABLE KEYS */;
INSERT INTO `meios_ensino` (`id`, `designacao`) VALUES
	(1, 'Quatro'),
	(2, 'Marcador'),
	(3, 'Apagador'),
	(4, 'Projector'),
	(5, 'Portátil'),
	(6, 'Tele de Projecção');
/*!40000 ALTER TABLE `meios_ensino` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.metodos_didaticos
CREATE TABLE IF NOT EXISTS `metodos_didaticos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(450) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.metodos_didaticos: ~4 rows (approximately)
/*!40000 ALTER TABLE `metodos_didaticos` DISABLE KEYS */;
INSERT INTO `metodos_didaticos` (`id`, `designacao`) VALUES
	(1, 'Explicativo'),
	(2, 'Demonstrativo'),
	(3, 'Ilustrativo'),
	(4, 'Interrogativo');
/*!40000 ALTER TABLE `metodos_didaticos` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.modulos_curso
CREATE TABLE IF NOT EXISTS `modulos_curso` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(450) NOT NULL,
  `curso_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_modulos_curso_user` (`user_id`),
  KEY `FK_modulos_curso_canal` (`canal_id`),
  KEY `FK_modulos_curso_status` (`status_id`),
  KEY `FK_modulos_curso_curso` (`curso_id`),
  CONSTRAINT `FK_modulos_curso_canal` FOREIGN KEY (`canal_id`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_modulos_curso_curso` FOREIGN KEY (`curso_id`) REFERENCES `curso_centro` (`id`),
  CONSTRAINT `FK_modulos_curso_status` FOREIGN KEY (`status_id`) REFERENCES `estado_sistema` (`id`),
  CONSTRAINT `FK_modulos_curso_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.modulos_curso: ~1 rows (approximately)
/*!40000 ALTER TABLE `modulos_curso` DISABLE KEYS */;
INSERT INTO `modulos_curso` (`id`, `designacao`, `curso_id`, `user_id`, `canal_id`, `status_id`, `updated_at`, `created_at`) VALUES
	(35, 'Estrutura da Sintaxe', 43, 82, 1, 1, '2020-08-25 21:31:41', '2020-08-25 21:31:41'),
	(36, 'Gramática de Termos', 44, 82, 1, 1, '2020-08-25 21:31:43', '2020-08-25 21:31:43'),
	(37, '444444444', 45, 83, 1, 1, '2020-08-26 15:05:41', '2020-08-26 15:05:41');
/*!40000 ALTER TABLE `modulos_curso` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.municipios
CREATE TABLE IF NOT EXISTS `municipios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_provincia` int(11) NOT NULL,
  `nome_municipio` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `codigo_provincia` (`codigo_provincia`),
  CONSTRAINT `municipios_ibfk_1` FOREIGN KEY (`codigo_provincia`) REFERENCES `provincias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=165 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.municipios: ~164 rows (approximately)
/*!40000 ALTER TABLE `municipios` DISABLE KEYS */;
INSERT INTO `municipios` (`id`, `codigo_provincia`, `nome_municipio`) VALUES
	(1, 1, 'Ambriz'),
	(2, 1, 'Bula'),
	(3, 1, 'Atumba'),
	(4, 1, 'Dembos'),
	(5, 1, 'Nambuangongo'),
	(6, 1, 'Pango Aluquem'),
	(7, 2, 'Baia Farta'),
	(8, 2, 'Balombo'),
	(9, 2, 'Benguela'),
	(10, 2, 'Bocoio'),
	(11, 2, 'Caimbambo'),
	(12, 2, 'Catumbela'),
	(13, 2, 'Chongoroi'),
	(14, 2, 'Cubal'),
	(15, 2, 'Ganda'),
	(16, 2, 'Lobito'),
	(17, 3, 'Andulo'),
	(18, 3, 'Camacupa'),
	(19, 3, 'Catabola'),
	(20, 3, 'Chinguar'),
	(21, 3, 'Chitembo'),
	(22, 3, 'Cuemba'),
	(23, 3, 'Cunhinga'),
	(24, 3, 'Kuito'),
	(25, 3, 'Nharea'),
	(26, 4, 'Cabinda'),
	(27, 4, 'Cacongo'),
	(28, 4, 'Buco-Zau'),
	(29, 4, 'Belize'),
	(30, 5, 'Cahama'),
	(31, 5, 'Cuanhama'),
	(32, 5, 'Curoca'),
	(33, 5, 'Cuvelai'),
	(34, 5, 'Namacunde'),
	(35, 5, 'Ombadja'),
	(36, 6, 'Calai'),
	(37, 6, 'Cuangar'),
	(38, 6, 'Cuchi'),
	(39, 6, 'Cuito'),
	(40, 6, 'Cuanavale'),
	(41, 6, 'Dirico'),
	(42, 6, 'Mavinga'),
	(43, 6, 'Menongue'),
	(44, 6, 'Nancova'),
	(45, 6, 'Rivungo'),
	(46, 7, 'Ambaca'),
	(47, 7, 'Banga'),
	(48, 7, 'Bolongongo'),
	(49, 7, 'Cambambe'),
	(50, 7, 'Cazengo'),
	(51, 7, 'Golungo Alto'),
	(52, 7, 'Gonguembo'),
	(53, 7, 'Lucala'),
	(54, 7, 'Quiculungo'),
	(55, 7, 'Samba Caju'),
	(56, 8, 'Amboim'),
	(57, 8, 'Cassongue'),
	(58, 8, 'Cela'),
	(59, 8, 'Conda'),
	(60, 8, 'Ebo'),
	(61, 8, 'Libolo'),
	(62, 8, 'Mussende'),
	(63, 8, 'Porto Amboim'),
	(64, 8, 'Quilenda'),
	(65, 8, 'Quibala'),
	(66, 8, 'Seles'),
	(67, 8, 'Sumbe'),
	(68, 9, 'Bailundo'),
	(69, 9, 'Caala'),
	(70, 9, 'Catchiungo'),
	(71, 9, 'Ekunha'),
	(72, 9, 'Huambo'),
	(73, 9, 'Londuimbale'),
	(74, 9, 'Longonjo'),
	(75, 9, 'Mungo'),
	(76, 9, 'Tchicala-Tcholoanga'),
	(77, 9, 'Tchindjenje'),
	(78, 9, 'Ucuma'),
	(79, 10, 'Caconda'),
	(80, 10, 'Cacula'),
	(81, 10, 'Caluquembe'),
	(82, 10, 'Chiange'),
	(83, 10, 'Chibia'),
	(84, 10, 'Chicomba'),
	(85, 10, 'Chipindo'),
	(86, 10, 'Cuvango'),
	(87, 10, 'Humpata'),
	(88, 10, 'Jamba'),
	(89, 10, 'Lubango'),
	(90, 10, 'Matala'),
	(91, 10, 'Quilengues'),
	(92, 10, 'Quipungo'),
	(93, 11, 'Belas'),
	(94, 11, 'Cacuaco'),
	(95, 11, 'Cazenga'),
	(96, 11, 'Icolo e Bengo'),
	(97, 11, 'Luanda'),
	(98, 11, 'Quiçama'),
	(99, 11, 'Viana'),
	(100, 12, 'Cambulo'),
	(101, 12, 'Capenda-Camulemba'),
	(102, 12, 'Caungula'),
	(103, 12, 'Chitato'),
	(104, 12, 'Cuango'),
	(105, 12, 'Cuilo'),
	(106, 12, 'Dundo'),
	(107, 12, 'Lubalo'),
	(108, 12, 'Lucapa Lovua'),
	(109, 12, 'Xá-Muteba'),
	(110, 13, 'Cacolo'),
	(111, 13, 'Dala'),
	(112, 13, 'Muconda'),
	(113, 13, 'Saurimo'),
	(114, 14, 'Cacuso'),
	(115, 14, 'Caombo'),
	(116, 14, 'Cambundi-Catembo'),
	(117, 14, 'Cangandala'),
	(118, 14, 'Cuaba Nzogo'),
	(119, 14, 'Cunda-Dia-Baze'),
	(120, 14, 'Kalandula'),
	(121, 14, 'Luquembo'),
	(122, 14, 'Malanje'),
	(123, 14, 'Marimba'),
	(124, 14, 'Massango'),
	(125, 14, 'Mucari'),
	(126, 14, 'Quela'),
	(127, 14, 'Quirima'),
	(128, 15, 'Alto Zambeze'),
	(129, 15, 'Bundas'),
	(130, 15, 'Camanongue'),
	(131, 15, 'Léua'),
	(132, 15, 'Luacano'),
	(133, 15, 'Luau'),
	(134, 15, 'Luchazes'),
	(135, 15, 'Lumeje'),
	(136, 15, 'Moxico'),
	(137, 16, 'Bibala'),
	(138, 16, 'Camucuio'),
	(139, 16, 'Namibe'),
	(140, 16, 'Tombua'),
	(141, 16, 'Virei'),
	(142, 17, 'Alto Cauale'),
	(143, 17, 'Ambuíla'),
	(144, 17, 'Bembe'),
	(145, 17, 'Buengas'),
	(146, 17, 'Bungo'),
	(147, 17, 'Damba'),
	(148, 17, 'Maquela do Zombo'),
	(149, 17, 'Macacola'),
	(150, 17, 'Milunga'),
	(151, 17, 'Mucaba'),
	(152, 17, 'Negage'),
	(153, 17, 'Puri'),
	(154, 17, 'Quimbele'),
	(155, 17, 'Quitexe'),
	(156, 17, 'Sanza Pombo'),
	(157, 17, 'Songo'),
	(158, 17, 'Uíge'),
	(159, 18, 'MBanza Kongo'),
	(160, 18, 'Soyo'),
	(161, 18, 'NZeto'),
	(162, 18, 'Cuimba'),
	(163, 18, 'Nóqui'),
	(164, 18, 'Tomboco');
/*!40000 ALTER TABLE `municipios` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.nacionalidades
CREATE TABLE IF NOT EXISTS `nacionalidades` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table rs_inefop.nacionalidades: ~3 rows (approximately)
/*!40000 ALTER TABLE `nacionalidades` DISABLE KEYS */;
INSERT INTO `nacionalidades` (`id`, `Designacao`) VALUES
	(1, 'Nenhuma'),
	(2, 'Angolana'),
	(3, 'Portuguesa');
/*!40000 ALTER TABLE `nacionalidades` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.pagamentos
CREATE TABLE IF NOT EXISTS `pagamentos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigo_factura` int(10) unsigned NOT NULL,
  `codigo_utilizador` bigint(20) unsigned NOT NULL,
  `data_pagamento` date NOT NULL,
  `data_envio` datetime NOT NULL,
  `data_validacao` datetime NOT NULL,
  `n_borderox` varchar(45) NOT NULL,
  `codigo_forma_pagamento` int(10) unsigned NOT NULL,
  `codigo_local_pagamento` int(10) unsigned NOT NULL,
  `codigo_status` int(10) unsigned NOT NULL,
  `canal` int(10) unsigned NOT NULL,
  `obs` text NOT NULL,
  `url_pagamento` varchar(145) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_pagamentos_factura` (`codigo_factura`),
  KEY `FK_pagamentos_utilizador` (`codigo_utilizador`),
  KEY `FK_pagamentos_canal` (`canal`),
  KEY `FK_pagamentos_status` (`codigo_status`),
  CONSTRAINT `FK_pagamentos_canal` FOREIGN KEY (`canal`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_pagamentos_factura` FOREIGN KEY (`codigo_factura`) REFERENCES `factura` (`id`),
  CONSTRAINT `FK_pagamentos_status` FOREIGN KEY (`codigo_status`) REFERENCES `estado_sistema` (`id`),
  CONSTRAINT `FK_pagamentos_utilizador` FOREIGN KEY (`codigo_utilizador`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.pagamentos: ~0 rows (approximately)
/*!40000 ALTER TABLE `pagamentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pagamentos` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.pais
CREATE TABLE IF NOT EXISTS `pais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.pais: ~5 rows (approximately)
/*!40000 ALTER TABLE `pais` DISABLE KEYS */;
INSERT INTO `pais` (`id`, `nome`) VALUES
	(1, 'Angola'),
	(2, 'Portugal'),
	(3, 'Espanha'),
	(4, 'Brazil'),
	(5, 'Italia');
/*!40000 ALTER TABLE `pais` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `Index 1` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` (`id`, `email`, `token`, `created_at`) VALUES
	(87, 'paulojoao@unesc.net', '$2y$10$VfZx7G35mQAv3YwVcct66OJlXl1TJPMbNabctQeL3PdGOyUq6v5ua', '2020-08-17 09:30:04');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.proprietarios_centros
CREATE TABLE IF NOT EXISTS `proprietarios_centros` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(450) NOT NULL,
  `bi` varchar(45) NOT NULL,
  `email` varchar(450) NOT NULL,
  `telefone1` varchar(45) NOT NULL,
  `telefone2` varchar(45) NOT NULL,
  `nacionalidade_id` int(10) unsigned NOT NULL,
  `centro_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `data_nascimento` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_proprietarios_centros` (`centro_id`),
  KEY `FK_proprietarios_nacionalidade` (`nacionalidade_id`),
  KEY `FK_proprietarios_status` (`status_id`),
  KEY `FK_proprietarios_canal` (`canal_id`),
  CONSTRAINT `FK_proprietarios_canal` FOREIGN KEY (`canal_id`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_proprietarios_centros` FOREIGN KEY (`centro_id`) REFERENCES `centro_formacao` (`id`),
  CONSTRAINT `FK_proprietarios_nacionalidade` FOREIGN KEY (`nacionalidade_id`) REFERENCES `nacionalidades` (`id`),
  CONSTRAINT `FK_proprietarios_status` FOREIGN KEY (`status_id`) REFERENCES `estado_sistema` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.proprietarios_centros: ~0 rows (approximately)
/*!40000 ALTER TABLE `proprietarios_centros` DISABLE KEYS */;
/*!40000 ALTER TABLE `proprietarios_centros` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.provincias
CREATE TABLE IF NOT EXISTS `provincias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `codigo_pais` int(11) NOT NULL,
  `designacao` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `codigo_pais` (`codigo_pais`),
  CONSTRAINT `provincias_ibfk_1` FOREIGN KEY (`codigo_pais`) REFERENCES `pais` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.provincias: ~26 rows (approximately)
/*!40000 ALTER TABLE `provincias` DISABLE KEYS */;
INSERT INTO `provincias` (`id`, `codigo_pais`, `designacao`) VALUES
	(1, 1, 'Bengo'),
	(2, 1, 'Benguela'),
	(3, 1, 'Bie'),
	(4, 1, 'Cabinda'),
	(5, 1, 'Cunene'),
	(6, 1, 'Kuando-Kubango'),
	(7, 1, 'Kwanza-Norte'),
	(8, 1, 'Kwanza-Sul'),
	(9, 1, 'Huambo'),
	(10, 1, 'Huila'),
	(11, 1, 'Luanda'),
	(12, 1, 'Lunda-Norte'),
	(13, 1, 'Lunda-Sul'),
	(14, 1, 'Malanje'),
	(15, 1, 'Moxico'),
	(16, 1, 'Namibe'),
	(17, 1, 'Uige'),
	(18, 1, 'Zaire'),
	(19, 2, 'Lisboa'),
	(20, 2, 'Porto'),
	(21, 3, 'Barcelona'),
	(22, 3, 'Madrid'),
	(23, 4, 'Rio de Janeiro'),
	(24, 4, 'São Paulo'),
	(25, 5, 'Roma'),
	(26, 5, 'Parlermo');
/*!40000 ALTER TABLE `provincias` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.publico_alvo
CREATE TABLE IF NOT EXISTS `publico_alvo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table rs_inefop.publico_alvo: ~2 rows (approximately)
/*!40000 ALTER TABLE `publico_alvo` DISABLE KEYS */;
INSERT INTO `publico_alvo` (`id`, `designacao`) VALUES
	(1, 'Estudantes'),
	(2, 'Diversos');
/*!40000 ALTER TABLE `publico_alvo` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.saida_profissional
CREATE TABLE IF NOT EXISTS `saida_profissional` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(450) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.saida_profissional: ~0 rows (approximately)
/*!40000 ALTER TABLE `saida_profissional` DISABLE KEYS */;
/*!40000 ALTER TABLE `saida_profissional` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.saida_profissional_curso
CREATE TABLE IF NOT EXISTS `saida_profissional_curso` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `saida_profissional_id` int(10) unsigned NOT NULL,
  `curso_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_saida_profissional` (`saida_profissional_id`),
  KEY `FK_saida_curso` (`curso_id`),
  KEY `FK_saida_user` (`user_id`),
  KEY `FK_saida_canal` (`canal_id`),
  KEY `FK_saida_status` (`status_id`),
  CONSTRAINT `FK_saida_canal` FOREIGN KEY (`canal_id`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_saida_curso` FOREIGN KEY (`curso_id`) REFERENCES `curso_centro` (`id`),
  CONSTRAINT `FK_saida_profissional` FOREIGN KEY (`saida_profissional_id`) REFERENCES `saida_profissional` (`id`),
  CONSTRAINT `FK_saida_status` FOREIGN KEY (`status_id`) REFERENCES `estado_sistema` (`id`),
  CONSTRAINT `FK_saida_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.saida_profissional_curso: ~0 rows (approximately)
/*!40000 ALTER TABLE `saida_profissional_curso` DISABLE KEYS */;
/*!40000 ALTER TABLE `saida_profissional_curso` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.sector_actividade
CREATE TABLE IF NOT EXISTS `sector_actividade` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.sector_actividade: ~3 rows (approximately)
/*!40000 ALTER TABLE `sector_actividade` DISABLE KEYS */;
INSERT INTO `sector_actividade` (`id`, `designacao`) VALUES
	(1, 'TIC\'s'),
	(2, 'Administração'),
	(3, 'Finanças');
/*!40000 ALTER TABLE `sector_actividade` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.tipo_centro_formacao
CREATE TABLE IF NOT EXISTS `tipo_centro_formacao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.tipo_centro_formacao: ~2 rows (approximately)
/*!40000 ALTER TABLE `tipo_centro_formacao` DISABLE KEYS */;
INSERT INTO `tipo_centro_formacao` (`id`, `designacao`) VALUES
	(1, 'Pública'),
	(2, 'Privada');
/*!40000 ALTER TABLE `tipo_centro_formacao` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.tipo_cliente
CREATE TABLE IF NOT EXISTS `tipo_cliente` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.tipo_cliente: ~0 rows (approximately)
/*!40000 ALTER TABLE `tipo_cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo_cliente` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.tipo_documento
CREATE TABLE IF NOT EXISTS `tipo_documento` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(405) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.tipo_documento: ~13 rows (approximately)
/*!40000 ALTER TABLE `tipo_documento` DISABLE KEYS */;
INSERT INTO `tipo_documento` (`id`, `designacao`) VALUES
	(1, 'Bilhete de Identidade'),
	(2, 'Certificado de habilitações literárias'),
	(3, 'Registo criminal'),
	(4, 'Atestado médico'),
	(5, 'Requerimento'),
	(6, 'Titulo legal de equisição ou usufruto das instalações'),
	(7, 'Planta ou simples desenho á escala de 1:100, sua respectiva memória descritiva e croquis de localização'),
	(8, 'Estatuto Organico'),
	(9, 'Regulamento interno'),
	(10, 'Cartão de contribuinte fiscal'),
	(11, 'Relação dos equipamentos e materiais didáticos em conformidade com os cursos a ministrar'),
	(12, 'Plano(s) curricular(es) do(s) curso(s) a ministrar de acordo com a matriz em anexo'),
	(13, 'Guia de deposito do emolumento');
/*!40000 ALTER TABLE `tipo_documento` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.tipo_funcionario
CREATE TABLE IF NOT EXISTS `tipo_funcionario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.tipo_funcionario: ~3 rows (approximately)
/*!40000 ALTER TABLE `tipo_funcionario` DISABLE KEYS */;
INSERT INTO `tipo_funcionario` (`id`, `designacao`) VALUES
	(1, 'Director do Centro'),
	(2, 'Coordenador Pedagógico'),
	(3, 'Formador');
/*!40000 ALTER TABLE `tipo_funcionario` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.tipo_servico
CREATE TABLE IF NOT EXISTS `tipo_servico` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(450) NOT NULL,
  `numero_curso` int(10) unsigned DEFAULT NULL,
  `valor_curso` double NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_tipo_servico_user` (`user_id`),
  KEY `FK_tipo_servico_canal` (`canal_id`),
  KEY `FK_tipo_servico_status` (`status_id`),
  CONSTRAINT `FK_tipo_servico_canal` FOREIGN KEY (`canal_id`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_tipo_servico_status` FOREIGN KEY (`status_id`) REFERENCES `estado_sistema` (`id`),
  CONSTRAINT `FK_tipo_servico_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.tipo_servico: ~0 rows (approximately)
/*!40000 ALTER TABLE `tipo_servico` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo_servico` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.tipo_utilizador
CREATE TABLE IF NOT EXISTS `tipo_utilizador` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.tipo_utilizador: ~3 rows (approximately)
/*!40000 ALTER TABLE `tipo_utilizador` DISABLE KEYS */;
INSERT INTO `tipo_utilizador` (`id`, `designacao`) VALUES
	(1, 'Administrador'),
	(2, 'Funcionário'),
	(3, 'Centro de Formação');
/*!40000 ALTER TABLE `tipo_utilizador` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.turmas_centros
CREATE TABLE IF NOT EXISTS `turmas_centros` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `centro_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `curso_id` int(10) unsigned NOT NULL,
  `ano_lectivo_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `designacao` varchar(450) NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `formador_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_turmas_centros` (`centro_id`),
  KEY `FK_turmas_centros_curso` (`curso_id`),
  KEY `FK_turmas_centros_3` (`ano_lectivo_id`),
  KEY `FK_turmas_centros_4` (`status_id`),
  KEY `FK_turmas_centros_5` (`canal_id`),
  KEY `FK_turmas_centros_formador` (`formador_id`),
  CONSTRAINT `FK_turmas_centros` FOREIGN KEY (`centro_id`) REFERENCES `centro_formacao` (`id`),
  CONSTRAINT `FK_turmas_centros_3` FOREIGN KEY (`ano_lectivo_id`) REFERENCES `ano_lectivo` (`id`),
  CONSTRAINT `FK_turmas_centros_4` FOREIGN KEY (`status_id`) REFERENCES `estado_sistema` (`id`),
  CONSTRAINT `FK_turmas_centros_5` FOREIGN KEY (`canal_id`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_turmas_centros_curso` FOREIGN KEY (`curso_id`) REFERENCES `curso_centro` (`id`),
  CONSTRAINT `FK_turmas_centros_formador` FOREIGN KEY (`formador_id`) REFERENCES `formador_centro` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table rs_inefop.turmas_centros: ~0 rows (approximately)
/*!40000 ALTER TABLE `turmas_centros` DISABLE KEYS */;
/*!40000 ALTER TABLE `turmas_centros` ENABLE KEYS */;

-- Dumping structure for table rs_inefop.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tipo_utilizador_id` int(10) unsigned DEFAULT NULL,
  `canal_id` int(10) unsigned DEFAULT NULL,
  `status_id` int(10) unsigned DEFAULT NULL,
  `nif` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status_senha_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_utilizadores_canal` (`canal_id`),
  KEY `FK_utilizadores_status` (`status_id`),
  KEY `FK_utilizadores_tipoUtilizador` (`tipo_utilizador_id`),
  CONSTRAINT `FK_utilizadores_canal` FOREIGN KEY (`canal_id`) REFERENCES `canal_comunicacao` (`id`),
  CONSTRAINT `FK_utilizadores_status` FOREIGN KEY (`status_id`) REFERENCES `estado_sistema` (`id`),
  CONSTRAINT `FK_utilizadores_tipoUtilizador` FOREIGN KEY (`tipo_utilizador_id`) REFERENCES `tipo_utilizador` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table rs_inefop.users: ~4 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `telefone`, `email`, `password`, `created_at`, `updated_at`, `username`, `tipo_utilizador_id`, `canal_id`, `status_id`, `nif`, `remember_token`, `foto`, `status_senha_id`) VALUES
	(42, 'Patricio Neto', '921504961', 'brunoneto256@gmail.com', '$2y$10$QWExKGhnkl9KTDwE2KjlKu/489J/Y8Lk.b7edVJlJza.qt9ICIlru', '2020-08-17 10:38:19', '2020-08-17 10:38:19', 'Patricio Neto', 2, 1, 1, '123456789', NULL, '01597660699.png', NULL),
	(43, 'Paulo João', '923656044', 'paulojoao@unesc.net', '$2y$10$9imv4ydxkHpa4YNMU1280uEKU2i3z.TZTMOzWvgpunODY.WoTeYEy', '2020-08-17 10:42:14', '2020-08-17 10:42:14', 'Paulo João', 1, 1, 1, '12345678', NULL, '21597660934.jpg', NULL),
	(80, 'hOsterteeopdfn f gdddddd', '+244 935-636-474', 'broooo@gmo.com', '$2y$10$IP7VtLuAxnCXOVun2X56.u0wb3o0j8z0/mH4BtTMXlJTU3KXSMR.q', '2020-08-25 15:42:07', '2020-08-25 15:42:07', 'ccccccccccccrt-2020', 3, 1, 1, NULL, 'bhst5KeMWjdeQJQ2vvnRdw7a5raqjeFbZYIBRjZR', NULL, 1),
	(81, 'hOsterteeopdfn f gdddddd', '+244 935-636-474', 'broooo@gmo.com', '$2y$10$9oOYICjXA1.bkmF0/KnR2eJNrmHJL4GLF/AWcBxkoKePbxaFhMm7W', '2020-08-25 15:43:28', '2020-08-25 15:43:28', 'ccccccccccccrt-2020', 3, 1, 1, NULL, 'xyqTRXqweEzgdxhxUsWvcjgNgXwnKdPe93LRXS5YD8PRiJyhqt2XNBNLgEYk', NULL, 1),
	(82, 'Patrisoft Developper', '+244 947-467-767', 'patrisoft@gmail.com', '$2y$10$zeBPBVdAj.gJPe07U4bD5.VBBbgIL2jUOHGWDGJLtUMGXB9PDR3B.', '2020-08-25 21:31:40', '2020-08-25 21:31:40', '123456789LA042-2020', 3, 1, 1, NULL, 'ApUKeXWEqxBaompuuVnATtmG1f1thm04Ubcx8mAD', 'utilizadores/avatar/vLhgeVN5D9jYCiXCR9ioE2LqBAhzwa0kZhvzjt2P.jpeg', 1),
	(83, 'dddddddddddddddd', '+244 437-678-789', 'bbgghhjkk@ggg.om', '$2y$10$JcvOzVGiy9ChfAbcsslW2OSs3R4xVbThte6RvoopU9UD.svL6w/fa', '2020-08-26 15:05:40', '2020-08-26 15:05:40', '12346789087667-2020', 3, 1, 1, NULL, '3NoNdjdSHbkyKMwpSelmHYXq4RlTSM41zi0p473LBZRTeNeVOETd3oXU1hnu', 'utilizadores/avatar/8zPM3JL8VjlH6JppZIL21nvYHXdkSYgYhQfQQMdL.jpeg', 1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
