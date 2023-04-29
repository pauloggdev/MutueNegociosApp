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


-- Dumping database structure for mutue_negocios_clientes
CREATE DATABASE IF NOT EXISTS `mutue_negocios_clientes` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `mutue_negocios_clientes`;

-- Dumping structure for table mutue_negocios_clientes.actualizacao_stocks
CREATE TABLE IF NOT EXISTS `actualizacao_stocks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `empresa_id` int(10) unsigned NOT NULL,
  `produto_id` int(10) unsigned NOT NULL,
  `quantidade_antes` int(10) unsigned NOT NULL,
  `quantidade_nova` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_actualizacao_stocks_empresa` (`empresa_id`),
  KEY `FK_actualizacao_stocks_produto` (`produto_id`),
  KEY `FK_actualizacao_stocks_user` (`user_id`),
  KEY `FK_actualizacao_stocks_canal` (`canal_id`),
  KEY `FK_actualizacao_stocks_status` (`status_id`),
  CONSTRAINT `FK_actualizacao_stocks_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_actualizacao_stocks_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_actualizacao_stocks_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  CONSTRAINT `FK_actualizacao_stocks_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_actualizacao_stocks_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.actualizacao_stocks: ~0 rows (approximately)
/*!40000 ALTER TABLE `actualizacao_stocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `actualizacao_stocks` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.armazens
CREATE TABLE IF NOT EXISTS `armazens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  `codigo` varchar(45) DEFAULT NULL,
  `localizacao` varchar(145) DEFAULT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_armazens_status` (`status_id`),
  KEY `FK_armazens_user` (`user_id`),
  KEY `FK_armazens_empresa` (`empresa_id`),
  CONSTRAINT `FK_armazens_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_armazens_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_armazens_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.armazens: ~11 rows (approximately)
/*!40000 ALTER TABLE `armazens` DISABLE KEYS */;
INSERT INTO `armazens` (`id`, `designacao`, `codigo`, `localizacao`, `status_id`, `user_id`, `empresa_id`, `created_at`, `updated_at`) VALUES
	(1, 'LOJA PRINCIPAL', 'DG01', 'Luanda Sul-Viana', 1, NULL, 26, '2020-06-03 21:53:10', '2020-06-03 21:53:10'),
	(2, 'RESFRIANGO LTDA', 'RA02', 'dsdsdsd', 1, NULL, 13, '2020-06-12 20:41:48', '2020-06-12 20:41:48'),
	(6, 'BAMAKO SOCIATY', 'BS03', 'fdafafda', 1, NULL, 26, '2020-06-12 20:59:48', '2020-06-12 20:59:48'),
	(7, 'PORTLAND LTDA', 'PL04', 'QQRT', 1, NULL, 26, '2020-06-12 21:00:15', '2020-09-10 15:26:40'),
	(8, 'ANGOREAL LTDA', 'AR05', 'gafgag', 1, NULL, 27, '2020-06-12 21:00:56', '2020-06-12 21:00:56'),
	(9, 'MOTALISTA LTDA', 'ML06', 'vvvvvvv', 1, NULL, 27, '2020-06-12 21:16:47', '2020-06-12 21:16:47'),
	(10, 'PATRISOFT DEVELOPPER', 'PS07', 'gggggggg', 2, NULL, 27, '2020-06-15 15:21:00', '2020-06-15 15:21:00'),
	(13, 'LOJA PRINCIPAL', '4rV7', 'Viana', 1, NULL, 33, '2020-07-08 16:00:57', '2020-07-08 16:00:57'),
	(14, 'LOJA PRINCIPAL', 'iY63', 'Viana', 1, NULL, 34, '2020-07-08 16:11:46', '2020-07-08 16:11:46'),
	(15, 'LOJA PRINCIPAL', 'eMAs', 'Bairro-Vila de Viiana', 1, NULL, 35, '2020-07-17 12:45:55', '2020-07-17 12:45:55'),
	(17, 'LOJA PRINCIPAL', 'vXnN', 'Samba', 1, NULL, 37, '2020-08-05 10:04:59', '2020-08-05 10:04:59');
/*!40000 ALTER TABLE `armazens` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.bancos
CREATE TABLE IF NOT EXISTS `bancos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  `sigla` varchar(45) DEFAULT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `empresa_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_bancos_canal` (`canal_id`),
  KEY `FK_bancos_user` (`user_id`),
  KEY `FK_bancos_status` (`status_id`),
  KEY `FK_bancos_empresas` (`empresa_id`),
  CONSTRAINT `FK_bancos_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_bancos_empresas` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_bancos_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_bancos_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.bancos: ~8 rows (approximately)
/*!40000 ALTER TABLE `bancos` DISABLE KEYS */;
INSERT INTO `bancos` (`id`, `designacao`, `sigla`, `status_id`, `canal_id`, `created_at`, `empresa_id`, `user_id`, `updated_at`) VALUES
	(3, 'BANCO DE INVESTIMENTO COMERCIAL', 'BIC', 2, 2, '2020-06-12 20:15:51', 26, NULL, '2020-06-12 20:15:51'),
	(4, 'BANCO AFRICANO DE INVESTIMENTO', 'BAI', 1, 2, '2020-06-12 20:22:16', 27, NULL, '2020-06-12 20:22:16'),
	(9, 'BANCO DE FOMENTO ANGOLA', 'BFA', 1, 2, '2020-07-10 17:58:31', 27, NULL, '2020-07-10 18:32:59'),
	(10, 'SANTANDER', 'SDT', 1, 2, '2020-07-13 12:51:41', 26, NULL, '2020-07-13 12:52:07'),
	(14, 'MILLENIUM', 'SDT', 1, 2, '2020-07-14 01:17:17', 27, NULL, '2020-07-14 01:17:17'),
	(15, 'BANCO NACIONAL DE ANGOLA', 'BNA', 1, 2, '2020-07-21 23:40:09', 26, NULL, '2020-07-21 23:40:09'),
	(23, 'NRJP NRE LHR', 'AFR', 1, 2, '2020-09-09 19:10:51', 26, NULL, '2020-09-09 22:33:23'),
	(24, 'BANCO DE FOMENTO ANGOLA', 'BFA', 1, 2, '2020-09-09 21:05:23', 26, NULL, '2020-09-09 21:05:23');
/*!40000 ALTER TABLE `bancos` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.canais_comunicacoes
CREATE TABLE IF NOT EXISTS `canais_comunicacoes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.canais_comunicacoes: ~4 rows (approximately)
/*!40000 ALTER TABLE `canais_comunicacoes` DISABLE KEYS */;
INSERT INTO `canais_comunicacoes` (`id`, `designacao`) VALUES
	(1, 'BD'),
	(2, 'Portal Cliente'),
	(3, 'Portal Admin'),
	(4, 'Mobile');
