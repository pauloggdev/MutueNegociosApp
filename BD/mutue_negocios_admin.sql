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


-- Dumping database structure for mutue_negocios_admin
CREATE DATABASE IF NOT EXISTS `mutue_negocios_admin` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `mutue_negocios_admin`;

-- Dumping structure for table mutue_negocios_admin.activacao_licencas
CREATE TABLE IF NOT EXISTS `activacao_licencas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `licenca_id` int(10) unsigned NOT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `pagamento_id` int(10) unsigned NOT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_fim` date DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `status_licenca_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_rejeicao` timestamp NULL DEFAULT NULL,
  `observacao` text,
  PRIMARY KEY (`id`),
  KEY `FK_activacao_licencas` (`licenca_id`),
  KEY `FK_activacao_empresa` (`empresa_id`),
  KEY `FK_activacao_user` (`user_id`),
  KEY `FK_activacao_canal` (`canal_id`),
  KEY `FK_activacao_licencas_status_licencas` (`status_licenca_id`),
  KEY `FK_activacao_licencas_pagamentos` (`pagamento_id`),
  CONSTRAINT `FK_activacao_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_activacao_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_activacao_licencas` FOREIGN KEY (`licenca_id`) REFERENCES `licencas` (`id`),
  CONSTRAINT `FK_activacao_licencas_pagamentos` FOREIGN KEY (`pagamento_id`) REFERENCES `pagamentos` (`id`),
  CONSTRAINT `FK_activacao_licencas_status_licencas` FOREIGN KEY (`status_licenca_id`) REFERENCES `status_licencas` (`id`),
  CONSTRAINT `FK_activacao_licencas_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.activacao_licencas: ~3 rows (approximately)
/*!40000 ALTER TABLE `activacao_licencas` DISABLE KEYS */;
INSERT INTO `activacao_licencas` (`id`, `licenca_id`, `empresa_id`, `pagamento_id`, `data_inicio`, `data_fim`, `user_id`, `canal_id`, `status_licenca_id`, `created_at`, `updated_at`, `data_rejeicao`, `observacao`) VALUES
	(26, 2, 21, 34, NULL, NULL, NULL, 3, 8, '2020-08-04 22:22:14', '2020-08-04 22:22:14', NULL, NULL),
	(27, 2, 21, 35, '2020-08-28', '2021-08-28', 1, 3, 6, '2020-08-28 12:11:43', '2020-08-28 12:19:02', NULL, NULL),
	(28, 1, 21, 36, NULL, NULL, NULL, 3, 8, '2020-10-06 12:05:18', '2020-10-06 12:05:18', NULL, NULL);
/*!40000 ALTER TABLE `activacao_licencas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.bancos
CREATE TABLE IF NOT EXISTS `bancos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(145) NOT NULL,
  `sigla` varchar(20) NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_bancos_status_gerais` (`status_id`),
  KEY `FK_bancos_canais_comunicacoes` (`canal_id`),
  KEY `FK_bancos_users` (`user_id`),
  CONSTRAINT `FK_bancos_canais_comunicacoes` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_bancos_status_gerais` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_bancos_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table mutue_negocios_admin.bancos: ~6 rows (approximately)
/*!40000 ALTER TABLE `bancos` DISABLE KEYS */;
INSERT INTO `bancos` (`id`, `designacao`, `sigla`, `status_id`, `canal_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'BANCO DE FORMENTO ANGOLA', 'BFA', 1, 3, 1, '2020-05-29 07:07:38', '2020-05-29 07:07:38'),
	(2, 'BANCO DE POUPANÇA E CREDITO', 'BPC', 2, 3, 1, '2020-06-11 20:41:55', '2020-06-11 20:41:55'),
	(3, 'BANCO DE INVESTIMENTO COMERCIAL', 'BIC', 2, 3, 1, '2020-06-12 16:15:51', '2020-06-12 16:15:51'),
	(4, 'BANCO AFRICANO DE INVESTIMENTO', 'BAI', 1, 3, 1, '2020-06-12 16:22:16', '2020-06-12 16:22:16'),
	(5, 'BANCO NACIONAL DE INVESTIMENTO', 'BNI', 1, 3, 1, '2020-07-05 16:11:25', '2020-07-05 16:11:35'),
	(6, 'BANCO SOL', 'SOL', 1, 3, 1, '2020-07-05 16:12:19', '2020-07-05 16:12:23');
/*!40000 ALTER TABLE `bancos` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.black_list
CREATE TABLE IF NOT EXISTS `black_list` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.black_list: ~0 rows (approximately)
/*!40000 ALTER TABLE `black_list` DISABLE KEYS */;
/*!40000 ALTER TABLE `black_list` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.canais_comunicacoes
CREATE TABLE IF NOT EXISTS `canais_comunicacoes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.canais_comunicacoes: ~4 rows (approximately)
/*!40000 ALTER TABLE `canais_comunicacoes` DISABLE KEYS */;
INSERT INTO `canais_comunicacoes` (`id`, `designacao`) VALUES
	(1, 'BD'),
	(2, 'Portal Cliente'),
	(3, 'Portal Admin'),
	(4, 'Mobile');
/*!40000 ALTER TABLE `canais_comunicacoes` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.contactos
CREATE TABLE IF NOT EXISTS `contactos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_contacto_id` int(10) unsigned NOT NULL,
  `designacao` varchar(45) NOT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_contactos_empresa` (`empresa_id`),
  KEY `FK_contactos_tipo_contacto` (`tipo_contacto_id`),
  KEY `FK_contactos_canal` (`canal_id`),
  CONSTRAINT `FK_contactos_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_contactos_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_contactos_tipo_contacto` FOREIGN KEY (`tipo_contacto_id`) REFERENCES `tipos_contactos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.contactos: ~0 rows (approximately)
/*!40000 ALTER TABLE `contactos` DISABLE KEYS */;
/*!40000 ALTER TABLE `contactos` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.coordenadas_bancarias
CREATE TABLE IF NOT EXISTS `coordenadas_bancarias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `num_conta` varchar(45) NOT NULL,
  `iban` varchar(45) DEFAULT NULL,
  `banco_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_coordenadas_bancarias_bancos` (`banco_id`),
  KEY `FK_coordenadas_bancarias_canais_comunicacoes` (`canal_id`),
  KEY `FK_coordenadas_bancarias_status_gerais` (`status_id`),
  KEY `FK_coordenadas_bancarias_users` (`user_id`),
  CONSTRAINT `FK_coordenadas_bancarias_bancos` FOREIGN KEY (`banco_id`) REFERENCES `bancos` (`id`),
  CONSTRAINT `FK_coordenadas_bancarias_canais_comunicacoes` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_coordenadas_bancarias_status_gerais` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_coordenadas_bancarias_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table mutue_negocios_admin.coordenadas_bancarias: ~6 rows (approximately)
/*!40000 ALTER TABLE `coordenadas_bancarias` DISABLE KEYS */;
INSERT INTO `coordenadas_bancarias` (`id`, `num_conta`, `iban`, `banco_id`, `canal_id`, `status_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, '211 664350/30/01', 'AO06.0006.0000.11 6643503.55', 3, 3, 1, 1, '2020-07-02 04:48:42', '2020-07-02 04:48:42'),
	(2, '300 664350/30/01', 'AO06.0006.0000.11 6643503.66', 4, 3, 1, 1, '2020-07-02 04:50:35', '2020-07-02 04:50:35'),
	(3, '300 664350/30/01', 'AO06.0006.0000.11 6643503.11', 5, 3, 1, 1, '2020-07-02 04:50:35', '2020-07-02 04:50:35'),
	(4, '300 664350/30/03', 'AO06.0006.0000.11 6643503.22', 6, 3, 1, 1, '2020-07-02 04:50:35', '2020-07-02 04:50:35'),
	(5, '300 664350/30/04', 'AO06.0006.0000.11 6643503.33', 1, 3, 1, 1, '2020-07-02 04:50:35', '2020-07-02 04:50:35'),
	(6, '300 664350/30/05', 'AO06.0006.0000.11 6643503.44', 2, 3, 1, 1, '2020-07-02 04:50:35', '2020-07-02 04:50:35');
/*!40000 ALTER TABLE `coordenadas_bancarias` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.empresas
CREATE TABLE IF NOT EXISTS `empresas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `pessoal_Contacto` varchar(145) NOT NULL,
  `endereco` varchar(245) NOT NULL,
  `pais_id` int(10) unsigned NOT NULL,
  `saldo` double DEFAULT NULL,
  `nif` varchar(45) NOT NULL,
  `gestor_cliente_id` int(10) unsigned DEFAULT NULL,
  `tipo_cliente_id` int(10) unsigned NOT NULL,
  `tipo_regime_id` int(10) unsigned DEFAULT NULL,
  `logotipo` varchar(145) DEFAULT NULL,
  `Website` varchar(145) DEFAULT NULL,
  `email` varchar(145) DEFAULT NULL,
  `referencia` varchar(145) DEFAULT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pessoal_Contacto` (`pessoal_Contacto`),
  UNIQUE KEY `nif` (`nif`),
  UNIQUE KEY `referencia` (`referencia`),
  UNIQUE KEY `email` (`email`),
  KEY `FK_empresas_pais` (`pais_id`),
  KEY `FK_empresas_canal` (`canal_id`),
  KEY `FK_empresas_status` (`status_id`),
  KEY `FK_empresas_tipo` (`tipo_cliente_id`),
  KEY `FK_empresas_users` (`user_id`),
  KEY `FK_empresas_gestor_clientes` (`gestor_cliente_id`),
  KEY `FK_empresas_tipos_regimes` (`tipo_regime_id`),
  CONSTRAINT `FK_empresas_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_empresas_gestor_clientes` FOREIGN KEY (`gestor_cliente_id`) REFERENCES `gestor_clientes` (`id`),
  CONSTRAINT `FK_empresas_pais` FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`),
  CONSTRAINT `FK_empresas_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_empresas_tipo` FOREIGN KEY (`tipo_cliente_id`) REFERENCES `tipos_clientes` (`id`),
  CONSTRAINT `FK_empresas_tipos_regimes` FOREIGN KEY (`tipo_regime_id`) REFERENCES `tipos_regimes` (`id`),
  CONSTRAINT `FK_empresas_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.empresas: ~4 rows (approximately)
/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT INTO `empresas` (`id`, `nome`, `pessoal_Contacto`, `endereco`, `pais_id`, `saldo`, `nif`, `gestor_cliente_id`, `tipo_cliente_id`, `tipo_regime_id`, `logotipo`, `Website`, `email`, `referencia`, `status_id`, `canal_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'FÁBRICA DE SOFTWARES  LDA', '923292970', 'RUA NOSSA SENHORA DA MUXIMA, Nº 10-8º ANDAR-LUANDA-ANGOLA', 1, 0, ' 5000467766', 1, 2, 3, 'utilizadores/cliente/FaP1senFd66zwVxNY4sOm1uiks03eORyJSXUVMmu.jpeg', 'http:// www.ramossoft.com', 'info@ramossoft.com', '78500', 1, 3, 1, '2020-05-17 16:50:53', '2020-06-09 16:26:33'),
	(21, 'PATSOFT DEVELOPPER CONSULTURING', '921504961', 'Bairro-Vila de Viiana', 1, 0, '123345567BA746', 1, 3, NULL, 'utilizadores/cliente/FaP1senFd66zwVxNY4sOm1uiks03eORyJSXUVMmu.jpeg', 'http://www.patrisoft.com.co', 'brunoneto256@gmail.com', '90695', 1, 3, 57, '2020-06-11 13:29:24', '2020-10-02 12:56:33'),
	(22, 'Paulo João', '933577829', 'Bairro-Vila de Viiana', 1, 0, '123345567CA746', 1, 2, NULL, NULL, NULL, 'paulojoao@unesc.net', '37994', 1, 3, 58, '2020-06-11 16:14:09', '2020-06-11 16:14:09'),
	(25, 'RamosSoftware', '934786543', 'Bairro-Vila de Viiana', 1, 0, 'DMMDF6DFD', 1, 2, 1, 'utilizadores/cliente/Yt6BpGDHlJdXxPAFWBLQSMgWZOFwKCZkp81uF7lw.png', 'http://www.suporte.com.co', 'suporte.mutue@gmail.com', '59961', 1, 3, 61, '2020-07-17 12:45:54', '2020-07-17 12:45:54'),
	(27, 'Pedro Soft', '939441294', 'Samba', 1, 0, '912345678', 1, 3, 3, NULL, NULL, 'pedrocabingano15@gmail.com', '1WV13WS', 1, 3, 63, '2020-08-05 10:04:59', '2020-08-05 10:04:59');