/*!40000 ALTER TABLE `canais_comunicacoes` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.carateristica_produtos
CREATE TABLE IF NOT EXISTS `carateristica_produtos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `altura` double DEFAULT '0',
  `largura` double DEFAULT '0',
  `cor` varchar(255) DEFAULT NULL,
  `peso` double DEFAULT '0',
  `especura` double DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.carateristica_produtos: ~0 rows (approximately)
/*!40000 ALTER TABLE `carateristica_produtos` DISABLE KEYS */;
/*!40000 ALTER TABLE `carateristica_produtos` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_categorias_status` (`status_id`),
  KEY `FK_categorias_user` (`user_id`),
  KEY `FK_categorias_canal` (`canal_id`),
  KEY `FK_categorias_empresa` (`empresa_id`),
  CONSTRAINT `FK_categorias_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_categorias_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_categorias_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_categorias_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.categorias: ~5 rows (approximately)
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` (`id`, `designacao`, `status_id`, `user_id`, `canal_id`, `empresa_id`, `created_at`, `updated_at`) VALUES
	(1, 'Bebida', 1, NULL, 2, 27, '2020-06-19 17:33:59', '2020-06-19 17:34:01'),
	(2, 'Brindes', 1, NULL, 2, 27, '2020-06-22 20:35:48', '2020-06-22 20:35:49'),
	(3, 'Jogos', 1, NULL, 2, 27, '2020-06-22 20:52:08', '2020-06-22 20:52:10'),
	(4, 'Arte e ofícios', 2, NULL, 2, 26, '2020-06-22 20:53:16', '2020-09-30 23:53:03'),
	(5, 'Diversos', 1, NULL, 2, 26, '2020-08-05 11:13:49', '2020-08-05 11:13:50');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.classes
CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(255) NOT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK__empresas` (`empresa_id`),
  KEY `FK__status_gerais` (`status_id`),
  KEY `FK__users` (`user_id`),
  KEY `FK__canais_comunicacoes` (`canal_id`),
  CONSTRAINT `FK__canais_comunicacoes` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK__empresas` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK__status_gerais` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK__users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.classes: ~7 rows (approximately)
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` (`id`, `designacao`, `empresa_id`, `status_id`, `user_id`, `canal_id`, `created_at`, `updated_at`) VALUES
	(1, 'Alimentar', 37, 1, NULL, 2, '2020-06-19 17:37:34', '2020-06-19 17:37:36'),
	(2, 'Alcóol e tabaco', 27, 1, NULL, 2, '2020-06-22 20:19:12', '2020-06-22 20:19:14'),
	(3, 'Produtos Culturais', 27, 1, NULL, 2, '2020-06-22 20:20:09', '2020-06-22 20:20:10'),
	(4, 'Desporto e Lazer', 27, 1, NULL, 2, '2020-06-22 20:20:54', '2020-06-22 20:20:55'),
	(5, 'Electrodomésticos', 27, 1, NULL, 2, '2020-06-22 20:21:39', '2020-06-22 20:21:40'),
	(6, 'Produtos para casa', 27, 1, NULL, 2, '2020-06-22 20:22:08', '2020-06-22 20:22:09'),
	(7, 'Diversos', 26, 1, NULL, 2, '2020-09-08 16:04:05', '2020-09-08 16:04:05');
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `pessoa_contacto` varchar(50) NOT NULL,
  `email` varchar(145) DEFAULT NULL,
  `website` varchar(145) DEFAULT NULL,
  `telefone_cliente` varchar(145) DEFAULT NULL,
  `numero_contrato` varchar(30) DEFAULT NULL,
  `data_contrato` date DEFAULT NULL,
  `tipo_conta_corrente` enum('Nacional','Estrangeiro') NOT NULL DEFAULT 'Nacional',
  `conta_corrente` varchar(50) DEFAULT NULL,
  `taxa_de_desconto` double DEFAULT '0',
  `limite_de_credito` double DEFAULT '0',
  `endereco` varchar(345) DEFAULT NULL,
  `gestor_id` int(10) unsigned DEFAULT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `nif` varchar(45) DEFAULT NULL,
  `operador` int(10) unsigned DEFAULT NULL,
  `tipo_cliente_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pais_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_clientes_gestor` (`gestor_id`),
  KEY `FK_clientes_empresa` (`empresa_id`),
  KEY `FK_clientes_canal` (`canal_id`),
  KEY `FK_clientes_status` (`status_id`),
  KEY `FK_clientes_user` (`user_id`),
  KEY `FK_clientes_pais` (`pais_id`),
  KEY `FK_clientes_operador` (`operador`),
  KEY `FK_clientes_tipos_clientes` (`tipo_cliente_id`),
  CONSTRAINT `FK_clientes_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_clientes_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_clientes_gestor` FOREIGN KEY (`gestor_id`) REFERENCES `gestor_clientes` (`id`),
  CONSTRAINT `FK_clientes_operador` FOREIGN KEY (`operador`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_clientes_pais` FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`),
  CONSTRAINT `FK_clientes_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_clientes_tipos_clientes` FOREIGN KEY (`tipo_cliente_id`) REFERENCES `tipos_clientes` (`id`),
  CONSTRAINT `FK_clientes_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.clientes: ~12 rows (approximately)
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`id`, `nome`, `pessoa_contacto`, `email`, `website`, `telefone_cliente`, `numero_contrato`, `data_contrato`, `tipo_conta_corrente`, `conta_corrente`, `taxa_de_desconto`, `limite_de_credito`, `endereco`, `gestor_id`, `canal_id`, `status_id`, `nif`, `operador`, `tipo_cliente_id`, `user_id`, `empresa_id`, `created_at`, `updated_at`, `pais_id`) VALUES
	(3, 'Paulo João', '923504961', 'ndongalamd@gmail.com', 'http://www.kldkkdk.com', '956545421', '45', '2020-07-14', 'Nacional', '31.1.2.1', 10, 1500, 'Bairro-Petrangol', 1, 2, 1, '56765322KH97', NULL, 4, 11, 26, '2020-05-29 03:51:51', '2020-06-04 02:43:04', 2),
	(4, 'Mobiliararia Consummer', '987654328', 'brunoneto256@gmail.com', 'http://www.jobart.com.co', '956545422', '25', '2020-07-14', 'Nacional', '31.1.2.1', 20, 2000, 'Bairro-Vila de Viiana', 1, 2, 1, 'ssssssssss', NULL, 4, 12, 26, '2020-05-29 04:06:47', '2020-06-04 02:41:49', 3),
	(5, 'Henrique Jorje', '921504967', 'benvindo@gmail.com', 'http://www.regex.com', '956545423', '32', '2020-07-14', 'Nacional', '31.1.2.1', 30, 3000, 'Bairro-Vila do Gamek', 1, 2, 1, '56765322KHRG', NULL, 4, 13, 26, '2020-06-26 16:35:43', '2020-06-26 16:35:43', 4),
	(6, 'Josafat Domingos', '921504964', 'josafat@gmail.com', 'http://www.jobaat.com.co', '956545424', '34', '2020-07-14', 'Nacional', '31.1.2.1', 40, 4000, 'Bairro-Vila do Gamek', 1, 2, 1, '12234567JF', NULL, 1, NULL, 27, '2020-07-01 21:36:51', '2020-07-01 21:36:51', 1),
	(12, 'Delfina Garcia João', '956688545', 'company@gmail.com1', 'http://teste1211.com.ao', '923656147', '12', '2020-07-14', 'Nacional', '31.1.2.1', 111, 12344, 'Viana', 1, 2, 1, 'qqqqqqqqqq124', NULL, 3, NULL, 27, '2020-07-14 18:39:29', '2020-07-14 18:39:29', 3),
	(13, 'Paulo Gonçalo', '923656044', 'paulogoncalo@gmail.com', 'http://contato.com.ao', '956654585', '456', '2020-07-14', 'Estrangeiro', '31.1.2.2', 20, 15000, 'Viana', 1, 2, 1, 'MMMDFDFD', NULL, 2, NULL, 27, '2020-07-14 18:42:00', '2020-07-14 18:42:00', 1),
	(14, 'Laurindo', '936565878', 'laurindo@gmail.com', 'http://site.com.ao', '956658545', '65', '2020-07-16', 'Nacional', '31.1.2.1.14', 20, 1700, 'Viana', 1, 2, 1, 'MMDFDFD', NULL, 2, NULL, 27, '2020-07-14 19:16:33', '2020-07-14 19:16:33', 1),
	(15, 'Jorge', '958878445', 'jorge@gmail.com', 'http://jorge.com.ao', '956854512', '456', '2020-07-08', 'Estrangeiro', '31.1.2.2.15', 10, 1700, 'Viana', 1, 2, 1, 'MMMDFDF', NULL, 2, NULL, 27, '2020-07-14 19:18:37', '2020-07-14 19:18:37', 5),
	(16, 'Raul Jorge', '958855245', 'teste2@gmail.com', 'http://teste13211.com.ao', '923656145', '45454', '2020-07-14', 'Nacional', '31.1.2.1.16', 20, 1500, 'Viana', 1, 2, 1, 'FDFDFDFD', NULL, 2, NULL, 27, '2020-07-15 00:52:12', '2020-07-15 00:52:12', 2),
	(19, 'Osvaldo Ramos', '956585215', 'osvaldo@gmail.com', 'osvaldoramos.com.ao', '923656045', '456', '2020-07-22', 'Nacional', '.19', NULL, NULL, 'Viana', 1, 2, 1, 'SDFDKLDF', NULL, 3, NULL, 27, '2020-07-15 00:56:34', '2020-07-15 00:56:34', 1),
	(20, 'Aristoteles ', '989774123', 'testeste@gmail.com', 'http://teste12116.com.ao', '923656147', '456', '2020-07-14', 'Nacional', '31.1.2.1.20', 0, 0, 'Viana', 1, 2, 1, 'FDFDFDFDF5', NULL, 2, NULL, 27, '2020-07-15 01:06:56', '2020-07-15 01:06:56', 3),
	(21, 'Edmundo', '965821200', 'edmundo@gmail.com', 'edmundo.com.ao', '956655452', '45', '2020-07-15', 'Estrangeiro', '31.1.2.2.21', 10, 1500, 'Viana', 1, 2, 1, 'FDDFDFD', NULL, 2, NULL, 27, '2020-07-15 14:23:50', '2020-07-15 14:23:50', 1),
	(22, 'Mande Paulo', '923456788', 'mandepaulo@gmail.com', 'https://www.mandepaulo.com.ao', '931456789', '568', '2020-09-11', 'Nacional', '31.1.2.2.22', 0, 0, 'Petrangol', 1, 2, 1, '22345678FDF5', NULL, 2, NULL, 26, '2020-09-13 22:33:37', '2020-09-13 22:33:42', 1);
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.contactos
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

-- Dumping data for table mutue_negocios_clientes.contactos: ~0 rows (approximately)
/*!40000 ALTER TABLE `contactos` DISABLE KEYS */;
/*!40000 ALTER TABLE `contactos` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.coordenadas_bancarias
CREATE TABLE IF NOT EXISTS `coordenadas_bancarias` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `banco_id` int(10) unsigned NOT NULL,
  `num_conta` varchar(45) NOT NULL,
  `iban` varchar(45) DEFAULT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_coordenadas_cancarias_canal` (`canal_id`),
  KEY `FK_coordenadas_cancarias_status` (`status_id`),
  KEY `FK_coordenadas_cancarias_user` (`user_id`),
  KEY `FK_coordenadas_cancarias_banco` (`banco_id`),
  CONSTRAINT `FK_coordenadas_cancarias_banco` FOREIGN KEY (`banco_id`) REFERENCES `bancos` (`id`),
  CONSTRAINT `FK_coordenadas_cancarias_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_coordenadas_cancarias_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_coordenadas_cancarias_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.coordenadas_bancarias: ~5 rows (approximately)
/*!40000 ALTER TABLE `coordenadas_bancarias` DISABLE KEYS */;
INSERT INTO `coordenadas_bancarias` (`id`, `banco_id`, `num_conta`, `iban`, `canal_id`, `status_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 3, '300 664350/30/098', 'AO06.0006.0000.11 5543503.66', 2, 1, NULL, '2020-07-02 08:48:42', '2020-09-09 22:14:21'),
	(2, 4, '300 664350/30/01', 'AO06.0006.0000.11 6643503.66', 2, 1, NULL, '2020-07-02 08:50:35', '2020-07-02 08:50:35'),
	(3, 15, '1234567', 'A000.0006.0000.', 2, 1, NULL, '2020-07-21 23:40:10', '2020-07-23 09:47:06'),
	(4, 23, '1234567', 'AO06.0006.0000.11 6643503.66', 2, 1, NULL, '2020-09-09 19:10:51', '2020-09-09 22:33:23'),
	(5, 24, '1234567', 'AO06.0006.0000.11 7543503.66', 2, 1, NULL, '2020-09-09 21:05:23', '2020-09-09 21:51:38');
/*!40000 ALTER TABLE `coordenadas_bancarias` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.empresas
CREATE TABLE IF NOT EXISTS `empresas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `pessoal_Contacto` varchar(145) NOT NULL,
  `endereco` varchar(245) NOT NULL,
  `pais_id` int(10) unsigned NOT NULL,
  `saldo` double DEFAULT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `nif` varchar(45) NOT NULL,
  `gestor_cliente_id` int(10) unsigned DEFAULT NULL,
  `tipo_cliente_id` int(10) unsigned DEFAULT NULL,
  `tipo_regime_id` int(10) unsigned DEFAULT NULL,
  `logotipo` varchar(145) DEFAULT NULL,
  `website` varchar(145) DEFAULT NULL,
  `email` varchar(145) DEFAULT NULL,
  `referencia` varchar(145) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`),
  UNIQUE KEY `pessoal_Contacto` (`pessoal_Contacto`),
  UNIQUE KEY `referencia` (`referencia`),
  UNIQUE KEY `email` (`email`),
  KEY `FK_empresas_pais` (`pais_id`),
  KEY `FK_empresas_canal` (`canal_id`),
  KEY `FK_empresas_status` (`status_id`),
  KEY `FK_empresas_gestor` (`gestor_cliente_id`),
  KEY `FK_empresas_tipo` (`tipo_cliente_id`),
  KEY `FK_empresas_tipos_regimes` (`tipo_regime_id`),
  CONSTRAINT `FK_empresas_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_empresas_pais` FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`),
  CONSTRAINT `FK_empresas_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_empresas_tipo` FOREIGN KEY (`tipo_cliente_id`) REFERENCES `tipos_clientes` (`id`),
  CONSTRAINT `FK_empresas_tipos_regimes` FOREIGN KEY (`tipo_regime_id`) REFERENCES `tipos_regimes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.empresas: ~10 rows (approximately)
/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT INTO `empresas` (`id`, `nome`, `pessoal_Contacto`, `endereco`, `pais_id`, `saldo`, `canal_id`, `status_id`, `nif`, `gestor_cliente_id`, `tipo_cliente_id`, `tipo_regime_id`, `logotipo`, `website`, `email`, `referencia`, `created_at`, `updated_at`) VALUES
	(1, 'LITEANGOLA', '923357660', 'ANGOLA-LUANDA-PETRANGOL', 1, 1234, 2, 1, '123456789LA98', NULL, 2, 3, NULL, NULL, NULL, NULL, '2020-04-23 19:35:12', '2020-04-23 19:35:12'),
	(13, 'Ndongala Nguinamau Luciano', '932768954', 'Bairro-Vila do Gamek', 1, 0, 3, 1, '291988', 1, 3, 1, '785001591716393.jpg', 'http://www.kldkkdk.com', 'ndongalamd@gmail.com', '78500', '2020-05-17 20:50:53', '2020-06-09 20:26:33'),
	(16, 'MOBILARIA ANGOLA LDA', '945577824', 'Bairro-Vila de Viiana', 3, 0, 3, 1, '123456789MB076', 1, 3, 2, '194041591904415.jpg', 'http://www.mobil.com.co', 'mobiliaria@gmail.com', '19404', '2020-06-04 20:56:30', '2020-06-12 00:40:15'),
	(26, 'PATSOFT DEVELOPPER CONSULTURING', '933577822', 'Bairro-Vila de Viiana', 1, 0, 3, 1, '123345567BA746', 1, 3, 1, 'utilizadores/cliente/FaP1senFd66zwVxNY4sOm1uiks03eORyJSXUVMmu.jpeg', 'http://www.jobart.com.co', 'brunoneto256@gmail.com', '90695', '2020-06-11 17:29:24', '2020-10-02 12:56:33'),
	(27, 'RamosSoft', '928277927', 'Rua do G.Shopping, por trás da casa dos frescos', 1, 0, 3, 1, '5000467766', 1, 2, 1, 'utilizadores/cliente/Yt6BpGDHlJdXxPAFWBLQSMgWZOFwKCZkp81uF7lw.png', 'www.ramossoft.com', 'info@ramossoft.com', '37994', '2020-06-11 20:14:10', '2020-06-11 20:14:10'),
	(29, 'Longa Domingos', '924678948', 'Bairro-Vila de Viiana', 5, 0, 3, 1, '9865322PB82345', 1, 4, 2, '51593386515.png', 'http://www.jobart.com.co', 'longa@gmail.com', '72409', '2020-06-29 04:21:55', '2020-06-29 04:21:55'),
	(33, 'Suporte Tecnico', '923656044', 'Viana', 1, 0, 3, 1, 'AABBBDD', 1, 1, 1, NULL, 'http://suporte00tecnico.com', 'suporte00tecnico@gmail.com', '64206', '2020-07-08 16:00:57', '2020-07-08 16:00:57'),
	(34, 'Ramos Software', '923458552', 'Viana', 1, 0, 3, 1, 'MMADQdfd', 1, 1, 1, NULL, 'http://brunoneto.com', 'ramosoft256@gmail.com', '74100', '2020-07-08 16:11:46', '2020-07-08 16:11:46'),
	(35, 'RamosSoftware', '934786543', 'Bairro-Vila de Viiana', 1, 0, 3, 1, 'DMMDF6DFD', 1, 2, 1, '101594986353.jpg', 'http://www.suporte.com.co', 'suporte.mutue@gmail.com', '59961', '2020-07-17 12:45:55', '2020-07-17 12:45:55'),
	(37, 'Pedro Soft', '939441294', 'Samba', 1, 0, 3, 1, '912345678', 1, 3, 3, NULL, NULL, 'pedrocabingano15@gmail.com', '1WV13WS', '2020-08-05 10:04:59', '2020-08-05 10:04:59');
/*!40000 ALTER TABLE `empresas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.entradas_stocks
CREATE TABLE IF NOT EXISTS `entradas_stocks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data_factura_fornecedor` date NOT NULL,
  `fornecedor_id` int(10) unsigned NOT NULL,
  `forma_pagamento_id` int(10) unsigned NOT NULL,
  `num_factura_fornecedor` varchar(45) DEFAULT NULL,
  `total_compras` double DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_entradas_stocks_user` (`user_id`),
  KEY `FK_entradas_stocks_canal` (`canal_id`),
  KEY `FK_entradas_stocks_status` (`status_id`),
  KEY `FK_entradas_stocks_fornecedor` (`fornecedor_id`),
  KEY `FK_entradas_stocks_forma_pagamento` (`forma_pagamento_id`),
  CONSTRAINT `FK_entradas_stocks_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_entradas_stocks_forma_pagamento` FOREIGN KEY (`forma_pagamento_id`) REFERENCES `formas_pagamentos` (`id`),
  CONSTRAINT `FK_entradas_stocks_fornecedor` FOREIGN KEY (`fornecedor_id`) REFERENCES `fornecedores` (`id`),
  CONSTRAINT `FK_entradas_stocks_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_entradas_stocks_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.entradas_stocks: ~0 rows (approximately)
/*!40000 ALTER TABLE `entradas_stocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `entradas_stocks` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.entradas_stock_items
CREATE TABLE IF NOT EXISTS `entradas_stock_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entrada_stock_id` int(10) unsigned NOT NULL,
  `produto_id` int(10) unsigned NOT NULL,
  `preco_compra` double NOT NULL,
  `quantidade` int(10) unsigned NOT NULL,
  `total` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_entradas_stock_items_produto` (`produto_id`),
  KEY `FK_entradas_stock` (`entrada_stock_id`),
  CONSTRAINT `FK_entradas_stock` FOREIGN KEY (`entrada_stock_id`) REFERENCES `entradas_stocks` (`id`),
  CONSTRAINT `FK_entradas_stock_items_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.entradas_stock_items: ~0 rows (approximately)
/*!40000 ALTER TABLE `entradas_stock_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `entradas_stock_items` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.existencias_stocks
CREATE TABLE IF NOT EXISTS `existencias_stocks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `produto_id` int(10) unsigned NOT NULL,
  `armazem_id` int(10) unsigned NOT NULL,
  `tipo_stocagem_id` int(10) unsigned DEFAULT NULL,
  `quantidade` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_existencias_produto` (`produto_id`),
  KEY `FK_existencias_armazem` (`armazem_id`),
  KEY `FK_existencias_canal` (`canal_id`),
  KEY `FK_existencias_user` (`user_id`),
  KEY `FK_existencias_status` (`status_id`),
  KEY `FK_existencias_empresa` (`empresa_id`),
  KEY `FK_existencias_stocks_tipos_stocagens` (`tipo_stocagem_id`),
  CONSTRAINT `FK_existencias_armazem` FOREIGN KEY (`armazem_id`) REFERENCES `armazens` (`id`),
  CONSTRAINT `FK_existencias_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_existencias_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_existencias_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  CONSTRAINT `FK_existencias_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_existencias_stocks_tipos_stocagens` FOREIGN KEY (`tipo_stocagem_id`) REFERENCES `tipos_stocagens` (`id`),
  CONSTRAINT `FK_existencias_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.existencias_stocks: ~3 rows (approximately)
/*!40000 ALTER TABLE `existencias_stocks` DISABLE KEYS */;
INSERT INTO `existencias_stocks` (`id`, `produto_id`, `armazem_id`, `tipo_stocagem_id`, `quantidade`, `canal_id`, `user_id`, `status_id`, `empresa_id`, `created_at`, `updated_at`) VALUES
	(32, 22, 8, 1, 4, 2, NULL, 1, 27, '2020-06-24 19:56:42', '2020-06-24 19:56:42'),
	(33, 23, 8, 1, 0, 2, NULL, 1, 26, '2020-06-24 20:16:43', '2020-06-24 20:16:43'),
	(45, 40, 1, 1, 9, 2, NULL, 1, 26, '2020-07-16 21:46:59', '2020-07-16 21:46:59');
/*!40000 ALTER TABLE `existencias_stocks` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.fabricantes
CREATE TABLE IF NOT EXISTS `fabricantes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_fabricantes_empresa` (`empresa_id`),
  KEY `FK_fabricantes_canal` (`canal_id`),
  KEY `FK_fabricantes_user` (`user_id`),
  KEY `FK_fabricantes_status` (`status_id`),
  CONSTRAINT `FK_fabricantes_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_fabricantes_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_fabricantes_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_fabricantes_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.fabricantes: ~3 rows (approximately)
/*!40000 ALTER TABLE `fabricantes` DISABLE KEYS */;
INSERT INTO `fabricantes` (`id`, `designacao`, `empresa_id`, `user_id`, `canal_id`, `status_id`, `created_at`, `updated_at`) VALUES
	(1, 'ANGOSFRAN', 26, NULL, 2, 1, '2020-06-03 19:55:22', '2020-06-03 19:55:22'),
	(2, 'Armando Soft', 27, NULL, 2, 1, '2020-06-23 15:30:34', '2020-06-23 15:30:35'),
	(3, 'NCR', 37, NULL, 2, 1, '2020-08-05 10:12:02', '2020-08-05 10:12:02');
/*!40000 ALTER TABLE `fabricantes` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.facturas
CREATE TABLE IF NOT EXISTS `facturas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `total_preco_factura` double NOT NULL,
  `valor_a_pagar` double DEFAULT NULL,
  `valor_entregue` double DEFAULT NULL,
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
  `conta_corrente_cliente` varchar(45) DEFAULT NULL,
  `numeroItems` int(10) unsigned NOT NULL,
  `tipo_documento` enum('FACTURA','FACTURA PROFORMA','FACTURA RECIBO') DEFAULT NULL,
  `retencao` double DEFAULT NULL,
  `nextFactura` varchar(45) DEFAULT NULL,
  `faturaReference` varchar(45) DEFAULT NULL,
  `numSequenciaFactura` int(10) unsigned DEFAULT '0',
  `numeracaoFactura` varchar(255) DEFAULT NULL,
  `hashValor` text,
  `retificado` enum('Sim','Não') DEFAULT 'Não',
  `formas_pagamento_id` int(10) unsigned NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `observacao` text,
  `armazen_id` int(10) unsigned NOT NULL,
  `cliente_id` int(10) unsigned DEFAULT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_vencimento` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_facturas_canal` (`canal_id`),
  KEY `FK_facturas_empresa` (`empresa_id`),
  KEY `FK_facturas_status` (`status_id`),
  KEY `FK_facturas_user` (`user_id`),
  KEY `FK_facturas_clientes` (`cliente_id`),
  KEY `FK_facturas_formas_pagamentos` (`formas_pagamento_id`),
  KEY `FK_facturas_armazens` (`armazen_id`),
  KEY `FK_facturas_moedas` (`codigo_moeda`),
  CONSTRAINT `FK_facturas_armazens` FOREIGN KEY (`armazen_id`) REFERENCES `armazens` (`id`),
  CONSTRAINT `FK_facturas_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_facturas_clientes` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  CONSTRAINT `FK_facturas_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_facturas_formas_pagamentos` FOREIGN KEY (`formas_pagamento_id`) REFERENCES `formas_pagamentos` (`id`),
  CONSTRAINT `FK_facturas_moedas` FOREIGN KEY (`codigo_moeda`) REFERENCES `moedas` (`id`),
  CONSTRAINT `FK_facturas_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_facturas_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=162 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.facturas: ~56 rows (approximately)
/*!40000 ALTER TABLE `facturas` DISABLE KEYS */;
INSERT INTO `facturas` (`id`, `total_preco_factura`, `valor_a_pagar`, `valor_entregue`, `troco`, `valor_extenso`, `codigo_moeda`, `desconto`, `total_iva`, `multa`, `nome_do_cliente`, `telefone_cliente`, `nif_cliente`, `email_cliente`, `endereco_cliente`, `conta_corrente_cliente`, `numeroItems`, `tipo_documento`, `retencao`, `nextFactura`, `faturaReference`, `numSequenciaFactura`, `numeracaoFactura`, `hashValor`, `retificado`, `formas_pagamento_id`, `descricao`, `observacao`, `armazen_id`, `cliente_id`, `empresa_id`, `canal_id`, `status_id`, `user_id`, `created_at`, `updated_at`, `data_vencimento`) VALUES
	(63, 155000, 134061, 1000000, 865939, 'cento e trinta e quatro mil e sessenta e um', 1, 21700, 10836, 0, 'Domingos', '921504967', '56765322KH', 'domingos@gmail.com', 'Viana, Vila Nova fffffffffffffff', NULL, 4, 'FACTURA', 10075, '-REF 1', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 5, 27, 2, 1, NULL, '2020-07-09 16:36:44', '2020-07-09 16:36:44', '2020-07-24'),
	(64, 157760.72267, 126074.53210149, 1000000, 873925.46789851, 'cento e vinte e seis mil e setenta e quatro vírgula cinquenta e três', 1, 31552.144534, 10120.40093904, 0, 'Domingos', '921504967', '56765322KH', 'domingos@gmail.com', 'Viana, Vila Nova', NULL, 6, 'FACTURA RECIBO', 10254.44697355, '-REF 64', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 5, 27, 2, 1, NULL, '2020-07-09 16:42:50', '2020-07-09 16:42:50', '2020-07-24'),
	(65, 365000, 285075, 1000000, 714925, 'duzentos e oitenta e cinco mil e setenta e cinco', 1, 73000, 16800, 0, 'Domingos', '921504967', '56765322KH', 'domingos@gmail.com', 'Viana, Vila Nova', NULL, 3, 'FACTURA PROFORMA', 23725, '-REF 65', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 5, 27, 2, 1, NULL, '2020-07-09 16:46:34', '2020-07-09 16:46:34', '2020-07-24'),
	(66, 602760.72267, 649711.2238438, 2000000, 1350288.7761562, 'seiscentos e quarenta e nove mil setecentos e onze vírgula vinte e dois', 1, 0, 46950.5011738, 0, 'Domingos', '921504967', '56765322KH', 'domingos@gmail.com', 'Viana, Vila Nova', NULL, 10, 'FACTURA', 0, '-REF 66', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 5, 27, 2, 1, NULL, '2020-07-10 15:28:03', '2020-07-10 15:28:03', '2020-07-25'),
	(67, 67760.72267, 67655.2238438, 2000000, 1932344.7761562, 'sessenta e sete mil seiscentos e cinquenta e cinco vírgula vinte e dois', 1, 0, 50.5011738, 0, 'Domingos', '921504967', '56765322KH', 'domingos@gmail.com', 'Viana, Vila Nova', NULL, 4, 'FACTURA', 156, '-REF 67', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 5, 27, 2, 1, NULL, '2020-07-10 16:54:04', '2020-07-10 16:54:04', '2020-07-25'),
	(68, 452760.72267, 499711.2238438, 2000000, 1500288.7761562, 'quatrocentos e noventa e nove mil setecentos e onze vírgula vinte e dois', 1, 0, 46950.5011738, 0, 'Josafat Domingos', '921504964', '12234567JF', 'josafat@gmail.com', 'Bairro-Vila do Gamek', NULL, 10, 'FACTURA', 0, '-REF 68', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 2, NULL, NULL, 8, 6, 27, 2, 1, NULL, '2020-07-15 00:25:13', '2020-07-15 00:25:13', '2020-07-29'),
	(69, 202760.72267, 223811.2238438, 10000000, 9776188.7761562, 'duzentos e vinte e três mil oitocentos e onze vírgula vinte e dois', 1, 0, 21050.5011738, 0, 'Josafat Domingos', '921504964', '12234567JF', 'josafat@gmail.com', 'Bairro-Vila do Gamek', NULL, 4, 'FACTURA', 0, '-REF 69', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 6, 27, 2, 1, NULL, '2020-07-15 14:29:47', '2020-07-15 14:29:47', '2020-07-30'),
	(70, 6007.2267, 4698.11819778, 20000, 15301.88180222, 'quatro mil seiscentos e noventa e oito vírgula doze', 1, 1201.44534, 282.80657328, 0, 'Osvaldo Ramos', 'Osvaldo', 'SDFDKLDF', 'osvaldo@gmail.com', 'Viana', NULL, 11, 'FACTURA', 390.4697355, '-REF 70', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 19, 27, 2, 1, NULL, '2020-07-16 06:37:11', '2020-07-16 06:37:11', '2020-07-31'),
	(71, 3121.44534, 3222.4476876, 10000, 6777.5523124, 'três mil duzentos e vinte e dois vírgula quarenta e cinco', 1, 0, 101.0023476, 0, 'Osvaldo Ramos', 'Osvaldo', 'SDFDKLDF', 'osvaldo@gmail.com', 'Viana', NULL, 3, 'FACTURA PROFORMA', 0, '-REF 71', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 19, 27, 2, 1, NULL, '2020-07-16 06:39:01', '2020-07-16 06:39:01', '2020-07-31'),
	(72, 8407.2267, 6238.5669066, 1000000, 993761.4330934, 'seis mil duzentos e trinta e oito vírgula cinquenta e sete', 1, 2522.16801, 353.5082166, 0, 'Laurindo', 'Laurindo', 'MMDFDFD', 'laurindo@gmail.com', 'Viana', NULL, 12, 'FACTURA', 0, '-REF 72', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 14, 27, 2, 1, NULL, '2020-07-16 06:49:22', '2020-07-16 06:49:22', '2020-07-31'),
	(73, 360.72267, 411.2238438, 1000, 588.7761562, 'quatrocentos e onze vírgula vinte e dois', 1, 0, 50.5011738, 0, 'Laurindo', 'Laurindo', 'MMDFDFD', 'laurindo@gmail.com', 'Viana', NULL, 1, 'FACTURA', 0, '-REF 73', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 14, 27, 2, 1, NULL, '2020-07-16 17:41:27', '2020-07-16 17:41:27', '2020-07-31'),
	(74, 360.72267, 411.2238438, 1000, 588.7761562, 'quatrocentos e onze vírgula vinte e dois', 1, 0, 50.5011738, 0, 'Laurindo', 'Laurindo', 'MMDFDFD', 'laurindo@gmail.com', 'Viana', NULL, 1, 'FACTURA', 0, '-REF 74', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 14, 27, 2, 1, NULL, '2020-07-16 17:41:28', '2020-07-16 17:41:28', '2020-07-31'),
	(75, 360.72267, 411.2238438, 10000, 9588.7761562, 'quatrocentos e onze vírgula vinte e dois', 1, 0, 50.5011738, 0, 'Laurindo', 'Laurindo', 'MMDFDFD', 'laurindo@gmail.com', 'Viana', NULL, 1, 'FACTURA', 0, '-REF 75', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 14, 27, 2, 1, NULL, '2020-07-16 17:52:04', '2020-07-16 17:52:04', '2020-07-31'),
	(76, 360.72267, 411.2238438, 10000, 9588.7761562, 'quatrocentos e onze vírgula vinte e dois', 1, 0, 50.5011738, 0, 'Josafat Domingos', '921504964', '12234567JF', 'josafat@gmail.com', 'Bairro-Vila do Gamek', NULL, 1, 'FACTURA', 0, '-REF 76', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 6, 27, 2, 1, NULL, '2020-07-16 17:53:55', '2020-07-16 17:53:55', '2020-07-31'),
	(77, 360.72267, 411.2238438, 10000, 9588.7761562, 'quatrocentos e onze vírgula vinte e dois', 1, 0, 50.5011738, 0, 'Josafat Domingos', '921504964', '12234567JF', 'josafat@gmail.com', 'Bairro-Vila do Gamek', NULL, 1, 'FACTURA', 0, '-REF 77', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 6, 27, 2, 1, NULL, '2020-07-16 17:57:05', '2020-07-16 17:57:05', '2020-07-31'),
	(78, 360.72267, 387.77687025, 5000, 4612.22312975, 'trezentos e oitenta e sete vírgula setenta e oito', 1, 0, 50.5011738, 0, 'Josafat Domingos', '921504964', '12234567JF', 'josafat@gmail.com', 'Bairro-Vila do Gamek', NULL, 1, 'FACTURA', 23.44697355, '-REF 78', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 6, 27, 2, 1, NULL, '2020-07-16 17:59:01', '2020-07-16 17:59:01', '2020-07-31'),
	(79, 1082.16801, 1233.6715314, 2000, 766.3284686, 'mil duzentos e trinta e três vírgula sessenta e sete', 1, 0, 151.5035214, 0, 'Osvaldo Ramos', 'Osvaldo', 'SDFDKLDF', 'osvaldo@gmail.com', 'Viana', NULL, 3, 'FACTURA', 0, '-REF 79', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 19, 27, 2, 1, NULL, '2020-07-16 18:01:13', '2020-07-16 18:01:13', '2020-07-31'),
	(80, 721.44534, 822.4476876, 10000, 9177.5523124, 'oitocentos e vinte e dois vírgula quarenta e cinco', 1, 0, 101.0023476, 0, 'Osvaldo Ramos', 'Osvaldo', 'SDFDKLDF', 'osvaldo@gmail.com', 'Viana', NULL, 2, 'FACTURA', 0, '-REF 80', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 19, 27, 2, 1, NULL, '2020-07-16 18:10:15', '2020-07-16 18:10:15', '2020-07-31'),
	(81, 721.44534, 822.4476876, 10000, 9177.5523124, 'oitocentos e vinte e dois vírgula quarenta e cinco', 1, 0, 101.0023476, 0, 'Laurindo', 'Laurindo', 'MMDFDFD', 'laurindo@gmail.com', 'Viana', NULL, 2, 'FACTURA', 0, '-REF 81', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 14, 27, 2, 1, NULL, '2020-07-16 18:16:32', '2020-07-16 18:16:32', '2020-07-31'),
	(82, 721.44534, 822.4476876, 5000, 4177.5523124, 'oitocentos e vinte e dois vírgula quarenta e cinco', 1, 0, 101.0023476, 0, 'dfdfdfdfd', 'FDS', 'FDFDFDFDF', 'companfdfdy@gmail.com', 'Viana', NULL, 2, 'FACTURA', 0, '-REF 82', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 17, 27, 2, 1, NULL, '2020-07-16 18:20:55', '2020-07-16 18:20:55', '2020-07-31'),
	(83, 1082.16801, 1233.6715314, 5000, 3766.3284686, 'mil duzentos e trinta e três vírgula sessenta e sete', 1, 0, 151.5035214, 0, 'Josafat Domingos', '921504964', '12234567JF', 'josafat@gmail.com', 'Bairro-Vila do Gamek', NULL, 3, 'FACTURA', 0, '-REF 83', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 6, 27, 2, 1, NULL, '2020-07-16 18:21:47', '2020-07-16 18:21:47', '2020-07-31'),
	(84, 721.44534, 775.5537405, 5000, 4224.4462595, 'setecentos e setenta e cinco vírgula cinquenta e cinco', 1, 0, 101.0023476, 0, 'Osvaldo Ramos', 'Osvaldo', 'SDFDKLDF', 'osvaldo@gmail.com', 'Viana', NULL, 2, 'FACTURA', 46.8939471, '-REF 84', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 19, 27, 2, 1, NULL, '2020-07-16 18:22:44', '2020-07-16 18:22:44', '2020-07-31'),
	(85, 721.44534, 775.5537405, 5000, 4224.4462595, 'setecentos e setenta e cinco vírgula cinquenta e cinco', 1, 0, 101.0023476, 0, 'Osvaldo Ramos', 'Osvaldo', 'SDFDKLDF', 'osvaldo@gmail.com', 'Viana', NULL, 2, 'FACTURA', 46.8939471, '-REF 85', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 19, 27, 2, 1, NULL, '2020-07-16 18:22:52', '2020-07-16 18:22:52', '2020-07-31'),
	(86, 721.44534, 822.4476876, 5000, 4177.5523124, 'oitocentos e vinte e dois vírgula quarenta e cinco', 1, 0, 101.0023476, 0, 'Laurindo', 'Laurindo', 'MMDFDFD', 'laurindo@gmail.com', 'Viana', NULL, 2, 'FACTURA', 0, '-REF 86', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 14, 27, 2, 1, NULL, '2020-07-16 18:23:27', '2020-07-16 18:23:27', '2020-07-31'),
	(87, 721.44534, 822.4476876, 5000, 4177.5523124, 'oitocentos e vinte e dois vírgula quarenta e cinco', 1, 0, 101.0023476, 0, 'Laurindo', 'Laurindo', 'MMDFDFD', 'laurindo@gmail.com', 'Viana', NULL, 2, 'FACTURA', 0, '-REF 87', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 14, 27, 2, 1, NULL, '2020-07-16 18:23:43', '2020-07-16 18:23:43', '2020-07-31'),
	(88, 721.44534, 822.4476876, 5000, 4177.5523124, 'oitocentos e vinte e dois vírgula quarenta e cinco', 1, 0, 101.0023476, 0, 'Josafat Domingos', '921504964', '12234567JF', 'josafat@gmail.com', 'Bairro-Vila do Gamek', NULL, 2, 'FACTURA', 0, '-REF 88', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 6, 27, 2, 1, NULL, '2020-07-16 18:27:41', '2020-07-16 18:27:41', '2020-07-31'),
	(89, 1082.16801, 1233.6715314, 50000, 48766.3284686, 'mil duzentos e trinta e três vírgula sessenta e sete', 1, 0, 151.5035214, 0, 'Laurindo', 'Laurindo', 'MMDFDFD', 'laurindo@gmail.com', 'Viana', NULL, 3, 'FACTURA', 0, '-REF 89', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 14, 27, 2, 1, NULL, '2020-07-16 18:29:12', '2020-07-16 18:29:12', '2020-07-31'),
	(90, 721.44534, 822.4476876, 1000, 177.5523124, 'oitocentos e vinte e dois vírgula quarenta e cinco', 1, 0, 101.0023476, 0, 'FDFDFD', 'FDFDF', 'FDFDFDF', 'brunonetoDF256@gmail.com', 'Viana', NULL, 2, 'FACTURA', 0, '-REF 90', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 18, 27, 2, 1, NULL, '2020-07-16 18:30:25', '2020-07-16 18:30:25', '2020-07-31'),
	(91, 721.44534, 775.5537405, 10000, 9224.4462595, 'setecentos e setenta e cinco vírgula cinquenta e cinco', 1, 0, 101.0023476, 0, 'Osvaldo Ramos', 'Osvaldo', 'SDFDKLDF', 'osvaldo@gmail.com', 'Viana', NULL, 2, 'FACTURA PROFORMA', 46.8939471, '-REF 91', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 19, 27, 2, 1, NULL, '2020-07-16 18:32:21', '2020-07-16 18:32:21', '2020-07-31'),
	(92, 360.72267, 411.2238438, 2000, 1588.7761562, 'quatrocentos e onze vírgula vinte e dois', 1, 0, 50.5011738, 0, 'Edmundo', 'Edmundo', 'FDDFDFD', 'edmundo@gmail.com', 'Viana', NULL, 1, 'FACTURA', 0, '-REF 92', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 21, 27, 2, 1, NULL, '2020-07-16 18:33:40', '2020-07-16 18:33:40', '2020-07-31'),
	(93, 721.44534, 822.4476876, 5000, 4177.5523124, 'oitocentos e vinte e dois vírgula quarenta e cinco', 1, 0, 101.0023476, 0, 'Josafat Domingos', '921504964', '12234567JF', 'josafat@gmail.com', 'Bairro-Vila do Gamek', NULL, 2, 'FACTURA PROFORMA', 0, '-REF 93', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 6, 27, 2, 1, NULL, '2020-07-16 18:35:17', '2020-07-16 18:35:17', '2020-07-31'),
	(94, 721.44534, 822.4476876, 20000, 19177.5523124, 'oitocentos e vinte e dois vírgula quarenta e cinco', 1, 0, 101.0023476, 0, 'Laurindo', 'Laurindo', 'MMDFDFD', 'laurindo@gmail.com', 'Viana', NULL, 2, 'FACTURA', 0, '-REF 94', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 14, 27, 2, 1, NULL, '2020-07-16 18:47:50', '2020-07-16 18:47:50', '2020-07-31'),
	(95, 721.44534, 822.4476876, 20000, 19177.5523124, 'oitocentos e vinte e dois vírgula quarenta e cinco', 1, 0, 101.0023476, 0, 'Laurindo', 'Laurindo', 'MMDFDFD', 'laurindo@gmail.com', 'Viana', NULL, 2, 'FACTURA', 0, '-REF 95', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 14, 27, 2, 1, NULL, '2020-07-16 18:48:44', '2020-07-16 18:48:44', '2020-07-31'),
	(96, 360.72267, 387.77687025, 10000, 9612.22312975, 'trezentos e oitenta e sete vírgula setenta e oito', 1, 0, 50.5011738, 0, 'Josafat Domingos', '921504964', '12234567JF', 'josafat@gmail.com', 'Bairro-Vila do Gamek', NULL, 1, 'FACTURA', 23.44697355, '-REF 96', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 6, 27, 2, 1, NULL, '2020-07-16 18:49:28', '2020-07-16 18:49:28', '2020-07-31'),
	(97, 360.72267, 387.77687025, 10000, 9612.22312975, 'trezentos e oitenta e sete vírgula setenta e oito', 1, 0, 50.5011738, 0, 'Josafat Domingos', '921504964', '12234567JF', 'josafat@gmail.com', 'Bairro-Vila do Gamek', NULL, 1, 'FACTURA RECIBO', 23.44697355, '-REF 97', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 6, 27, 2, 1, NULL, '2020-07-16 18:49:35', '2020-07-16 18:49:35', '2020-07-31'),
	(98, 360.72267, 387.77687025, 10000, 9612.22312975, 'trezentos e oitenta e sete vírgula setenta e oito', 1, 0, 50.5011738, 0, 'Josafat Domingos', '921504964', '12234567JF', 'josafat@gmail.com', 'Bairro-Vila do Gamek', NULL, 1, 'FACTURA PROFORMA', 23.44697355, '-REF 98', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 6, 27, 2, 1, NULL, '2020-07-16 18:49:40', '2020-07-16 18:49:40', '2020-07-31'),
	(99, 360.72267, 387.77687025, 10000, 9612.22312975, 'trezentos e oitenta e sete vírgula setenta e oito', 1, 0, 50.5011738, 0, 'Josafat Domingos', '921504964', '12234567JF', 'josafat@gmail.com', 'Bairro-Vila do Gamek', NULL, 1, 'FACTURA PROFORMA', 23.44697355, '-REF 99', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 6, 27, 2, 1, NULL, '2020-07-16 18:51:28', '2020-07-16 18:51:28', '2020-07-31'),
	(100, 360.72267, 387.77687025, 10000, 9612.22312975, 'trezentos e oitenta e sete vírgula setenta e oito', 1, 0, 50.5011738, 0, 'Josafat Domingos', '921504964', '12234567JF', 'josafat@gmail.com', 'Bairro-Vila do Gamek', NULL, 1, 'FACTURA PROFORMA', 23.44697355, '-REF 100', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 6, 27, 2, 1, NULL, '2020-07-16 18:53:13', '2020-07-16 18:53:13', '2020-07-31'),
	(101, 360.72267, 387.77687025, 10000, 9612.22312975, 'trezentos e oitenta e sete vírgula setenta e oito', 1, 0, 50.5011738, 0, 'Josafat Domingos', '921504964', '12234567JF', 'josafat@gmail.com', 'Bairro-Vila do Gamek', NULL, 1, 'FACTURA', 23.44697355, '-REF 101', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 6, 27, 2, 1, NULL, '2020-07-16 18:53:41', '2020-07-16 18:53:41', '2020-07-31'),
	(102, 360.72267, 387.77687025, 10000, 9612.22312975, 'trezentos e oitenta e sete vírgula setenta e oito', 1, 0, 50.5011738, 0, 'Josafat Domingos', '921504964', '12234567JF', 'josafat@gmail.com', 'Bairro-Vila do Gamek', NULL, 1, 'FACTURA', 23.44697355, '-REF 102', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 6, 27, 2, 1, NULL, '2020-07-16 18:53:52', '2020-07-16 18:53:52', '2020-07-31'),
	(103, 360.72267, 387.77687025, 10000, 9612.22312975, 'trezentos e oitenta e sete vírgula setenta e oito', 1, 0, 50.5011738, 0, 'Josafat Domingos', '921504964', '12234567JF', 'josafat@gmail.com', 'Bairro-Vila do Gamek', NULL, 1, 'FACTURA PROFORMA', 23.44697355, '-REF 103', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 6, 27, 2, 1, NULL, '2020-07-16 18:54:20', '2020-07-16 18:54:20', '2020-07-31'),
	(104, 3607.2267, 3708.2290476, 10000, 6291.7709524, 'três mil setecentos e oito vírgula vinte e três', 1, 0, 101.0023476, 0, 'Josafat Domingos', '921504964', '12234567JF', 'josafat@gmail.com', 'Bairro-Vila do Gamek', NULL, 10, 'FACTURA', 0, '-REF 104', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 6, 27, 2, 1, NULL, '2020-07-16 15:30:58', '2020-07-16 15:30:58', '2020-07-31'),
	(105, 3607.2267, 3708.2290476, 10000, 6291.7709524, 'três mil setecentos e oito vírgula vinte e três', 1, 0, 101.0023476, 0, 'Josafat Domingos', '921504964', '12234567JF', 'josafat@gmail.com', 'Bairro-Vila do Gamek', NULL, 10, 'FACTURA', 0, '-REF 105', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 6, 27, 2, 1, NULL, '2020-07-16 15:31:02', '2020-07-16 15:31:02', '2020-07-31'),
	(106, 2760.72267, 2631.77687025, 10000, 7368.22312975, 'dois mil seiscentos e trinta e um vírgula setenta e oito', 1, 0, 50.5011738, 0, 'Osvaldo Ramos', 'Osvaldo', 'SDFDKLDF', 'osvaldo@gmail.com', 'Viana', NULL, 2, 'FACTURA', 179.44697355, '-REF 106', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 19, 27, 2, 1, NULL, '2020-07-16 23:10:36', '2020-07-16 23:10:36', '2020-07-31'),
	(107, 1400360.72267, 1327387.7768703, 10000000, 8672612.2231297, 'um milhão, trezentos e vinte e sete mil trezentos e oitenta e sete vírgula setenta e oito', 1, 10000, 28050.5011738, 0, 'Osvaldo Ramos', '956585215', 'SDFDKLDF', 'osvaldo@gmail.com', 'Viana', NULL, 9, 'FACTURA RECIBO', 91023.44697355, '-REF 107', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 19, 27, 2, 1, NULL, '2020-07-17 14:07:11', '2020-07-17 14:07:11', '2020-08-01'),
	(108, 1400360.72267, 1327387.7768703, 10000000, 8672612.2231297, 'um milhão, trezentos e vinte e sete mil trezentos e oitenta e sete vírgula setenta e oito', 1, 10000, 28050.5011738, 0, 'Osvaldo Ramos', '956585215', 'SDFDKLDF', 'osvaldo@gmail.com', 'Viana', NULL, 9, 'FACTURA RECIBO', 91023.44697355, '-REF 108', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 19, 27, 2, 1, NULL, '2020-07-17 14:07:13', '2020-07-17 14:07:13', '2020-08-01'),
	(109, 1400360.72267, 1327387.7768703, 10000000, 8672612.2231297, 'um milhão, trezentos e vinte e sete mil trezentos e oitenta e sete vírgula setenta e oito', 1, 10000, 28050.5011738, 0, 'Osvaldo Ramos', '956585215', 'SDFDKLDF', 'osvaldo@gmail.com', 'Viana', NULL, 9, 'FACTURA RECIBO', 91023.44697355, '-REF 109', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 19, 27, 2, 1, NULL, '2020-07-17 14:07:23', '2020-07-17 14:07:23', '2020-08-01'),
	(110, 1400360.72267, 1327387.7768703, 10000000, 8672612.2231297, 'um milhão, trezentos e vinte e sete mil trezentos e oitenta e sete vírgula setenta e oito', 1, 10000, 28050.5011738, 0, 'Osvaldo Ramos', '956585215', 'SDFDKLDF', 'osvaldo@gmail.com', 'Viana', NULL, 9, 'FACTURA RECIBO', 91023.44697355, '-REF 110', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 1, 19, 27, 2, 1, NULL, '2020-07-17 14:07:34', '2020-07-17 14:07:34', '2020-08-01'),
	(142, 1082.16801, 1233.6715314, 50000, 48766.3284686, 'mil duzentos e trinta e três vírgula sessenta e sete', 1, 0, 151.5035214, 0, 'Delfina Garcia João', '956688545', 'qqqqqqqqqq124', 'company@gmail.com1', 'Viana', NULL, 3, 'FACTURA', 0, '235904981', NULL, NULL, NULL, '$1$rasmusle$rISCgZzpwk3UhDidwXvin0', 'Não', 1, NULL, NULL, 8, 12, 27, 2, 1, NULL, '2020-08-28 11:57:27', '2020-08-28 11:57:27', '2020-09-12'),
	(143, 400360.72267, 428411.2238438, 4567899, 4139487.7761562, 'quatrocentos e vinte e oito mil quatrocentos e onze vírgula vinte e dois', 1, 0, 28050.5011738, 0, 'Mauro Domingos', '956389689', '12345678PT89', 'brunao@gmaail.com', 'Luanda-Kina xixe', NULL, 4, 'FACTURA', 0, '965251476', '965251476', 1, 'FT PAT2020/1', NULL, 'Não', 6, NULL, NULL, 1, NULL, 26, 2, 1, NULL, '2020-10-01 13:11:27', '2020-10-01 13:11:27', '2020-10-16'),
	(144, 400360.72267, 428411.2238438, 4567899, 4139487.7761562, 'quatrocentos e vinte e oito mil quatrocentos e onze vírgula vinte e dois', 1, 0, 28050.5011738, 0, 'Mauro Domingos', '956389689', '12345678PT89', 'brunao@gmaail.com', 'Luanda-Kina xixe', NULL, 4, 'FACTURA', 0, '532189421', '532189421', 2, 'FT PAT2020/2', NULL, 'Não', 6, NULL, NULL, 1, NULL, 26, 2, 1, NULL, '2020-10-01 13:12:17', '2020-10-01 13:12:17', '2020-10-16'),
	(158, 400360.72267, 326338.43000899, 124445999, 124119660.56999, 'trezentos e vinte e seis mil trezentos e trinta e oito vírgula quarenta e três', 1, 48043.2867204, 44.441032944, 0, 'sssssssssssssssss', '345677888', 'dddddd', 'bbbbbbbbbbbbbb', 'vvvvvvvvvvvvvvvvvvvvv', 'ffffffffffffff', 3, 'FACTURA RECIBO', 26023.44697355, '010869439', '010869439', 1, 'FR PAT2020/1', 'J4/NmU7mXwTI5oToDYYVcji032nE+3MPH/9VcDSt7rRrnpWDYYV0Bei66HMSh9ki1Qq9fKdi9RGonlwhb2oJaw5GBsUMnO+uhV2p+oLfCgXdgWgPVPlWWrLOqlIiAgPzt2s5uYnAJLjkySjhTxXWyvbAjpGFg6vSExEVMMr8+6E=', 'Não', 6, NULL, NULL, 1, NULL, 26, 2, 1, NULL, '2020-10-02 10:16:09', '2020-10-02 10:16:09', '2020-10-17'),
	(159, 400360.72267, 359546.65448587, 500000, 140453.34551413, 'trezentos e cinquenta e nove mil quinhentos e quarenta e seis vírgula sessenta e cinco', 1, 40036.072267, 25245.45105642, 0, 'Henrique Jorje', '921504967', '56765322KHRG', 'benvindo@gmail.com', 'Bairro-Vila do Gamek', '31.1.2.1', 4, 'FACTURA', 26023.44697355, '251695997', '251695997', 3, 'FT PAT2020/3', 'XFYQ2n/75gTM4lhx51zLvHIePcQ9Gy31CA04aG2D6kEHER56vQGZNfN1vsgFBvvXunD3ed8wBWJzqHsI41gT0Mn89mfPnHHStnwW3feM35L4obqN9Eapd0Ehf06OAO+WfW7uLAHh3xDW3JcNkcZDvpuM9UdDjeAPXtGIJ/GeXU0=', 'Não', 2, NULL, NULL, 1, 5, 26, 2, 1, NULL, '2020-10-06 10:40:18', '2020-10-06 10:40:19', '2020-10-21'),
	(160, 250360.72267, 210248.43000899, 1500000, 1289751.569991, 'duzentos e dez mil duzentos e quarenta e oito vírgula quarenta e três', 1, 30043.2867204, 6204.441032944, 0, 'Paulo João', '923504961', '56765322KH97', 'ndongalamd@gmail.com', 'Bairro-Petrangol', '31.1.2.1', 3, 'FACTURA', 16273.44697355, '128951938', '128951938', 4, 'FT PAT2020/4', 'IUnAyAdmwOUdo4UkVyRQaN3vtT6NcGqPVXBKUq8VqX5C1WcE/jcP+5DCyBDnNKQjtVvDldrdGdQsXVyJonVdAoj3b4a0hDuHPjemcBWhwoOZCgl/nPWZDwDNZvg6BgBE3Rn4O9F5yPyD+QHHvnj1eEvE9u4eP1s3JwS7/fahEjk=', 'Não', 6, NULL, NULL, 1, 3, 26, 2, 1, NULL, '2020-10-06 11:14:43', '2020-10-06 11:14:44', '2020-10-21'),
	(161, 250360.72267, 207674.31777056, 1256789, 1049114.6822294, 'duzentos e sete mil seiscentos e setenta e quatro vírgula trinta e dois', 1, 32546.8939471, 6133.936021206, 0, 'Henrique Jorje', '921504967', '56765322KHRG', 'benvindo@gmail.com', 'Bairro-Vila do Gamek', '31.1.2.1', 3, 'FACTURA RECIBO', 16273.44697355, '437121582', '437121582', 2, 'FR PAT2020/2', 'bAFYWSOVymfyZd8wxjoYEGmCw0hOk+40NsrcgNMJMWxk9rOMxCpyXA6ABeowNpG43/ln+7YLqtAIoBsbnImWWKcaPtM1LaTXjFi1U8NTHemc22FggZ48IhcVpLxMhbkWfEC/kMMBgYczd4VmK0u3FM9Bhoj+lP+wAUf128/rO68=', 'Não', 6, NULL, NULL, 1, 5, 26, 2, 1, NULL, '2020-10-06 11:18:03', '2020-10-06 11:18:03', '2020-10-21');