/*!40000 ALTER TABLE `empresas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.facturas
CREATE TABLE IF NOT EXISTS `facturas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `total_preco_factura` double NOT NULL,
  `valor_entregue` double DEFAULT NULL,
  `valor_a_pagar` double DEFAULT NULL,
  `troco` double DEFAULT NULL,
  `valor_extenso` varchar(345) DEFAULT NULL,
  `codigo_moeda` int(10) unsigned DEFAULT NULL,
  `desconto` double DEFAULT NULL,
  `total_iva` double DEFAULT NULL,
  `multa` double DEFAULT NULL,
  `nome_do_cliente` varchar(145) DEFAULT NULL,
  `telefone_cliente` varchar(145) DEFAULT NULL,
  `nif_cliente` varchar(145) DEFAULT NULL,
  `email_cliente` varchar(145) DEFAULT NULL,
  `endereco_cliente` varchar(145) DEFAULT NULL,
  `numeroItems` int(10) unsigned DEFAULT NULL,
  `tipo_documento` enum('FACTURA','FACTURA PROFORMA','FACTURA RECIBO') DEFAULT 'FACTURA',
  `observacao` text,
  `retencao` double DEFAULT NULL,
  `nextFactura` varchar(45) DEFAULT NULL,
  `faturaReference` varchar(45) DEFAULT NULL,
  `numSequenciaFactura` int(10) unsigned NOT NULL DEFAULT '0',
  `numeracaoFactura` varchar(255) DEFAULT NULL,
  `hashValor` text,
  `retificado` enum('Sim','Não') DEFAULT 'Não',
  `formas_pagamento_id` int(10) unsigned DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_vencimento` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_facturas_canal` (`canal_id`),
  KEY `FK_facturas_empresa` (`empresa_id`),
  KEY `FK_facturas_status` (`status_id`),
  KEY `FK_facturas_user` (`user_id`),
  KEY `FK_facturas_formas_pagamentos` (`formas_pagamento_id`),
  KEY `FK_facturas_moedas` (`codigo_moeda`),
  CONSTRAINT `FK_facturas_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_facturas_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_facturas_formas_pagamentos` FOREIGN KEY (`formas_pagamento_id`) REFERENCES `formas_pagamentos` (`id`),
  CONSTRAINT `FK_facturas_moedas` FOREIGN KEY (`codigo_moeda`) REFERENCES `moedas` (`id`),
  CONSTRAINT `FK_facturas_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_facturas_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.facturas: ~9 rows (approximately)
/*!40000 ALTER TABLE `facturas` DISABLE KEYS */;
INSERT INTO `facturas` (`id`, `total_preco_factura`, `valor_entregue`, `valor_a_pagar`, `troco`, `valor_extenso`, `codigo_moeda`, `desconto`, `total_iva`, `multa`, `nome_do_cliente`, `telefone_cliente`, `nif_cliente`, `email_cliente`, `endereco_cliente`, `numeroItems`, `tipo_documento`, `observacao`, `retencao`, `nextFactura`, `faturaReference`, `numSequenciaFactura`, `numeracaoFactura`, `hashValor`, `retificado`, `formas_pagamento_id`, `descricao`, `empresa_id`, `canal_id`, `status_id`, `user_id`, `created_at`, `updated_at`, `data_vencimento`) VALUES
	(36, 50000, 0, 50000, 0, 'cinquenta mil', 1, 0, 0, 0, 'PATSOFT DEVELOPPER CONSULTURING', '921504961', '123345567BA746', 'brunoneto256@gmail.com', 'Bairro-Vila de Viiana', 1, 'FACTURA', NULL, 0, 'REF 1', '692865001', 0, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 3, NULL, 1, 1, 1, 57, '2020-08-04 21:49:31', '2020-08-04 21:49:31', '2020-08-19'),
	(37, 400000, 0, 400000, 0, 'quatrocentos mil', 1, 0, 0, 0, 'PATSOFT DEVELOPPER CONSULTURING', '921504961', '123345567BA746', 'brunoneto256@gmail.com', 'Bairro-Vila de Viiana', 1, 'FACTURA', NULL, 0, 'REF 37', '162506399', 0, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 3, NULL, 1, 1, 1, 57, '2020-08-04 22:38:50', '2020-08-04 22:38:50', '2020-08-19'),
	(38, 5000, 0, 5000, 0, 'cinco mil', 1, 0, 0, 0, 'PATSOFT DEVELOPPER CONSULTURING', '921504961', '123345567BA746', 'brunoneto256@gmail.com', 'Bairro-Vila de Viiana', 1, 'FACTURA', NULL, 0, 'REF 38', '753027532', 0, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 3, NULL, 1, 1, 1, 57, '2020-08-05 04:01:58', '2020-08-05 04:01:58', '2020-08-20'),
	(39, 500000, 0, 500000, 0, 'quinhentos mil', 1, 0, 0, 0, 'PATSOFT DEVELOPPER CONSULTURING', '921504961', '123345567BA746', 'brunoneto256@gmail.com', 'Bairro-Vila de Viiana', 1, 'FACTURA', NULL, 0, 'REF 39', '943297216', 0, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 3, NULL, 1, 1, 1, 57, '2020-08-05 05:30:13', '2020-08-05 05:30:13', '2020-08-20'),
	(40, 10000, 0, 10000, 0, 'dez mil', 1, 0, 0, 0, 'PATSOFT DEVELOPPER CONSULTURING', '921504961', '123345567BA746', 'brunoneto256@gmail.com', 'Bairro-Vila de Viiana', 1, 'FACTURA', NULL, 0, 'REF 40', '989337285', 0, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 3, NULL, 1, 1, 1, 57, '2020-08-05 05:30:52', '2020-08-05 05:30:52', '2020-08-20'),
	(41, 100000, 0, 100000, 0, 'cem mil', 1, 0, 0, 0, 'PATSOFT DEVELOPPER CONSULTURING', '921504961', '123345567BA746', 'brunoneto256@gmail.com', 'Bairro-Vila de Viiana', 1, 'FACTURA', NULL, 0, 'REF 41', '589621494', 0, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 3, NULL, 1, 1, 1, 57, '2020-08-28 12:05:27', '2020-08-28 12:05:27', '2020-09-12'),
	(42, 500000, 0, 500000, 0, 'quinhentos mil', 1, 0, 0, 0, 'PATSOFT DEVELOPPER CONSULTURING', '921504961', '123345567BA746', 'brunoneto256@gmail.com', 'Bairro-Vila de Viiana', 1, 'FACTURA', NULL, 0, 'REF 42', '071143610', 0, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 3, NULL, 1, 1, 1, 57, '2020-08-28 12:06:41', '2020-08-28 12:06:41', '2020-09-12'),
	(43, 25000, 0, 25000, 0, 'vinte e cinco mil', 1, 0, 0, 0, 'PATSOFT DEVELOPPER CONSULTURING', '921504961', '123345567BA746', 'brunoneto256@gmail.com', 'Bairro-Vila de Viiana', 1, 'FACTURA', NULL, 0, '033529124', '033529124', 1, 'PAT2020', '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 3, NULL, 1, 1, 1, 57, '2020-09-11 00:20:24', '2020-09-11 00:20:24', '2020-09-26'),
	(44, 30000, 0, 30000, 0, 'trinta mil', 1, 0, 0, 0, 'PATSOFT DEVELOPPER CONSULTURING', '921504961', '123345567BA746', 'brunoneto256@gmail.com', 'Bairro-Vila de Viiana', 1, 'FACTURA', NULL, 0, '859152120', '859152120', 2, 'FT RAM2020/2', 'WUiqrKu+BnxJWKHngw0Aa1sHlPAPWofoYxpAtQkTMK4a7D2y1Osh2hF3XEAXrymNRpcL4OKIbpE94Hk4xDfSUmPTNxKzCxYtdV52xiS5NmQ5K8fmQKe/6EVsgyBGKmhgsNVVcYdUTt6LPxzBC2XiObpGqnySYugAfq5nHe0Y3+w=', 'Não', 3, NULL, 1, 1, 1, 57, '2020-10-06 11:46:08', '2020-10-06 11:46:08', '2020-10-21');
/*!40000 ALTER TABLE `facturas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.factura_items
CREATE TABLE IF NOT EXISTS `factura_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao_produto` varchar(250) DEFAULT '0',
  `preco_produto` double NOT NULL DEFAULT '0',
  `quantidade_produto` int(10) unsigned NOT NULL,
  `total_preco_produto` double NOT NULL DEFAULT '0',
  `licenca_id` int(10) unsigned NOT NULL,
  `factura_id` int(10) unsigned NOT NULL,
  `desconto_produto` double DEFAULT '0',
  `retencao_produto` double DEFAULT '0',
  `incidencia_produto` double DEFAULT NULL,
  `iva_produto` double DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_factura_items_factura` (`factura_id`),
  KEY `FK_factura_items_licencas` (`licenca_id`),
  CONSTRAINT `FK_factura_items_factura` FOREIGN KEY (`factura_id`) REFERENCES `facturas` (`id`),
  CONSTRAINT `FK_factura_items_licencas` FOREIGN KEY (`licenca_id`) REFERENCES `licencas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.factura_items: ~8 rows (approximately)
/*!40000 ALTER TABLE `factura_items` DISABLE KEYS */;
INSERT INTO `factura_items` (`id`, `descricao_produto`, `preco_produto`, `quantidade_produto`, `total_preco_produto`, `licenca_id`, `factura_id`, `desconto_produto`, `retencao_produto`, `incidencia_produto`, `iva_produto`) VALUES
	(36, 'LICENÇA PLATINA-ANUAL', 10000, 5, 50000, 2, 36, 0, 0, 0, 0),
	(37, 'LICENÇA DEFINITIVO-DEFINITIVA', 100000, 4, 400000, 3, 37, 0, 0, 0, 0),
	(38, 'LICENÇA PREMIUM-MENSAL', 5000, 1, 5000, 1, 38, 0, 0, 0, 0),
	(39, 'LICENÇA DEFINITIVO-DEFINITIVA', 100000, 5, 500000, 3, 39, 0, 0, 0, 0),
	(40, 'LICENÇA PLATINA-ANUAL', 10000, 6, 10000, 2, 40, 0, 0, 0, 0),
	(41, 'LICENÇA PLATINA-ANUAL', 10000, 10, 100000, 2, 41, 0, 0, 0, 0),
	(42, 'LICENÇA DEFINITIVO-DEFINITIVA', 100000, 5, 500000, 3, 42, 0, 0, 0, 0),
	(43, 'LICENÇA PREMIUM-MENSAL', 5000, 5, 25000, 1, 43, 0, 0, 0, 0),
	(44, 'LICENÇA PREMIUM-MENSAL', 5000, 6, 30000, 1, 44, 0, 0, 0, 0);
/*!40000 ALTER TABLE `factura_items` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mutue_negocios_admin.failed_jobs: ~0 rows (approximately)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.formas_pagamentos
CREATE TABLE IF NOT EXISTS `formas_pagamentos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table mutue_negocios_admin.formas_pagamentos: ~4 rows (approximately)
/*!40000 ALTER TABLE `formas_pagamentos` DISABLE KEYS */;
INSERT INTO `formas_pagamentos` (`id`, `descricao`) VALUES
	(1, 'TPA'),
	(2, 'DEPÓSITO'),
	(3, 'TRANSFERÊNCIA'),
	(4, 'MULTICAIXA');
/*!40000 ALTER TABLE `formas_pagamentos` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.gestor_clientes
CREATE TABLE IF NOT EXISTS `gestor_clientes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(145) NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_gestor_clientes_status_gerais` (`status_id`),
  KEY `FK_gestor_clientes_canais_comunicacoes` (`canal_id`),
  KEY `FK_gestor_clientes_users` (`user_id`),
  CONSTRAINT `FK_gestor_clientes_canais_comunicacoes` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_gestor_clientes_status_gerais` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_gestor_clientes_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table mutue_negocios_admin.gestor_clientes: ~0 rows (approximately)
/*!40000 ALTER TABLE `gestor_clientes` DISABLE KEYS */;
INSERT INTO `gestor_clientes` (`id`, `nome`, `status_id`, `canal_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'RAMOSSOFT TECNOLOGIAS LDA', 1, 3, 1, '2020-05-17 16:50:14', '2020-05-17 16:50:15');
/*!40000 ALTER TABLE `gestor_clientes` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.idiomas
CREATE TABLE IF NOT EXISTS `idiomas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.idiomas: ~2 rows (approximately)
/*!40000 ALTER TABLE `idiomas` DISABLE KEYS */;
INSERT INTO `idiomas` (`id`, `designacao`) VALUES
	(1, 'Portugues'),
	(2, 'Inglês');
/*!40000 ALTER TABLE `idiomas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.jobs
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mutue_negocios_admin.jobs: ~0 rows (approximately)
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.licencas
CREATE TABLE IF NOT EXISTS `licencas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_licenca_id` int(10) unsigned NOT NULL,
  `licenca` varchar(345) NOT NULL,
  `status_licenca_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `canal_id` int(10) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `descricao` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_licencas_tipo` (`tipo_licenca_id`),
  KEY `FK_licencas_status` (`status_licenca_id`),
  KEY `FK_licencas_canal` (`canal_id`),
  KEY `FK_licencas_users` (`user_id`),
  CONSTRAINT `FK_licencas_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_licencas_status` FOREIGN KEY (`status_licenca_id`) REFERENCES `status_licencas` (`id`),
  CONSTRAINT `FK_licencas_tipo` FOREIGN KEY (`tipo_licenca_id`) REFERENCES `tipos_licencas` (`id`),
  CONSTRAINT `FK_licencas_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.licencas: ~3 rows (approximately)
/*!40000 ALTER TABLE `licencas` DISABLE KEYS */;
INSERT INTO `licencas` (`id`, `tipo_licenca_id`, `licenca`, `status_licenca_id`, `created_at`, `updated_at`, `canal_id`, `user_id`, `descricao`) VALUES
	(1, 2, 'Premium', 4, '2020-05-18 15:26:09', '2020-05-18 15:26:09', 3, 1, 'Gestão comercial completa. Acesso simultâneos ilimitados. 12 usuários. 1 empresa. Emitir facturas.Emitir notas fiscais'),
	(2, 1, 'Platina', 4, '2020-06-09 11:33:42', '2020-06-09 11:33:43', 3, 1, 'Gestão comercial completa. Acesso simultâneos ilimitados. 5 usuários. 3 empresas. Emitir facturas.Emitir notas fiscais'),
	(3, 3, 'Definitivo', 4, '2020-06-09 11:36:45', '2020-06-09 11:36:46', 3, 1, 'Gestão comercial completa. Acesso simultâneos ilimitados. 15 usuários. 5 empresas. Emitir facturas.Emitir notas fiscais');
/*!40000 ALTER TABLE `licencas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.logs_acessos
CREATE TABLE IF NOT EXISTS `logs_acessos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(45) DEFAULT NULL,
  `maquina` varchar(45) DEFAULT NULL,
  `browser` text,
  `user_id` bigint(20) unsigned NOT NULL,
  `descricao` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `canal_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.logs_acessos: ~89 rows (approximately)
/*!40000 ALTER TABLE `logs_acessos` DISABLE KEYS */;
INSERT INTO `logs_acessos` (`id`, `ip`, `maquina`, `browser`, `user_id`, `descricao`, `created_at`, `updated_at`, `canal_id`) VALUES
	(1, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-20 11:24:29', '2020-05-20 11:24:29', 3),
	(2, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-20 11:26:01', '2020-05-20 11:26:01', 3),
	(3, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-20 11:29:03', '2020-05-20 11:29:03', 3),
	(4, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-20 11:29:45', '2020-05-20 11:29:45', 3),
	(5, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-20 11:42:01', '2020-05-20 11:42:01', 3),
	(6, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-20 11:43:39', '2020-05-20 11:43:39', 3),
	(7, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-20 11:45:22', '2020-05-20 11:45:22', 3),
	(8, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-20 11:51:05', '2020-05-20 11:51:05', 3),
	(9, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-20 11:58:10', '2020-05-20 11:58:10', 3),
	(10, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-20 11:58:49', '2020-05-20 11:58:49', 3),
	(11, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-20 13:48:12', '2020-05-20 13:48:12', 3),
	(12, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-20 14:12:02', '2020-05-20 14:12:02', 3),
	(13, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-20 17:04:35', '2020-05-20 17:04:35', 3),
	(14, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-20 21:01:32', '2020-05-20 21:01:32', 3),
	(15, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-21 11:07:37', '2020-05-21 11:07:37', 3),
	(16, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-21 12:24:57', '2020-05-21 12:24:57', 3),
	(17, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-22 11:11:03', '2020-05-22 11:11:03', 3),
	(18, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-22 18:05:35', '2020-05-22 18:05:35', 3),
	(19, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-22 22:30:00', '2020-05-22 22:30:00', 3),
	(20, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-23 08:53:07', '2020-05-23 08:53:07', 3),
	(21, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-23 14:48:36', '2020-05-23 14:48:36', 3),
	(22, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-23 14:54:00', '2020-05-23 14:54:00', 3),
	(23, '::1', '/api-mutue-negocio/public/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-23 22:38:52', '2020-05-23 22:38:52', 3),
	(24, '::1', '/api-mutue-negocio/public/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-24 09:22:03', '2020-05-24 09:22:03', 3),
	(25, '::1', '/api-mutue-negocio/public/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-24 18:26:22', '2020-05-24 18:26:22', 3),
	(26, '::1', '/api-mutue-negocio/public/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-24 22:10:47', '2020-05-24 22:10:47', 3),
	(27, '::1', '/api-mutue-negocio/public/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-24 22:48:37', '2020-05-24 22:48:37', 3),
	(28, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-25 10:33:49', '2020-05-25 10:33:49', 3),
	(29, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-25 10:35:52', '2020-05-25 10:35:52', 3),
	(30, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-25 16:05:16', '2020-05-25 16:05:16', 3),
	(31, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-25 16:11:04', '2020-05-25 16:11:04', 3),
	(32, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-25 16:17:57', '2020-05-25 16:17:57', 3),
	(33, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-25 16:24:29', '2020-05-25 16:24:29', 3),
	(34, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-25 16:26:03', '2020-05-25 16:26:03', 3),
	(35, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-25 22:32:03', '2020-05-25 22:32:03', 3),
	(36, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-27 12:10:34', '2020-05-27 12:10:34', 3),
	(37, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-27 16:35:34', '2020-05-27 16:35:34', 3),
	(38, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-27 16:37:08', '2020-05-27 16:37:08', 3),
	(39, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-27 17:02:11', '2020-05-27 17:02:11', 3),
	(40, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-27 17:10:53', '2020-05-27 17:10:53', 3),
	(41, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-27 21:53:25', '2020-05-27 21:53:25', 3),
	(42, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-27 22:25:42', '2020-05-27 22:25:42', 3),
	(43, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-27 23:09:06', '2020-05-27 23:09:06', 3),
	(44, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-28 10:19:52', '2020-05-28 10:19:52', 3),
	(45, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-28 11:59:38', '2020-05-28 11:59:38', 3),
	(46, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-28 13:55:33', '2020-05-28 13:55:33', 3),
	(47, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-28 14:09:14', '2020-05-28 14:09:14', 3),
	(48, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-28 14:10:09', '2020-05-28 14:10:09', 3),
	(49, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-28 14:12:09', '2020-05-28 14:12:09', 3),
	(50, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-28 14:13:46', '2020-05-28 14:13:46', 3),
	(51, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-05-28 14:53:29', '2020-05-28 14:53:29', 3),
	(52, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-28 20:55:37', '2020-05-28 20:55:37', 3),
	(53, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-28 22:50:44', '2020-05-28 22:50:44', 3),
	(54, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-29 06:10:09', '2020-05-29 06:10:09', 3),
	(55, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-05-29 14:57:25', '2020-05-29 14:57:25', 3),
	(56, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-06-01 10:50:10', '2020-06-01 10:50:10', 3),
	(57, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-06-01 15:28:17', '2020-06-01 15:28:17', 3),
	(58, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-06-01 15:36:06', '2020-06-01 15:36:06', 3),
	(59, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-06-01 15:38:44', '2020-06-01 15:38:44', 3),
	(60, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-06-01 23:11:15', '2020-06-01 23:11:15', 3),
	(61, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-06-01 23:11:54', '2020-06-01 23:11:54', 3),
	(62, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-06-02 10:21:25', '2020-06-02 10:21:25', 3),
	(63, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-06-02 10:29:47', '2020-06-02 10:29:47', 3),
	(64, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-06-02 14:09:27', '2020-06-02 14:09:27', 3),
	(65, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-06-02 15:33:05', '2020-06-02 15:33:05', 3),
	(66, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-06-03 11:57:40', '2020-06-03 11:57:40', 3),
	(67, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-06-03 22:00:26', '2020-06-03 22:00:26', 3),
	(68, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-06-03 22:51:09', '2020-06-03 22:51:09', 3),
	(69, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-06-04 13:14:24', '2020-06-04 13:14:24', 3),
	(70, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-06-04 23:51:50', '2020-06-04 23:51:50', 3),
	(71, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-06-05 09:59:38', '2020-06-05 09:59:38', 3),
	(72, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 47, 'Acessou o sistema', '2020-06-05 10:54:04', '2020-06-05 10:54:04', 3),
	(73, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 47, 'Acessou o sistema', '2020-06-05 11:32:31', '2020-06-05 11:32:31', 3),
	(74, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-06-05 11:50:39', '2020-06-05 11:50:39', 3),
	(75, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 47, 'Acessou o sistema', '2020-06-08 10:30:57', '2020-06-08 10:30:57', 3),
	(76, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 47, 'Acessou o sistema', '2020-06-08 15:14:24', '2020-06-08 15:14:24', 3),
	(77, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 47, 'Acessou o sistema', '2020-06-14 16:27:39', '2020-06-14 16:27:39', 3),
	(78, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 47, 'Acessou o sistema', '2020-06-24 16:31:53', '2020-06-24 16:31:53', 3),
	(79, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 47, 'Acessou o sistema', '2020-07-04 16:49:18', '2020-07-04 16:49:18', 3),
	(80, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 47, 'Acessou o sistema', '2020-07-16 16:52:36', '2020-07-16 16:52:36', 3),
	(81, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 47, 'Acessou o sistema', '2020-06-09 11:12:42', '2020-06-09 11:12:42', 3),
	(82, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1, 'Acessou o sistema', '2020-06-09 13:29:06', '2020-06-09 13:29:06', 3),
	(83, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 47, 'Acessou o sistema', '2020-06-09 14:14:12', '2020-06-09 14:14:12', 3),
	(84, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-06-09 15:05:45', '2020-06-09 15:05:45', 3),
	(85, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 47, 'Acessou o sistema', '2020-06-09 17:40:52', '2020-06-09 17:40:52', 3),
	(86, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 47, 'Acessou o sistema', '2020-06-10 12:44:08', '2020-06-10 12:44:08', 3),
	(87, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 26, 'Acessou o sistema', '2020-06-10 14:07:06', '2020-06-10 14:07:06', 3),
	(88, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 47, 'Acessou o sistema', '2020-06-10 14:07:46', '2020-06-10 14:07:46', 3),
	(89, '127.0.0.1', '/login', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 47, 'Acessou o sistema', '2020-06-10 14:29:29', '2020-06-10 14:29:29', 3);
/*!40000 ALTER TABLE `logs_acessos` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mutue_negocios_admin.migrations: ~3 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_100000_create_password_resets_table', 1),
	(2, '2019_08_19_000000_create_failed_jobs_table', 1),
	(3, '2020_05_19_211825_create_permission_tables', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mutue_negocios_admin.model_has_permissions: ~10 rows (approximately)
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\admin\\User', 1),
	(2, 'App\\Models\\admin\\User', 1),
	(3, 'App\\Models\\admin\\User', 1),
	(4, 'App\\Models\\admin\\User', 1),
	(6, 'App\\Models\\admin\\User', 1),
	(4, 'App\\Models\\admin\\User', 26),
	(5, 'App\\Models\\admin\\User', 26),
	(7, 'App\\Models\\admin\\User', 26),
	(8, 'App\\Models\\admin\\User', 26),
	(8, 'App\\Models\\admin\\User', 31);
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8 NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mutue_negocios_admin.model_has_roles: ~30 rows (approximately)
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\admin\\User', 1),
	(2, 'App\\Models\\admin\\User', 1),
	(3, 'App\\Models\\admin\\User', 1),
	(3, 'App\\Models\\admin\\User', 26),
	(2, 'App\\Models\\admin\\User', 31),
	(3, 'App\\Models\\admin\\User', 38),
	(2, 'App\\Models\\admin\\User', 39),
	(3, 'App\\Models\\admin\\User', 40),
	(3, 'App\\Models\\admin\\User', 41),
	(3, 'App\\Models\\admin\\User', 42),
	(3, 'App\\Models\\admin\\User', 43),
	(3, 'App\\Models\\admin\\User', 44),
	(3, 'App\\Models\\admin\\User', 45),
	(3, 'App\\Models\\admin\\User', 46),
	(3, 'App\\Models\\admin\\User', 47),
	(3, 'App\\Models\\admin\\User', 48),
	(3, 'App\\Models\\admin\\User', 49),
	(3, 'App\\Models\\admin\\User', 50),
	(3, 'App\\Models\\admin\\User', 51),
	(3, 'App\\Models\\admin\\User', 52),
	(3, 'App\\Models\\admin\\User', 53),
	(3, 'App\\Models\\admin\\User', 54),
	(3, 'App\\Models\\admin\\User', 55),
	(3, 'App\\Models\\admin\\User', 56),
	(3, 'App\\Models\\admin\\User', 58),
	(3, 'App\\Models\\admin\\User', 59),
	(3, 'App\\Models\\admin\\User', 60),
	(3, 'App\\Models\\admin\\User', 61),
	(3, 'App\\Models\\admin\\User', 62),
	(3, 'App\\Models\\admin\\User', 63);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.moedas
CREATE TABLE IF NOT EXISTS `moedas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `cambio` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.moedas: ~0 rows (approximately)
/*!40000 ALTER TABLE `moedas` DISABLE KEYS */;
INSERT INTO `moedas` (`id`, `designacao`, `codigo`, `cambio`) VALUES
	(1, 'AKZ', 'AOA', 1);
/*!40000 ALTER TABLE `moedas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.motivo
CREATE TABLE IF NOT EXISTS `motivo` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigoMotivo` varchar(50) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `codigoStatus` int(10) unsigned NOT NULL DEFAULT '0',
  `canal_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `status_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`codigo`),
  KEY `FK_motivo_canais_comunicacoes` (`canal_id`),
  KEY `FK_motivo_users` (`user_id`),
  KEY `FK_motivo_status_gerais` (`status_id`),
  CONSTRAINT `FK_motivo_canais_comunicacoes` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_motivo_status_gerais` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_motivo_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- Dumping data for table mutue_negocios_admin.motivo: ~23 rows (approximately)
/*!40000 ALTER TABLE `motivo` DISABLE KEYS */;
INSERT INTO `motivo` (`codigo`, `codigoMotivo`, `descricao`, `codigoStatus`, `canal_id`, `user_id`, `status_id`, `created_at`, `updated_at`) VALUES
	(7, 'M04', 'IVA-Regime de não Sujeição', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(8, 'M02', 'Transmissãoo de Bens e serviços nãoo sujeita', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(9, 'M00', 'Regime Transitórios', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(10, 'M10', 'Isento Artigo 12.º a) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(11, 'M11', 'Isento Artigo 12.º b) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(12, 'M12', 'Isento Artigo 12.º c) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(13, 'M13', 'Isento Artigo 12.º d) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(14, 'M14', 'Isento Artigo 12.º e) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(15, 'M15', 'Isento Artigo 12.º f) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(16, 'M16', 'Isento Artigo 12.º g) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(17, 'M17', 'Isento Artigo 12.º h) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(18, 'M18', 'Isento Artigo 12.º i) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(19, 'M19', 'Isento Artigo 12.º j) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(20, 'M20', 'Isento Artigo 12.º k) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(21, 'M30', 'Isento Artigo 15º 1 a) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(22, 'M31', 'Isento Artigo 15.º 1 b) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(23, 'M32', 'Isento Artigo 15.º 1 c) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(24, 'M33', 'Isento Artigo 15.º 1 d) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(25, 'M34', 'Isento Artigo 15.º 1 e) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(26, 'M35', 'Isento Artigo 15.º 1 f) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(27, 'M36', 'Isento Artigo 15.º 1 g) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(28, 'M37', 'Isento Artigo 15.º 1 h) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(29, 'M38', 'Isento Artigo 12.º  i) do CIVA', 1, 1, 1, 1, '2020-04-23 19:56:46', '2020-04-23 19:56:46'),
	(31, 'M023', 'Regime Transitório', 1, 3, NULL, 1, '2020-09-22 14:28:42', '2020-09-22 14:28:42');
/*!40000 ALTER TABLE `motivo` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.notificacoes_sistema
CREATE TABLE IF NOT EXISTS `notificacoes_sistema` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `empresa_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_notificacoes_empresa` (`empresa_id`),
  KEY `FK_notificacoes_canal` (`canal_id`),
  CONSTRAINT `FK_notificacoes_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_notificacoes_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.notificacoes_sistema: ~0 rows (approximately)
/*!40000 ALTER TABLE `notificacoes_sistema` DISABLE KEYS */;
/*!40000 ALTER TABLE `notificacoes_sistema` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.pagamentos
CREATE TABLE IF NOT EXISTS `pagamentos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `valor_depositado` double NOT NULL DEFAULT '0',
  `quantidade` int(10) NOT NULL DEFAULT '0',
  `totalPago` double NOT NULL DEFAULT '0',
  `data_pago_banco` date NOT NULL,
  `numero_operacao_bancaria` varchar(50) NOT NULL,
  `forma_pagamento_id` int(10) unsigned NOT NULL,
  `conta_movimentada_id` int(10) unsigned NOT NULL,
  `referenciaFactura` varchar(50) NOT NULL,
  `comprovativo_bancario` varchar(145) DEFAULT NULL,
  `observacao` varchar(255) DEFAULT NULL,
  `factura_id` int(10) unsigned NOT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `status_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_validacao` date DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_operacao_bancaria` (`numero_operacao_bancaria`),
  UNIQUE KEY `referenciaFactura` (`referenciaFactura`),
  KEY `FK_pagamentos_formas_pagamentos` (`forma_pagamento_id`),
  KEY `FK_pagamentos_bancos` (`conta_movimentada_id`),
  KEY `FK_pagamentos_facturas` (`factura_id`),
  KEY `FK_pagamentos_empresas` (`empresa_id`),
  KEY `FK_pagamentos_canais_comunicacoes` (`canal_id`),
  KEY `FK_pagamentos_users` (`user_id`),
  KEY `FK_pagamentos_status_gerais` (`status_id`),
  CONSTRAINT `FK_pagamentos_bancos` FOREIGN KEY (`conta_movimentada_id`) REFERENCES `bancos` (`id`),
  CONSTRAINT `FK_pagamentos_canais_comunicacoes` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_pagamentos_empresas` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_pagamentos_facturas` FOREIGN KEY (`factura_id`) REFERENCES `facturas` (`id`),
  CONSTRAINT `FK_pagamentos_formas_pagamentos` FOREIGN KEY (`forma_pagamento_id`) REFERENCES `formas_pagamentos` (`id`),
  CONSTRAINT `FK_pagamentos_status_gerais` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_pagamentos_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- Dumping data for table mutue_negocios_admin.pagamentos: ~1 rows (approximately)
/*!40000 ALTER TABLE `pagamentos` DISABLE KEYS */;
INSERT INTO `pagamentos` (`id`, `valor_depositado`, `quantidade`, `totalPago`, `data_pago_banco`, `numero_operacao_bancaria`, `forma_pagamento_id`, `conta_movimentada_id`, `referenciaFactura`, `comprovativo_bancario`, `observacao`, `factura_id`, `empresa_id`, `canal_id`, `user_id`, `status_id`, `created_at`, `data_validacao`, `updated_at`) VALUES
	(34, 50000, 5, 50000, '2020-08-04', 'MR7536DS', 4, 3, '692865001', '71596576134.jpg', ' nnnnnnnnnnnnnnnnnlpçsdsssssss', 36, 1, 1, 57, 1, '2020-08-04 22:22:14', NULL, '2020-08-04 22:22:14'),
	(35, 100000, 10, 100000, '2020-08-20', 'MG235KUR', 4, 1, '589621494', '71598613103.png', 'ggggggggggggggggggggggggggg', 41, 1, 1, 57, 1, '2020-08-28 12:11:43', '2020-08-28', '2020-08-28 12:19:02'),
	(36, 30000, 6, 30000, '2020-10-06', 'MR7536TR', 4, 3, '859152120', '41601982317.jpg', 'ffffffffffffffffffffffffffff', 44, 1, 1, 57, 1, '2020-10-06 12:05:17', NULL, '2020-10-06 12:05:17');
/*!40000 ALTER TABLE `pagamentos` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.paises
CREATE TABLE IF NOT EXISTS `paises` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  `sigla` varchar(45) DEFAULT NULL,
  `indicativo` varchar(45) DEFAULT NULL,
  `moeda_id` int(10) unsigned DEFAULT NULL,
  `idioma_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=248 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.paises: ~245 rows (approximately)
/*!40000 ALTER TABLE `paises` DISABLE KEYS */;
INSERT INTO `paises` (`id`, `designacao`, `sigla`, `indicativo`, `moeda_id`, `idioma_id`) VALUES
	(1, 'Angola', 'ANG', '+244', 1, 1),
	(2, 'Argélia', NULL, NULL, NULL, NULL),
	(3, 'Brasil', NULL, NULL, NULL, NULL),
	(4, 'Alemanha', NULL, NULL, NULL, NULL),
	(5, 'Dinamarques', NULL, NULL, NULL, NULL),
	(6, 'França', NULL, NULL, NULL, NULL),
	(7, 'Canadá', NULL, NULL, NULL, NULL),
	(8, 'Itália', NULL, NULL, NULL, NULL),
	(9, 'Holanda', NULL, NULL, NULL, NULL),
	(10, 'Bélgica', NULL, NULL, NULL, NULL),
	(11, 'África do Sul', NULL, NULL, NULL, NULL),
	(12, 'Espanha', NULL, NULL, NULL, NULL),
	(13, 'Venezuela', NULL, NULL, NULL, NULL),
	(15, 'Grã-Bretanha', NULL, NULL, NULL, NULL),
	(16, 'Irlanda', NULL, NULL, NULL, NULL),
	(17, 'Moçambique', NULL, NULL, NULL, NULL),
	(18, 'Áustria', NULL, NULL, NULL, NULL),
	(19, 'Costa Rica', NULL, NULL, NULL, NULL),
	(21, 'Marrocos', NULL, NULL, NULL, NULL),
	(22, 'Afeganistão', NULL, NULL, NULL, NULL),
	(23, 'Albania', NULL, NULL, NULL, NULL),
	(24, 'Andorra', NULL, NULL, NULL, NULL),
	(25, 'Angola', NULL, NULL, NULL, NULL),
	(26, 'Anguila', NULL, NULL, NULL, NULL),
	(27, 'Antárctica', NULL, NULL, NULL, NULL),
	(28, 'Antígua e Barbuda', NULL, NULL, NULL, NULL),
	(29, 'Antilhas holandesas', NULL, NULL, NULL, NULL),
	(30, 'Arábia Saudita', NULL, NULL, NULL, NULL),
	(31, 'Argentina', NULL, NULL, NULL, NULL),
	(32, 'Arménia', NULL, NULL, NULL, NULL),
	(33, 'Aruba', NULL, NULL, NULL, NULL),
	(34, 'Austrália', NULL, NULL, NULL, NULL),
	(35, 'Azerbaijão', NULL, NULL, NULL, NULL),
	(36, 'Bahamas', NULL, NULL, NULL, NULL),
	(37, 'Bangladesh', NULL, NULL, NULL, NULL),
	(38, 'Barbados', NULL, NULL, NULL, NULL),
	(39, 'Barém', NULL, NULL, NULL, NULL),
	(40, 'Belize', NULL, NULL, NULL, NULL),
	(41, 'Benin', NULL, NULL, NULL, NULL),
	(42, 'Bermuda', NULL, NULL, NULL, NULL),
	(43, 'Bielorrússia', NULL, NULL, NULL, NULL),
	(44, 'Bolívia', NULL, NULL, NULL, NULL),
	(45, 'Bósnia e Herzegovina', NULL, NULL, NULL, NULL),
	(46, 'Botswana', NULL, NULL, NULL, NULL),
	(47, 'Brunei Darussalam', NULL, NULL, NULL, NULL),
	(48, 'Bulgária', NULL, NULL, NULL, NULL),
	(49, 'Burkina Faso', NULL, NULL, NULL, NULL),
	(50, 'Burundi', NULL, NULL, NULL, NULL),
	(51, 'Butão', NULL, NULL, NULL, NULL),
	(52, 'Cabo Verde', NULL, NULL, NULL, NULL),
	(53, 'Camarões', NULL, NULL, NULL, NULL),
	(54, 'Camboja', NULL, NULL, NULL, NULL),
	(55, 'Catar', NULL, NULL, NULL, NULL),
	(56, 'Cazaquistão', NULL, NULL, NULL, NULL),
	(57, 'Centro-Africana (República)', NULL, NULL, NULL, NULL),
	(58, 'Chade', NULL, NULL, NULL, NULL),
	(59, 'Chile', NULL, NULL, NULL, NULL),
	(60, 'China', NULL, NULL, NULL, NULL),
	(61, 'Chipre', NULL, NULL, NULL, NULL),
	(62, 'Cidade do Vaticano ver Santa Sé', NULL, NULL, NULL, NULL),
	(63, 'Colômbia', NULL, NULL, NULL, NULL),
	(64, 'Comores', NULL, NULL, NULL, NULL),
	(65, 'Congo', NULL, NULL, NULL, NULL),
	(66, 'Congo (República Democrática do)', NULL, NULL, NULL, NULL),
	(67, 'Coreia (República da) ', NULL, NULL, NULL, NULL),
	(68, 'Coreia (República Popular Democrática da) ', NULL, NULL, NULL, NULL),
	(69, 'Costa do Marfim', NULL, NULL, NULL, NULL),
	(70, 'Croácia', NULL, NULL, NULL, NULL),
	(71, 'Cuba', NULL, NULL, NULL, NULL),
	(72, 'Dinamarca', NULL, NULL, NULL, NULL),
	(73, 'Domínica', NULL, NULL, NULL, NULL),
	(74, 'Egipto', NULL, NULL, NULL, NULL),
	(75, 'El Salvador', NULL, NULL, NULL, NULL),
	(76, 'Emiratos Árabes Unidos', NULL, NULL, NULL, NULL),
	(77, 'Equador', NULL, NULL, NULL, NULL),
	(78, 'Eritreia', NULL, NULL, NULL, NULL),
	(79, 'Eslovaca (República)', NULL, NULL, NULL, NULL),
	(80, 'Eslovénia', NULL, NULL, NULL, NULL),
	(81, 'Estados Unidos', NULL, NULL, NULL, NULL),
	(82, 'Estónia', NULL, NULL, NULL, NULL),
	(83, 'Etiópia', NULL, NULL, NULL, NULL),
	(84, 'Filipinas', NULL, NULL, NULL, NULL),
	(85, 'Finlândia', NULL, NULL, NULL, NULL),
	(86, 'Gabão', NULL, NULL, NULL, NULL),
	(87, 'Gâmbia', NULL, NULL, NULL, NULL),
	(88, 'Gana', NULL, NULL, NULL, NULL),
	(89, 'Geórgia', NULL, NULL, NULL, NULL),
	(90, 'Georgia do Sul e Ilhas Sandwich', NULL, NULL, NULL, NULL),
	(91, 'Gibraltar', NULL, NULL, NULL, NULL),
	(92, 'Granada', NULL, NULL, NULL, NULL),
	(93, 'Grécia', NULL, NULL, NULL, NULL),
	(94, 'Gronelândia', NULL, NULL, NULL, NULL),
	(95, 'Guadalupe', NULL, NULL, NULL, NULL),
	(96, 'Guam', NULL, NULL, NULL, NULL),
	(97, 'Guatemala', NULL, NULL, NULL, NULL),
	(98, 'Guiana', NULL, NULL, NULL, NULL),
	(99, 'Guiana Francesa', NULL, NULL, NULL, NULL),
	(100, 'Guiné', NULL, NULL, NULL, NULL),
	(101, 'Guiné Equatorial', NULL, NULL, NULL, NULL),
	(102, 'Guiné-Bissau', NULL, NULL, NULL, NULL),
	(103, 'Haiti', NULL, NULL, NULL, NULL),
	(104, 'Honduras', NULL, NULL, NULL, NULL),
	(105, 'Hong Kong', NULL, NULL, NULL, NULL),
	(106, 'Hungria', NULL, NULL, NULL, NULL),
	(107, 'Iémen', NULL, NULL, NULL, NULL),
	(108, 'Ilhas Bouvet', NULL, NULL, NULL, NULL),
	(109, 'Ilhas Caimão', NULL, NULL, NULL, NULL),
	(110, 'Ilhas Christmas', NULL, NULL, NULL, NULL),
	(111, 'Ilhas Cocos (Keeling)', NULL, NULL, NULL, NULL),
	(112, 'Ilhas Cook', NULL, NULL, NULL, NULL),
	(113, 'Ilhas Falkland (Malvinas)', NULL, NULL, NULL, NULL),
	(114, 'Ilhas Faroé', NULL, NULL, NULL, NULL),
	(115, 'Ilhas Fiji', NULL, NULL, NULL, NULL),
	(116, 'Ilhas Heard e Ilhas McDonald', NULL, NULL, NULL, NULL),
	(117, 'Ilhas Marianas do Norte', NULL, NULL, NULL, NULL),
	(118, 'Ilhas Marshall', NULL, NULL, NULL, NULL),
	(119, 'Ilhas menores distantes dos Estados Unidos', NULL, NULL, NULL, NULL),
	(120, 'Ilhas Norfolk', NULL, NULL, NULL, NULL),
	(121, 'Ilhas Salomão', NULL, NULL, NULL, NULL),
	(122, 'Ilhas Virgens (britânicas)', NULL, NULL, NULL, NULL),
	(123, 'Ilhas Virgens (Estados Unidos)', NULL, NULL, NULL, NULL),
	(124, 'Índia', NULL, NULL, NULL, NULL),
	(125, 'Indonésia', NULL, NULL, NULL, NULL),
	(126, 'Irão (República Islâmica)', NULL, NULL, NULL, NULL),
	(127, 'Iraque', NULL, NULL, NULL, NULL),
	(128, 'Islândia', NULL, NULL, NULL, NULL),
	(129, 'Israel', NULL, NULL, NULL, NULL),
	(130, 'Jamaica', NULL, NULL, NULL, NULL),
	(131, 'Japão', NULL, NULL, NULL, NULL),
	(132, 'Jibuti', NULL, NULL, NULL, NULL),
	(133, 'Jordânia', NULL, NULL, NULL, NULL),
	(134, 'Jugoslávia', NULL, NULL, NULL, NULL),
	(135, 'Kenya', NULL, NULL, NULL, NULL),
	(136, 'Kiribati', NULL, NULL, NULL, NULL),
	(137, 'Kuwait', NULL, NULL, NULL, NULL),
	(138, 'Laos (República Popular Democrática do)', NULL, NULL, NULL, NULL),
	(139, 'Lesoto', NULL, NULL, NULL, NULL),
	(140, 'Letónia', NULL, NULL, NULL, NULL),
	(141, 'Líbano', NULL, NULL, NULL, NULL),
	(142, 'Libéria', NULL, NULL, NULL, NULL),
	(143, 'Líbia (Jamahiriya Árabe da)', NULL, NULL, NULL, NULL),
	(144, 'Liechtenstein', NULL, NULL, NULL, NULL),
	(145, 'Lituânia', NULL, NULL, NULL, NULL),
	(146, 'Luxemburgo', NULL, NULL, NULL, NULL),
	(147, 'Macau', NULL, NULL, NULL, NULL),
	(148, 'Macedónia (antiga república jugoslava da)', NULL, NULL, NULL, NULL),
	(149, 'Madagáscar', NULL, NULL, NULL, NULL),
	(150, 'Malásia', NULL, NULL, NULL, NULL),
	(151, 'Malawi', NULL, NULL, NULL, NULL),
	(152, 'Maldivas', NULL, NULL, NULL, NULL),
	(153, 'Mali', NULL, NULL, NULL, NULL),
	(154, 'Malta', NULL, NULL, NULL, NULL),
	(155, 'Martinica', NULL, NULL, NULL, NULL),
	(156, 'Maurícias', NULL, NULL, NULL, NULL),
	(157, 'Mauritânia', NULL, NULL, NULL, NULL),
	(158, 'Mayotte', NULL, NULL, NULL, NULL),
	(159, 'México', NULL, NULL, NULL, NULL),
	(160, 'Micronésia (Estados Federados da)', NULL, NULL, NULL, NULL),
	(161, 'Moldova (República de)', NULL, NULL, NULL, NULL),
	(162, 'Mónaco', NULL, NULL, NULL, NULL),
	(163, 'Mongólia', NULL, NULL, NULL, NULL),
	(164, 'Monserrate', NULL, NULL, NULL, NULL),
	(165, 'Myanmar', NULL, NULL, NULL, NULL),
	(166, 'Namíbia', NULL, NULL, NULL, NULL),
	(167, 'Nauru', NULL, NULL, NULL, NULL),
	(168, 'Nepal', NULL, NULL, NULL, NULL),
	(169, 'Nicarágua', NULL, NULL, NULL, NULL),
	(170, 'Niger', NULL, NULL, NULL, NULL),
	(171, 'Nigéria', NULL, NULL, NULL, NULL),
	(172, 'Niue', NULL, NULL, NULL, NULL),
	(173, 'Noruega', NULL, NULL, NULL, NULL),
	(174, 'Nova Caledónia', NULL, NULL, NULL, NULL),
	(175, 'Nova Zelândia', NULL, NULL, NULL, NULL),
	(176, 'Omã', NULL, NULL, NULL, NULL),
	(177, 'Países Baixos', NULL, NULL, NULL, NULL),
	(178, 'Palau', NULL, NULL, NULL, NULL),
	(179, 'Panamá', NULL, NULL, NULL, NULL),
	(180, 'Papuásia-Nova Guiné', NULL, NULL, NULL, NULL),
	(181, 'Paquistão', NULL, NULL, NULL, NULL),
	(182, 'Paraguai', NULL, NULL, NULL, NULL),
	(183, 'Peru', NULL, NULL, NULL, NULL),
	(184, 'Pitcairn', NULL, NULL, NULL, NULL),
	(185, 'Polinésia Francesa', NULL, NULL, NULL, NULL),
	(186, 'Polónia', NULL, NULL, NULL, NULL),
	(187, 'Porto Rico', NULL, NULL, NULL, NULL),
	(188, 'Portugal', NULL, NULL, NULL, NULL),
	(189, 'Quirguizistão', NULL, NULL, NULL, NULL),
	(190, 'Reino Unido', NULL, NULL, NULL, NULL),
	(191, 'República Checa', NULL, NULL, NULL, NULL),
	(192, 'República Dominicana', NULL, NULL, NULL, NULL),
	(193, 'Reunião', NULL, NULL, NULL, NULL),
	(194, 'Roménia', NULL, NULL, NULL, NULL),
	(195, 'Ruanda', NULL, NULL, NULL, NULL),
	(196, 'Rússia (Federação da)', NULL, NULL, NULL, NULL),
	(197, 'Samoa', NULL, NULL, NULL, NULL),
	(198, 'Samoa Americana', NULL, NULL, NULL, NULL),
	(199, 'Santa Helena', NULL, NULL, NULL, NULL),
	(200, 'Santa Lúcia', NULL, NULL, NULL, NULL),
	(201, 'Santa Sé (Cidade Estado do Vaticano)*', NULL, NULL, NULL, NULL),
	(202, 'São Cristóvão e Nevis', NULL, NULL, NULL, NULL),
	(203, 'São Marino', NULL, NULL, NULL, NULL),
	(204, 'São Pedro e Miquelon', NULL, NULL, NULL, NULL),
	(205, 'São Tomé e Príncipe', NULL, NULL, NULL, NULL),
	(206, 'São Vicente e Granadinas', NULL, NULL, NULL, NULL),
	(207, 'Sara Ocidental', NULL, NULL, NULL, NULL),
	(208, 'Senegal', NULL, NULL, NULL, NULL),
	(209, 'Serra Leoa', NULL, NULL, NULL, NULL),
	(210, 'Seychelles', NULL, NULL, NULL, NULL),
	(211, 'Singapura', NULL, NULL, NULL, NULL),
	(212, 'Síria (República Árabe da)', NULL, NULL, NULL, NULL),
	(213, 'Somália', NULL, NULL, NULL, NULL),
	(214, 'Sri Lanka', NULL, NULL, NULL, NULL),
	(215, 'Suazilândia', NULL, NULL, NULL, NULL),
	(216, 'Sudão', NULL, NULL, NULL, NULL),
	(217, 'Suécia', NULL, NULL, NULL, NULL),
	(218, 'Suiça', NULL, NULL, NULL, NULL),
	(219, 'Suriname', NULL, NULL, NULL, NULL),
	(220, 'Svålbard e a Ilha de Jan Mayen', NULL, NULL, NULL, NULL),
	(221, 'Tailândia', NULL, NULL, NULL, NULL),
	(222, 'Taiwan (Província da China)', NULL, NULL, NULL, NULL),
	(223, 'Tajiquistão', NULL, NULL, NULL, NULL),
	(224, 'Tanzânia, República Unida da', NULL, NULL, NULL, NULL),
	(225, 'Território Britânico do Oceano Índico', NULL, NULL, NULL, NULL),
	(226, 'Território Palestiniano Ocupado', NULL, NULL, NULL, NULL),
	(227, 'Territórios Franceses do Sul', NULL, NULL, NULL, NULL),
	(228, 'Timor Leste', NULL, NULL, NULL, NULL),
	(229, 'Togo', NULL, NULL, NULL, NULL),
	(230, 'Tokelau', NULL, NULL, NULL, NULL),
	(231, 'Tonga', NULL, NULL, NULL, NULL),
	(232, 'Trindade e Tobago', NULL, NULL, NULL, NULL),
	(233, 'Tunísia', NULL, NULL, NULL, NULL),
	(234, 'Turcos e Caicos (Ilhas)', NULL, NULL, NULL, NULL),
	(235, 'Turquemenistão', NULL, NULL, NULL, NULL),
	(236, 'Turquia', NULL, NULL, NULL, NULL),
	(237, 'Tuvalu', NULL, NULL, NULL, NULL),
	(238, 'Ucrânia', NULL, NULL, NULL, NULL),
	(239, 'Uganda', NULL, NULL, NULL, NULL),
	(240, 'Uruguai', NULL, NULL, NULL, NULL),
	(241, 'Usbequistão', NULL, NULL, NULL, NULL),
	(242, 'Vanuatu', NULL, NULL, NULL, NULL),
	(243, 'Vietname', NULL, NULL, NULL, NULL),
	(244, 'Wallis e Futuna (Ilha)', NULL, NULL, NULL, NULL),
	(245, 'Zaire, ver Congo (República Democrática do)', NULL, NULL, NULL, NULL),
	(246, 'Zâmbia', NULL, NULL, NULL, NULL),
	(247, 'Zimbabwe', NULL, NULL, NULL, NULL);
/*!40000 ALTER TABLE `paises` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.parametros
CREATE TABLE IF NOT EXISTS `parametros` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  `valor` varchar(45) DEFAULT NULL,
  `vida` int(10) unsigned DEFAULT NULL,
  `createde_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `canal_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_parametros_canal` (`canal_id`),
  CONSTRAINT `FK_parametros_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.parametros: ~22 rows (approximately)
/*!40000 ALTER TABLE `parametros` DISABLE KEYS */;
INSERT INTO `parametros` (`id`, `designacao`, `valor`, `vida`, `createde_at`, `updated_at`, `canal_id`) VALUES
	(1, 'N.º de Dias Gratis', '30', NULL, '2020-04-22 16:18:57', '2020-04-22 16:18:57', 1),
	(2, 'N.º de Dias Aviso', '10', NULL, '2020-04-22 16:18:57', '2020-04-22 16:18:57', 1),
	(8, 'IPC', '0.05', 0, '2020-07-09 15:05:56', '2020-07-09 15:05:56', 1),
	(9, 'cambio', '190', 0, '2020-07-09 15:05:56', '2020-07-09 15:05:56', 1),
	(10, 'N.º Mes Paragem Vendas de Produto', NULL, 9, '2020-07-09 15:05:56', '2020-07-09 15:05:56', 1),
	(11, 'N.º Mes Alerta Vendas de Produto', NULL, 5, '2020-07-09 15:05:56', '2020-07-09 15:05:56', 1),
	(12, 'Nº Minimo de Alerta Existencia dos Produtos', NULL, 21, '2020-07-09 15:05:56', '2020-07-09 15:05:56', 1),
	(13, 'Valor Desconto', '100', 100, '2020-07-09 15:05:56', '2020-07-09 15:05:56', 1),
	(14, 'Retencao na fonte', '6.5', 7, '2020-07-09 15:05:56', '2020-07-09 15:05:56', 1),
	(15, 'hora', '22:00:00', 22, '2020-07-09 15:05:56', '2020-07-09 15:05:56', 1),
	(16, 'TipoImpreensao', 'A4', 1, '2020-07-09 15:05:56', '2020-07-09 15:05:56', 1),
	(17, 'NotaEntrega', 'SIM', 1, '2020-07-09 15:05:56', '2020-07-09 15:05:56', 1),
	(18, 'CartaRecompesa', 'SIM', 1, '2020-07-09 15:05:56', '2020-07-09 15:05:56', 1),
	(19, 'LayoutVenda', 'Classico', 1, '2020-07-09 15:05:56', '2020-07-09 15:05:56', 1),
	(20, 'Nº Dias Vencimento Factura', NULL, 15, '2020-07-09 15:05:56', '2020-07-09 15:05:56', 3),
	(21, 'IVA', NULL, 1, '2020-07-09 15:05:56', '2020-07-09 15:05:56', 3),
	(22, 'Deposito de valor', NULL, 1, '2020-07-09 15:05:56', '2020-07-09 15:05:56', 3),
	(23, 'Nº Dias Vencimento Factura Proforma', NULL, 15, '2020-07-09 15:05:56', '2020-07-09 15:05:56', 3),
	(24, 'Sigla da empresa', 'AGT', 0, '2020-07-09 15:05:56', '2020-07-09 15:05:56', 3),
	(25, 'Licença Premium', 'Mensal', 31, '2020-07-16 15:38:01', '2020-07-16 15:38:01', 3),
	(26, 'Licença Platina', 'Anual', 365, '2020-07-16 15:40:57', '2020-07-16 15:40:57', 3),
	(27, 'Licença Definitiva', 'Definitiva', NULL, '2020-07-16 15:48:18', '2020-07-16 15:48:18', 3);
/*!40000 ALTER TABLE `parametros` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mutue_negocios_admin.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.periodo_testes
CREATE TABLE IF NOT EXISTS `periodo_testes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `periodo` date NOT NULL,
  `dias_restante` int(10) unsigned NOT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_periodo_teste_empresas` (`empresa_id`),
  CONSTRAINT `FK_periodo_teste_empresas` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- Dumping data for table mutue_negocios_admin.periodo_testes: ~3 rows (approximately)
/*!40000 ALTER TABLE `periodo_testes` DISABLE KEYS */;
INSERT INTO `periodo_testes` (`id`, `periodo`, `dias_restante`, `empresa_id`) VALUES
	(16, '2020-08-16', 30, 25),
	(19, '2020-09-04', 30, 27),
	(20, '2020-09-06', 0, 21);
/*!40000 ALTER TABLE `periodo_testes` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mutue_negocios_admin.permissions: ~8 rows (approximately)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'gerir utilizadores', 'web', '2020-05-04 16:07:01', '2020-05-04 16:07:02'),
	(2, 'gerir permissões', 'web', '2020-05-18 01:08:13', '2020-05-18 01:08:15'),
	(3, 'gerir licenças', 'web', '2020-05-18 01:09:05', '2020-05-18 01:09:06'),
	(4, 'consultar licenças', 'web', '2020-05-18 01:10:17', '2020-05-18 01:10:19'),
	(5, 'gerir fornecedores', 'web', '2020-05-18 01:11:34', '2020-05-18 01:11:36'),
	(6, 'gerir empresas', 'web', '2020-05-18 01:14:35', '2020-05-18 01:14:36'),
	(7, 'gerir clientes', 'web', '2020-05-22 23:49:57', '2020-05-22 23:49:58'),
	(8, 'gerir funcionario', 'web', '2020-05-22 23:50:17', '2020-05-22 23:50:18');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mutue_negocios_admin.roles: ~6 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'Super-Admin', 'web', '2020-05-03 10:13:41', '2020-05-03 10:13:43'),
	(2, 'Admin', 'web', '2020-05-03 10:14:38', '2020-05-03 10:14:39'),
	(3, 'Empresa', 'web', '2020-05-13 16:50:57', '2020-05-13 16:50:58'),
	(4, 'Gestor', 'web', '2020-06-02 14:11:21', '2020-06-02 14:11:24'),
	(5, 'Funcionario', 'empresa', '2020-06-09 16:19:24', '2020-06-09 16:19:26'),
	(6, 'Cliente', 'empresa', '2020-06-09 16:21:18', '2020-06-09 16:21:19');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mutue_negocios_admin.role_has_permissions: ~0 rows (approximately)
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.status_gerais
CREATE TABLE IF NOT EXISTS `status_gerais` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.status_gerais: ~2 rows (approximately)
/*!40000 ALTER TABLE `status_gerais` DISABLE KEYS */;
INSERT INTO `status_gerais` (`id`, `designacao`) VALUES
	(1, 'Activo'),
	(2, 'Desactivo');
/*!40000 ALTER TABLE `status_gerais` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.status_licencas
CREATE TABLE IF NOT EXISTS `status_licencas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.status_licencas: ~8 rows (approximately)
/*!40000 ALTER TABLE `status_licencas` DISABLE KEYS */;
INSERT INTO `status_licencas` (`id`, `designacao`) VALUES
	(1, 'Nova'),
	(2, 'Usada'),
	(3, 'Cancelada'),
	(4, 'Disponivel'),
	(5, 'Indisponivel'),
	(6, 'Activa'),
	(7, 'Rejeitada'),
	(8, 'Pendente');
/*!40000 ALTER TABLE `status_licencas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.status_senha
CREATE TABLE IF NOT EXISTS `status_senha` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

-- Dumping data for table mutue_negocios_admin.status_senha: ~2 rows (approximately)
/*!40000 ALTER TABLE `status_senha` DISABLE KEYS */;
INSERT INTO `status_senha` (`id`, `designacao`) VALUES
	(1, 'Vulnerável'),
	(2, 'Segura');
/*!40000 ALTER TABLE `status_senha` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.tipos_clientes
CREATE TABLE IF NOT EXISTS `tipos_clientes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.tipos_clientes: ~6 rows (approximately)
/*!40000 ALTER TABLE `tipos_clientes` DISABLE KEYS */;
INSERT INTO `tipos_clientes` (`id`, `designacao`) VALUES
	(1, 'Singular'),
	(2, 'Instituição Privada'),
	(3, 'Instituição Publica'),
	(4, 'Sociedade Anónima'),
	(5, 'ONG'),
	(6, 'Diversos');
/*!40000 ALTER TABLE `tipos_clientes` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.tipos_contactos
CREATE TABLE IF NOT EXISTS `tipos_contactos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.tipos_contactos: ~0 rows (approximately)
/*!40000 ALTER TABLE `tipos_contactos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipos_contactos` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.tipos_licencas
CREATE TABLE IF NOT EXISTS `tipos_licencas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  `valor` double NOT NULL DEFAULT '0',
  `tipo_taxa_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `canal_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tipos_licencas_taxa` (`tipo_taxa_id`),
  KEY `FK_tipos_licencas_canal` (`canal_id`),
  KEY `FK_tipos_licencas_user` (`user_id`),
  CONSTRAINT `FK_tipos_licencas_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_tipos_licencas_taxa` FOREIGN KEY (`tipo_taxa_id`) REFERENCES `tipotaxa` (`codigo`),
  CONSTRAINT `FK_tipos_licencas_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.tipos_licencas: ~3 rows (approximately)
/*!40000 ALTER TABLE `tipos_licencas` DISABLE KEYS */;
INSERT INTO `tipos_licencas` (`id`, `designacao`, `valor`, `tipo_taxa_id`, `created_at`, `updated_at`, `canal_id`, `user_id`) VALUES
	(1, 'Anual', 10000, 1, '2020-04-22 17:03:12', '2020-04-22 17:03:12', 3, NULL),
	(2, 'Mensal', 5000, 1, '2020-04-22 17:03:12', '2020-04-22 17:03:12', 2, NULL),
	(3, 'Definitiva', 100000, 1, '2020-04-22 17:03:12', '2020-04-22 17:03:12', 2, NULL);
/*!40000 ALTER TABLE `tipos_licencas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.tipos_regimes
CREATE TABLE IF NOT EXISTS `tipos_regimes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table mutue_negocios_admin.tipos_regimes: ~3 rows (approximately)
/*!40000 ALTER TABLE `tipos_regimes` DISABLE KEYS */;
INSERT INTO `tipos_regimes` (`id`, `Designacao`) VALUES
	(1, 'Regime Geral'),
	(2, 'Regime Transitório'),
	(3, 'Regime de Não Sujeição (Lei n.º 7/19 de 24 de Abril)');
/*!40000 ALTER TABLE `tipos_regimes` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.tipotaxa
CREATE TABLE IF NOT EXISTS `tipotaxa` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `taxa` int(11) NOT NULL,
  `codigostatus` int(10) unsigned NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`codigo`),
  KEY `FK_tipotaxa_2` (`codigostatus`),
  CONSTRAINT `FK_tipotaxa_2` FOREIGN KEY (`codigostatus`) REFERENCES `status_gerais` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table mutue_negocios_admin.tipotaxa: ~3 rows (approximately)
/*!40000 ALTER TABLE `tipotaxa` DISABLE KEYS */;
INSERT INTO `tipotaxa` (`codigo`, `taxa`, `codigostatus`, `descricao`, `created_at`, `updated_at`) VALUES
	(1, 0, 1, 'IVA(0,00%)', '2020-09-28 13:10:30', '2020-09-28 13:10:30'),
	(2, 14, 1, 'IVA(14,00%)', '2020-09-28 13:10:30', '2020-09-28 13:10:30'),
	(3, 2, 2, 'IVA(2,00%)', '2020-09-28 13:10:30', '2020-09-28 13:10:30');
/*!40000 ALTER TABLE `tipotaxa` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.tipo_users
CREATE TABLE IF NOT EXISTS `tipo_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_admin.tipo_users: ~3 rows (approximately)
/*!40000 ALTER TABLE `tipo_users` DISABLE KEYS */;
INSERT INTO `tipo_users` (`id`, `designacao`) VALUES
	(1, 'Admin'),
	(2, 'Empresa'),
	(3, 'Cliente');
/*!40000 ALTER TABLE `tipo_users` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_admin.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `telefone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `canal_id` int(10) unsigned DEFAULT '2',
  `tipo_user_id` int(10) unsigned DEFAULT '2',
  `status_id` int(10) unsigned DEFAULT '2',
  `status_senha_id` int(10) unsigned DEFAULT '1',
  `username` varchar(450) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `telefone` (`telefone`),
  KEY `FK_users_canal` (`canal_id`),
  KEY `Fk_tipo_user_id` (`tipo_user_id`),
  KEY `Fk_status_id` (`status_id`),
  KEY `FK_users_status_senha` (`status_senha_id`),
  CONSTRAINT `FK_users_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_users_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_users_status_senha` FOREIGN KEY (`status_senha_id`) REFERENCES `status_senha` (`id`),
  CONSTRAINT `FK_users_tipo` FOREIGN KEY (`tipo_user_id`) REFERENCES `tipo_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table mutue_negocios_admin.users: ~7 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `telefone`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `canal_id`, `tipo_user_id`, `status_id`, `status_senha_id`, `username`, `foto`) VALUES
	(1, 'RAMOSSOFT TECNOLOGIAS LDA', '923292970', 'info@ramossoft.com', '2020-05-08 13:24:57', '$2y$10$QWExKGhnkl9KTDwE2KjlKu/489J/Y8Lk.b7edVJlJza.qt9ICIlru', 'nMvQQs6dNmWgtBq4dxwxonBrjDMPuvSUhp1uEWm8PXa7Ak895qodDVhOGUIq', '2020-05-08 13:25:31', '2020-06-02 14:57:54', 3, 1, 1, 1, 'ramossoft.tecnologias', 'ramososofware.png'),
	(26, 'Ndongala Nguinamau Luciano', '932768954', 'ndongalamd@gmail.com', '2020-05-17 16:50:53', '$2y$10$oGp4gjieny8OkK/1wPYFZuKULUxQjfOa2jilGtIHUos0zxVQLvP1K', 'MDraHQMAMd2Julc9E1kIeGxPCAppElZ6rHca8bwYQafFVNmOHqZUSce1mgCG', '2020-05-17 16:50:53', '2020-06-09 16:26:33', 3, 2, 1, 1, 'Ndongala Nguinamau Luciano', '785001591716393.jpg'),
	(47, 'MOBILARIA ANGOLA LDA', '945577824', 'mobiliaria@gmail.com', '2020-06-04 16:56:30', '$2y$10$eCcURr.gTtu8N/DKrF7md.RHplm6p3RfIxYwn1.el7pAYU.8AmkrW', '8rhpBI1h27DmUy6QDirgg7uEtKifmZWwkUbq0mTGHDv8QrE80szzUXN5qdso', '2020-06-04 16:56:30', '2020-06-11 20:40:15', 3, 2, 1, 1, 'MOBILARIA ANGOLA LDA', '194041591904415.jpg'),
	(57, 'PATSOFT CONSULTURING', '921504961', 'brunoneto256@gmail.com', '2020-06-11 13:29:24', '$2y$10$5Uoiz.E9.PnBemlANqKEVuU0zeE5pZdygupkrJAg6rhryI3BtREym', 'MezhjrM4VzNj2HgehIMBGMY1JU42OmU4HlOqDxIB8BxUlbl1ZCloO4MexmqJ', '2020-06-11 13:29:24', '2020-10-02 12:56:33', 3, 2, 1, 2, 'patsoft.developper', 'utilizadores/cliente/FaP1senFd66zwVxNY4sOm1uiks03eORyJSXUVMmu.jpeg'),
	(58, 'Paulo João', '933577829', 'paulojoao@unesc.net', '2020-06-11 16:14:08', '$2y$10$.GhT5HthjnMLdlG.iVDpce2US2W5vcJyYJ0THzExJygTrxCg/4C2a', '7wrKa8IikfEq08GKVrDmxz7e3ZvlH8ykw353SRMELMvmU3oiOmMuwLS9bTH2', '2020-06-11 16:14:08', '2020-06-11 16:14:08', 3, 2, 1, 1, 'Paulo João', NULL),
	(61, 'RamosSoftware', '934786543', 'suporte.mutue@gmail.com', '2020-07-17 12:45:54', '$2y$10$pe.MqHpjY64iDCuaREHiMek6YI5i2b7frqKSC0tGK6rM3tceIivj6', 'eNKn34Auqg3X83VsC8sNM795ocDdQgxmqoCcU3YDpDhDkdpGutnUC28JUDEE', '2020-07-17 12:45:54', '2020-07-17 12:45:54', 3, 2, 1, 1, 'RamosSoftware', 'utilizadores/cliente/Yt6BpGDHlJdXxPAFWBLQSMgWZOFwKCZkp81uF7lw.png'),
	(63, 'Pedro Soft', '939441294', 'pedrocabingano15@gmail.com', '2020-08-05 10:04:59', '$2y$10$22oFRVRWsO36J8p1ETCQp.MyH//BKZ/jl1nfDF.ltwoA.op88vU5C', 'LFPnP59NHfXCuXSKVMfFBisMQK0MXwRxLu4c2fVhN9jVgiPxozTSuRSVEXho', '2020-08-05 10:04:59', '2020-08-05 10:04:59', 3, 2, 1, 1, 'Pedro Soft', NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