/*!40000 ALTER TABLE `facturas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.factura_items
CREATE TABLE IF NOT EXISTS `factura_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao_produto` varchar(250) DEFAULT '0',
  `preco_compra_produto` double NOT NULL DEFAULT '0',
  `preco_venda_produto` double NOT NULL DEFAULT '0',
  `quantidade_produto` int(10) unsigned NOT NULL,
  `desconto_produto` double DEFAULT '0',
  `incidencia_produto` double NOT NULL,
  `retencao_produto` double NOT NULL DEFAULT '0',
  `iva_produto` double NOT NULL DEFAULT '0',
  `total_preco_produto` double NOT NULL DEFAULT '0',
  `produto_id` int(10) unsigned NOT NULL,
  `factura_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_factura_items_factura` (`factura_id`),
  KEY `FK_factura_items_produtos` (`produto_id`),
  CONSTRAINT `FK_factura_items_factura` FOREIGN KEY (`factura_id`) REFERENCES `facturas` (`id`),
  CONSTRAINT `FK_factura_items_produtos` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=387 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.factura_items: ~65 rows (approximately)
/*!40000 ALTER TABLE `factura_items` DISABLE KEYS */;
INSERT INTO `factura_items` (`id`, `descricao_produto`, `preco_compra_produto`, `preco_venda_produto`, `quantidade_produto`, `desconto_produto`, `incidencia_produto`, `retencao_produto`, `iva_produto`, `total_preco_produto`, `produto_id`, `factura_id`) VALUES
	(240, 'FERRO DE ENGOMAR', 40500, 50000, 1, 7000, 43000, 3250, 0, 50000, 24, 63),
	(241, 'TOALHETES DE BANHO', 20000, 15000, 1, 2100, 12900, 975, 0, 15000, 25, 63),
	(242, 'LICENCA DEFINITIVA WINMARKET ATÉ 2PC', 20000, 45000, 1, 6300, 38700, 2925, 5418, 45000, 26, 63),
	(243, 'LICENCA ANUAL CONTSYS 1PC 1', 50000, 45000, 1, 6300, 38700, 2925, 5418, 45000, 28, 63),
	(244, 'LICENCA ANUAL CONTSYS 1PC 3', 50000, 45000, 1, 9000, 36000, 2925, 5040, 45000, 29, 64),
	(245, 'LICENCA ANUAL CONTSYS 1PC 1', 50000, 45000, 1, 9000, 36000, 2925, 5040, 45000, 28, 64),
	(246, 'TOALHETES DE BANHO', 20000, 15000, 1, 3000, 12000, 975, 0, 15000, 25, 64),
	(247, 'FERRO DE ENGOMAR', 40500, 50000, 1, 10000, 40000, 3250, 0, 50000, 24, 64),
	(248, 'COMPUTADOR HP', 343.5454, 360.72267, 1, 72.144534, 288.578136, 23.44697355, 40.40093904, 360.72267, 23, 64),
	(249, 'MÁQUINA FOTOGRAFICA', 2000, 2400, 1, 480, 1920, 156, 0, 2400, 22, 64),
	(250, 'TOALHETES DE BANHO', 20000, 15000, 1, 3000, 12000, 975, 0, 15000, 25, 65),
	(251, 'LICENCA ANUAL 4REST 5PC', 15000, 150000, 1, 30000, 120000, 9750, 16800, 150000, 27, 65),
	(252, 'LICENCA ANUAL - GSCHOOL', 750000, 200000, 1, 40000, 160000, 13000, 0, 200000, 31, 65),
	(253, 'FERRO DE ENGOMAR', 40500, 50000, 1, 0, 50000, 0, 0, 50000, 24, 66),
	(254, 'COMPUTADOR HP', 343.5454, 360.72267, 1, 0, 360.72267, 0, 50.5011738, 360.72267, 23, 66),
	(255, 'MÁQUINA FOTOGRAFICA', 2000, 2400, 1, 0, 2400, 0, 0, 2400, 22, 66),
	(256, 'TOALHETES DE BANHO', 20000, 15000, 1, 0, 15000, 0, 0, 15000, 25, 66),
	(257, 'LICENCA DEFINITIVA WINMARKET ATÉ 2PC', 20000, 45000, 1, 0, 45000, 0, 6300, 45000, 26, 66),
	(258, 'LICENCA ANUAL 4REST 5PC', 15000, 150000, 1, 0, 150000, 0, 21000, 150000, 27, 66),
	(259, 'LICENCA ANUAL CONTSYS 1PC 1', 50000, 45000, 1, 0, 45000, 0, 6300, 45000, 28, 66),
	(260, 'LICENCA ANUAL CONTSYS 1PC 3', 50000, 45000, 1, 0, 45000, 0, 6300, 45000, 29, 66),
	(261, 'IMPRESSORA TERMICA DE REDE C', 40000, 50000, 1, 0, 50000, 0, 7000, 50000, 30, 66),
	(262, 'LICENCA ANUAL - GSCHOOL', 750000, 200000, 1, 0, 200000, 0, 0, 200000, 31, 66),
	(263, 'TOALHETES DE BANHO', 20000, 15000, 1, 0, 15000, 0, 0, 15000, 25, 67),
	(264, 'FERRO DE ENGOMAR', 40500, 50000, 1, 0, 50000, 0, 0, 50000, 24, 67),
	(265, 'COMPUTADOR HP', 343.5454, 360.72267, 1, 0, 360.72267, 0, 50.5011738, 360.72267, 23, 67),
	(266, 'MÁQUINA FOTOGRAFICA', 2000, 2400, 1, 0, 2400, 156, 0, 2400, 22, 67),
	(267, 'MÁQUINA FOTOGRAFICA', 2000, 2400, 1, 0, 2400, 0, 0, 2400, 22, 68),
	(268, 'COMPUTADOR HP', 343.5454, 360.72267, 1, 0, 360.72267, 0, 50.5011738, 360.72267, 23, 68),
	(269, 'FERRO DE ENGOMAR', 40500, 50000, 2, 0, 100000, 0, 0, 100000, 24, 68),
	(270, 'LICENCA DEFINITIVA WINMARKET ATÉ 2PC', 20000, 45000, 1, 0, 45000, 0, 6300, 45000, 26, 68),
	(271, 'TOALHETES DE BANHO', 20000, 15000, 1, 0, 15000, 0, 0, 15000, 25, 68),
	(272, 'LICENCA ANUAL 4REST 5PC', 15000, 150000, 1, 0, 150000, 0, 21000, 150000, 27, 68),
	(273, 'LICENCA ANUAL CONTSYS 1PC 1', 50000, 45000, 1, 0, 45000, 0, 6300, 45000, 28, 68),
	(274, 'LICENCA ANUAL CONTSYS 1PC 3', 50000, 45000, 1, 0, 45000, 0, 6300, 45000, 29, 68),
	(275, 'IMPRESSORA TERMICA DE REDE C', 40000, 50000, 1, 0, 50000, 0, 7000, 50000, 30, 68),
	(276, 'MÁQUINA FOTOGRAFICA', 2000, 2400, 1, 0, 2400, 0, 0, 2400, 22, 69),
	(277, 'COMPUTADOR HP', 343.5454, 360.72267, 1, 0, 360.72267, 0, 50.5011738, 360.72267, 23, 69),
	(278, 'FERRO DE ENGOMAR', 40500, 50000, 1, 0, 50000, 0, 0, 50000, 24, 69),
	(279, 'LICENCA ANUAL 4REST 5PC', 15000, 150000, 1, 0, 150000, 0, 21000, 150000, 27, 69),
	(280, 'COMPUTADOR HP', 343.5454, 360.72267, 10, 721.44534, 2885.78136, 234.4697355, 282.80657328, 3607.2267, 23, 70),
	(281, 'MÁQUINA FOTOGRAFICA', 2000, 2400, 1, 480, 1920, 156, 0, 2400, 22, 70),
	(282, 'COMPUTADOR HP', 343.5454, 360.72267, 2, 0, 721.44534, 0, 101.0023476, 721.44534, 23, 71),
	(283, 'MÁQUINA FOTOGRAFICA', 2000, 2400, 1, 0, 2400, 0, 0, 2400, 22, 71),
	(284, 'MÁQUINA FOTOGRAFICA', 2000, 2400, 2, 1440, 3360, 0, 0, 4800, 22, 72),
	(285, 'COMPUTADOR HP', 343.5454, 360.72267, 10, 1082.16801, 2525.05869, 0, 353.5082166, 3607.2267, 23, 72),
	(286, 'COMPUTADOR HP', 343.5454, 360.72267, 1, 0, 360.72267, 0, 50.5011738, 360.72267, 23, 73),
	(287, 'COMPUTADOR HP', 343.5454, 360.72267, 1, 0, 360.72267, 0, 50.5011738, 360.72267, 23, 74),
	(288, 'COMPUTADOR HP', 343.5454, 360.72267, 1, 0, 360.72267, 0, 50.5011738, 360.72267, 23, 77),
	(289, 'COMPUTADOR HP', 343.5454, 360.72267, 3, 0, 1082.16801, 0, 151.5035214, 1082.16801, 23, 83),
	(290, 'COMPUTADOR HP', 343.5454, 360.72267, 2, 0, 721.44534, 0, 101.0023476, 721.44534, 23, 87),
	(291, 'COMPUTADOR HP', 343.5454, 360.72267, 3, 0, 1082.16801, 0, 151.5035214, 1082.16801, 23, 89),
	(292, 'COMPUTADOR HP', 343.5454, 360.72267, 2, 0, 721.44534, 0, 101.0023476, 721.44534, 23, 90),
	(293, 'COMPUTADOR HP', 343.5454, 360.72267, 2, 0, 721.44534, 46.8939471, 101.0023476, 721.44534, 23, 91),
	(294, 'COMPUTADOR HP', 343.5454, 360.72267, 1, 0, 360.72267, 23.44697355, 50.5011738, 360.72267, 23, 100),
	(295, 'COMPUTADOR HP', 343.5454, 360.72267, 1, 0, 360.72267, 23.44697355, 50.5011738, 360.72267, 23, 101),
	(296, 'COMPUTADOR HP', 343.5454, 360.72267, 1, 0, 360.72267, 23.44697355, 50.5011738, 360.72267, 23, 103),
	(297, 'MÁQUINA FOTOGRAFICA', 2000, 2400, 1, 0, 2400, 156, 0, 2400, 22, 106),
	(298, 'LICENCA ANUAL - GSCHOOL', 750000, 200000, 6, 0, 1200000, 78000, 0, 1200000, 31, 107),
	(299, 'LICENCA ANUAL - GSCHOOL', 750000, 200000, 6, 0, 1200000, 78000, 0, 1200000, 31, 108),
	(300, 'LICENCA ANUAL - GSCHOOL', 750000, 200000, 6, 0, 1200000, 78000, 0, 1200000, 31, 109),
	(301, 'LICENCA ANUAL - GSCHOOL', 750000, 200000, 6, 0, 1200000, 78000, 0, 1200000, 31, 110),
	(368, 'COMPUTADOR HP', 343.5454, 360.72267, 3, 0, 1082.16801, 0, 151.5035214, 1082.16801, 23, 142),
	(375, 'LICENCA ANUAL - GSCHOOL', 750000, 200000, 2, 48000, 352000, 26000, 0, 400000, 31, 158),
	(376, 'COMPUTADOR HP', 343.5454, 360.72267, 1, 43.2867204, 317.4359496, 23.44697355, 44.441032944, 360.72267, 23, 158),
	(377, 'LICENCA ANUAL - GSCHOOL', 750000, 200000, 1, 20000, 180000, 13000, 0, 200000, 31, 159),
	(378, 'COMPUTADOR HP', 343.5454, 360.72267, 1, 36.072267, 324.650403, 23.44697355, 45.45105642, 360.72267, 23, 159),
	(379, 'IMPRESSORA TERMICA DE REDE C', 40000, 50000, 1, 5000, 45000, 3250, 6300, 50000, 30, 159),
	(380, 'LICENCA ANUAL 4REST 5PC', 15000, 150000, 1, 15000, 135000, 9750, 18900, 150000, 27, 159),
	(381, 'LICENCA ANUAL - GSCHOOL', 750000, 200000, 1, 24000, 176000, 13000, 0, 200000, 31, 160),
	(382, 'COMPUTADOR HP', 343.5454, 360.72267, 1, 43.2867204, 317.4359496, 23.44697355, 44.441032944, 360.72267, 23, 160),
	(383, 'IMPRESSORA TERMICA DE REDE C', 40000, 50000, 1, 6000, 44000, 3250, 6160, 50000, 30, 160),
	(384, 'LICENCA ANUAL - GSCHOOL', 750000, 200000, 1, 26000, 174000, 13000, 0, 200000, 31, 161),
	(385, 'COMPUTADOR HP', 343.5454, 360.72267, 1, 46.8939471, 313.8287229, 23.44697355, 43.936021206, 360.72267, 23, 161),
	(386, 'IMPRESSORA TERMICA DE REDE C', 40000, 50000, 1, 6500, 43500, 3250, 6090, 50000, 30, 161);
/*!40000 ALTER TABLE `factura_items` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mutue_negocios_clientes.failed_jobs: ~0 rows (approximately)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.formas_pagamentos
CREATE TABLE IF NOT EXISTS `formas_pagamentos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  `codigo_contabilidade` varchar(45) DEFAULT NULL,
  `conta_corrente` varchar(45) NOT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_formas_pagamentos_user` (`user_id`),
  KEY `FK_formas_pagamentos_canal` (`canal_id`),
  KEY `FK_formas_pagamentos_status` (`status_id`),
  KEY `FK_formas_pagamentos_empresas` (`empresa_id`),
  CONSTRAINT `FK_formas_pagamentos_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_formas_pagamentos_empresas` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_formas_pagamentos_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_formas_pagamentos_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.formas_pagamentos: ~6 rows (approximately)
/*!40000 ALTER TABLE `formas_pagamentos` DISABLE KEYS */;
INSERT INTO `formas_pagamentos` (`id`, `designacao`, `codigo_contabilidade`, `conta_corrente`, `empresa_id`, `status_id`, `canal_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'NUMERARIO', '45.1.1', 'CAIXA 1', 27, 1, 2, NULL, '2020-06-29 16:28:23', '2020-06-29 16:28:24'),
	(2, 'MULTICAIXA', '48.2.1', 'RECEBIMENTOS EM MULTI CAIXA', 26, 1, 2, NULL, '2020-06-29 16:29:13', '2020-06-29 16:29:14'),
	(3, 'DEP. BFA', '43.1.1', 'B.F.A 73257256 - 30 - 001', 27, 1, 2, NULL, '2020-06-29 16:29:13', '2020-06-29 16:29:14'),
	(4, 'DEP. BPC', '43.1.3', 'BPC 0152 - J14743 - 11', 27, 1, 2, NULL, '2020-06-29 16:29:13', '2020-06-29 16:29:14'),
	(5, 'DEP. BIC', '43.1.2', 'BIC 56603038 - 10 - 001', 27, 1, 2, NULL, '2020-06-29 16:29:13', '2020-06-29 16:29:14'),
	(6, 'DEPOSITO', '31.1.1.2', 'EMPRESAS DO GRUPO', 26, 1, 2, NULL, '2020-06-29 16:29:13', '2020-06-29 16:29:14');
/*!40000 ALTER TABLE `formas_pagamentos` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.fornecedores
CREATE TABLE IF NOT EXISTS `fornecedores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(145) NOT NULL,
  `telefone_empresa` varchar(45) NOT NULL,
  `email_empresa` varchar(145) DEFAULT NULL,
  `nif` varchar(45) DEFAULT NULL,
  `website` varchar(145) DEFAULT NULL,
  `pessoal_contacto` varchar(145) DEFAULT NULL,
  `telefone_contacto` varchar(45) DEFAULT NULL,
  `email_contacto` varchar(145) DEFAULT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `data_contracto` date DEFAULT NULL,
  `pais_nacionalidade_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_fornecedores_empresa` (`empresa_id`),
  KEY `FK_fornecedores_canal` (`canal_id`),
  KEY `FK_fornecedores_status` (`status_id`),
  KEY `FK_fornecedores_user` (`user_id`),
  KEY `FK_fornecedores_pais` (`pais_nacionalidade_id`),
  CONSTRAINT `FK_fornecedores_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_fornecedores_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_fornecedores_pais` FOREIGN KEY (`pais_nacionalidade_id`) REFERENCES `paises` (`id`),
  CONSTRAINT `FK_fornecedores_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_fornecedores_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.fornecedores: ~0 rows (approximately)
/*!40000 ALTER TABLE `fornecedores` DISABLE KEYS */;
/*!40000 ALTER TABLE `fornecedores` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.gestor_clientes
CREATE TABLE IF NOT EXISTS `gestor_clientes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(145) NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_gestor_clientes_empresa` (`empresa_id`),
  KEY `FK_gestor_clientes_canal` (`canal_id`),
  KEY `FK_gestor_clientes_user` (`user_id`),
  KEY `FK_gestor_clientes_status` (`status_id`),
  CONSTRAINT `FK_gestor_clientes_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_gestor_clientes_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_gestor_clientes_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_gestor_clientes_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.gestor_clientes: ~3 rows (approximately)
/*!40000 ALTER TABLE `gestor_clientes` DISABLE KEYS */;
INSERT INTO `gestor_clientes` (`id`, `nome`, `status_id`, `canal_id`, `empresa_id`, `user_id`, `created_at`, `updated_at`) VALUES
	(1, 'Patrício Neto', 1, 2, 27, 1, '2020-05-08 17:37:49', '2020-05-08 17:37:55'),
	(2, 'Paulo', 1, 2, 26, 11, '2020-09-08 16:07:20', '2020-09-08 16:07:20'),
	(4, 'IVA907788', 1, 3, 26, 17, '2020-09-30 15:21:52', '2020-09-30 15:21:52');
/*!40000 ALTER TABLE `gestor_clientes` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.idiomas
CREATE TABLE IF NOT EXISTS `idiomas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.idiomas: ~0 rows (approximately)
/*!40000 ALTER TABLE `idiomas` DISABLE KEYS */;
/*!40000 ALTER TABLE `idiomas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.images
CREATE TABLE IF NOT EXISTS `images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `org_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mutue_negocios_clientes.images: ~0 rows (approximately)
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
/*!40000 ALTER TABLE `images` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.inventarios_empresas
CREATE TABLE IF NOT EXISTS `inventarios_empresas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `empresa_id` int(10) unsigned NOT NULL,
  `inventario_tipo_id` int(10) unsigned NOT NULL,
  `data_inventario` date NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `status` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `armazem_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_inventarios_empresas_empresa` (`empresa_id`),
  KEY `FK_inventarios_empresas_tipo` (`inventario_tipo_id`),
  KEY `FK_inventarios_empresas_user` (`user_id`),
  KEY `FK_inventarios_empresas_canal` (`canal_id`),
  KEY `FK_inventarios_empresas_status` (`status`),
  KEY `FK_inventarios_empresas_armazem` (`armazem_id`),
  CONSTRAINT `FK_inventarios_empresas_armazem` FOREIGN KEY (`armazem_id`) REFERENCES `armazens` (`id`),
  CONSTRAINT `FK_inventarios_empresas_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_inventarios_empresas_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_inventarios_empresas_status` FOREIGN KEY (`status`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_inventarios_empresas_tipo` FOREIGN KEY (`inventario_tipo_id`) REFERENCES `tipo_inventarios` (`id`),
  CONSTRAINT `FK_inventarios_empresas_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.inventarios_empresas: ~0 rows (approximately)
/*!40000 ALTER TABLE `inventarios_empresas` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventarios_empresas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.inventario_itens
CREATE TABLE IF NOT EXISTS `inventario_itens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inventario_id` int(10) unsigned NOT NULL,
  `produto_id` int(10) unsigned NOT NULL,
  `existencia_logica` int(10) unsigned NOT NULL,
  `existencia_fisica` int(10) unsigned NOT NULL,
  `diferenca` int(10) unsigned NOT NULL,
  `valor_total_diferenca` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_inventario_itens_inventario` (`inventario_id`),
  KEY `FK_inventario_itens_produto` (`produto_id`),
  CONSTRAINT `FK_inventario_itens_inventario` FOREIGN KEY (`inventario_id`) REFERENCES `inventarios_empresas` (`id`),
  CONSTRAINT `FK_inventario_itens_produto` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.inventario_itens: ~0 rows (approximately)
/*!40000 ALTER TABLE `inventario_itens` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventario_itens` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.jobs
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mutue_negocios_clientes.jobs: ~17 rows (approximately)
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
	(1, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:22;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 11:25:11.344281\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598610311, 1598610306),
	(2, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:0;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 11:26:50.152503\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598610410, 1598610405),
	(3, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:0;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 11:28:33.875650\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598610513, 1598610509),
	(4, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:0;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 11:29:53.480971\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598610593, 1598610588),
	(5, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:0;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 11:31:03.163141\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598610663, 1598610658),
	(6, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:0;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 11:33:53.418353\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598610833, 1598610828),
	(7, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:0;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 11:34:52.919906\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598610892, 1598610887),
	(8, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:0;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 11:36:23.805058\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598610983, 1598610978),
	(9, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:0;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 11:37:16.895891\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598611036, 1598611031),
	(10, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:0;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 11:38:21.573869\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598611101, 1598611096),
	(11, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:0;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 11:46:44.366489\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598611604, 1598611599),
	(12, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:0;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 11:47:10.889498\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598611630, 1598611625),
	(13, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:0;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 11:47:31.413998\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598611651, 1598611646),
	(14, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:0;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 11:51:02.740136\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598611862, 1598611857),
	(15, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:0;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 11:52:57.787113\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598611977, 1598611972),
	(16, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:0;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 11:56:00.896711\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598612160, 1598612155),
	(17, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:0;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 12:01:00.281867\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598612460, 1598612455),
	(18, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:0;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 12:01:14.280989\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598612474, 1598612469),
	(19, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa","command":"O:35:\\"App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\":10:{s:41:\\"\\u0000App\\\\Jobs\\\\JobMailPrazoLicencaEmpresa\\u0000data\\";a:4:{s:13:\\"dias_restante\\";i:0;s:4:\\"nome\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:5:\\"email\\";s:22:\\"brunoneto256@gmail.com\\";s:16:\\"pessoal_Contacto\\";s:9:\\"921504961\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 12:03:32.441273\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598612612, 1598612607),
	(20, 'default', '{"displayName":"App\\\\Jobs\\\\JobMailAtivacaoLicenca","job":"Illuminate\\\\Queue\\\\CallQueuedHandler@call","maxTries":3,"delay":null,"timeout":null,"timeoutAt":null,"data":{"commandName":"App\\\\Jobs\\\\JobMailAtivacaoLicenca","command":"O:31:\\"App\\\\Jobs\\\\JobMailAtivacaoLicenca\\":10:{s:37:\\"\\u0000App\\\\Jobs\\\\JobMailAtivacaoLicenca\\u0000data\\";a:6:{s:11:\\"data_inicio\\";s:10:\\"28-08-2020\\";s:10:\\"data_final\\";s:10:\\"28-08-2021\\";s:17:\\"dataPedidoLicenca\\";s:10:\\"28-08-2020\\";s:11:\\"nomeEmpresa\\";s:31:\\"PATSOFT DEVELOPPER CONSULTURING\\";s:12:\\"emailEmpresa\\";s:22:\\"brunoneto256@gmail.com\\";s:11:\\"tipoLicenca\\";s:5:\\"Anual\\";}s:5:\\"tries\\";i:3;s:6:\\"\\u0000*\\u0000job\\";N;s:10:\\"connection\\";N;s:5:\\"queue\\";N;s:15:\\"chainConnection\\";N;s:10:\\"chainQueue\\";N;s:5:\\"delay\\";O:25:\\"Illuminate\\\\Support\\\\Carbon\\":3:{s:4:\\"date\\";s:26:\\"2020-08-28 12:19:07.599128\\";s:13:\\"timezone_type\\";i:3;s:8:\\"timezone\\";s:13:\\"Africa\\/Luanda\\";}s:10:\\"middleware\\";a:0:{}s:7:\\"chained\\";a:0:{}}"}}', 0, NULL, 1598613547, 1598613542);
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.marcas
CREATE TABLE IF NOT EXISTS `marcas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(255) DEFAULT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_marcas_empresas` (`empresa_id`),
  KEY `FK_marcas_canais_comunicacoes` (`canal_id`),
  KEY `FK_marcas_status_gerais` (`status_id`),
  KEY `FK_marcas_users` (`user_id`),
  CONSTRAINT `FK_marcas_canais_comunicacoes` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_marcas_empresas` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_marcas_status_gerais` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_marcas_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.marcas: ~5 rows (approximately)
/*!40000 ALTER TABLE `marcas` DISABLE KEYS */;
INSERT INTO `marcas` (`id`, `designacao`, `empresa_id`, `status_id`, `user_id`, `canal_id`, `created_at`, `updated_at`) VALUES
	(1, 'Refriango', 27, 1, NULL, 2, '2020-06-19 17:34:50', '2020-06-19 17:34:51'),
	(2, 'Samsung', 27, 1, NULL, 2, '2020-06-22 20:56:10', '2020-06-22 20:56:11'),
	(3, 'Nokia', 26, 1, NULL, 2, '2020-06-22 20:57:04', '2020-06-22 20:57:09'),
	(4, 'Bamako', 27, 1, NULL, 2, '2020-06-22 21:01:15', '2020-06-22 21:01:16'),
	(5, 'Diversos', 26, 1, NULL, 2, '2020-08-05 11:12:49', '2020-08-05 11:12:50');
/*!40000 ALTER TABLE `marcas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mutue_negocios_clientes.migrations: ~0 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2020_06_02_155156_create_images_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.modelo_facturas
CREATE TABLE IF NOT EXISTS `modelo_facturas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `obs` varchar(145) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_modelo_facturas_empresa` (`empresa_id`),
  KEY `FK_modelo_facturas_user` (`user_id`),
  KEY `FK_modelo_facturas_canal` (`canal_id`),
  KEY `FK_modelo_facturas_status` (`status_id`),
  CONSTRAINT `FK_modelo_facturas_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_modelo_facturas_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_modelo_facturas_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_modelo_facturas_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.modelo_facturas: ~0 rows (approximately)
/*!40000 ALTER TABLE `modelo_facturas` DISABLE KEYS */;
/*!40000 ALTER TABLE `modelo_facturas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mutue_negocios_clientes.model_has_permissions: ~0 rows (approximately)
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) CHARACTER SET utf8 NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mutue_negocios_clientes.model_has_roles: ~6 rows (approximately)
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(5, 'App\\Models\\empresa\\User', 13),
	(5, 'App\\Models\\empresa\\User', 14),
	(5, 'App\\Models\\empresa\\User', 15),
	(7, 'App\\Models\\empresa\\User', 15),
	(5, 'App\\Models\\empresa\\User', 17),
	(7, 'App\\Models\\empresa\\User', 17);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.moedas
CREATE TABLE IF NOT EXISTS `moedas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `cambio` double DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.moedas: ~0 rows (approximately)
/*!40000 ALTER TABLE `moedas` DISABLE KEYS */;
INSERT INTO `moedas` (`id`, `designacao`, `codigo`, `cambio`) VALUES
	(1, 'AKZ', 'AOA', 1);
/*!40000 ALTER TABLE `moedas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.motivo
CREATE TABLE IF NOT EXISTS `motivo` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigoMotivo` varchar(45) NOT NULL,
  `descricao` varchar(45) NOT NULL,
  `codigoStatus` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned DEFAULT NULL,
  `status_id` int(10) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`codigo`),
  KEY `FK_motivo_canal` (`canal_id`),
  KEY `FK_motivo_user` (`user_id`),
  KEY `FK_motivo_status` (`status_id`),
  CONSTRAINT `FK_motivo_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_motivo_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_motivo_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- Dumping data for table mutue_negocios_clientes.motivo: ~25 rows (approximately)
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

-- Dumping structure for table mutue_negocios_clientes.pagamentos
CREATE TABLE IF NOT EXISTS `pagamentos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `factura_id` int(10) unsigned NOT NULL,
  `valor` double NOT NULL,
  `data_envio` datetime NOT NULL,
  `data_validacao` datetime NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `status_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_pagamentos_factura` (`factura_id`),
  KEY `FK_pagamentos_canal` (`canal_id`),
  KEY `FK_pagamentos_user` (`user_id`),
  KEY `FK_pagamentos_status` (`status_id`),
  CONSTRAINT `FK_pagamentos_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_pagamentos_factura` FOREIGN KEY (`factura_id`) REFERENCES `facturas` (`id`),
  CONSTRAINT `FK_pagamentos_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_pagamentos_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.pagamentos: ~0 rows (approximately)
/*!40000 ALTER TABLE `pagamentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pagamentos` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.paises
CREATE TABLE IF NOT EXISTS `paises` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  `sigla` varchar(45) DEFAULT NULL,
  `indicativo` varchar(45) DEFAULT NULL,
  `moeda_id` int(10) unsigned DEFAULT NULL,
  `idioma_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=248 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.paises: ~245 rows (approximately)
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

-- Dumping structure for table mutue_negocios_clientes.parametros
CREATE TABLE IF NOT EXISTS `parametros` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) DEFAULT NULL,
  `valor` varchar(45) DEFAULT NULL,
  `vida` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.parametros: ~18 rows (approximately)
/*!40000 ALTER TABLE `parametros` DISABLE KEYS */;
INSERT INTO `parametros` (`id`, `designacao`, `valor`, `vida`) VALUES
	(8, 'IPC', '0.05', 0),
	(9, 'cambio', '190', 0),
	(10, 'N.º Mes Paragem Vendas de Produto', NULL, 9),
	(11, 'N.º Mes Alerta Vendas de Produto', NULL, 5),
	(12, 'Nº Minimo de Alerta Existencia dos Produtos', NULL, 21),
	(13, 'Valor Desconto', '100', 100),
	(14, 'Retencao na fonte', '6.5', 7),
	(15, 'hora', '22:00:00', 22),
	(16, 'TipoImpreensao', 'A4', 1),
	(17, 'NotaEntrega', 'SIM', 1),
	(18, 'CartaRecompesa', 'SIM', 1),
	(19, 'LayoutVenda', 'Classico', 1),
	(20, 'Nº Dias Vencimento Factura', NULL, 15),
	(21, 'IVA', NULL, 1),
	(22, 'Deposito de valor', NULL, 1),
	(23, 'Nº Dias Vencimento Factura Proforma', NULL, 15),
	(24, 'Sigla da empresa', 'AGT', 0),
	(25, 'Multa factura', '10', 0);
/*!40000 ALTER TABLE `parametros` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mutue_negocios_clientes.permissions: ~8 rows (approximately)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'gerir utilizadores', 'web', '2020-05-04 20:07:01', '2020-05-04 20:07:02'),
	(2, 'gerir permissões', 'web', '2020-05-18 05:08:13', '2020-05-18 05:08:15'),
	(3, 'gerir licenças', 'web', '2020-05-18 05:09:05', '2020-05-18 05:09:06'),
	(4, 'consultar licenças', 'web', '2020-05-18 05:10:17', '2020-05-18 05:10:19'),
	(5, 'gerir fornecedores', 'web', '2020-05-18 05:11:34', '2020-05-18 05:11:36'),
	(6, 'gerir empresas', 'web', '2020-05-18 05:14:35', '2020-05-18 05:14:36'),
	(7, 'gerir clientes', 'web', '2020-05-20 00:55:52', '2020-05-20 00:55:53'),
	(8, 'gerir funcionario', 'web', '2020-05-20 00:56:24', '2020-05-20 00:56:26');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.precos
CREATE TABLE IF NOT EXISTS `precos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `produto_is` int(10) unsigned NOT NULL,
  `preco` double NOT NULL,
  `descricao` varchar(145) DEFAULT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_precos_user` (`user_id`),
  KEY `FK_precos_status` (`status_id`),
  KEY `FK_precos_canal` (`canal_id`),
  CONSTRAINT `FK_precos_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_precos_produto` FOREIGN KEY (`id`) REFERENCES `produtos` (`id`),
  CONSTRAINT `FK_precos_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_precos_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.precos: ~0 rows (approximately)
/*!40000 ALTER TABLE `precos` DISABLE KEYS */;
/*!40000 ALTER TABLE `precos` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.produtos
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(145) NOT NULL,
  `preco_venda` double NOT NULL,
  `preco_compra` double NOT NULL,
  `marca_id` int(10) unsigned DEFAULT NULL,
  `categoria_id` int(10) unsigned DEFAULT NULL,
  `classe_id` int(10) unsigned DEFAULT NULL,
  `unidade_medida_id` int(10) unsigned DEFAULT NULL,
  `fabricante_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `codigo_taxa` int(10) unsigned NOT NULL,
  `motivo_isencao_id` int(10) unsigned DEFAULT NULL,
  `quantidade_minima` int(10) unsigned DEFAULT NULL,
  `quantidade_critica` int(10) unsigned DEFAULT NULL,
  `imagem_produto` varchar(145) DEFAULT NULL,
  `referencia` varchar(45) DEFAULT NULL,
  `codigo_barra` varchar(45) DEFAULT NULL,
  `data_expiracao` date DEFAULT NULL,
  `descricao` varchar(345) DEFAULT NULL,
  `stocavel` enum('Sim','Não') DEFAULT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_produtos_empresa` (`empresa_id`),
  KEY `FK_produtos_status` (`status_id`),
  KEY `FK_produtos_canal` (`canal_id`),
  KEY `FK_produtos_user` (`user_id`),
  KEY `FK_fabricante_id` (`fabricante_id`),
  KEY `FK_produtos_motivo` (`motivo_isencao_id`),
  KEY `FK_produtos_marcas` (`marca_id`),
  KEY `FK_produtos_unidade_medidas` (`unidade_medida_id`),
  KEY `FK_produtos_categorias` (`categoria_id`),
  KEY `FK_produtos_classes` (`classe_id`),
  KEY `FK_produtos_tipoTaxa` (`codigo_taxa`),
  CONSTRAINT `FK_produtos_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_produtos_categorias` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`),
  CONSTRAINT `FK_produtos_classes` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`),
  CONSTRAINT `FK_produtos_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_produtos_fabricantes` FOREIGN KEY (`fabricante_id`) REFERENCES `fabricantes` (`id`),
  CONSTRAINT `FK_produtos_marcas` FOREIGN KEY (`marca_id`) REFERENCES `marcas` (`id`),
  CONSTRAINT `FK_produtos_motivo` FOREIGN KEY (`motivo_isencao_id`) REFERENCES `motivo` (`codigo`),
  CONSTRAINT `FK_produtos_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_produtos_tipoTaxa` FOREIGN KEY (`codigo_taxa`) REFERENCES `tipotaxa` (`codigo`),
  CONSTRAINT `FK_produtos_unidade_medidas` FOREIGN KEY (`unidade_medida_id`) REFERENCES `unidade_medidas` (`id`),
  CONSTRAINT `FK_produtos_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.produtos: ~14 rows (approximately)
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` (`id`, `designacao`, `preco_venda`, `preco_compra`, `marca_id`, `categoria_id`, `classe_id`, `unidade_medida_id`, `fabricante_id`, `user_id`, `canal_id`, `status_id`, `codigo_taxa`, `motivo_isencao_id`, `quantidade_minima`, `quantidade_critica`, `imagem_produto`, `referencia`, `codigo_barra`, `data_expiracao`, `descricao`, `stocavel`, `empresa_id`, `created_at`, `updated_at`) VALUES
	(22, 'MÁQUINA FOTOGRAFICA', 2400, 2000, 4, 4, 3, 4, 2, NULL, 2, 1, 1, 16, 6, 4, NULL, 'H34343R', 'CodigoBarraTEste', NULL, 'Teste Descriçao', 'Não', 26, '2020-06-24 19:56:41', '2020-06-24 19:56:41'),
	(23, 'COMPUTADOR HP', 360.72267, 343.5454, 4, 4, 1, 1, 2, NULL, 2, 1, 2, 24, 4, 5, NULL, 'H34353R', 'fddfdfd', NULL, 'fdafafda', 'Sim', 27, '2020-06-24 20:16:43', '2020-06-24 20:16:43'),
	(24, 'FERRO DE ENGOMAR', 50000, 40500, 4, 1, 1, 1, 2, NULL, 2, 1, 1, 12, 13, 35, NULL, 'H34283R', 'jkkkk777', NULL, 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhh', 'Sim', 27, '2020-06-29 21:15:43', '2020-06-29 21:15:43'),
	(25, 'TOALHETES DE BANHO', 15000, 20000, 4, 1, 1, 4, 2, NULL, 2, 1, 1, 7, 13, 35, NULL, 'y6788', 'jkkkk777', NULL, 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhh', 'Sim', 26, '2020-06-29 21:15:59', '2020-06-29 21:15:59'),
	(26, 'LICENCA DEFINITIVA WINMARKET ATÉ 2PC', 45000, 20000, 4, 1, 1, 4, 2, NULL, 2, 1, 2, 7, 13, 35, NULL, 'y6788', 'CCCCC', NULL, 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhh', 'Sim', 26, '2020-06-29 21:15:43', '2020-06-29 21:15:43'),
	(27, 'LICENCA ANUAL 4REST 5PC', 150000, 15000, 4, 1, 1, 2, 2, NULL, 2, 1, 2, 7, 13, 35, NULL, 'y6788', 'DDDDD', NULL, 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhh', 'Sim', 27, '2020-06-29 21:15:59', '2020-06-29 21:15:59'),
	(28, 'LICENCA ANUAL CONTSYS 1PC 1', 45000, 50000, 4, 1, 1, 1, 2, NULL, 2, 1, 2, 7, 13, 35, NULL, 'y6788', 'EEEEEE', NULL, 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhh', 'Sim', 27, '2020-06-29 21:15:59', '2020-06-29 21:15:59'),
	(29, 'LICENCA ANUAL CONTSYS 1PC 3', 45000, 50000, 4, 1, 1, 4, 2, NULL, 2, 1, 2, 7, 13, 35, NULL, 'y6788', 'EEEEEE', NULL, 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhh', 'Sim', 26, '2020-06-29 21:15:59', '2020-06-29 21:15:59'),
	(30, 'IMPRESSORA TERMICA DE REDE C', 50000, 40000, 4, 1, 1, 1, 2, NULL, 2, 1, 2, 7, 13, 35, NULL, 'y6788', 'EEEEEE', NULL, 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhh', 'Sim', 27, '2020-06-29 21:15:59', '2020-06-29 21:15:59'),
	(31, 'LICENCA ANUAL - GSCHOOL', 200000, 750000, 4, 4, 3, 1, 2, NULL, 2, 1, 1, 16, 6, 4, NULL, 'H343AFR', 'AAAAA', NULL, 'Teste Descriçao', 'Sim', 27, '2020-06-24 19:56:41', '2020-06-24 19:56:41'),
	(32, 'LICENCA ANUAL WINMARKET 1PC', 490000, 100000, 4, 4, 1, 4, 2, NULL, 2, 1, 1, 24, 4, 5, NULL, 'H3BB43R', 'BBBBB', NULL, 'fdafafda', 'Sim', 26, '2020-06-24 20:16:43', '2020-06-24 20:16:43'),
	(40, 'fdfdfd', 1200, 1000, 1, 1, 1, 1, 2, NULL, 2, 1, 1, 7, 1, 3, NULL, 'fdfdfd', 'fdfdfdfd', '2020-07-16', NULL, 'Sim', 27, '2020-07-16 21:46:59', '2020-07-16 21:46:59'),
	(41, 'dsdsds', 60000, 50000, 3, 1, 4, 1, 2, NULL, 2, 2, 1, 7, 1, 4, NULL, 'dsdsds', 'dsdsds', '2020-07-16', 'dsdsdsdsds', 'Sim', 27, '2020-07-16 21:57:40', '2020-07-16 21:57:40'),
	(42, 'ProdutoTeste2', 1200, 1000, 1, 1, 1, 4, 2, NULL, 2, 1, 1, 7, 1, 1, NULL, 'fdfd', 'fdfdfd', '2020-07-15', 'fdfdfdd', 'Sim', 26, '2020-07-16 22:01:04', '2020-07-16 22:01:04');
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.produtos_lojas
CREATE TABLE IF NOT EXISTS `produtos_lojas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `produto_id` int(10) unsigned NOT NULL,
  `armazem_id` int(10) unsigned NOT NULL,
  `preco_compra` int(10) unsigned NOT NULL,
  `quantidade_critica` int(10) unsigned NOT NULL,
  `preco_venda` int(10) unsigned NOT NULL,
  `quantidade_minima` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_produtos_lojas_produtos` (`produto_id`),
  KEY `FK_produtos_lojas_armazens` (`armazem_id`),
  KEY `FK_produtos_lojas_canais_comunicacoes` (`canal_id`),
  KEY `FK_produtos_lojas_users` (`user_id`),
  KEY `FK_produtos_lojas_status_gerais` (`status_id`),
  KEY `FK_produtos_lojas_empresas` (`empresa_id`),
  CONSTRAINT `FK_produtos_lojas_armazens` FOREIGN KEY (`armazem_id`) REFERENCES `armazens` (`id`),
  CONSTRAINT `FK_produtos_lojas_canais_comunicacoes` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_produtos_lojas_empresas` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_produtos_lojas_produtos` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  CONSTRAINT `FK_produtos_lojas_status_gerais` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_produtos_lojas_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.produtos_lojas: ~6 rows (approximately)
/*!40000 ALTER TABLE `produtos_lojas` DISABLE KEYS */;
INSERT INTO `produtos_lojas` (`id`, `produto_id`, `armazem_id`, `preco_compra`, `quantidade_critica`, `preco_venda`, `quantidade_minima`, `canal_id`, `user_id`, `status_id`, `empresa_id`, `created_at`, `updated_at`) VALUES
	(7, 22, 8, 2000, 4, 2400, 6, 2, NULL, 1, 27, '2020-06-24 19:56:42', '2020-06-24 19:56:42'),
	(8, 23, 8, 344, 5, 361, 4, 2, NULL, 1, 27, '2020-06-24 20:16:43', '2020-06-24 20:16:43'),
	(9, 23, 1, 2000, 5, 5000, 4, 2, NULL, 1, 27, '2020-06-24 20:16:43', '2020-06-24 20:16:43'),
	(10, 30, 1, 40000, 10, 50000, 4, 2, NULL, 1, 27, '2020-06-24 20:16:43', '2020-06-24 20:16:43'),
	(11, 31, 1, 750000, 10, 200000, 4, 2, NULL, 1, 27, '2020-06-24 20:16:43', '2020-06-24 20:16:43'),
	(12, 27, 1, 15000, 10, 150000, 4, 2, NULL, 1, 27, '2020-06-24 20:16:43', '2020-06-24 20:16:43'),
	(13, 22, 17, 256, 6, 6789, 9, 2, NULL, 1, 26, '2020-09-08 16:12:39', '2020-09-08 16:12:39');
/*!40000 ALTER TABLE `produtos_lojas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mutue_negocios_clientes.roles: ~6 rows (approximately)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'Super-Admin', 'web', '2020-05-18 00:05:05', '2020-05-18 00:05:06'),
	(2, 'Admin', 'web', '2020-05-18 00:05:41', '2020-05-18 00:05:42'),
	(3, 'Empresa', 'web', '2020-05-18 00:06:01', '2020-05-18 00:06:02'),
	(4, 'Gestor', 'web', '2020-06-02 03:13:53', '2020-06-02 03:13:53'),
	(5, 'Funcionario', 'empresa', '2020-06-09 20:22:21', '2020-06-09 20:22:23'),
	(6, 'Cliente', 'empresa', '2020-06-09 20:22:47', '2020-06-09 20:22:48'),
	(7, 'Gestor_Cliente', 'empresa', '2020-09-14 22:16:49', '2020-09-14 22:16:50'),
	(8, 'Empresa', 'empresa', '2020-10-01 16:33:37', '2020-10-01 16:33:38');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table mutue_negocios_clientes.role_has_permissions: ~13 rows (approximately)
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(5, 1),
	(6, 1),
	(7, 1),
	(8, 1),
	(1, 3),
	(4, 3),
	(5, 3),
	(7, 3),
	(8, 3);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.status_gerais
CREATE TABLE IF NOT EXISTS `status_gerais` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.status_gerais: ~2 rows (approximately)
/*!40000 ALTER TABLE `status_gerais` DISABLE KEYS */;
INSERT INTO `status_gerais` (`id`, `designacao`) VALUES
	(1, 'Activo'),
	(2, 'Desactivo');
/*!40000 ALTER TABLE `status_gerais` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.status_senha
CREATE TABLE IF NOT EXISTS `status_senha` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.status_senha: ~2 rows (approximately)
/*!40000 ALTER TABLE `status_senha` DISABLE KEYS */;
INSERT INTO `status_senha` (`id`, `designacao`) VALUES
	(1, 'Vulnerável'),
	(2, 'Segura');
/*!40000 ALTER TABLE `status_senha` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.tipos_clientes
CREATE TABLE IF NOT EXISTS `tipos_clientes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.tipos_clientes: ~6 rows (approximately)
/*!40000 ALTER TABLE `tipos_clientes` DISABLE KEYS */;
INSERT INTO `tipos_clientes` (`id`, `designacao`) VALUES
	(1, 'Singular'),
	(2, 'Instituição Privada'),
	(3, 'Instituição Publica'),
	(4, 'Sociedade Anónima'),
	(5, 'ONG'),
	(6, 'Diversos');
/*!40000 ALTER TABLE `tipos_clientes` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.tipos_contactos
CREATE TABLE IF NOT EXISTS `tipos_contactos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.tipos_contactos: ~0 rows (approximately)
/*!40000 ALTER TABLE `tipos_contactos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipos_contactos` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.tipos_regimes
CREATE TABLE IF NOT EXISTS `tipos_regimes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table mutue_negocios_clientes.tipos_regimes: ~3 rows (approximately)
/*!40000 ALTER TABLE `tipos_regimes` DISABLE KEYS */;
INSERT INTO `tipos_regimes` (`id`, `Designacao`) VALUES
	(1, 'Regime Geral'),
	(2, 'Regime Transitório'),
	(3, 'Regime de Não Sujeição (Lei n.º 7/19 de 24 de Abril)');
/*!40000 ALTER TABLE `tipos_regimes` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.tipos_stocagens
CREATE TABLE IF NOT EXISTS `tipos_stocagens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(145) NOT NULL,
  `obs` varchar(345) DEFAULT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_tipos_stocagens_status` (`status_id`),
  KEY `FK_tipos_stocagens_canal` (`canal_id`),
  KEY `FK_tipos_stocagens_user` (`user_id`),
  KEY `FK_tipos_stocagens_empresa` (`empresa_id`),
  CONSTRAINT `FK_tipos_stocagens_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_tipos_stocagens_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_tipos_stocagens_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_tipos_stocagens_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.tipos_stocagens: ~4 rows (approximately)
/*!40000 ALTER TABLE `tipos_stocagens` DISABLE KEYS */;
INSERT INTO `tipos_stocagens` (`id`, `designacao`, `obs`, `status_id`, `canal_id`, `user_id`, `empresa_id`, `created_at`, `updated_at`) VALUES
	(1, 'Mercadoria', 'produtos exclusivos de mercadoria', 1, 2, NULL, 27, '2020-06-22 20:09:28', '2020-06-22 20:09:29'),
	(2, 'Matérias Primas, subisidiárias ou de consumo', NULL, 1, 2, NULL, 27, '2020-06-22 20:11:42', '2020-06-22 20:11:43'),
	(3, 'Produtos acabados ou intermédios', NULL, 1, 2, NULL, 27, '2020-06-22 20:13:42', '2020-06-22 20:13:43'),
	(4, 'Subprodutos, disperdícios ou refugo', NULL, 1, 2, NULL, 27, '2020-06-22 20:16:54', '2020-06-22 20:16:54'),
	(5, 'Subprodutos, disperdícios ou refugo', NULL, 1, 2, NULL, 26, '2020-09-08 16:11:20', '2020-09-08 16:11:20');
/*!40000 ALTER TABLE `tipos_stocagens` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.tipos_stocagens_empresas
CREATE TABLE IF NOT EXISTS `tipos_stocagens_empresas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_stocagem_id` int(10) unsigned NOT NULL,
  `empresa_id` int(10) unsigned DEFAULT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `cana_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `obs` varchar(145) DEFAULT NULL COMMENT 'FIFO, LIFO, PMP',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_tipos_stocagens_empresas_empresa` (`empresa_id`),
  KEY `FK_tipos_stocagens_empresas_user` (`user_id`),
  KEY `FK_tipos_stocagens_empresas_canal` (`cana_id`),
  KEY `FK_tipos_stocagens_empresas_status` (`status_id`),
  KEY `FK_tipos_stocagens_empresas_tipo` (`tipo_stocagem_id`),
  CONSTRAINT `FK_tipos_stocagens_empresas_canal` FOREIGN KEY (`cana_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_tipos_stocagens_empresas_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_tipos_stocagens_empresas_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_tipos_stocagens_empresas_tipo` FOREIGN KEY (`tipo_stocagem_id`) REFERENCES `tipos_stocagens` (`id`),
  CONSTRAINT `FK_tipos_stocagens_empresas_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.tipos_stocagens_empresas: ~0 rows (approximately)
/*!40000 ALTER TABLE `tipos_stocagens_empresas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipos_stocagens_empresas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.tipotaxa
CREATE TABLE IF NOT EXISTS `tipotaxa` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `taxa` int(11) NOT NULL,
  `codigostatus` int(10) unsigned NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `FK_tipotaxa_2` (`codigostatus`),
  CONSTRAINT `FK_tipotaxa_2` FOREIGN KEY (`codigostatus`) REFERENCES `status_gerais` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table mutue_negocios_clientes.tipotaxa: ~3 rows (approximately)
/*!40000 ALTER TABLE `tipotaxa` DISABLE KEYS */;
INSERT INTO `tipotaxa` (`codigo`, `taxa`, `codigostatus`, `descricao`, `created_at`, `updated_at`) VALUES
	(1, 0, 1, 'IVA(0,00%)', NULL, NULL),
	(2, 14, 1, 'IVA(14,00%)', NULL, NULL),
	(3, 2, 2, 'IVA(2,00%)', NULL, NULL);
/*!40000 ALTER TABLE `tipotaxa` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.tipo_documentos
CREATE TABLE IF NOT EXISTS `tipo_documentos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.tipo_documentos: ~0 rows (approximately)
/*!40000 ALTER TABLE `tipo_documentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo_documentos` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.tipo_documentos_empresas
CREATE TABLE IF NOT EXISTS `tipo_documentos_empresas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_documento_id` int(10) unsigned NOT NULL,
  `next_number` int(10) unsigned NOT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `obs` varchar(145) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_tipo_documentos_empresas_tipo` (`tipo_documento_id`),
  KEY `FK_tipo_documentos_empresas_empresa` (`empresa_id`),
  KEY `FK_tipo_documentos_empresas_status` (`status_id`),
  KEY `FK_tipo_documentos_empresas_canal` (`canal_id`),
  KEY `FK_tipo_documentos_empresas_user` (`user_id`),
  CONSTRAINT `FK_tipo_documentos_empresas_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_tipo_documentos_empresas_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_tipo_documentos_empresas_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_tipo_documentos_empresas_tipo` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipo_documentos` (`id`),
  CONSTRAINT `FK_tipo_documentos_empresas_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.tipo_documentos_empresas: ~0 rows (approximately)
/*!40000 ALTER TABLE `tipo_documentos_empresas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo_documentos_empresas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.tipo_inventarios
CREATE TABLE IF NOT EXISTS `tipo_inventarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.tipo_inventarios: ~0 rows (approximately)
/*!40000 ALTER TABLE `tipo_inventarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo_inventarios` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.tipo_users
CREATE TABLE IF NOT EXISTS `tipo_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.tipo_users: ~2 rows (approximately)
/*!40000 ALTER TABLE `tipo_users` DISABLE KEYS */;
INSERT INTO `tipo_users` (`id`, `designacao`) VALUES
	(1, 'Admin'),
	(2, 'Funcionario');
/*!40000 ALTER TABLE `tipo_users` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.unidade_medidas
CREATE TABLE IF NOT EXISTS `unidade_medidas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `designacao` varchar(45) NOT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned DEFAULT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_unidade_empresa` (`empresa_id`),
  KEY `FK_unidade_user` (`user_id`),
  KEY `FK_unidade_canal` (`canal_id`),
  KEY `FK_unidade_status` (`status_id`),
  CONSTRAINT `FK_unidade_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_unidade_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_unidade_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_unidade_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.unidade_medidas: ~4 rows (approximately)
/*!40000 ALTER TABLE `unidade_medidas` DISABLE KEYS */;
INSERT INTO `unidade_medidas` (`id`, `designacao`, `empresa_id`, `user_id`, `canal_id`, `status_id`, `created_at`, `updated_at`) VALUES
	(1, 'Kg', 27, NULL, 2, 1, '2020-06-19 17:38:20', '2020-06-19 17:38:21'),
	(2, 'Litro', 27, NULL, 2, 1, '2020-06-22 20:23:57', '2020-06-22 20:23:58'),
	(3, 'Grama', 27, NULL, 2, 1, '2020-06-22 20:25:17', '2020-06-22 20:25:19'),
	(4, 'Gramas', 26, NULL, 2, 1, '2020-09-08 15:15:41', '2020-10-01 12:04:46');
/*!40000 ALTER TABLE `unidade_medidas` ENABLE KEYS */;

-- Dumping structure for table mutue_negocios_clientes.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo_user_id` int(10) unsigned NOT NULL,
  `status_id` int(10) unsigned NOT NULL,
  `status_senha_id` int(10) unsigned DEFAULT '1',
  `telefone` varchar(45) DEFAULT NULL,
  `email` varchar(245) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `canal_id` int(10) unsigned NOT NULL,
  `empresa_id` int(10) unsigned NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `telefone` (`telefone`),
  KEY `FK_users_canal` (`canal_id`),
  KEY `FK_users_tipo` (`tipo_user_id`),
  KEY `FK_users_status` (`status_id`),
  KEY `FK_users_empresa` (`empresa_id`),
  KEY `FK_users_status_senha` (`status_senha_id`),
  CONSTRAINT `FK_users_canal` FOREIGN KEY (`canal_id`) REFERENCES `canais_comunicacoes` (`id`),
  CONSTRAINT `FK_users_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_users_status` FOREIGN KEY (`status_id`) REFERENCES `status_gerais` (`id`),
  CONSTRAINT `FK_users_status_senha` FOREIGN KEY (`status_senha_id`) REFERENCES `status_senha` (`id`),
  CONSTRAINT `FK_users_tipo` FOREIGN KEY (`tipo_user_id`) REFERENCES `tipo_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- Dumping data for table mutue_negocios_clientes.users: ~4 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `username`, `password`, `remember_token`, `created_at`, `updated_at`, `tipo_user_id`, `status_id`, `status_senha_id`, `telefone`, `email`, `email_verified_at`, `canal_id`, `empresa_id`, `foto`) VALUES
	(11, 'Paulo João', 'Paulo João', '$2y$10$YrCXzgLzHE/FYr8p3mtmFOniaCjcmoh0.tpwAPv9AN5sSYcMCasx.', 'tqakQoAdLcvL3KuLfNSEcYvPz0itGICWCGxvc3WD', '2020-05-29 03:51:51', '2020-06-04 02:43:03', 2, 1, 1, '923504961', 'ndongalamd@gmail.com', NULL, 2, 13, NULL),
	(12, 'Henriques', 'Henriques', '$2y$10$f7Gso5xLR4nwbua8uT/YKOSM6z7.7.VlEUatti.MPMhUDFtpuWDOe', 'tqakQoAdLcvL3KuLfNSEcYvPz0itGICWCGxvc3WD', '2020-05-29 04:06:47', '2020-06-04 02:41:49', 2, 1, 1, '987654328', 'brunoneto25@gmail.com', NULL, 2, 13, NULL),
	(13, 'Henrique Jorje', 'Henrique Jorje', '$2y$10$Tgv8xgJ474ziqo7Voo7ulOIOSoK//n0DOm.GBvy94KY2frmcl1mzu', 'FwqlMRaLhSbH2QgS6koMlLARNByRnqiiB26szY89', '2020-06-26 16:35:43', '2020-10-05 17:04:47', 2, 1, 2, '921504967', 'benvindo@gmail.com', NULL, 2, 26, NULL),
	(17, 'IVA907788', 'IVA907788', '$2y$10$bcUhRu5I5SdT8PZOtTKx3.7DsAiLqIHQ3yvVmUMVOaL4.PVg2p1/C', 'AuaxNyko2B5zTsSfBZ19rLjQH93MUa1DgrXPn1Jg', '2020-09-30 15:21:52', '2020-09-30 15:21:52', 2, 1, 1, '963334556', NULL, NULL, 2, 26, NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
