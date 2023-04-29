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


-- Dumping database structure for contsys
CREATE DATABASE IF NOT EXISTS `contsys` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `contsys`;

-- Dumping structure for table contsys.cambios
CREATE TABLE IF NOT EXISTS `cambios` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CodMoeda` int(10) unsigned NOT NULL,
  `Valor` float NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_cambios_1` (`CodMoeda`),
  CONSTRAINT `FK_cambios_1` FOREIGN KEY (`CodMoeda`) REFERENCES `moedas` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.cambios: ~2 rows (approximately)
/*!40000 ALTER TABLE `cambios` DISABLE KEYS */;
INSERT INTO `cambios` (`Codigo`, `CodMoeda`, `Valor`) VALUES
	(1, 1, 1),
	(2, 2, 1),
	(3, 3, 115);
/*!40000 ALTER TABLE `cambios` ENABLE KEYS */;

-- Dumping structure for table contsys.centros_custo
CREATE TABLE IF NOT EXISTS `centros_custo` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.centros_custo: ~4 rows (approximately)
/*!40000 ALTER TABLE `centros_custo` DISABLE KEYS */;
INSERT INTO `centros_custo` (`Codigo`, `Designacao`) VALUES
	(1, 'ESCRITORIO'),
	(2, 'LOJA'),
	(3, 'GRAFICA'),
	(4, 'CENTRO');
/*!40000 ALTER TABLE `centros_custo` ENABLE KEYS */;

-- Dumping structure for table contsys.centro_custo
CREATE TABLE IF NOT EXISTS `centro_custo` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.centro_custo: ~2 rows (approximately)
/*!40000 ALTER TABLE `centro_custo` DISABLE KEYS */;
INSERT INTO `centro_custo` (`Codigo`, `Designacao`) VALUES
	(1, 'SEDE'),
	(2, 'LOJA'),
	(3, 'GRAFICA');
/*!40000 ALTER TABLE `centro_custo` ENABLE KEYS */;

-- Dumping structure for table contsys.classeimobilizado
CREATE TABLE IF NOT EXISTS `classeimobilizado` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(145) NOT NULL,
  `CodigoGrupo` int(10) unsigned NOT NULL,
  `Numero` varchar(15) NOT NULL,
  `TaxaAnual` float NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_classeimobilizado_1` (`CodigoGrupo`),
  CONSTRAINT `FK_classeimobilizado_1` FOREIGN KEY (`CodigoGrupo`) REFERENCES `grupo` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.classeimobilizado: ~65 rows (approximately)
/*!40000 ALTER TABLE `classeimobilizado` DISABLE KEYS */;
INSERT INTO `classeimobilizado` (`Codigo`, `Designacao`, `CodigoGrupo`, `Numero`, `TaxaAnual`) VALUES
	(1, 'CONSTRUCOES DE TIJOLO, PEDRA OU BETAO', 1, '0005', 5),
	(2, 'CONSTRUCOES DE MADEIRA COM FUNDACOES DE ALVENARIA', 1, 'OO10', 6.66),
	(3, 'ESTUFAS DE ESTRUTURA METALICA OU DE BETAO OU SIMILARES', 1, '0015', 10),
	(4, 'ESTUFAS DE ESTRUTURA DE MADEIRA', 1, '0020', 20),
	(5, 'SILOS', 1, '0025', 8.33),
	(6, 'NITREIRAS E FOSSAS', 1, '0030', 5),
	(7, 'CONSTRUCOES LIGEIRAS (EM FIBROCIMENTO, MADEIRA, ZINCO, ETC)', 1, '0035', 10),
	(8, 'APARELHAGEM E MAQUINAS ELETRONICAS', 28, '2200', 20),
	(9, 'APARELHAGEM DE REPRODUCAO DE SOM', 28, '2205', 20),
	(10, 'APARELHOS DE AR CONDICIONADO', 28, '2210', 12.5),
	(11, 'APARELHOS DE AQUECIMENTO (IRRADIAORES E OUTROS)', 28, '2215', 12.5),
	(12, 'APARELHOS DE LABORATORIO E PRECISAO', 28, '2220', 14.28),
	(13, 'APARELHOS DE VENTILACAO (VENTOINHAS E OUTROS)', 28, '2225', 12.5),
	(14, 'COMPUTADORES', 28, '2240', 33.33),
	(15, 'EQUIPAMENTOS DE CENTROS DE FORMACAO PROFISSIONAL', 28, '2245', 16.66),
	(16, 'APARELHOS TELEMOVEIS', 28, '2251', 20),
	(17, 'FERRAMENTAS E UTENSILIOS', 28, '2265', 25),
	(18, 'MAQUINAS DE ESCREVER, DE CALCULAR, DE CONTABILIDADE E DE FOTOCOPIAR', 28, '2275', 20),
	(19, 'MATERIAL DE INCENDIO (EXTINTOR E OUTORS)', 28, '2300', 25),
	(20, 'TELEVISORES', 28, '2315', 14.28),
	(21, 'ALCATIFAS', 28, '2400', 25),
	(22, 'OUTROS', 28, '2405', 12.5),
	(23, 'FILMES, DISCOS, E CASSETES', 28, '2420', 25),
	(24, 'MATERIAL DE DESENHO E TOPOGRAFIA', 28, '2425', 12.5),
	(25, 'MOILIARIO', 28, '2430', 12.5),
	(26, 'PROGRAMAS DE COMPUTADORES', 28, '2440', 33.33),
	(27, 'CONSTRUCAO DE MADEIRA COM FUNDACOES DE ALVENARIA', 1, '0010', 6.66),
	(28, 'PLANTACOES OLIVEIRA', 1, '0045', 4),
	(29, 'PLANTACOES VINHAS', 1, '0050', 5),
	(30, 'PLANTACOES AMENDOEIRAS, CITRINOS, FIGUEIRAS E NOGUEIRAS', 1, '0055', 5),
	(31, 'PLANTACOES AMOREIRAS, FRAMBOESAS, GROSSELHEIRAS E PESSEGUEIROS', 1, '0060', 14.28),
	(32, 'PLANTACOES OUTROS POMARES', 1, '0065', 10),
	(33, 'EQUIPAMENTOS MOTORIZADOS TRACTORES, CEIFEIRAS-DEBULHADORAS, MOTO-CULTIVADORES, ETC', 1, '0075', 16.66),
	(34, 'EQUIPAMENTOS NAO MOTORIZADOS ARRANCADORA-CARREGADORA, DESBASTADOR, ENSILADORA E SEMEADOR MECANICO DE PRESSAO', 1, '0090', 14.28),
	(35, 'EQUIPAMENTOS NAO MOTORIZADOS OUTROS EQUIPAMENTOS', 1, '0095', 12.5),
	(36, 'EQUIPAMENTOS ESPECIALIZADOS: EQUIPAMENTOS DE REGA EPOR ASPERSAO: BARRAGENS E REDE DE PRIMEIRA', 1, '0100', 3.33),
	(37, 'EQUIPAMENTOS ESPECIALIZADOS: EQUIPAMENTO DE REGA POS ASPERSAO REDE SECUNDARIA E CANALIZACAO ENTERRADAS', 1, '0105', 5),
	(38, 'EQUIPAMENTOS ESPECIALIZADOS:  EQUIPAMENTO DE REGA POR ASPERSAO: BARRAGENS E REDE PRIMARIA', 1, '0110', 3.33),
	(39, 'EQUIPAMENTO ESPECIALIZADO: EQUIPAMENTO DE REGA POR ASPERSAO: RESTANTE DE EQUIPAMENTO', 1, '0115', 12.5),
	(40, 'EQUIPAMENTO ESPECIALIZADO: DE VINIFICACAO', 1, '0120', 12.5),
	(41, 'MELHORAMENTOS FUNDIARIOS: SUBSOLAGEM DE EFEITO DURADOURO', 1, '0125', 33.33),
	(42, 'MELHORAMENTOS FUNDIARIOS: RIPAGENS E CORRECCOES DE SOLOS DE EFEITO DURADOURO', 1, '0130', 20),
	(43, 'MELHORAMENTOS FUNDIARIOS: BARRAGENS DE TERRA BATIDA E CHARCAS', 1, '0130-I', 5),
	(44, 'MELHORAMENTOS FUNDIARIOS: SURIBAS PROFUNDAS, TRABALHOS DE ENXUGO OU DRENAGEM, OBRAS DE DEFEDA', 1, '0135', 14.28),
	(45, 'MELHORAMENTOS FUNDIARIOS: CONTRA INUNDACOES, ETC', 1, '0140', 14.28),
	(46, 'MELHORAMENTOS FUNDIARIOS: POCOS E FUROS', 1, '0140-I', 10),
	(47, 'MELHORAMENTOS FUNDIARIOS: CERCAS', 1, '0145', 10),
	(48, 'ANIMAIS: DE TRABALHO', 1, '0150', 12.5),
	(49, 'ANIMAIS REPRODUTORES: SUINOS', 1, '0155', 33.33),
	(50, 'ANIMAIS REPRODUTORES: OUTROS', 1, '0160', 10),
	(51, 'BARCOS DE PESCA: COSTEIROS (TRAINEIRAS, E OUTRAS EMBARCACOES CUJA ARQUEACAO BRUTA OU CALADA AS CARACTERIZE COMO COSTEIRAS)', 2, '0170', 12.5),
	(52, 'BARCOS DE PESCA DE ALTO MAR: DE FERRO', 2, '0175', 7.14),
	(53, 'BARCOS DE PESCA DE ALTO MAR: DE MADEIRA', 2, '0180', 10),
	(54, 'NAVIOS-FABRICAS E NAVIOS-FRIGORIFICOS', 2, '0185', 10),
	(55, 'INSTALACOES DE CONGELACAO E CONSERVACAO', 2, '0190', 12.5),
	(56, 'APARELHOS LOCALIZADORES, DE TELEFONIA, DE RADIOGONIOMETRIA E DE RADAR', 2, '0195', 20),
	(57, 'APRESTO DE PESCA', 2, '0200', 33.33),
	(58, 'FORNOS DE INSULACAO E FUNDICAO', 3, '0220', 20),
	(59, 'EQUIPAMENTO DE MINEIRO FIXO: DE SUPERFICIE', 3, '0225', 12.5),
	(60, 'EQUIPAMENTO DE MINEIRO FIXO: DE SUBSOLO', 3, '0230', 20),
	(61, 'EQUIPAMENTO MINEIRO FIXO: VIAS FERREAS E RESPECTIVO MATERIAL ROLANTE', 3, '0235', 12.5),
	(62, 'EQUIPAMENTO MINEIRO FIXO: EQUIPAMENTO MOVEL SOBRE RODAS OU LAGARYTAS', 3, '0240', 20),
	(63, 'EQUIPAMENTO MINEIRO FIXO:  FERRAMENTAS E UTENSILIOS DE USO ESPECIFICO', 3, '0245', 33.33),
	(64, 'CARTEIRAS', 32, '11.5.1.1', 0),
	(65, 'CARRO', 20, 'TOYOTA', 5);
/*!40000 ALTER TABLE `classeimobilizado` ENABLE KEYS */;

-- Dumping structure for table contsys.classes
CREATE TABLE IF NOT EXISTS `classes` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Numero` varchar(25) NOT NULL,
  `Descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.classes: ~9 rows (approximately)
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` (`Codigo`, `Numero`, `Descricao`) VALUES
	(1, '0', 'CONTAS DE ORDEM'),
	(2, '1', 'MEIOS FIXOS E INVESTIMENTOS'),
	(3, '2', 'EXISTENCIAS'),
	(4, '3', 'TERCEIROS'),
	(5, '4', 'MEIOS MONETARIOS'),
	(6, '5', 'CAPITAL E RESERVAS'),
	(7, '6', 'PROVEITOS E GANHOS POR NATUREZA'),
	(8, '7', 'CUSTOS E PERDAS POR NATUREZA'),
	(9, '8', 'RESULTADOS');
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;

-- Dumping structure for table contsys.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(145) NOT NULL,
  `Localizacao` varchar(145) DEFAULT NULL,
  `Contactos` varchar(45) DEFAULT NULL,
  `Email` varchar(145) DEFAULT NULL,
  `CodUtilizador` int(10) unsigned NOT NULL,
  `DataCadastro` date DEFAULT NULL,
  `CodigoConta` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_clientes_1` (`CodUtilizador`),
  KEY `FK_clientes_2` (`CodigoConta`),
  CONSTRAINT `FK_clientes_1` FOREIGN KEY (`CodUtilizador`) REFERENCES `utilizadores` (`Codigo`),
  CONSTRAINT `FK_clientes_2` FOREIGN KEY (`CodigoConta`) REFERENCES `subcontas2` (`Numero`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.clientes: ~0 rows (approximately)
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Dumping structure for table contsys.codigo_documentos
CREATE TABLE IF NOT EXISTS `codigo_documentos` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `TipoDocumento` varchar(45) NOT NULL,
  `Last` int(10) unsigned NOT NULL,
  `Next` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.codigo_documentos: ~0 rows (approximately)
/*!40000 ALTER TABLE `codigo_documentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `codigo_documentos` ENABLE KEYS */;

-- Dumping structure for table contsys.contas
CREATE TABLE IF NOT EXISTS `contas` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Numero` varchar(45) NOT NULL,
  `Descricao` varchar(245) NOT NULL,
  `CodTipoConta` int(10) unsigned NOT NULL,
  `CodClasse` int(10) unsigned NOT NULL,
  `CodUtilizador` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_contas_1` (`CodClasse`),
  KEY `FK_contas_2` (`CodUtilizador`),
  KEY `FK_contas_3` (`CodTipoConta`),
  CONSTRAINT `FK_contas_1` FOREIGN KEY (`CodClasse`) REFERENCES `classes` (`Codigo`),
  CONSTRAINT `FK_contas_2` FOREIGN KEY (`CodUtilizador`) REFERENCES `utilizadores` (`Codigo`),
  CONSTRAINT `FK_contas_3` FOREIGN KEY (`CodTipoConta`) REFERENCES `tipo_contas` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.contas: ~65 rows (approximately)
/*!40000 ALTER TABLE `contas` DISABLE KEYS */;
INSERT INTO `contas` (`Codigo`, `Numero`, `Descricao`, `CodTipoConta`, `CodClasse`, `CodUtilizador`) VALUES
	(1, '11', 'IMOBILIZACOES CORPOREAS', 3, 2, 1),
	(2, '12', 'IMOBILIZACOES INCORPOREAS', 3, 2, 1),
	(3, '13', 'INVESTIMENTO FINANCEIRO', 3, 2, 1),
	(4, '14', 'IMOBILIZACOES EM CURSO', 3, 2, 1),
	(5, '18', 'AMORTIZACOES ACUMULADAS', 3, 2, 1),
	(6, '19', 'PROVISOES PARA INVESTIMENTO FINANCEIRO', 3, 2, 1),
	(7, '21', 'COMPRAS', 3, 3, 1),
	(8, '22', 'MATERIAS-PRIMAS SUBSIDIARIAS E DE CONSUMO', 3, 3, 1),
	(9, '23', 'PRODUTOS E TRABALHOS EM CURSO', 3, 3, 1),
	(10, '24', 'PRODUTOS ACABADOS E INTERMEDIOS', 3, 3, 1),
	(11, '25', 'SUB-PRODUTOS, DESPERDICIOS, RESIDUOS E REFUGOS', 3, 3, 1),
	(12, '26', 'MERCADORIAS', 3, 3, 1),
	(13, '27', 'MATERIAS-PRIMAS, MERCADORIAS E OUTROS MATERIAIS EM TRANSITO', 3, 3, 1),
	(14, '28', 'ADIANTAMENTOS POR CONTA DE COMPRAS', 3, 3, 1),
	(15, '29', 'PROVISAO PARA DEPRECIACAO DE EXISTENCIAS', 3, 3, 1),
	(16, '31', 'CLIENTES', 3, 4, 1),
	(17, '32', 'FORNECEDORES', 3, 4, 1),
	(18, '33', 'EMPRESTIMOS', 3, 4, 1),
	(19, '34', 'ESTADO', 3, 4, 1),
	(20, '35', 'ENTIDADES PARTICIPANTES  E PARTICIPADAS', 3, 4, 1),
	(21, '36', 'PESSOAL', 3, 4, 1),
	(22, '37', 'OUTROS VALORES A RECEBER E A PAGAR', 3, 4, 1),
	(23, '38', 'PROVISOES PARA COBRANCAS DUVIDOSAS', 3, 4, 1),
	(24, '39', 'PROVISOES PARA OUTROS RISCOS E ENCARGOS', 3, 4, 1),
	(25, '41', 'TITULOS NEGOCIAVEIS', 3, 5, 1),
	(26, '42', 'DEPOSITO A PRAZO', 3, 5, 1),
	(27, '43', 'DEPOSITO A ORDEM', 3, 5, 1),
	(28, '44', 'OUTROS DEPOSITOS', 3, 5, 1),
	(29, '45', 'CAIXA', 3, 5, 1),
	(30, '48', 'CONTA TRANSITORIA', 3, 5, 1),
	(31, '49', 'PROVISOES PARA APLICACOES DE TESOURARIA', 3, 5, 1),
	(32, '51', 'CAPITAL', 3, 6, 1),
	(33, '52', 'ACCOES/QUOTAS PROPRIAS', 3, 6, 1),
	(34, '53', 'PREMIOS DE EMISSAO', 3, 6, 1),
	(35, '54', 'PRESTACOES SUPLEMENTARES', 3, 6, 1),
	(36, '55', 'RESERVAS LEGAIS', 3, 6, 1),
	(37, '56', 'RESERVAS DE REAVALIACAO', 3, 6, 1),
	(38, '57', 'RESERVAS COM FINS ESPECIASIS', 3, 6, 1),
	(39, '58', 'RESERVAS LIVRES', 3, 6, 1),
	(40, '61', 'VENDAS', 2, 7, 1),
	(41, '62', 'PRESTACOES DE SERVICO', 2, 7, 1),
	(42, '63', 'OUTROS PROVEITOS OPERACIONAIS', 2, 7, 1),
	(43, '64', 'VARIACAO NOS INVESTIMENTOS DE PRODUTOS ACABADOS E DE PRODUCAO EM CURSO', 2, 7, 1),
	(44, '65', 'TRABALHOS PARA A PROPRIA EMPRESA', 2, 7, 1),
	(45, '66', 'PROVEITOS E GANHOS FINANCEIROS GERAIS', 2, 7, 1),
	(46, '67', 'PROVEITOS E GANHOS FINANCEIROS EM FILIAIS E ASSOCIADAS', 2, 7, 1),
	(47, '68', 'OUTROS PROVEITOS E GANHOS NAO OPERACIONAIS', 2, 7, 1),
	(48, '69', 'PROVEITOS E GANHOS EXTRAORDINARIOS', 2, 7, 1),
	(49, '71', 'CUSTO DAS EXISTENCIAS VENDIDAS', 1, 8, 1),
	(51, '73', 'AMORTIZACOES DO EXERCICIO', 1, 8, 1),
	(52, '75', 'OUTROS CUSTOS E PERDAS OPERACIONAIS', 1, 8, 1),
	(53, '76', 'CUSTOS E PERDAS FINANCEIOS GERAIS', 1, 8, 1),
	(54, '77', 'CUSTOS E PERDAS FINACEIROS EM FILIAIS E ASSOCIADAS', 1, 8, 1),
	(55, '78', 'OUTROS CUSTOS E PERDAS NAO OPERACIONAIS', 1, 8, 1),
	(56, '79', 'CUSTOS E PERDAS EXTRAORDINARIAS', 1, 8, 1),
	(57, '81', 'RESULTADOS TRANSITADOS', 4, 9, 1),
	(58, '82', 'RESULTADOS OPERACIONAIS', 4, 9, 1),
	(59, '83', 'RESULTADOS FINANCEIROS', 4, 9, 1),
	(60, '84', 'RESULTADOS FINANCEIROS EM FILIAIS E ASSOCIADAS', 4, 9, 1),
	(61, '85', 'RESULTADOS NAO OPERACIONAIS', 4, 9, 1),
	(62, '86', 'RESULTADOS EXTRAORDINARIOS', 4, 9, 1),
	(63, '87', 'IMPOSTOS SOBRE LUCROS', 4, 9, 1),
	(64, '88', 'RESULTADOS LIQUIDOS DO EXERCICIO', 4, 9, 1),
	(65, '89', 'DIVIDENDOS ANTECIPADOS', 4, 9, 1),
	(70, '72', 'CUSTOS COM O PESSOAL', 1, 8, 1);
/*!40000 ALTER TABLE `contas` ENABLE KEYS */;

-- Dumping structure for table contsys.depositos_clientes
CREATE TABLE IF NOT EXISTS `depositos_clientes` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CodigoMovimento` int(10) unsigned NOT NULL,
  `Valor` double NOT NULL DEFAULT '0',
  `ValorRestante` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`Codigo`),
  KEY `FK_depositos_clientes_1` (`CodigoMovimento`),
  CONSTRAINT `FK_depositos_clientes_1` FOREIGN KEY (`CodigoMovimento`) REFERENCES `movimentos` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table contsys.depositos_clientes: ~0 rows (approximately)
/*!40000 ALTER TABLE `depositos_clientes` DISABLE KEYS */;
/*!40000 ALTER TABLE `depositos_clientes` ENABLE KEYS */;

-- Dumping structure for table contsys.diarios
CREATE TABLE IF NOT EXISTS `diarios` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Numero` varchar(45) NOT NULL DEFAULT '',
  `Descricao` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.diarios: ~5 rows (approximately)
/*!40000 ALTER TABLE `diarios` DISABLE KEYS */;
INSERT INTO `diarios` (`Codigo`, `Numero`, `Descricao`) VALUES
	(1, '10', 'CAIXA'),
	(2, '20', 'BANCOS'),
	(3, '30', 'CLIENTES'),
	(4, '40', 'FORNCEDORES'),
	(5, '50', 'DIVERSOS');
/*!40000 ALTER TABLE `diarios` ENABLE KEYS */;

-- Dumping structure for table contsys.divisao
CREATE TABLE IF NOT EXISTS `divisao` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Numero` varchar(145) NOT NULL,
  `Designacao` varchar(145) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.divisao: ~8 rows (approximately)
/*!40000 ALTER TABLE `divisao` DISABLE KEYS */;
INSERT INTO `divisao` (`Codigo`, `Numero`, `Designacao`) VALUES
	(1, 'DIVISAO I', 'AGRICULTURA, CIVICULTURA, PECUARIA E PESCA'),
	(2, 'DIVISAO II', 'INDUSTRIAS EXTRACTIVAS'),
	(3, 'DIVISAO III', 'INDUSTRIAS TRANSFORMADORAS'),
	(4, 'DIVISAO IV', 'CONSTRUCAO CIVIL E OBRAS PUBLICAS'),
	(5, 'DIVISAO V', 'ELECTRICIDADE, GAS E AGUA'),
	(6, 'DIVISAO VI', 'TRANSPORTES E COMUNICACOES'),
	(7, 'DIVISAO VII', 'SERVICOS'),
	(8, 'DIVISAO I.I', '');
/*!40000 ALTER TABLE `divisao` ENABLE KEYS */;

-- Dumping structure for table contsys.empresas
CREATE TABLE IF NOT EXISTS `empresas` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(145) CHARACTER SET utf8 NOT NULL,
  `Endereco` varchar(145) DEFAULT NULL,
  `Fixo` varchar(15) DEFAULT NULL,
  `Movel` varchar(45) DEFAULT NULL,
  `CapitalSocial` float DEFAULT NULL,
  `DataCadastro` date DEFAULT NULL,
  `NIF` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.empresas: ~0 rows (approximately)
/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT INTO `empresas` (`Codigo`, `Nome`, `Endereco`, `Fixo`, `Movel`, `CapitalSocial`, `DataCadastro`, `NIF`) VALUES
	(1, 'RamosSoft', 'RUA DO G.SHOPPING, POR TRÁS DA CASA DOS FRESCOS', '222014194', '924484342', 100000, '2011-04-16', '5000467766');
/*!40000 ALTER TABLE `empresas` ENABLE KEYS */;

-- Dumping structure for table contsys.entradas_caixa
CREATE TABLE IF NOT EXISTS `entradas_caixa` (
  `Codigo` int(10) unsigned NOT NULL,
  `Valor` float NOT NULL,
  `Descricao` varchar(145) CHARACTER SET latin1 DEFAULT NULL,
  `Data` datetime DEFAULT NULL,
  `CodUtilizador` int(10) unsigned NOT NULL,
  `CodEmpresa` int(10) unsigned NOT NULL,
  `Entregou` varchar(45) CHARACTER SET latin1 NOT NULL,
  `Recebeu` varchar(45) CHARACTER SET latin1 NOT NULL,
  `CodMoeda` int(10) unsigned NOT NULL,
  `CodCliente` int(10) unsigned NOT NULL,
  `CodigoContaDebito` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Codigo`),
  KEY `FK_entradas_caixa_1` (`CodEmpresa`),
  KEY `FK_entradas_caixa_2` (`CodUtilizador`),
  KEY `FK_entradas_caixa_3` (`CodMoeda`),
  KEY `FK_entradas_caixa_4` (`CodCliente`),
  CONSTRAINT `FK_entradas_caixa_1` FOREIGN KEY (`CodEmpresa`) REFERENCES `empresas` (`Codigo`),
  CONSTRAINT `FK_entradas_caixa_2` FOREIGN KEY (`CodUtilizador`) REFERENCES `utilizadores` (`Codigo`),
  CONSTRAINT `FK_entradas_caixa_3` FOREIGN KEY (`CodMoeda`) REFERENCES `moedas` (`Codigo`),
  CONSTRAINT `FK_entradas_caixa_4` FOREIGN KEY (`CodCliente`) REFERENCES `clientes` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table contsys.entradas_caixa: ~0 rows (approximately)
/*!40000 ALTER TABLE `entradas_caixa` DISABLE KEYS */;
/*!40000 ALTER TABLE `entradas_caixa` ENABLE KEYS */;

-- Dumping structure for table contsys.gestor_clientes
CREATE TABLE IF NOT EXISTS `gestor_clientes` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(45) NOT NULL,
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_gestor_clientes_1` (`CodigoUtilizador`),
  CONSTRAINT `FK_gestor_clientes_1` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table contsys.gestor_clientes: ~0 rows (approximately)
/*!40000 ALTER TABLE `gestor_clientes` DISABLE KEYS */;
INSERT INTO `gestor_clientes` (`Codigo`, `Nome`, `CodigoUtilizador`) VALUES
	(1, 'DIVERSOS', 1);
/*!40000 ALTER TABLE `gestor_clientes` ENABLE KEYS */;

-- Dumping structure for table contsys.grupo
CREATE TABLE IF NOT EXISTS `grupo` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(145) NOT NULL,
  `CodigoDivisao` int(10) unsigned NOT NULL,
  `Numero` varchar(45) NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_grupo_1` (`CodigoDivisao`),
  CONSTRAINT `FK_grupo_1` FOREIGN KEY (`CodigoDivisao`) REFERENCES `divisao` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.grupo: ~32 rows (approximately)
/*!40000 ALTER TABLE `grupo` DISABLE KEYS */;
INSERT INTO `grupo` (`Codigo`, `Designacao`, `CodigoDivisao`, `Numero`) VALUES
	(1, 'AGRICULTURA, CIVICULTURA E PECUARIA', 1, 'GRUPO I'),
	(2, 'PESCA', 1, 'GRUPO II'),
	(3, '', 2, 'GRUPO UNICO'),
	(4, 'DE ALIMENTACAO, BEBIDAS E TABACOS', 3, 'GRUPO I'),
	(5, 'TEXTEIS', 3, 'GRUPO II'),
	(6, 'CALCAOS, VESTUARIOS E TEXTEIS EM OBRA', 3, 'GRUPO III'),
	(7, 'MADEIRA E CORTICA', 3, 'GRUPO IV'),
	(8, 'INDUSTRIAS DE PAPEL E DE ARTIGOS DE PAPEL', 3, 'GRUPO V'),
	(9, 'TIPOGRAFIA, EDITORIAIS E INDUSTRIAS CONEXAS', 3, 'GRUPO VI'),
	(10, 'INDUSTRIAS DE CURTUMES E DE ARTIGOS DE COURO E PELE (EXCEPTO CALCADOS E ARTIGOS DE VESTUARIO)', 3, 'GRUPO VII'),
	(11, 'INDUSTRIA DE BORRACHA', 3, 'GRUPO VIII'),
	(12, 'INDUSTRIAS QUIMICAS', 3, 'GRUPO IX'),
	(13, 'INDUSTRIAS DOS PRODUTOS MINERAIS NAO METALICOS', 3, 'GRUPO X'),
	(14, 'INDUSTRIAS METALURGICAS, METALOMECANICAS E DE MATERIAL ELECTRICO', 3, 'GRUPO XI'),
	(15, 'INDUSTRIAS TRANSFORMADORAS DIVERSAS', 3, 'GRUPO XII'),
	(16, '', 4, 'GRUPO UNICO'),
	(17, 'PRODUCAO, TRANSPORTE E DISTRIBUICAO DE ENERGIA ELECTRICA', 5, 'GRUPO I'),
	(18, 'PRODUCAO E DISTRIBUICAO DE GAS', 5, 'GRUPO II'),
	(19, 'CAPTACAO E DISTRIBUICAO DE AGUAS', 5, 'GRUPO III'),
	(20, 'TRANSPORTES', 6, 'GRUPO I'),
	(21, 'COMUNICACOES TELEFONICAS, TELEGRAFICAS E RADIOTELEGRAFICAS', 6, 'GRUPO II'),
	(22, 'SERVICOS DE SAUDE COM OU SEM INTERNAMENTO', 7, 'GRUPO I'),
	(23, 'SERVICOS RECREATIVOS', 7, 'GRUPO II'),
	(24, 'HOTEIS, RESTAURANTES, CAFES E ACTIVIDADES SIMILARES', 7, 'GRUPO III'),
	(25, 'SERVICOS DE HIGIENE E DE ESTETICA', 7, 'GRUPO IV'),
	(26, 'IMOVEIS', 8, 'GRUPO I'),
	(27, 'INSTALACOES', 8, 'GRUPO II'),
	(28, 'MAQUINAS, APARELHOS E FERRAMENTAS', 8, 'GRUPO III'),
	(29, 'MATERIAL ROLANTE OU DE TRANSPORTE', 8, 'GRUPO IV'),
	(30, 'ELEMENTOS DIVERSOS', 8, 'GRUPO V'),
	(31, 'GRUPO DE ALIMENTACAO, BEBIDAS E TABACO', 1, 'I.I'),
	(32, 'GRUPO V - SERVIÃ‡OS DE FORMAÃ‡ÃƒO E ENSINO', 7, '');
/*!40000 ALTER TABLE `grupo` ENABLE KEYS */;

-- Dumping structure for table contsys.imobilizados
CREATE TABLE IF NOT EXISTS `imobilizados` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Descricao` varchar(245) DEFAULT NULL,
  `ValorCompra` float DEFAULT NULL,
  `DataCompra` date DEFAULT NULL,
  `TaxaAmortizacaoAnual` float DEFAULT NULL,
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  `DataInicioAmortizacao` date DEFAULT NULL,
  `OBS` varchar(245) DEFAULT NULL,
  `CodigoClasse` int(10) unsigned NOT NULL,
  `CodEmpresa` int(10) unsigned NOT NULL,
  `CodigoPatrimonial` varchar(45) DEFAULT NULL,
  `Fornecedor` varchar(145) DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_imobilizados_1` (`CodigoUtilizador`),
  KEY `FK_imobilizados_3` (`CodEmpresa`),
  KEY `FK_imobilizados_2` (`CodigoClasse`),
  CONSTRAINT `FK_imobilizados_1` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`),
  CONSTRAINT `FK_imobilizados_2` FOREIGN KEY (`CodigoClasse`) REFERENCES `classeimobilizado` (`Codigo`),
  CONSTRAINT `FK_imobilizados_3` FOREIGN KEY (`CodEmpresa`) REFERENCES `empresas` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.imobilizados: ~3 rows (approximately)
/*!40000 ALTER TABLE `imobilizados` DISABLE KEYS */;
INSERT INTO `imobilizados` (`Codigo`, `Descricao`, `ValorCompra`, `DataCompra`, `TaxaAmortizacaoAnual`, `CodigoUtilizador`, `DataInicioAmortizacao`, `OBS`, `CodigoClasse`, `CodEmpresa`, `CodigoPatrimonial`, `Fornecedor`) VALUES
	(1, 'COMPRA DE 1 CACHORRO', 120000, '2014-02-01', 10, 1, '2014-02-03', '', 50, 1, NULL, NULL),
	(2, 'COMPUTADOR', 87500, '2015-11-08', 10, 1, '2015-11-08', '', 50, 1, 'PC001', 'RAMOSSOFT2'),
	(3, 'TOYOTA HILUX', 2000000, '2016-05-18', 5, 23, '2016-05-18', 'COMPRA PARA O DEPARTAMENTO DO RH', 65, 1, '', 'FORNECEDOR DIVERSOS');
/*!40000 ALTER TABLE `imobilizados` ENABLE KEYS */;

-- Dumping structure for table contsys.moedas
CREATE TABLE IF NOT EXISTS `moedas` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.moedas: ~3 rows (approximately)
/*!40000 ALTER TABLE `moedas` DISABLE KEYS */;
INSERT INTO `moedas` (`Codigo`, `Descricao`) VALUES
	(1, 'AKZ'),
	(2, 'USD'),
	(3, 'EUR');
/*!40000 ALTER TABLE `moedas` ENABLE KEYS */;

-- Dumping structure for table contsys.movimentos
CREATE TABLE IF NOT EXISTS `movimentos` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DataMovimento` datetime NOT NULL,
  `Descricao` varchar(1045) DEFAULT NULL,
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  `CodEmpresa` int(10) unsigned NOT NULL,
  `AnoFinanceiro` int(10) unsigned NOT NULL DEFAULT '2015',
  `CodigoStatus` int(11) NOT NULL DEFAULT '1',
  `CodigoContaDebito` int(10) unsigned NOT NULL DEFAULT '0',
  `CodigoContaCredito` int(10) unsigned NOT NULL DEFAULT '0',
  `CodigoCentroCusto` int(10) unsigned NOT NULL DEFAULT '0',
  `NextMovimento` varchar(45) DEFAULT '',
  `movimentoReferences` varchar(45) DEFAULT '',
  `CodigoFactura` varchar(200) DEFAULT '',
  `ContaCliente` varchar(200) DEFAULT '',
  `TipoMovimento` varchar(45) DEFAULT '',
  `TipoDocumento` int(10) unsigned DEFAULT NULL,
  `hash` varchar(500) NOT NULL,
  `forma` int(10) unsigned DEFAULT '1',
  PRIMARY KEY (`Codigo`),
  KEY `FK_utilizador1` (`CodigoUtilizador`),
  KEY `FK_movimentos2_2` (`CodEmpresa`),
  KEY `cod_status` (`CodigoStatus`),
  CONSTRAINT `FK_movimentos2_2` FOREIGN KEY (`CodEmpresa`) REFERENCES `empresas` (`Codigo`),
  CONSTRAINT `FK_utilizador1` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`),
  CONSTRAINT `cod_status` FOREIGN KEY (`CodigoStatus`) REFERENCES `status` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 DELAY_KEY_WRITE=1;

-- Dumping data for table contsys.movimentos: ~0 rows (approximately)
/*!40000 ALTER TABLE `movimentos` DISABLE KEYS */;
INSERT INTO `movimentos` (`Codigo`, `DataMovimento`, `Descricao`, `CodigoUtilizador`, `CodEmpresa`, `AnoFinanceiro`, `CodigoStatus`, `CodigoContaDebito`, `CodigoContaCredito`, `CodigoCentroCusto`, `NextMovimento`, `movimentoReferences`, `CodigoFactura`, `ContaCliente`, `TipoMovimento`, `TipoDocumento`, `hash`, `forma`) VALUES
	(1, '2020-05-27 10:49:59', 'VENDA A PRONTO, FACTURA RECIBO N. 1', 1, 1, 2020, 1, 0, 0, 1, '', 'null', 'null', '', 'VENDA A PRONTO', 1, 'null', 0);
/*!40000 ALTER TABLE `movimentos` ENABLE KEYS */;

-- Dumping structure for table contsys.movimentos_item
CREATE TABLE IF NOT EXISTS `movimentos_item` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CodigoConta` int(10) NOT NULL,
  `CodigoTipoMovimento` int(10) unsigned NOT NULL DEFAULT '2',
  `Valor` double NOT NULL DEFAULT '0',
  `OBS` varchar(1045) DEFAULT NULL,
  `CodigoMoeda` int(10) unsigned DEFAULT NULL,
  `Cambio` double DEFAULT NULL,
  `CodigoMovimento` int(10) unsigned NOT NULL,
  `CodigoContaDebito` int(10) unsigned NOT NULL DEFAULT '1',
  `CodigoContaCredito` int(10) unsigned NOT NULL DEFAULT '1',
  `Retencao` double DEFAULT '0',
  `RetencaoTaxa` double DEFAULT '0',
  `IVA` double DEFAULT '0',
  `IVATaxa` double DEFAULT '0',
  `CodigoDeposito` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`Codigo`),
  KEY `FK_Moeda1` (`CodigoMoeda`),
  KEY `FK_TipoMovimento1` (`CodigoTipoMovimento`),
  KEY `FK_Movimento` (`CodigoMovimento`),
  KEY `FK_movimentos_item_4` (`CodigoConta`),
  CONSTRAINT `FK_Moeda1` FOREIGN KEY (`CodigoMoeda`) REFERENCES `moedas` (`Codigo`),
  CONSTRAINT `FK_Movimento` FOREIGN KEY (`CodigoMovimento`) REFERENCES `movimentos` (`Codigo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_TipoMovimento1` FOREIGN KEY (`CodigoTipoMovimento`) REFERENCES `tipo_movimentos` (`Codigo`),
  CONSTRAINT `FK_movimentos_item_4` FOREIGN KEY (`CodigoConta`) REFERENCES `subcontas` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.movimentos_item: ~2 rows (approximately)
/*!40000 ALTER TABLE `movimentos_item` DISABLE KEYS */;
INSERT INTO `movimentos_item` (`Codigo`, `CodigoConta`, `CodigoTipoMovimento`, `Valor`, `OBS`, `CodigoMoeda`, `Cambio`, `CodigoMovimento`, `CodigoContaDebito`, `CodigoContaCredito`, `Retencao`, `RetencaoTaxa`, `IVA`, `IVATaxa`, `CodigoDeposito`) VALUES
	(1, 332, 1, 33, 'VENDA A PRONTO, FACTURA RECIBO N. 1', 1, 1, 1, 1, 1, 0, 0, 0, 0, 0),
	(2, 391, 2, 33, 'VENDA A PRONTO, FACTURA RECIBO N. 1', 1, 1, 1, 1, 1, 0, 0, 0, 0, 0);
/*!40000 ALTER TABLE `movimentos_item` ENABLE KEYS */;

-- Dumping structure for table contsys.nota_credito_items
CREATE TABLE IF NOT EXISTS `nota_credito_items` (
  `CodigoProduto` int(10) unsigned NOT NULL DEFAULT '0',
  `CodigoFactura` int(10) unsigned NOT NULL,
  `Quantidade` double NOT NULL DEFAULT '0',
  `Total` double NOT NULL DEFAULT '0',
  `TotalIPC` double NOT NULL DEFAULT '0',
  `preco` double NOT NULL DEFAULT '0',
  `descontoProduto` double DEFAULT '0',
  `dia` int(11) DEFAULT '1',
  `precoCompra` double DEFAULT '0',
  `motivoIsencao` varchar(850) DEFAULT '',
  `Descricao` varchar(250) DEFAULT '',
  `ExistenciaAnterior` double DEFAULT '0',
  `ExistenciaActual` double DEFAULT '0',
  `retencao` double DEFAULT '0',
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CodigoMovimento` int(10) unsigned NOT NULL,
  `unidadeMedida` varchar(100) NOT NULL,
  `codigoTipoTaxa` int(10) unsigned NOT NULL DEFAULT '31',
  `DescricaoProduto` varchar(250) NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_nota_credito_items_1` (`CodigoMovimento`),
  CONSTRAINT `FK_nota_credito_items_1` FOREIGN KEY (`CodigoMovimento`) REFERENCES `movimentos` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.nota_credito_items: ~0 rows (approximately)
/*!40000 ALTER TABLE `nota_credito_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `nota_credito_items` ENABLE KEYS */;

-- Dumping structure for table contsys.parametros
CREATE TABLE IF NOT EXISTS `parametros` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Descricao` varchar(45) DEFAULT NULL,
  `Valor` varchar(45) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.parametros: ~2 rows (approximately)
/*!40000 ALTER TABLE `parametros` DISABLE KEYS */;
INSERT INTO `parametros` (`Codigo`, `Descricao`, `Valor`) VALUES
	(1, '192.168.1.100', '0'),
	(2, '2095-02-04', '0');
/*!40000 ALTER TABLE `parametros` ENABLE KEYS */;

-- Dumping structure for table contsys.periodos
CREATE TABLE IF NOT EXISTS `periodos` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) NOT NULL,
  `Numero` varchar(5) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.periodos: ~16 rows (approximately)
/*!40000 ALTER TABLE `periodos` DISABLE KEYS */;
INSERT INTO `periodos` (`Codigo`, `Designacao`, `Numero`) VALUES
	(1, 'SALDOS INICIAIS', '00'),
	(2, 'JANEIRO', '01'),
	(3, 'FEVEREIRO', '02'),
	(4, 'MARCO', '03'),
	(5, 'ABRIL', '04'),
	(6, 'MAIO', '05'),
	(7, 'JUNHO', '06'),
	(8, 'JULHO', '07'),
	(9, 'AGOSTO', '08'),
	(10, 'SETEMBRO', '09'),
	(11, 'OUTUBRO', '10'),
	(12, 'NOVEMBRO', '11'),
	(13, 'DEZEMBRO', '12'),
	(14, 'AMORTIZACOES', '13'),
	(15, 'APURAMENTOS', '14'),
	(16, 'ENCERRAMENTO', '15');
/*!40000 ALTER TABLE `periodos` ENABLE KEYS */;

-- Dumping structure for table contsys.saidas_caixa
CREATE TABLE IF NOT EXISTS `saidas_caixa` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Valor` float NOT NULL,
  `Descricao` varchar(145) NOT NULL,
  `Entregou` varchar(45) NOT NULL,
  `Recebeu` varchar(45) NOT NULL,
  `Data` datetime NOT NULL,
  `CodEmpresa` int(10) unsigned NOT NULL,
  `CodUtilizador` int(10) unsigned NOT NULL,
  `ContaDebito` int(10) NOT NULL,
  `ContaCredito` int(10) NOT NULL,
  `CodigoMovimento` int(11) DEFAULT NULL,
  `CodigoStatus` int(11) NOT NULL DEFAULT '1',
  `Extenso` varchar(245) DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_saidas_caixa_1` (`CodEmpresa`),
  KEY `FK_saidas_caixa_2` (`CodUtilizador`),
  KEY `debito` (`ContaDebito`),
  KEY `credito` (`ContaCredito`),
  KEY `status` (`CodigoStatus`),
  CONSTRAINT `FK_saidas_caixa_1` FOREIGN KEY (`CodEmpresa`) REFERENCES `empresas` (`Codigo`),
  CONSTRAINT `FK_saidas_caixa_2` FOREIGN KEY (`CodUtilizador`) REFERENCES `utilizadores` (`Codigo`),
  CONSTRAINT `credito` FOREIGN KEY (`ContaCredito`) REFERENCES `subcontas` (`Codigo`),
  CONSTRAINT `debito` FOREIGN KEY (`ContaDebito`) REFERENCES `subcontas` (`Codigo`),
  CONSTRAINT `movimento` FOREIGN KEY (`Codigo`) REFERENCES `movimentos` (`Codigo`),
  CONSTRAINT `status` FOREIGN KEY (`CodigoStatus`) REFERENCES `status` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.saidas_caixa: ~0 rows (approximately)
/*!40000 ALTER TABLE `saidas_caixa` DISABLE KEYS */;
/*!40000 ALTER TABLE `saidas_caixa` ENABLE KEYS */;

-- Dumping structure for table contsys.status
CREATE TABLE IF NOT EXISTS `status` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.status: ~2 rows (approximately)
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` (`Codigo`, `Designacao`) VALUES
	(1, 'ACTIVO'),
	(2, 'DESACTIVO');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;

-- Dumping structure for table contsys.status_utilizadores
CREATE TABLE IF NOT EXISTS `status_utilizadores` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.status_utilizadores: ~2 rows (approximately)
/*!40000 ALTER TABLE `status_utilizadores` DISABLE KEYS */;
INSERT INTO `status_utilizadores` (`Codigo`, `Descricao`) VALUES
	(1, 'activo'),
	(2, 'desactivo');
/*!40000 ALTER TABLE `status_utilizadores` ENABLE KEYS */;

-- Dumping structure for table contsys.subcontas
CREATE TABLE IF NOT EXISTS `subcontas` (
  `Codigo` int(10) NOT NULL AUTO_INCREMENT,
  `Numero` varchar(45) CHARACTER SET latin1 NOT NULL,
  `Descricao` varchar(145) CHARACTER SET latin1 DEFAULT NULL,
  `CodConta` int(10) unsigned NOT NULL,
  `CodUtilizador` int(10) unsigned NOT NULL,
  `DataCadastro` datetime DEFAULT NULL,
  `CodTipoConta` int(10) unsigned NOT NULL,
  `CodEmpresa` int(10) unsigned DEFAULT '1',
  `Movimentar` varchar(3) DEFAULT 'SIM',
  PRIMARY KEY (`Codigo`),
  KEY `FK_subcontas_1` (`CodConta`),
  KEY `FK_subcontas_2` (`CodUtilizador`),
  KEY `FK_subcontas_3` (`CodTipoConta`),
  KEY `FK_subcontas_4` (`CodEmpresa`),
  CONSTRAINT `FK_subcontas_1` FOREIGN KEY (`CodConta`) REFERENCES `contas` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_subcontas_2` FOREIGN KEY (`CodUtilizador`) REFERENCES `utilizadores` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_subcontas_3` FOREIGN KEY (`CodTipoConta`) REFERENCES `tipo_contas` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_subcontas_4` FOREIGN KEY (`CodEmpresa`) REFERENCES `empresas` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=797 DEFAULT CHARSET=utf8;

-- Dumping data for table contsys.subcontas: ~705 rows (approximately)
/*!40000 ALTER TABLE `subcontas` DISABLE KEYS */;
INSERT INTO `subcontas` (`Codigo`, `Numero`, `Descricao`, `CodConta`, `CodUtilizador`, `DataCadastro`, `CodTipoConta`, `CodEmpresa`, `Movimentar`) VALUES
	(2, '11.1', 'TERRENOS E RECURSOS NATURAIS', 1, 1, '2014-02-03 00:06:13', 3, 1, 'NAO'),
	(3, '11.1.1', 'TERRENOS EM BRUTO', 1, 1, '2011-05-17 07:47:08', 3, 1, 'SIM'),
	(4, '11.1.2', 'TERRENOS COM ARRANJOS', 1, 1, '2011-05-17 07:47:53', 3, 1, 'SIM'),
	(5, '11.1.3', 'SUBSOLOS', 1, 1, '2011-05-17 07:48:28', 3, 1, 'SIM'),
	(6, '11.1.4', 'TERRENOS COM EDIFICIOS', 1, 1, '2016-08-22 11:20:28', 3, 1, 'NAO'),
	(7, '11.1.4.1', 'RELATIVOS A EDIFICIOS INDUSTRIAIS', 1, 1, '2011-05-17 07:49:26', 3, 1, 'SIM'),
	(8, '11.1.4.2', 'RELATIVOS A EDIFICIOS ADMINISTRATIVOS E COMERCIAIS', 1, 1, '2011-05-17 07:51:00', 3, 1, 'SIM'),
	(9, '11.1.4.3', 'RELATIVOS A OUTROS EDIFICIOS', 1, 1, '2011-05-17 07:52:40', 3, 1, 'SIM'),
	(10, '11.2', 'EDIFICIOS E OUTRAS CONSTRUCOES', 1, 1, '2014-02-03 00:07:35', 3, 1, 'NAO'),
	(11, '11.2.1', 'EDIFICIOS', 1, 1, '2011-05-17 07:56:12', 3, 1, 'SIM'),
	(12, '11.2.1.1', 'INTEGRADOS EM CONJUNTOS INDUSTRIAIS', 1, 1, '2011-05-17 07:56:35', 3, 1, 'SIM'),
	(13, '11.2.1.2', 'INTEGRADOS EM CONJUNTOS ADMINISTRATIVOS E COMERCIAIS', 1, 1, '2011-05-17 07:57:37', 3, 1, 'SIM'),
	(14, '11.2.1.3', 'OUTROS CONJUNTOS INDUSTRIAIS', 1, 1, '2011-05-17 07:59:01', 3, 1, 'SIM'),
	(15, '11.2.1.4', 'IMPLANTADOS EM PROPRIEDADE ALHEIA', 1, 1, '2011-05-17 07:59:50', 3, 1, 'SIM'),
	(16, '11.2.2', 'OUTRAS CONSTRUCOES', 1, 1, '2011-05-17 08:01:01', 3, 1, 'SIM'),
	(17, '11.2.3', 'INSTALACOES', 1, 1, '2011-05-17 08:01:24', 3, 1, 'SIM'),
	(19, '11.3', 'EQUIPAMENTO BASICO', 1, 1, '2014-02-03 00:07:01', 3, 1, 'NAO'),
	(20, '11.3.1', 'MATERIAL INDUSTRIAL', 1, 1, '2011-05-17 08:01:59', 3, 1, 'SIM'),
	(21, '11.3.2', 'FERRAMENTAS INDUSTRIAIS', 1, 1, '2011-05-17 08:02:30', 3, 1, 'SIM'),
	(22, '11.3.3', 'MELHORAMENTOS EM EQUIPAMENTOS BASICOS', 1, 1, '2011-05-17 08:02:55', 3, 1, 'SIM'),
	(25, '11.4', 'EQUIPAMENTO DE CARGA E TRANSPORTE', 1, 1, '2014-02-03 00:07:08', 3, 1, 'NAO'),
	(26, '11.4.1', 'EQUPAMENTOS DE CARGA', 1, 1, '2011-06-05 11:40:05', 3, 1, 'SIM'),
	(27, '11.4.2', 'MEIOS DE TRANSPORTE', 1, 1, '2011-06-05 11:40:40', 3, 1, 'SIM'),
	(28, '11.5', 'EQUIPAMENTO ADMINISTRATIVO', 1, 1, '2011-05-17 08:04:38', 3, 1, 'SIM'),
	(30, '11.5.2', 'EQUIPAMENTO INFORMATICO E COMUNICACAO', 1, 1, '2015-12-08 10:43:12', 3, 1, 'SIM'),
	(34, '11.6', 'TARAS E VASILHAME', 1, 1, '2015-12-08 10:53:30', 3, 1, 'NAO'),
	(35, '11.9', 'OUTRAS IMOBILIZACOES CORPOREAS', 1, 1, '2011-05-17 08:05:28', 3, 1, 'SIM'),
	(36, '11.9.1', 'OUTROS EQUIPAMENTOS', 1, 1, '2015-12-08 10:56:52', 3, 1, 'SIM'),
	(41, '12.2', 'DESPESAS DE INVESTIGACAO E DESENVOLVIMENTO', 2, 1, '2015-12-08 11:18:36', 3, 1, 'NAO'),
	(42, '12.3', 'PROPRIEDADE INDUSTRIAL E OUTROS DIREITOS E CONTRATOS', 2, 1, '2015-12-08 11:25:44', 3, 1, 'NAO'),
	(43, '12.3.1', 'LICENÃ‡AS', 2, 1, '2015-12-08 11:26:41', 3, 1, 'SIM'),
	(45, '12.4.1', 'DESPESAS DE CONSTITUIÃ‡ÃƒO', 2, 1, '2015-12-08 11:29:08', 3, 1, 'SIM'),
	(46, '12.9', 'OUTRAS IMOBILIZACOES INCORPOREAS', 2, 1, '2015-12-08 11:31:09', 3, 1, 'NAO'),
	(47, '12.9.1', 'OUTRAS IMOBILIZAÃ‡. INCORPOREAS', 2, 1, '2015-12-08 11:32:00', 3, 1, 'SIM'),
	(48, '13', 'INVESTIMENTOS FINANCEIROS', 3, 1, '2015-12-08 11:37:40', 3, 1, 'NAO'),
	(49, '13.1', 'EMPRESAS SUBSIDIARIAS', 3, 1, '2015-12-08 11:38:51', 3, 1, 'NAO'),
	(50, '13.1.1', 'PARTES DE CAPITAL', 3, 1, '2011-05-17 10:23:27', 3, 1, 'SIM'),
	(51, '13.1.2', 'OBRIGACOES E TITULOS DE PARTICIPACAO', 3, 1, '2011-05-17 10:23:52', 3, 1, 'SIM'),
	(52, '13.1.3', 'EMPRESTIMOS', 3, 1, '2011-05-17 10:24:36', 3, 1, 'SIM'),
	(53, '13.2', 'EMPRESAS ASSOCIADAS', 3, 1, '2015-12-08 11:44:40', 3, 1, 'NAO'),
	(54, '13.2.1', 'PARTES DE CAPITAL', 3, 1, '2011-05-17 10:25:25', 3, 1, 'SIM'),
	(55, '13.2.2', 'SUPRIMENTOS', 3, 1, '2015-12-08 11:46:01', 3, 1, 'SIM'),
	(56, '13.2.3', 'EMPRESTIMOS', 3, 1, '2011-05-17 10:30:42', 3, 1, 'SIM'),
	(57, '13.3', 'OUTRAS EMPRESAS', 3, 1, '2015-12-08 11:46:46', 3, 1, 'NAO'),
	(58, '13.3.1', 'PARTES DE CAPITAL', 3, 1, '2011-05-17 10:31:57', 3, 1, 'SIM'),
	(59, '13.3.2', 'OBRIGACOES E TITULOS DE PARTICIPACAO', 3, 1, '2011-05-17 10:32:35', 3, 1, 'SIM'),
	(60, '13.3.3', 'EMPRESTIMOS', 3, 1, '2011-05-17 10:33:49', 3, 1, 'SIM'),
	(61, '13.4', 'INVESTIMENTOS EM IMOVEIS', 3, 1, '2015-12-08 00:35:53', 3, 1, 'NAO'),
	(62, '13.5', 'FUNDOS', 3, 1, '2015-12-08 00:41:56', 3, 1, 'NAO'),
	(63, '13.9', 'OUTROS INVESTIMENTOS FINANCEIROS', 3, 1, '2015-12-08 00:42:56', 3, 1, 'NAO'),
	(64, '13.9.1', 'DIAMANTES', 3, 1, '2011-05-17 10:37:40', 3, 1, 'SIM'),
	(65, '13.9.2', 'OURO', 3, 1, '2011-05-17 10:37:56', 3, 1, 'SIM'),
	(66, '13.9.3', 'DEPOSITOS BANCARIOS', 3, 1, '2011-05-17 10:38:11', 3, 1, 'SIM'),
	(68, '14.1', 'OBRA EM CURSO', 4, 1, '2015-12-12 10:20:24', 3, 1, 'SIM'),
	(69, '14.2', 'OBRA EM CURSO', 4, 1, '2015-12-12 10:20:43', 3, 1, 'SIM'),
	(70, '14.7', 'ADIANTAMENTOS POR CONTA DE IMOBILIZADO CORPOREO', 4, 1, '2015-12-12 10:20:57', 3, 1, 'NAO'),
	(71, '14.8', 'ADIANTAMENTOS POR CONTA DE IMOBILIZADO INCORPOREO', 4, 1, '2015-12-10 10:29:47', 3, 1, 'NAO'),
	(72, '14.9', 'ADIANTAMENTOS POR CONTA DE INVESTIMENTOS FINANCEIROS', 4, 1, '2015-12-10 10:33:24', 3, 1, 'NAO'),
	(73, '18.1', 'IMOBILIZACOES CORPOREAS', 5, 1, '2015-12-11 02:37:02', 3, 1, 'NAO'),
	(74, '18.1.1', 'TERRENOS E RECURSOS NATURAIS', 5, 1, '2011-05-17 10:46:20', 3, 1, 'SIM'),
	(75, '18.1.2', 'EDIFICIOS E OUTRAS CONSTRUCOES', 5, 1, '2011-05-17 10:46:53', 3, 1, 'SIM'),
	(76, '18.1.3', 'EQUIPAMENTO BASICO', 5, 1, '2011-05-17 10:47:17', 3, 1, 'SIM'),
	(77, '18.1.4', 'EQUIPAMENTO DE CARGA E TRANSPORTE', 5, 1, '2011-05-17 10:47:37', 3, 1, 'SIM'),
	(78, '18.1.5', 'EQUIPAMENTO ADMINISTRATIVO', 5, 1, '2011-05-17 10:48:08', 3, 1, 'SIM'),
	(79, '18.1.6', 'TARAS E VASILHAME', 5, 1, '2011-05-17 10:48:33', 3, 1, 'SIM'),
	(80, '18.1.9', 'OUTRAS IMOBILIZACOES CORPOREAS', 5, 1, '2011-05-17 10:49:07', 3, 1, 'SIM'),
	(81, '18.2', 'IMOBILIZACOES INCORPOREAS', 5, 1, '2015-12-10 10:55:03', 3, 1, 'NAO'),
	(82, '18.2.1', 'TRESPASSES', 5, 1, '2011-05-17 10:50:35', 3, 1, 'SIM'),
	(83, '18.2.2', 'DESPESAS DE INVESTIGACAO E DESENVOLVIMENTO', 5, 1, '2011-05-17 10:50:47', 3, 1, 'SIM'),
	(84, '18.2.3', 'PROPRIEDADE INDUSTRIAL E OUTROS DIREITOS E CONTRATOS', 5, 1, '2011-05-17 10:51:39', 3, 1, 'SIM'),
	(85, '18.2.4', 'DESPESAS DE CONSTITUICAO', 5, 1, '2015-12-10 10:57:04', 3, 1, 'SIM'),
	(86, '18.2.9', 'OUTRAS IMOBILIZACOES INCORPOREAS', 5, 1, '2011-05-17 10:53:45', 3, 1, 'SIM'),
	(87, '18.3', 'INVESTIMENTOS FINANCEIROS EM IMOVEIS', 5, 1, '2015-12-10 10:57:59', 3, 1, 'NAO'),
	(88, '18.3.1', 'TERRENOS E RECURSOS NATURAIS', 5, 1, '2011-05-17 10:55:27', 3, 1, 'SIM'),
	(89, '18.3.2', 'EDIFICIOS E OUTRAS CONSTRUCOES', 5, 1, '2011-05-17 10:55:52', 3, 1, 'SIM'),
	(90, '19.1', 'EMPRESAS SUBSIDIARIAS', 6, 1, '2015-12-10 11:02:23', 3, 1, 'NAO'),
	(91, '19.1.1', 'PARTES DE CAPITAL', 6, 1, '2011-05-17 10:56:53', 3, 1, 'SIM'),
	(92, '19.1.2', 'OBRIGACOES E TITULOS DE PARTICIPACAO', 6, 1, '2011-05-17 10:57:47', 3, 1, 'SIM'),
	(93, '19.1.3', 'EMPRESTIMOS', 6, 1, '2011-05-17 10:58:27', 3, 1, 'SIM'),
	(94, '19.2', 'EMPRESAS ASSOCIADAS', 6, 1, '2015-12-10 11:17:17', 3, 1, 'NAO'),
	(95, '19.2.1', 'PARTES DE CAPITAL', 6, 1, '2011-05-17 10:58:57', 3, 1, 'SIM'),
	(96, '19.2.2', 'OBRIGACOES E TITULOS DE PARTICIPACAO', 6, 1, '2011-05-17 10:59:14', 3, 1, 'SIM'),
	(97, '19.2.3', 'EMPRESTIMOS', 6, 1, '2011-05-17 10:59:39', 3, 1, 'SIM'),
	(98, '19.3', 'OUTRAS EMPRESAS', 6, 1, '2015-12-10 11:49:21', 3, 1, 'NAO'),
	(99, '19.3.1', 'PARTES DE CAPITAL', 6, 1, '2011-06-05 11:47:28', 3, 1, 'SIM'),
	(100, '19.3.2', 'OBRIGACOES E TITULOS DE PARTICIPACAO', 6, 1, '2011-06-05 11:49:18', 3, 1, 'SIM'),
	(101, '19.3.3', 'EMPRESTIMOS', 6, 1, '2011-05-17 11:01:51', 3, 1, 'SIM'),
	(102, '19.4', 'FUNDOS', 6, 1, '2015-12-10 11:51:08', 3, 1, 'NAO'),
	(103, '19.4.1', 'PARTES DE CAPITAL', 6, 1, '2011-05-17 11:04:18', 3, 1, 'SIM'),
	(104, '19.9', 'OUTROS INVESTIMENTOS FINANCEIROS', 6, 1, '2015-12-10 11:53:00', 3, 1, 'NAO'),
	(105, '19.9.1', 'DIAMANTES', 6, 1, '2011-05-17 11:05:49', 3, 1, 'SIM'),
	(106, '19.9.2', 'OURO', 6, 1, '2011-05-17 11:06:05', 3, 1, 'SIM'),
	(107, '19.9.3', 'DEPOSITOS BANCARIOS', 6, 1, '2011-06-05 04:45:09', 3, 1, 'SIM'),
	(109, '21.1', 'MATERIAS-PRIMAS, SUBSIDIARIAS E DE CONSUMO', 7, 1, '2016-01-06 01:05:38', 3, 1, 'SIM'),
	(110, '21.1.1', 'MATERIAIS PRIMAS', 6, 1, '2015-12-10 11:56:48', 3, 1, 'SIM'),
	(112, '21.2', 'MERCADORIAS', 7, 1, '2015-12-10 11:59:01', 3, 1, 'NAO'),
	(113, '21.2.1', 'MATERIAL INFORMATICO', 7, 1, '2016-01-06 01:11:33', 3, 1, 'SIM'),
	(114, '21.7', 'DEVOLUCOES DE COMPRAS', 7, 1, '2015-12-10 00:03:30', 3, 1, 'NAO'),
	(115, '21.8', 'DESCONTOS E ABATIMENTOS EM COMPRAS', 7, 1, '2015-12-10 00:10:41', 3, 1, 'NAO'),
	(116, '22.1', 'MATERIAS-PRIMAS', 8, 1, '2015-12-10 00:13:41', 3, 1, 'NAO'),
	(117, '22.2', 'MATERIAS SUBSIDIARIAS', 8, 1, '2015-12-10 00:26:23', 3, 1, 'NAO'),
	(118, '22.3', 'MATERIAIS DIVERSOS', 8, 1, '2015-12-10 00:27:29', 3, 1, 'NAO'),
	(119, '22.4', 'EMBALAGENS DE CONSUMO', 8, 1, '2015-12-10 00:33:57', 3, 1, 'NAO'),
	(120, '22.5', 'OUTROS MATERIAIS', 8, 1, '2015-12-10 00:36:34', 3, 1, 'NAO'),
	(121, '23.1', 'PRODUTOS E TRABALHOS EM CURSO', 9, 1, '2015-12-10 00:38:44', 3, 1, 'SIM'),
	(122, '24.1', 'PRODUTOS ACABADOS', 10, 1, '2015-12-11 02:39:31', 3, 1, 'NAO'),
	(123, '24.2', 'PRODUTOS INTERMEDIOS', 10, 1, '2015-12-10 00:41:11', 3, 1, 'NAO'),
	(124, '24.9', 'EM PODER DE TERCEIROS', 10, 1, '2015-12-10 00:49:46', 3, 1, 'NAO'),
	(125, '25.1', 'SUB-PRODUTOS', 11, 1, '2015-12-10 01:00:55', 3, 1, 'NAO'),
	(126, '25.2', 'DESPERDICIOS, RESIDUOS E REFUGOS', 11, 1, '2015-12-10 01:02:25', 3, 1, 'NAO'),
	(128, '26.9', 'EM PODER DE TERCEIROS', 12, 1, '2015-12-10 01:05:30', 3, 1, 'NAO'),
	(129, '27.1', 'MATERIAS-PRIMAS', 13, 1, '2015-12-10 01:07:29', 3, 1, 'NAO'),
	(130, '27.2', 'OUTROS MATERIAIS', 13, 1, '2015-12-10 01:12:29', 3, 1, 'NAO'),
	(131, '27.3', 'MERCADORIAS', 13, 1, '2015-12-10 01:14:01', 3, 1, 'NAO'),
	(132, '28.1', 'MATERIAS-PRIMA E OUTR. MATERIAS', 14, 1, '2015-12-10 01:24:05', 3, 1, 'NAO'),
	(133, '28.2', 'MERCADORIAS', 14, 1, '2015-12-10 01:26:21', 3, 1, 'NAO'),
	(134, '29.2', 'MATERIAS-PRIMAS SUBSIDIARIAS E DE CONSUMO', 15, 1, '2015-12-10 01:31:18', 3, 1, 'NAO'),
	(135, '29.3', 'PRODUTOS E TRABALHOS EM CURSO', 15, 1, '2015-12-10 01:31:53', 3, 1, 'NAO'),
	(136, '29.4', 'PRODUTOS ACABADOS E INTERMEDIOS', 15, 1, '2015-12-10 01:34:22', 3, 1, 'NAO'),
	(137, '29.5', 'SUB-PRODUTOS, DESPERDICIOS, RESIDUOS E REFUGOS', 15, 1, '2015-12-10 01:35:59', 3, 1, 'NAO'),
	(138, '29.6', 'MERCADORIAS', 15, 1, '2015-12-10 01:36:42', 3, 1, 'NAO'),
	(139, '31.1', 'CLIENTES - CORRENTES', 16, 1, '2015-12-11 08:48:18', 3, 1, 'NAO'),
	(140, '31.1.1', 'GRUPO', 16, 1, '2015-12-11 08:48:43', 3, 1, 'NAO'),
	(141, '31.1.1.1', 'SUBSIDIARIAS', 16, 1, '2015-12-11 08:49:11', 3, 1, 'SIM'),
	(142, '31.1.1.2', 'ASSOCIADAS', 16, 1, '2011-05-17 11:24:40', 3, 1, 'SIM'),
	(143, '31.1.2', 'NAO GRUPO', 16, 1, '2015-12-11 08:50:27', 3, 1, 'NAO'),
	(144, '31.1.2.1', 'NACIONAIS', 16, 1, '2011-05-17 11:25:25', 3, 1, 'SIM'),
	(145, '31.1.2.2', 'ESTRANGEIROS', 16, 1, '2011-05-17 11:25:50', 3, 1, 'SIM'),
	(146, '31.2', 'CLIENTE -TITULOS A RECEBER', 16, 1, '2015-12-11 08:51:46', 3, 1, 'NAO'),
	(147, '31.2.1', 'GRUPO', 16, 1, '2015-12-11 08:52:28', 3, 1, 'NAO'),
	(148, '31.2.1.1', 'SUBSIDIARIAS', 16, 1, '2011-05-17 11:26:48', 3, 1, 'SIM'),
	(149, '31.2.1.2', 'ASSOCIADAS', 16, 1, '2011-05-17 11:27:43', 3, 1, 'SIM'),
	(150, '31.2.2', 'NAO GRUPO', 16, 1, '2015-12-11 08:53:25', 3, 1, 'NAO'),
	(151, '31.2.2.1', 'NACIONAIS', 16, 1, '2011-05-17 11:28:30', 3, 1, 'SIM'),
	(152, '31.2.2.2', 'ESTRANGEIROS', 16, 1, '2011-05-17 11:29:08', 3, 1, 'SIM'),
	(153, '31.3', 'CLIENTES - TITULOS DESCONTADOS', 16, 1, '2015-12-11 08:54:35', 3, 1, 'NAO'),
	(154, '31.3.1', 'GRUPO', 16, 1, '2015-12-11 08:55:10', 3, 1, 'NAO'),
	(155, '31.3.1.1', 'SUBSIDIARIAS', 16, 1, '2011-05-17 11:30:17', 3, 1, 'SIM'),
	(156, '31.3.1.2', 'ASSOCIADAS', 16, 1, '2011-05-17 11:30:50', 3, 1, 'SIM'),
	(157, '31.3.2', 'NAO GRUPO', 16, 1, '2015-12-11 08:56:23', 3, 1, 'NAO'),
	(158, '31.3.2.2', 'ESTRANGEIROS', 16, 1, '2015-12-12 10:22:11', 3, 1, 'SIM'),
	(159, '31.8', 'CLIENTES DE COBRANCA DUVIDOSA', 16, 1, '2015-12-11 08:59:43', 3, 1, 'NAO'),
	(160, '31.8.1', 'CLIENTES - CORRENTES', 16, 1, '2011-05-17 11:33:06', 3, 1, 'SIM'),
	(161, '31.8.2', 'CLIENTES - TITULOS', 16, 1, '2015-12-12 10:22:29', 3, 1, 'SIM'),
	(162, '31.9', 'CLIENTES - SALDOS CREDORES', 16, 1, '2015-12-11 09:00:20', 3, 1, 'NAO'),
	(163, '31.9', 'CLIENTES - SALDOS CREDORES', 16, 1, '2015-12-11 09:01:09', 3, 1, 'SIM'),
	(164, '31.9.2', 'EMBALAGENS A DEVOLVER', 16, 1, '2011-05-17 11:34:37', 3, 1, 'SIM'),
	(165, '31.9.3', 'MATERIAL A CONSIGNACAO', 16, 1, '2011-05-17 11:35:05', 3, 1, 'SIM'),
	(166, '32.1', 'FORNECEDORES - CORRENTES', 17, 1, '2011-06-05 05:40:03', 3, 1, 'SIM'),
	(167, '32.1.1', 'GRUPO', 17, 1, '2011-05-17 11:36:37', 3, 1, 'SIM'),
	(168, '32.1.1.1', 'SUBSIDIARIAS', 17, 1, '2011-05-17 11:36:51', 3, 1, 'SIM'),
	(169, '32.1.1.2', 'ASSOCIADAS', 17, 1, '2011-05-17 11:37:09', 3, 1, 'SIM'),
	(170, '32.1.2', 'NAO GRUPO', 17, 1, '2011-05-17 11:37:25', 3, 1, 'SIM'),
	(171, '32.1.2.1', 'NACIONAIS', 17, 1, '2011-05-17 11:37:40', 3, 1, 'SIM'),
	(172, '32.1.2.2', 'ESTRANGEIROS', 17, 1, '2011-05-17 11:38:01', 3, 1, 'SIM'),
	(173, '32.2', 'FORNECEDORES - TITULOS A PAGAR', 17, 1, '2011-05-17 11:38:19', 3, 1, 'SIM'),
	(174, '32.2.1', 'GRUPO', 17, 1, '2011-05-17 11:38:54', 3, 1, 'SIM'),
	(175, '32.2.1.1', 'SUBSIDIARIAS', 17, 1, '2011-05-17 11:39:10', 3, 1, 'SIM'),
	(176, '32.2.1.2', 'ASSOCIADAS', 17, 1, '2011-06-05 05:58:25', 3, 1, 'SIM'),
	(177, '32.2.2', 'NAO GRUPO', 17, 1, '2011-05-17 11:39:51', 3, 1, 'SIM'),
	(178, '32.2.2.1', 'NACIONAIS', 17, 1, '2011-05-17 11:40:06', 3, 1, 'SIM'),
	(179, '32.2.2.2', 'ESTRANGEIROS', 17, 1, '2011-05-17 11:40:20', 3, 1, 'SIM'),
	(180, '32.8', 'FORNECEDORES - FACTURAS EM RECEPCAO E CONFERENCIA', 17, 1, '2011-05-17 11:40:32', 3, 1, 'SIM'),
	(181, '32.9', 'FORNECEDORES: SALDOS DEVEDORES', 17, 1, '2011-05-17 11:41:18', 3, 1, 'SIM'),
	(182, '32.9.1', 'ADIANTAMENTOS', 17, 1, '2011-05-17 11:43:00', 3, 1, 'SIM'),
	(183, '32.9.2', 'EMBALAGENS A DEVOLVER', 17, 1, '2011-05-17 11:43:18', 3, 1, 'SIM'),
	(184, '32.9.3', 'MATERIAL A CONSIGNACAO', 17, 1, '2011-05-17 11:44:41', 3, 1, 'SIM'),
	(185, '33.1', 'EMPRESTIMOS BANCARIOS', 18, 1, '2011-05-17 11:45:42', 3, 1, 'SIM'),
	(186, '33.1.1', 'MOEDA NACIONAL', 18, 1, '2011-05-17 11:46:16', 3, 1, 'SIM'),
	(187, '33.1.1.1', 'BANCO BPC', 18, 1, '2011-08-16 08:39:21', 3, 1, 'SIM'),
	(188, '33.1.2', 'MOEDA ESTRANGEIRA', 18, 1, '2011-05-18 10:52:40', 4, 1, 'SIM'),
	(189, '33.1.2.1', 'BFA - NOVA GESTAO', 18, 1, '2011-08-16 08:40:17', 4, 1, 'SIM'),
	(190, '33.2', 'EMPRESTIMO POR OBRIGACOES', 18, 1, '2011-05-18 10:56:43', 4, 1, 'SIM'),
	(191, '33.2.1', 'CONVERTIVEIS', 18, 1, '2011-05-18 10:57:11', 4, 1, 'SIM'),
	(192, '33.2.1.1', 'ENTIDADE', 18, 1, '2011-05-18 10:57:32', 4, 1, 'SIM'),
	(193, '33.2.2', 'NAO CONVERTIVEIS', 18, 1, '2011-05-18 10:58:02', 4, 1, 'SIM'),
	(194, '33.2.2.1', 'ENTIDADE', 18, 1, '2011-05-18 10:58:38', 4, 1, 'SIM'),
	(195, '33.3', 'EMPRESTIMO POR TITULO DE PARTICIPACAO', 18, 1, '2011-05-18 10:58:51', 4, 1, 'SIM'),
	(196, '33.3.1', 'ENTIDADE', 18, 1, '2011-05-18 10:59:35', 4, 1, 'SIM'),
	(197, '33.9', 'OUTROS EMPRESTIMOS OBTIDOS', 18, 1, '2011-05-18 10:59:53', 4, 1, 'SIM'),
	(198, '33.9.1', 'GRUPO', 18, 1, '2011-06-05 11:58:50', 4, 1, 'SIM'),
	(199, '33.9.2', 'NAO GRUPO', 18, 1, '2011-06-06 00:09:58', 4, 1, 'SIM'),
	(200, '34.1', 'IMPOSTO SOBRE LUCROS', 19, 1, '2011-06-06 00:14:45', 4, 1, 'SIM'),
	(201, '34.1.1', 'IMPOSTO SOBRE LUCROS', 19, 1, '2011-06-06 00:13:29', 4, 1, 'SIM'),
	(203, '34.1.4.4', 'EMPRESTIMOS', 20, 1, '2011-05-18 11:14:04', 4, 1, 'SIM'),
	(204, '34.2', 'IMPOSTO DE PRODUCAO E CONSUMO', 19, 1, '2011-05-18 11:01:21', 4, 1, 'SIM'),
	(205, '34.3', 'IMPOSTO DE RENDIMENTO DE TRABALHO', 19, 1, '2011-05-18 11:02:00', 4, 1, 'SIM'),
	(206, '34.3.1', 'CONTA DE OUTREM', 19, 1, '2011-06-06 00:15:12', 4, 1, 'SIM'),
	(208, '34.4', 'IMPOSTO DE CIRCULACAO', 19, 1, '2011-05-18 11:02:35', 4, 1, 'SIM'),
	(209, '34.8', 'SUBSIDIOS A PRECOS', 19, 1, '2011-05-18 11:03:07', 4, 1, 'SIM'),
	(210, '34.9', 'OUTROS IMPOSTOS', 19, 1, '2011-05-18 11:03:56', 4, 1, 'SIM'),
	(211, '34.9.1', 'IMPOSTO DE SELO', 19, 1, '2011-06-06 00:16:22', 4, 1, 'SIM'),
	(212, '35.1', 'ENTIDADES PARTICIPANTES', 20, 1, '2011-05-18 11:04:41', 4, 1, 'SIM'),
	(213, '35.1.1', 'ESTADO', 20, 1, '2011-05-18 11:05:23', 4, 1, 'SIM'),
	(214, '35.1.1.1', 'C/SUBSCRICAO', 20, 1, '2011-05-18 11:05:37', 4, 1, 'SIM'),
	(215, '35.1.1.2', 'C/ADIANTAMENTO SOBRE LUCROS', 20, 1, '2011-05-18 11:06:03', 4, 1, 'SIM'),
	(216, '35.1.1.3', 'C/LUCROS', 20, 1, '2011-05-18 11:06:45', 4, 1, 'SIM'),
	(217, '35.1.1.4', 'EMPRESTIMOS', 20, 1, '2011-06-05 06:16:09', 4, 1, 'SIM'),
	(218, '35.1.2', 'EMPRESAS DO GRUPO - SUBSIDIARIAS', 20, 1, '2011-06-05 05:58:29', 4, 1, 'SIM'),
	(219, '35.1.2.1', 'C/SUBSCRICAO', 20, 1, '2011-05-18 11:08:12', 4, 1, 'SIM'),
	(220, '35.1.2.2', 'C/ADIANTAMENTO SOBRE LUCRO', 20, 1, '2011-05-18 11:08:34', 4, 1, 'SIM'),
	(221, '35.1.2.3', 'C/LUCROS', 20, 1, '2011-05-18 11:09:06', 4, 1, 'SIM'),
	(222, '35.1.2.4', 'EMPRESTIMO', 20, 1, '2011-05-18 11:09:30', 4, 1, 'SIM'),
	(223, '35.1.3', 'EMPRESAS DO GRUPO - ASSOCIADAS', 20, 1, '2011-05-18 11:09:56', 4, 1, 'SIM'),
	(224, '35.1.3.1', 'C/SUBSCRICAO', 20, 1, '2011-05-18 11:10:36', 4, 1, 'SIM'),
	(225, '35.1.3.2', 'C/ADIANTAMENTOS SOBRE LUCROS', 20, 1, '2011-05-18 11:10:57', 4, 1, 'SIM'),
	(226, '35.1.3.3', 'C/LUCROS', 20, 1, '2011-05-18 11:11:34', 4, 1, 'SIM'),
	(227, '35.1.3.4', 'EMPRESTIMOS', 20, 1, '2011-06-05 06:17:38', 4, 1, 'SIM'),
	(228, '35.1.4', 'OUTROS', 20, 1, '2011-05-18 11:12:26', 4, 1, 'SIM'),
	(229, '35.1.4.1', 'C/SUBSCRICAO', 20, 1, '2011-05-18 11:12:39', 4, 1, 'SIM'),
	(230, '35.1.4.2', 'C/ADIANTAMENTOS SOBRE LUCROS', 20, 1, '2011-05-18 11:13:07', 4, 1, 'SIM'),
	(231, '35.1.4.3', 'C/LUCROS', 20, 1, '2011-06-05 06:20:46', 4, 1, 'SIM'),
	(232, '35.1.4.4', 'EMPRESTIMOS', 20, 1, '2011-06-05 06:29:54', 4, 1, 'SIM'),
	(233, '35.2', 'ENTIDADES PARTICIPADAS', 20, 1, '2011-05-18 11:14:26', 4, 1, 'SIM'),
	(234, '35.2.1', 'ESTADO', 20, 1, '2011-06-05 06:30:34', 4, 1, 'SIM'),
	(235, '35.2.1.1', 'C/SUBSCRICAO', 20, 1, '2011-06-05 06:35:39', 4, 1, 'SIM'),
	(236, '35.2.1.2', 'C/ADIANTAMENTOS SOBRE LUCROS', 20, 1, '2011-05-18 11:16:10', 4, 1, 'SIM'),
	(237, '35.2.1.3', 'C/LUCROS', 20, 1, '2011-05-18 11:16:47', 4, 1, 'SIM'),
	(238, '35.2.1.4', 'EMPRESTIMOS', 20, 1, '2011-05-18 11:17:04', 4, 1, 'SIM'),
	(239, '35.2.2', 'EMPRESAS DO GRUPO - SUBSIDIARIAS', 20, 1, '2011-05-18 11:17:24', 4, 1, 'SIM'),
	(240, '35.2.2.1', 'C/SUBSCRICAO', 20, 1, '2011-05-18 11:18:05', 4, 1, 'SIM'),
	(241, '35.2.2.2', 'C/ADIANTAMENTOS SOBRE LUCROS', 20, 1, '2011-06-05 06:54:16', 4, 1, 'SIM'),
	(242, '35.2.2.3', 'C/LUCROS', 20, 1, '2011-05-18 11:18:52', 4, 1, 'SIM'),
	(243, '35.2.2.4', 'EMPRESTIMOS', 20, 1, '2011-05-18 11:19:29', 4, 1, 'SIM'),
	(244, '35.2.3', 'EMPRESAS DO GRUPO - ASSOCIADAS', 20, 1, '2011-05-18 11:19:45', 4, 1, 'SIM'),
	(245, '35.2.3.1', 'C/SUBSCRICAO', 20, 1, '2011-05-18 11:20:14', 4, 1, 'SIM'),
	(246, '35.2.3.2', 'C/ADIANTAMENTOS SOBRE LUCROS', 20, 1, '2011-06-05 06:56:55', 4, 1, 'SIM'),
	(247, '35.2.3.3', 'C/LUCROS', 20, 1, '2011-05-18 11:23:19', 4, 1, 'SIM'),
	(248, '35.2.3.4', 'EMPRESTIMOS', 20, 1, '2011-05-18 11:23:37', 4, 1, 'SIM'),
	(249, '35.2.4', 'OUTROS', 20, 1, '2011-05-18 11:24:07', 4, 1, 'SIM'),
	(250, '35.2.4.1', 'C/SUBSCRICAO', 20, 1, '2011-05-18 11:24:23', 4, 1, 'SIM'),
	(251, '35.2.4.2', 'C/ADIANTAMENTOS SOBRE LUCROS', 20, 1, '2011-05-18 11:24:54', 4, 1, 'SIM'),
	(252, '35.2.4.3', 'C/LUCROS', 20, 1, '2011-05-18 11:25:38', 4, 1, 'SIM'),
	(253, '35.2.4.4', 'EMPRESTIMOS', 20, 1, '2011-05-18 11:26:00', 4, 1, 'SIM'),
	(254, '36.1', 'PESSOAL - REMUNERACOES', 21, 1, '2011-06-05 06:59:44', 4, 1, 'SIM'),
	(255, '36.1.1', 'ORGAOS SOCIAIS', 21, 1, '2011-05-18 11:28:49', 4, 1, 'SIM'),
	(259, '36.1.2', 'EMPREGADOS', 21, 1, '2011-05-18 11:29:11', 4, 1, 'SIM'),
	(264, '36.2', 'PESSOAL - PARTICIPACAO NOS RESULTADOS', 21, 1, '2011-05-18 11:29:33', 4, 1, 'SIM'),
	(265, '36.2.1', 'ORGAOS SOCIAIS', 21, 1, '2011-05-18 11:31:02', 4, 1, 'SIM'),
	(266, '36.2.2', 'EMPREGADOS', 21, 1, '2011-05-18 11:31:28', 4, 1, 'SIM'),
	(267, '36.3', 'PESSOAL - ADIANTAMENTOS', 21, 1, '2011-05-18 11:31:42', 4, 1, 'SIM'),
	(271, '36.9', 'PESSOAL - OUTROS', 21, 1, '2011-05-18 11:32:06', 4, 1, 'SIM'),
	(272, '37.1', 'COMPRAS DE IMOBILIZADO', 22, 1, '2011-05-18 11:32:28', 4, 1, 'SIM'),
	(273, '37.1.1', 'CORPOREO', 22, 1, '2011-05-18 11:33:03', 4, 1, 'SIM'),
	(274, '37.1.2', 'INCORPOREO', 22, 1, '2011-05-18 11:33:28', 4, 1, 'SIM'),
	(275, '37.1.3', 'FINANCEIRO', 22, 1, '2011-05-18 11:33:47', 4, 1, 'SIM'),
	(276, '37.2', 'VENDAS DE IMOBILIZADO', 22, 1, '2011-05-18 11:34:00', 4, 1, 'SIM'),
	(277, '37.2.1', 'CORPOREO', 22, 1, '2011-05-18 11:34:28', 4, 1, 'SIM'),
	(278, '37.2.2', 'INCORPOREO', 22, 1, '2011-05-18 11:34:43', 4, 1, 'SIM'),
	(279, '37.2.3', 'FINANCEIRO', 22, 1, '2011-05-18 11:35:13', 4, 1, 'SIM'),
	(280, '37.3', 'PROVEITOS A FACTURAR', 22, 1, '2011-05-18 11:35:53', 4, 1, 'SIM'),
	(281, '37.3.1', 'VENDAS', 22, 1, '2011-05-18 11:36:43', 4, 1, 'SIM'),
	(282, '37.3.2', 'PRESTACOES DE SERVICO', 22, 1, '2011-05-18 11:37:00', 4, 1, 'SIM'),
	(283, '37.3.3', 'JUROS', 22, 1, '2011-05-18 11:37:31', 4, 1, 'SIM'),
	(284, '37.4', 'ENCARGOS A REPARTIR POR PERIODOS FUTUROS', 22, 1, '2011-05-18 11:37:41', 4, 1, 'SIM'),
	(285, '37.4.1', 'DESCONTOS DE EMISSAO DE OBRIGACOES', 22, 1, '2011-05-18 11:38:30', 4, 1, 'SIM'),
	(286, '37.4.2', 'DESCONTOS DE EMISSAO DE TITULOS DE PARTICIPACAO', 22, 1, '2011-05-18 11:39:12', 4, 1, 'SIM'),
	(287, '37.5', 'ENCARGOS A PAGAR', 22, 1, '2011-05-18 11:39:51', 4, 1, 'SIM'),
	(288, '37.5.1', 'REMUNERACOES', 22, 1, '2011-05-18 11:40:07', 4, 1, 'SIM'),
	(289, '37.5.2', 'JUROS', 22, 1, '2011-05-18 11:40:25', 4, 1, 'SIM'),
	(290, '37.6', 'PROVEITOS A REPARTIR POR PERIODOS FUTUROS', 22, 1, '2011-05-18 11:40:38', 4, 1, 'SIM'),
	(291, '37.6.1', 'PREMIOS DE EMISSAO DE OBRIGACOES', 22, 1, '2011-05-18 11:41:12', 4, 1, 'SIM'),
	(292, '37.6.2', 'PREMIOS DE EMISSAO DE TITULOS DE PARTICIPACAO', 22, 1, '2011-05-18 11:41:50', 4, 1, 'SIM'),
	(293, '37.6.3', 'SUBSIDIOS PARA INVESTIMENTO', 22, 1, '2011-05-18 11:42:28', 4, 1, 'SIM'),
	(294, '37.6.4', 'DIFERENCAS DE CAMBIO FAVORAVEIS REVERSIVEIS', 22, 1, '2011-05-18 11:43:00', 4, 1, 'SIM'),
	(295, '37.7', 'CONTAS TRANSITORIAS', 22, 1, '2011-05-18 11:44:05', 4, 1, 'SIM'),
	(296, '37.7.1', 'TRANSACCOES ENTRE A SEDE E AS DEPENDENCIAS DA EMPRESA', 22, 1, '2011-06-05 07:02:28', 4, 1, 'SIM'),
	(297, '37.7.2.3', 'DEPOSITO MAL EFECTUADO', 22, 1, '2011-06-06 00:26:56', 4, 1, 'SIM'),
	(298, '37.7.4', 'DIFERENCAS - SALARIOS', 22, 1, '2011-06-06 00:28:00', 4, 1, 'SIM'),
	(299, '37.7.5', 'RECEITAS BANCO', 22, 1, '2011-06-06 00:28:40', 4, 1, 'SIM'),
	(300, '37.7.6', 'CONTAS A REGULARIZAR', 22, 1, '2011-06-06 00:29:08', 4, 1, 'SIM'),
	(301, '37.7.9', 'DIVERSOS', 22, 1, '2011-06-06 00:26:27', 4, 1, 'SIM'),
	(302, '37.9', 'OUTROS VALORES A RECEBER E A PAGAR', 22, 1, '2011-05-18 11:45:19', 4, 1, 'SIM'),
	(307, '38.1', 'PROVISOES PARA CLIENTES', 23, 1, '2011-05-18 11:46:42', 4, 1, 'SIM'),
	(308, '38.1.1', 'CLIENTES - CORRENTES', 23, 1, '2011-05-18 11:46:07', 4, 1, 'SIM'),
	(309, '38.1.1.1', 'GRUPO', 23, 1, '2011-05-18 11:48:20', 4, 1, 'SIM'),
	(310, '38.1.1.2', 'NAO GRUPO', 23, 1, '2011-05-18 11:48:35', 4, 1, 'SIM'),
	(311, '38.1.2', 'CLIENTES - TITULOS A RECEBER', 23, 1, '2011-05-18 11:48:52', 4, 1, 'SIM'),
	(312, '38.1.2.1', 'GRUPO', 23, 1, '2011-05-18 11:49:21', 4, 1, 'SIM'),
	(313, '38.1.2.2', 'NAO GRUPO', 23, 1, '2011-05-18 11:49:41', 4, 1, 'SIM'),
	(314, '38.1.3', 'CLIENTES - COBRANCA DUVIDOSA', 23, 1, '2011-05-18 11:50:03', 4, 1, 'SIM'),
	(315, '38.2', 'PROVISOES PARA SALDOS DEVEDORES DE FORNECEDORES', 23, 1, '2011-05-18 11:51:04', 4, 1, 'SIM'),
	(316, '38.3', 'PROVISOES P/PARTICIPANTES E PARTICIPADAS', 23, 1, '2011-05-18 11:51:44', 4, 1, 'SIM'),
	(317, '38.3.1', 'PARTICIPANTES', 23, 1, '2011-05-18 11:52:22', 4, 1, 'SIM'),
	(318, '38.3.2', 'PARTICIPADAS', 23, 1, '2011-05-18 11:52:45', 4, 1, 'SIM'),
	(319, '38.4', 'PROVISOES P/DIVIDAS DO PESSOAL', 23, 1, '2011-05-18 11:52:57', 4, 1, 'SIM'),
	(320, '38.9', 'PROVISOES PARA OUTROS SALDOS A RECEBER', 23, 1, '2011-05-19 09:39:00', 4, 1, 'SIM'),
	(321, '38.9.1', 'VENDAS IMOBILIZADO', 23, 1, '2011-05-19 09:39:39', 4, 1, 'SIM'),
	(322, '39.1', 'PROVISOES PARA PENSOES', 24, 1, '2011-05-19 09:40:08', 4, 1, 'SIM'),
	(323, '39.2', 'PROVISOES PARA PROCESSOS JUDICIAIS EM CURSO', 24, 1, '2011-05-19 09:41:44', 4, 1, 'SIM'),
	(324, '39.3', 'PROVISOES PARA ACIDENTES DE TRABALHO', 24, 1, '2011-05-19 09:42:53', 4, 1, 'SIM'),
	(325, '39.4', 'PROVISOES PARA GARANTIAS DADAS A CLIENTES', 24, 1, '2011-05-19 09:45:10', 4, 1, 'SIM'),
	(326, '39.9', 'PROVISOES PARA OUTROS RISCOS E ENCARGOS', 24, 1, '2011-05-19 09:45:44', 4, 1, 'SIM'),
	(328, '41.1', 'ACCOES', 25, 1, '2011-08-09 08:25:38', 4, 1, 'SIM'),
	(329, '41.1.1', 'EMPRESAS DO GRUPO', 25, 1, '2011-05-19 09:48:23', 4, 1, 'SIM'),
	(330, '41.1.2', 'ASSOCIADAS', 25, 1, '2011-05-19 09:50:02', 4, 1, 'SIM'),
	(331, '41.1.3', 'OUTRAS EMPRESAS', 25, 1, '2011-05-19 09:50:22', 4, 1, 'SIM'),
	(332, '41.2', 'OBRIGACOES', 25, 1, '2011-05-19 09:50:37', 4, 1, 'SIM'),
	(333, '41.2.1', 'EMPRESAS DO GRUPO', 25, 1, '2011-05-19 09:50:54', 4, 1, 'SIM'),
	(334, '41.2.2', 'ASSOCIADAS', 25, 1, '2011-06-05 08:28:21', 3, 1, 'SIM'),
	(335, '41.2.3', 'OUTRAS EMPRESAS', 25, 1, '2011-06-05 09:10:16', 3, 1, 'SIM'),
	(336, '41.3', 'TITULOS DA DIVIDA PUBLICA', 25, 1, '2011-05-19 09:51:53', 4, 1, 'SIM'),
	(337, '42.1', 'MOEDA NACIONAL', 26, 1, '2011-05-19 09:52:30', 3, 1, 'SIM'),
	(338, '42.1.1', 'BANCO BFA', 26, 1, '2011-05-19 09:53:10', 3, 1, 'SIM'),
	(339, '42.2', 'MOEDA ESTRANGEIRA', 26, 1, '2011-05-19 09:54:02', 3, 1, 'SIM'),
	(340, '42.2.1', 'BANCO BFA', 26, 1, '2011-05-19 09:54:18', 3, 1, 'SIM'),
	(341, '42.2.2', 'ASSOCIADAS', 25, 1, '2011-05-19 09:51:15', 4, 1, 'SIM'),
	(342, '42.2.3', 'OUTRAS EMPRESAS', 25, 1, '2011-05-19 09:51:34', 4, 1, 'SIM'),
	(343, '43.1', 'MOEDA NACIONAL', 27, 1, '2015-12-11 02:54:52', 3, 1, 'NAO'),
	(349, '43.2', 'MOEDA ESTRANGEIRA', 27, 1, '2015-12-11 02:55:15', 3, 1, 'NAO'),
	(358, '44.1', 'MOEDA NACIONAL', 28, 1, '2011-05-19 09:57:54', 3, 1, 'SIM'),
	(359, '44.1.1', 'BANCO BFA', 28, 1, '2011-05-19 09:58:27', 3, 1, 'SIM'),
	(360, '44.2', 'MOEDA ESTRANGEIRA', 28, 1, '2011-05-19 09:58:44', 3, 1, 'SIM'),
	(361, '44.2.1', 'BANCO BFA', 28, 1, '2011-05-19 09:59:27', 3, 1, 'SIM'),
	(363, '45.1.1', 'SEDE /ESCRITÃ“RIO', 29, 1, '2015-12-11 09:21:36', 3, 1, 'SIM'),
	(365, '45.2', 'VALORES PARA DEPOSITAR', 16, 1, '2015-12-11 09:22:06', 3, 1, 'NAO'),
	(366, '45.2.1', 'RECEBIMENTOS EM NUMERARIO', 16, 1, '2015-12-11 09:22:50', 3, 1, 'SIM'),
	(368, '45.3', 'VALORES DESTINADOS A PAGAMENTOS ESPECIFICOS', 16, 1, '2015-12-11 09:23:45', 3, 1, 'NAO'),
	(369, '45.3.1', 'SALARIOS', 29, 1, '2015-12-11 03:04:52', 3, 1, 'SIM'),
	(371, '48.1', 'TRANSFERENCIA ENTRE BANCOS E CAIXA', 30, 1, '2011-06-06 00:35:58', 3, 1, 'SIM'),
	(372, '48.2', 'TRANSFERENCIA ENTRE BANCOS', 30, 1, '2011-06-06 00:36:58', 3, 1, 'SIM'),
	(373, '48.3', 'TRANSFERENCIA ENTRE CAIXAS', 30, 1, '2011-06-06 00:37:27', 3, 1, 'SIM'),
	(374, '48.4', 'TRANSFERENCIA ENTRE SUBCONTAS', 30, 1, '2011-06-06 00:37:50', 3, 1, 'SIM'),
	(375, '49.1', 'TITULOS NEGOCIAVEIS', 31, 1, '2011-05-19 10:01:25', 4, 1, 'SIM'),
	(376, '49.1.1', 'ACCOES', 31, 1, '2011-06-06 00:43:45', 4, 1, 'SIM'),
	(377, '49.1.2', 'OBRIGACOES', 31, 1, '2011-06-06 00:44:19', 4, 1, 'SIM'),
	(378, '49.1.3', 'TITULOS DE DIVIDA PUBLICA', 31, 1, '2011-06-06 00:44:35', 4, 1, 'SIM'),
	(379, '49.2', 'OUTRAS APLICACOES DE TESOURARIA', 31, 1, '2011-05-19 10:02:23', 4, 1, 'SIM'),
	(380, '51.1', 'CAPITAL INICIAL', 32, 1, '2011-06-06 00:39:49', 4, 1, 'SIM'),
	(381, '52.1', 'VALOR NOMINAL', 33, 1, '2011-05-19 10:03:24', 4, 1, 'SIM'),
	(382, '52.2', 'DESCONTOS', 33, 1, '2011-05-19 10:05:04', 4, 1, 'SIM'),
	(383, '52.3', 'PREMIOS', 33, 1, '2011-05-19 10:05:19', 4, 1, 'SIM'),
	(384, '56.1', 'LEGAIS', 37, 1, '2011-05-19 10:05:34', 4, 1, 'SIM'),
	(385, '56.1.1', 'DECRETO LEI NÃ‚Âº', 37, 1, '2011-05-19 10:06:15', 4, 1, 'SIM'),
	(386, '56.1.2', 'DECRETO LEI NÃ‚Âº', 37, 1, '2011-05-19 10:06:34', 4, 1, 'SIM'),
	(387, '56.2', 'AUTONOMAS', 37, 1, '2011-05-19 10:06:48', 4, 1, 'SIM'),
	(388, '56.2.1', 'AVALIACAO', 37, 1, '2011-05-19 10:07:07', 4, 1, 'SIM'),
	(389, '56.2.2', 'REALIZACAO', 37, 1, '2011-05-19 10:07:24', 4, 1, 'SIM'),
	(390, '61.1', 'SOFTWARES', 40, 1, '2015-12-11 03:03:48', 3, 1, 'NAO'),
	(391, '61.1.1', 'MERCADO NACIONAL', 40, 1, '2015-12-11 03:01:16', 3, 1, 'SIM'),
	(392, '61.1.2', 'MERCADO ESTRANGEIRO', 40, 1, '2011-05-19 10:09:42', 3, 1, 'SIM'),
	(393, '61.2', 'SU-PRODUTOS, DESPERDICIOS, RESIDUOS E REFUGOS', 40, 1, '2015-12-11 09:57:25', 3, 1, 'NAO'),
	(394, '61.2.1', 'MERCADO NACIONAL', 40, 1, '2011-05-19 10:11:02', 3, 1, 'SIM'),
	(395, '61.2.2', 'MERCADO ESTRANGEIRO', 40, 1, '2011-05-19 10:11:23', 3, 1, 'SIM'),
	(396, '61.3', 'MERCADORIAS', 40, 1, '2011-05-19 10:11:42', 3, 1, 'SIM'),
	(397, '61.3.1', 'PRODUTOS DIVERSOS', 40, 1, '2015-12-11 03:08:22', 3, 1, 'SIM'),
	(400, '61.4', 'EMBALAGENS DE CONSUMO', 40, 1, '2015-12-11 10:05:03', 3, 1, 'NAO'),
	(401, '61.4.1', 'MERCADO NACIONAL', 40, 1, '2011-05-19 10:13:08', 3, 1, 'SIM'),
	(402, '61.4.2', 'MERCADO ESTRANGEIRO', 40, 1, '2011-05-19 10:13:25', 3, 1, 'SIM'),
	(403, '61.5', 'SUBSIDIOS A PRECOS', 40, 1, '2015-12-11 10:05:49', 3, 1, 'NAO'),
	(404, '61.7', 'DEVOLUCOES', 40, 1, '2015-12-11 10:06:33', 3, 1, 'NAO'),
	(405, '61.7.1', 'MERCADO NACIONAL', 40, 1, '2011-05-19 10:14:24', 3, 1, 'SIM'),
	(406, '61.7.2', 'MERCADO ESTRANGEIRO', 40, 1, '2011-05-19 10:14:44', 3, 1, 'SIM'),
	(407, '61.8', 'DESCONTOS E ABATIMENTOS', 40, 1, '2015-12-11 10:07:21', 3, 1, 'NAO'),
	(408, '61.8.1', 'MERCADO NACIONAL', 40, 1, '2011-05-19 10:15:33', 3, 1, 'SIM'),
	(409, '61.9', 'TRANSFERENCIA PARA RESULTADOS OPERACIONAIS', 40, 1, '2011-05-19 10:16:32', 3, 1, 'SIM'),
	(410, '62.1', 'SERVICOS PRINCIPAIS', 41, 1, '2011-05-19 10:17:15', 3, 1, 'SIM'),
	(411, '62.1.1', 'MERCADO NACIONAL', 41, 1, '2011-05-19 10:18:10', 3, 1, 'SIM'),
	(413, '62.1.2', 'MERCADO ESTRANGEIRO', 41, 1, '2011-05-19 10:18:38', 3, 1, 'SIM'),
	(414, '62.2', 'SERVICOS SECUNDARIOS', 41, 1, '2015-12-11 10:32:15', 3, 1, 'NAO'),
	(415, '62.2.1', 'MERCADO NACIONAL', 41, 1, '2011-05-19 10:19:28', 3, 1, 'SIM'),
	(417, '62.2.2', 'MERCADO ESTRANGEIRO', 41, 1, '2011-05-19 10:20:03', 3, 1, 'SIM'),
	(418, '62.8', 'DESCONTOS E ABATIMENTOS', 41, 1, '2011-05-19 10:20:27', 3, 1, 'SIM'),
	(419, '62.8.1', 'MERCADO NACIONAL', 41, 1, '2011-05-19 10:21:02', 3, 1, 'SIM'),
	(420, '62.8.2', 'MERCADO ESTRANGEIRO', 41, 1, '2011-05-19 10:21:28', 3, 1, 'SIM'),
	(421, '62.9', 'TRANSFERENCIA PARA RESULTADOS OPERACIONAIS', 41, 1, '2011-05-19 10:22:15', 3, 1, 'SIM'),
	(422, '63.1', 'SERVICOS SUPLEMENTARES', 42, 1, '2011-05-19 10:23:09', 3, 1, 'SIM'),
	(423, '63.1.1', 'ALUGUER DE EQUIPAMENTO', 42, 1, '2011-05-19 10:23:43', 2, 1, 'SIM'),
	(424, '63.1.2', 'CEDENCIA DE PESSOAL', 42, 1, '2011-05-19 10:25:24', 2, 1, 'SIM'),
	(425, '63.1.3', 'CEDENCIA DE ENERGIA', 42, 1, '2011-05-19 10:25:54', 2, 1, 'SIM'),
	(426, '63.1.4', 'ESTUDOS, PROJECTOS E ASSISTENCIA TECNICA', 42, 1, '2011-05-19 10:26:15', 2, 1, 'SIM'),
	(427, '63.2', 'ROYALTIES', 42, 1, '2011-05-19 10:27:02', 2, 1, 'SIM'),
	(428, '63.3', 'SUBSIDIOS A EXPLORACAO', 42, 1, '2011-05-19 10:27:30', 2, 1, 'SIM'),
	(429, '63.4', 'SUBSIDIOS A INVESTIMENTO', 42, 1, '2011-05-19 10:28:00', 2, 1, 'SIM'),
	(430, '63.8', 'OUTROS PROVEITOS E GANHOS OPERACIONAIS', 42, 1, '2011-05-19 10:28:30', 2, 1, 'SIM'),
	(431, '63.8.1', 'FALTAS', 42, 1, '2011-09-14 00:03:57', 2, 1, 'SIM'),
	(432, '63.9', 'TRANSFERENCIA PARA RESULTADOS OPERACIONAIS', 42, 1, '2011-05-19 10:29:05', 2, 1, 'SIM'),
	(433, '64.1', 'PRODUTOS E TRABALHOS EM CURSO', 42, 1, '2011-05-19 10:29:53', 2, 1, 'SIM'),
	(434, '64.2', 'PRODUTOS ACABADOS', 43, 1, '2011-05-19 10:30:38', 2, 1, 'SIM'),
	(435, '64.3', 'PRODUTOS INTERMEDIOS', 43, 1, '2011-05-19 10:33:19', 2, 1, 'SIM'),
	(436, '64.9', 'TRANSFERENCIA PARA RESULTADOS OPERACIONAIS', 43, 1, '2011-05-19 10:33:40', 2, 1, 'SIM'),
	(437, '65.1', 'PARA IMOBILIZADO', 44, 1, '2011-06-06 00:56:59', 2, 1, 'SIM'),
	(438, '65.1.1', 'CORPOREO', 44, 1, '2011-06-06 00:58:43', 2, 1, 'SIM'),
	(439, '65.1.2', 'INCORPOREO', 44, 1, '2011-06-06 00:59:10', 2, 1, 'SIM'),
	(440, '65.1.3', 'FINANCEIRO', 44, 1, '2011-06-06 00:59:25', 2, 1, 'SIM'),
	(441, '65.1.4', 'EM CURSO', 44, 1, '2011-06-06 00:59:42', 2, 1, 'SIM'),
	(442, '66.1', 'JUROS', 44, 1, '2011-06-05 09:10:39', 2, 1, 'SIM'),
	(443, '66.1.1', 'DE INVESTIMENTOS FINANCEIROS', 44, 1, '2011-05-19 10:34:41', 2, 1, 'SIM'),
	(444, '66.1.1.1', 'OBRIGACOES', 44, 1, '2011-05-19 10:35:27', 2, 1, 'SIM'),
	(445, '66.1.1.3', 'TITULOS DE PARTICIPACAO', 45, 1, '2011-05-19 10:35:40', 2, 1, 'SIM'),
	(446, '66.1.1.4', 'EMPRESTIMOS', 45, 1, '2011-05-19 10:54:24', 2, 1, 'SIM'),
	(447, '66.1.1.9', 'OUTROS', 45, 1, '2011-05-19 10:54:45', 2, 1, 'SIM'),
	(448, '66.1.2', 'DE MORA RELATIVOS A DIVIDAS DE TERCEIROS', 45, 1, '2011-05-19 10:55:18', 2, 1, 'SIM'),
	(449, '66.1.2.1', 'DIVIDAS RECEBIDAS A PRESTACAO', 45, 1, '2011-05-19 10:56:04', 2, 1, 'SIM'),
	(450, '66.1.2.2', 'DE EMPRESTIMO A TERCEIROS', 45, 1, '2011-05-19 10:56:32', 2, 1, 'SIM'),
	(451, '66.1.4', 'DESCONTO DE TITULOS', 45, 1, '2011-05-19 10:57:59', 2, 1, 'SIM'),
	(452, '66.1.5', 'DE APLICACACOES DE TESOURARIA', 45, 1, '2011-05-19 10:57:03', 2, 1, 'SIM'),
	(453, '66.1.9', 'OUTRAS APLICACOES DE TESOURARIA', 45, 1, '2015-12-11 03:13:46', 2, 1, 'SIM'),
	(454, '66.2', 'DIFERENCAS DE CAMBIO FAVORAVEIS', 45, 1, '2011-05-19 10:58:35', 2, 1, 'SIM'),
	(455, '66.2.1', 'REALIZADAS', 45, 1, '2011-05-19 10:59:10', 2, 1, 'SIM'),
	(456, '66.2.2', 'NAO REALIZADAS', 45, 1, '2011-05-19 10:59:49', 2, 1, 'SIM'),
	(457, '66.5', 'RENDIMENTO DE PARTICIPACOES DE CAPITAL', 45, 1, '2011-05-19 11:01:31', 2, 1, 'SIM'),
	(458, '66.5.1', 'ACCOES, QUOTAS, EM OUTRAS EMPRESAS', 45, 1, '2011-05-19 11:02:13', 2, 1, 'SIM'),
	(459, '66.5.2', 'ACCOES, QUOTAS, INCLUIDAS NOS FUNDOS', 45, 1, '2011-05-19 11:02:42', 2, 1, 'SIM'),
	(460, '66.5.3', 'ACCOES, QUOTAS INCLUIDAS NOS TITULOS NEGOCIAVEIS', 45, 1, '2011-05-19 11:03:38', 2, 1, 'SIM'),
	(461, '66.6', 'GANHOS NA ALIENACAO DE APLICACACOES FINANCEIRAS', 45, 1, '2011-05-19 11:04:29', 2, 1, 'SIM'),
	(462, '66.6.1', 'INVESTIMENTOS FINANCEIROS', 45, 1, '2011-05-19 11:05:42', 2, 1, 'SIM'),
	(463, '66.6.1.1', 'SUBSIDIARIAS', 45, 1, '2011-05-19 11:06:01', 2, 1, 'SIM'),
	(464, '66.6.1.2', 'ASSOCIADAS', 45, 1, '2011-05-19 11:06:21', 2, 1, 'SIM'),
	(465, '66.6.1.3', 'OUTRAS EMPRESAS', 45, 1, '2011-05-19 11:06:39', 2, 1, 'SIM'),
	(466, '66.6.1.4', 'IMOVEIS', 45, 1, '2011-05-19 11:07:02', 2, 1, 'SIM'),
	(467, '66.6.1.5', 'FUNDOS', 45, 1, '2011-05-19 11:07:17', 2, 1, 'SIM'),
	(468, '66.6.1.9', 'OUTROS INVESTIMENTOS', 45, 1, '2011-05-19 11:07:38', 2, 1, 'SIM'),
	(469, '66.6.2', 'TITULOS NEGOCIAVEIS', 45, 1, '2011-05-19 11:08:03', 2, 1, 'SIM'),
	(470, '66.7', 'REPOSICAO DE PROVISOES', 45, 1, '2011-05-19 11:08:34', 2, 1, 'SIM'),
	(471, '66.7.1', 'INVESTIMENTOS FINANCEIROS', 45, 1, '2011-05-19 11:09:03', 2, 1, 'SIM'),
	(472, '66.7.1.1', 'SUBSIDIARIAS', 45, 1, '2011-05-19 11:09:29', 2, 1, 'SIM'),
	(473, '66.7.1.2', 'ASSOCIADAS', 45, 1, '2011-05-19 11:11:26', 2, 1, 'SIM'),
	(474, '66.7.1.3', 'OUTRAS EMPRESAS', 45, 1, '2011-06-06 01:01:33', 2, 1, 'SIM'),
	(475, '66.7.1.4', 'FUNDOS', 45, 1, '2011-06-06 01:02:24', 2, 1, 'SIM'),
	(476, '66.7.1.9', 'OUTROS INVESTIMENOS', 45, 1, '2011-06-05 09:40:13', 2, 1, 'SIM'),
	(477, '66.7.2', 'APLICACAO DE TESOURARIA', 45, 1, '2011-05-19 11:11:43', 2, 1, 'SIM'),
	(478, '66.7.2.1', 'TITULOS NEGOCIAVEIS', 45, 1, '2011-05-19 11:09:45', 2, 1, 'SIM'),
	(479, '66.7.2.2', 'DEPOSITOS A PRAZO', 45, 1, '2011-05-19 11:12:30', 2, 1, 'SIM'),
	(480, '66.7.2.3', 'OUTROS DEPOSITOS', 45, 1, '2011-05-19 11:13:07', 2, 1, 'SIM'),
	(481, '66.7.2.9', 'OUTROS INVESTIMENTOS', 45, 1, '2011-05-19 11:13:28', 2, 1, 'SIM'),
	(482, '67.1', 'RENDIMENTO DE PARTICIPACOES DE CAPITAL', 46, 1, '2011-05-19 11:15:30', 2, 1, 'SIM'),
	(483, '67.1.1', 'SUBSIDIARIAS', 46, 1, '2011-05-19 11:16:22', 2, 1, 'SIM'),
	(484, '67.1.2', 'ASSOCIADAS', 46, 1, '2011-05-19 11:16:37', 2, 1, 'SIM'),
	(485, '67.9', 'TRANSFERENCIA PARA RESULTADOS EM FILIAIS E ASSOCIADAS', 46, 1, '2011-05-19 11:16:48', 2, 1, 'SIM'),
	(486, '68.1', 'REPOSICAO DE PROVISOES', 47, 1, '2011-05-19 11:17:24', 2, 1, 'SIM'),
	(487, '68.1.1', 'EXISTENCIA', 47, 1, '2011-05-19 11:17:55', 2, 1, 'SIM'),
	(488, '68.1.1.1', 'MATERIAS-PRIMAS SUBSIDIARIAS E DE CONSUMO', 47, 1, '2011-05-19 11:18:09', 2, 1, 'SIM'),
	(489, '68.1.1.2', 'PRODUTOS E TRABALHOS EM CURSO', 47, 1, '2011-05-19 11:18:45', 2, 1, 'SIM'),
	(490, '68.1.1.3', 'PRODUTOS ACABADOS E INTERMEDIOS', 47, 1, '2011-05-19 11:19:09', 2, 1, 'SIM'),
	(491, '68.1.1.4', 'SUB-PRODUTOS, DESPERDICIOS, RESIDUOS E REFUGOS', 47, 1, '2011-05-19 11:19:42', 2, 1, 'SIM'),
	(492, '68.1.1.5', 'MERCADORIAS', 47, 1, '2011-05-19 11:20:21', 2, 1, 'SIM'),
	(493, '68.1.2', 'COBRANCAS DUVIDOSAS', 47, 1, '2011-05-19 11:20:38', 2, 1, 'SIM'),
	(494, '68.1.2.1', 'CLIENTES', 47, 1, '2011-05-19 11:21:00', 2, 1, 'SIM'),
	(495, '68.1.2.2', 'CLIENTES - TITULOS A RECEBER', 47, 1, '2011-05-19 11:21:14', 2, 1, 'SIM'),
	(496, '68.1.2.3', 'CLIENTES - COBRANCA DUVIDOSA', 47, 1, '2011-05-19 11:22:11', 2, 1, 'SIM'),
	(497, '68.1.2.4', 'SALDOS DEVEDORES DE FORNECEDORES', 47, 1, '2011-05-19 11:22:43', 2, 1, 'SIM'),
	(498, '68.1.2.5', 'PARTICIPANTES E PARTICIPADAS', 47, 1, '2011-05-19 11:23:12', 2, 1, 'SIM'),
	(499, '68.1.2.6', 'DIVIDAS DO PESSOAL', 47, 1, '2011-05-19 11:23:46', 2, 1, 'SIM'),
	(500, '68.1.2.9', 'OUTROS SALDOS A RECEBER', 47, 1, '2011-05-19 11:24:13', 2, 1, 'SIM'),
	(501, '68.1.3', 'RISCOS E ENCARGOS', 47, 1, '2011-05-19 11:24:38', 2, 1, 'SIM'),
	(502, '68.1.3.1', 'PENSOES', 47, 1, '2011-05-19 11:25:08', 2, 1, 'SIM'),
	(503, '68.1.3.2', 'PROCESSOS JUDICIAIS EM CURSO', 47, 1, '2011-05-19 11:25:24', 2, 1, 'SIM'),
	(504, '68.1.3.3', 'ACIDENTES DE TRABALHO', 47, 1, '2011-05-19 11:25:55', 2, 1, 'SIM'),
	(505, '68.1.3.4', 'GARANTIAS DADAS A CLIENTES', 47, 1, '2011-05-19 11:26:24', 2, 1, 'SIM'),
	(506, '68.1.3.9', 'OUTROS RISCOS E ENCARGOS', 47, 1, '2011-05-19 11:26:53', 2, 1, 'SIM'),
	(507, '68.10', 'CORRECCOES RELATIVAS A EXERCICIOS ANTERIORES', 47, 1, '2011-05-19 11:33:19', 2, 1, 'SIM'),
	(508, '68.10.1', 'ESTIMATIVA IMPOSTO', 47, 1, '2011-05-19 11:34:13', 2, 1, 'SIM'),
	(509, '68.10.2', 'RESTITUICAO DE IMPOSTO', 47, 1, '2011-05-19 11:34:40', 2, 1, 'SIM'),
	(510, '68.10.3', 'OUTRAS CORRECCOES', 47, 1, '2011-06-06 00:50:48', 2, 1, 'SIM'),
	(511, '68.11', 'OUTROS GANHOS E PERDAS NAO OPERACIONAIS', 47, 1, '2011-05-19 11:35:06', 2, 1, 'SIM'),
	(512, '68.19', 'TRANSFERENCIA PARA RESULTADOS NAO OPERACIONAIS', 47, 1, '2011-06-06 01:03:50', 2, 1, 'SIM'),
	(513, '68.2', 'ANULACAO DE AMORTIZACAO EXTRAORDINARIA', 47, 1, '2011-05-19 11:27:21', 2, 1, 'SIM'),
	(514, '68.2.1', 'IMOBILIZACOES CORPOREAS', 47, 1, '2011-05-19 11:27:57', 2, 1, 'SIM'),
	(515, '68.2.2', 'IMOBLIZACOES INCORPOREAS', 47, 1, '2011-05-19 11:28:23', 2, 1, 'SIM'),
	(516, '68.3', 'GANHOS EM IMOBILIZACOES', 47, 1, '2011-05-19 11:28:55', 2, 1, 'SIM'),
	(517, '68.3.1', 'VENDA DE IMOBILIZACOES CORPOREAS', 47, 1, '2011-05-19 11:29:18', 2, 1, 'SIM'),
	(518, '68.3.2', 'VENDA DE IMOBILIZACOES INCORPOREAS', 47, 1, '2011-06-05 09:52:16', 2, 1, 'SIM'),
	(519, '68.4', 'GANHOS EM EXERCICIOS', 47, 1, '2011-05-19 11:30:25', 2, 1, 'SIM'),
	(520, '68.4.1', 'SOBRAS', 47, 1, '2011-05-19 11:30:54', 2, 1, 'SIM'),
	(521, '68.5', 'RECUPERACAO DE DIVIDAS', 47, 1, '2011-05-19 11:31:11', 2, 1, 'SIM'),
	(522, '68.6', 'BENEFICIOS DE PENELIDADES CONTRATUAIS', 47, 1, '2011-05-19 11:31:33', 2, 1, 'SIM'),
	(523, '68.8', 'DESCONTINUIDADE DE OPERACOES', 47, 1, '2011-05-19 11:32:19', 2, 1, 'SIM'),
	(524, '68.8.2', 'MERCADO ESTRANGEIRO', 47, 1, '2015-12-11 03:11:36', 3, 1, 'SIM'),
	(525, '68.9', 'ALTERACAO DE POLITICAS CONTABILISTICAS', 47, 1, '2011-05-19 11:32:47', 2, 1, 'SIM'),
	(526, '69.1', 'GANHOS RESULTANTES DE CATASTROFES NATURAIS', 48, 1, '2011-06-05 10:04:23', 2, 1, 'SIM'),
	(527, '69.2', 'GANHOS RESULTANTES DE CONVULSOES POLITICAS', 48, 1, '2011-05-20 11:57:27', 2, 1, 'SIM'),
	(528, '69.3', 'GANHOS RESULTANTES DE EXPROPRIACOES', 48, 1, '2011-05-20 11:58:41', 2, 1, 'SIM'),
	(529, '69.4', 'GANHOS RESULTANTES DE SINISTROS', 48, 1, '2011-05-20 11:59:30', 2, 1, 'SIM'),
	(530, '69.5', 'SUBSIDIOS', 48, 1, '2011-05-20 11:59:57', 2, 1, 'SIM'),
	(531, '69.9', 'TRANSFERENCIA PARA RESULTADOS EXTRAORDINARIO', 48, 1, '2011-05-21 00:01:17', 2, 1, 'SIM'),
	(533, '71.1', 'MATERIA-PRIMAS', 49, 1, '2011-05-21 00:02:00', 1, 1, 'SIM'),
	(534, '71.2', 'MATERIAS SUBSIDIARIAS', 49, 1, '2011-05-21 00:13:46', 1, 1, 'SIM'),
	(535, '71.3', 'MATERIAIS DIVERSOS', 49, 1, '2011-05-21 00:13:55', 1, 1, 'SIM'),
	(536, '71.4', 'EMBALAGENS DE CONSUMO', 49, 1, '2011-05-21 00:14:31', 1, 1, 'SIM'),
	(537, '71.5', 'OUTROS MATERIAIS', 49, 1, '2011-05-21 00:14:53', 1, 1, 'SIM'),
	(538, '71.5.1', 'CONSUMIVEIS MEDICOS', 49, 1, '2011-06-06 00:54:38', 1, 1, 'SIM'),
	(539, '71.5.2', 'PRESTACAO DE SERVICO', 49, 1, '2011-06-06 00:52:53', 1, 1, 'SIM'),
	(540, '71.9', 'TRANSFERENCIA PARA RESULTADOS OPERACIONAIS', 49, 1, '2011-05-21 00:15:25', 1, 1, 'SIM'),
	(541, '72.1', 'REMUNERACOES - ORGAOS SOCIASIS', 52, 1, '2015-12-11 11:50:32', 1, 1, 'NAO'),
	(542, '72.2', 'REMUNERACOES - PESSOAL', 52, 1, '2015-12-11 11:51:06', 1, 1, 'NAO'),
	(554, '72.3', 'PENSOES', 52, 1, '2015-12-11 11:54:02', 1, 1, 'NAO'),
	(555, '72.3.1', 'ORGAOS SOCIAIS', 70, 1, '2011-05-21 00:24:13', 1, 1, 'SIM'),
	(556, '72.4', 'PREMIOS PARA PENSOES', 52, 1, '2015-12-11 11:56:45', 1, 1, 'NAO'),
	(557, '72.4.1', 'ORGAOS SOCIAIS', 70, 1, '2011-05-21 00:25:56', 1, 1, 'SIM'),
	(558, '72.4.2', 'PESSOAL', 70, 1, '2011-05-21 00:26:29', 1, 1, 'SIM'),
	(559, '72.5', 'ENCARGOS SOBRE REMUNERACOES', 70, 1, '2015-12-11 11:59:02', 1, 1, 'NAO'),
	(560, '72.5.1', 'ORGAOS SOCIAIS', 70, 1, '2011-05-21 00:27:23', 1, 1, 'SIM'),
	(561, '72.5.2', 'PESSOAL', 70, 1, '2011-05-21 00:28:13', 1, 1, 'SIM'),
	(562, '72.6', 'SEGUROS DE ACIDENTES DE TRABALHO E DOENCAS PROFISSIONAIS', 70, 1, '2011-05-21 00:28:38', 1, 1, 'SIM'),
	(563, '72.6.1', 'ORGAOS SOCIAIS', 70, 1, '2011-05-21 00:29:50', 1, 1, 'SIM'),
	(564, '72.6.2', 'PESSOAL', 70, 1, '2011-05-21 00:30:18', 1, 1, 'SIM'),
	(565, '72.7.1', 'ORGAOS SOCIAIS', 70, 1, '2011-05-21 00:30:53', 1, 1, 'SIM'),
	(566, '72.7.2', 'PESSOAL', 70, 1, '2011-05-21 00:31:15', 1, 1, 'SIM'),
	(568, '72.8', 'OUTRAS DESPESAS COM PESSOAL', 70, 1, '2015-12-11 00:02:56', 1, 1, 'NAO'),
	(569, '72.8.1', 'ORGAOS SOCIAIS', 70, 1, '2011-05-21 00:32:16', 1, 1, 'SIM'),
	(570, '72.8.2', 'PESSOAL', 70, 1, '2011-05-21 00:32:44', 1, 1, 'SIM'),
	(571, '72.8.2.1', 'ALIMENTACAO', 70, 1, '2015-12-14 10:36:55', 1, 1, 'SIM'),
	(573, '72.9', 'TRANSFERENCIA PARA RESULTADOS OPERACIONAIS', 70, 1, '2011-05-21 00:32:56', 1, 1, 'SIM'),
	(574, '73.1', 'IMOBILIZACOES CORPOREAS', 51, 1, '2011-05-21 00:34:17', 1, 1, 'SIM'),
	(575, '73.1.2', 'EDIFICIOS E OUTRAS CONSTRUCOES', 51, 1, '2011-05-21 00:35:46', 4, 1, 'SIM'),
	(576, '73.1.3', 'EQUIPAMENTO BASICO', 51, 1, '2011-05-21 00:37:41', 4, 1, 'SIM'),
	(577, '73.1.4', 'EQUIPAMENTO DE CARGA E TRANSPORTE', 51, 1, '2011-05-21 00:38:19', 4, 1, 'SIM'),
	(578, '73.1.5', 'EQUIPAMENTO ADMINISTRATIVO', 51, 1, '2011-05-21 00:38:51', 4, 1, 'SIM'),
	(579, '73.1.6', 'TARAS E VASILHAME', 51, 1, '2011-05-21 00:39:29', 4, 1, 'SIM'),
	(580, '73.1.9', 'OUTRAS IMOBILIZACOES CORPOREAS', 51, 1, '2011-05-21 00:39:56', 4, 1, 'SIM'),
	(581, '73.2', 'IMOBILIZACOES INCORPOREAS', 51, 1, '2011-05-21 00:40:45', 1, 1, 'SIM'),
	(582, '73.2.1', 'TRESPASSES', 51, 1, '2011-05-21 00:41:35', 1, 1, 'SIM'),
	(583, '73.2.2', 'DESPESAS DE INVESTIGACAO E DESENVOLVIMENTO', 51, 1, '2011-05-21 00:43:26', 1, 1, 'SIM'),
	(584, '73.2.3', 'PROPRIEDADE INDUSTRIAL E OUTROS DIREITOS E CONTRATOS', 51, 1, '2011-05-21 00:44:11', 1, 1, 'SIM'),
	(585, '73.2.4', 'DESPESAS DE CONTITUICAO', 51, 1, '2011-05-21 00:49:06', 1, 1, 'SIM'),
	(586, '73.2.9', 'OUTRAS IMOBILIZACOES INCORPOREAS', 51, 1, '2011-05-21 00:50:11', 1, 1, 'SIM'),
	(587, '73.9', 'TRANSFERENCIA PARA RESULTADOS OPERACIONAIS', 51, 1, '2011-05-21 00:51:52', 1, 1, 'SIM'),
	(588, '75.1', 'SUB-CONTRATOS', 41, 1, '2015-12-11 10:36:03', 1, 1, 'NAO'),
	(589, '75.2', 'FORNECIMENTOS E SERVICOS DE TERCEIROS', 52, 1, '2015-12-11 10:37:51', 1, 1, 'NAO'),
	(590, '75.2.1.1', 'AGUA', 52, 1, '2015-12-11 10:40:31', 1, 1, 'SIM'),
	(591, '75.2.1.2', 'ELECTRICIDADE', 52, 1, '2015-12-11 10:40:48', 1, 1, 'SIM'),
	(592, '75.2.1.3', 'COMBUSTIVEIS E OUTROS FLUIDOS', 52, 1, '2015-12-11 10:41:16', 1, 1, 'SIM'),
	(593, '75.2.1.4', 'CONSERVACAO E REPARACAO', 52, 1, '2015-12-11 10:41:41', 1, 1, 'NAO'),
	(594, '75.2.1.5', 'MATERIAL DE PROTECCAO, SEGURANCA E CONFORTO', 52, 1, '2015-12-11 10:45:27', 1, 1, 'SIM'),
	(595, '75.2.1.6', 'FERRAMENTAS E UTENSILHOS DE DESGASTE RAPIDO', 52, 1, '2015-12-11 10:45:41', 1, 1, 'SIM'),
	(596, '75.2.1.7', 'MATERIAL DE ESCRITORIO', 52, 1, '2015-12-11 10:46:48', 1, 1, 'SIM'),
	(597, '75.2.1.8', 'LIVROS E DOCUMENTACAO TECNICA', 52, 1, '2015-12-11 10:47:00', 1, 1, 'SIM'),
	(598, '75.2.1.9', 'OUTROS FORNECIMENTOS', 52, 1, '2015-12-11 10:48:29', 1, 1, 'NAO'),
	(599, '75.2.2.0', 'COMUNICACAO', 52, 1, '2015-12-11 10:51:02', 1, 1, 'SIM'),
	(600, '75.2.2.1', 'RENDAS E ALUGUERES', 52, 1, '2015-12-11 10:51:27', 1, 1, 'SIM'),
	(601, '75.2.2.2', 'SEGUROS', 52, 1, '2015-12-11 11:17:29', 1, 1, 'NAO'),
	(602, '75.2.2.3', 'DESLOCACOES E ESTADIAS', 52, 1, '2015-12-11 11:18:48', 1, 1, 'SIM'),
	(603, '75.2.2.4', 'DESPESAS DE REPRESENTACAO', 52, 1, '2015-12-11 11:19:01', 1, 1, 'SIM'),
	(604, '75.2.2.6', 'CONSERVACAO E REPARACAO', 52, 1, '2015-12-11 11:19:19', 1, 1, 'SIM'),
	(605, '75.2.2.7', 'VIGILANCIA E SEGURANCA', 52, 1, '2015-12-11 11:19:32', 1, 1, 'SIM'),
	(606, '75.2.2.8', 'LIMPEZA, HIGIENE E CONFORTO', 52, 1, '2015-12-11 11:19:44', 1, 1, 'SIM'),
	(607, '75.2.2.9', 'PUBLICIDADE E PROPAGANDA', 52, 1, '2015-12-11 11:19:58', 1, 1, 'SIM'),
	(608, '75.2.3.0', 'CONTENCIOSO E NOTARIADO', 52, 1, '2015-12-11 11:20:18', 1, 1, 'SIM'),
	(609, '75.2.3.1', 'COMISSOES A INTERMEDIARIOS', 52, 1, '2015-12-11 11:22:22', 1, 1, 'SIM'),
	(610, '75.2.3.2', 'ASSISTENCIA TECNICA', 52, 1, '2015-12-11 11:23:24', 1, 1, 'NAO'),
	(612, '75.2.3.2.2', 'NACIONAL', 52, 1, '2015-12-11 11:24:04', 1, 1, 'SIM'),
	(613, '75.2.3.3', 'TRABALHOS EXECUTADOS NO EXTERIOR', 52, 1, '2015-12-11 11:26:37', 1, 1, 'SIM'),
	(614, '75.2.3.4', 'HONORARIOS E AVENCAS', 52, 1, '2015-12-11 11:26:57', 1, 1, 'SIM'),
	(615, '75.2.3.5', 'ROYALTIES', 52, 1, '2015-12-11 11:27:24', 1, 1, 'SIM'),
	(616, '75.2.3.9', 'OUTROS SERVICOS', 52, 1, '2015-12-11 11:27:40', 1, 1, 'NAO'),
	(617, '75.2.3.9.1', 'SAUDE', 52, 1, '2015-12-11 11:29:32', 1, 1, 'SIM'),
	(618, '75.2.3.9.2', 'OFERTAS E GRATIFICAÃ‡OES', 52, 1, '2015-12-11 11:30:12', 1, 1, 'SIM'),
	(619, '75.3', 'IMPOSTOS', 52, 1, '2015-12-11 11:34:42', 1, 1, 'NAO'),
	(620, '75.3.1', 'INDIRECTOS', 52, 1, '2011-05-21 01:16:04', 1, 1, 'SIM'),
	(621, '75.3.1.1', 'IMPOSTO DE SELO/ VENDAS', 52, 1, '2015-12-11 11:35:50', 1, 1, 'SIM'),
	(622, '75.3.1.2', 'IMPOSTOS DE SELO/ OUTROS', 52, 1, '2015-12-11 11:36:46', 1, 1, 'SIM'),
	(623, '75.3.1.9', 'OUTROS IMPOSTOS', 52, 1, '2011-05-21 01:17:01', 1, 1, 'SIM'),
	(624, '75.3.2', 'DIRECTOS', 52, 1, '2015-12-11 11:41:24', 1, 1, 'NAO'),
	(625, '75.3.2.1', 'IMPOSTO DE CAPITAIS', 52, 1, '2011-05-21 01:18:05', 1, 1, 'SIM'),
	(626, '75.3.2.2', 'CONTRIBUICAO PREDIAL', 52, 1, '2011-05-21 01:20:07', 1, 1, 'SIM'),
	(627, '75.3.2.3', 'LICENÃ‡AS E TAXAS', 52, 1, '2015-12-11 11:42:27', 1, 1, 'SIM'),
	(628, '75.3.2.9', 'OUTROS IMPOSTOS', 52, 1, '2011-05-21 01:20:44', 1, 1, 'SIM'),
	(629, '75.4', 'DESPESAS CONFIDENCIAIS', 52, 1, '2011-05-21 01:21:15', 1, 1, 'SIM'),
	(630, '75.5', 'QUOTIZACOES', 52, 1, '2011-05-21 01:22:41', 1, 1, 'SIM'),
	(631, '75.6', 'OFERTAS E AMOSTRAS DE EXISTENCIAS', 52, 1, '2011-05-21 01:23:05', 1, 1, 'SIM'),
	(632, '75.8', 'OUTROS CUSTOS E PERDAS OPERACIONAIS', 52, 1, '2011-05-21 01:23:46', 1, 1, 'SIM'),
	(635, '75.9', 'TRANSFERENCIA PARA RESULTADOS OPERACIONAIS', 52, 1, '2011-05-21 01:26:49', 1, 1, 'SIM'),
	(636, '76.1', 'JUROS', 53, 1, '2011-05-21 01:27:55', 1, 1, 'SIM'),
	(637, '76.1.1', 'DE EMPRESTIMOS', 53, 1, '2011-05-21 01:28:35', 1, 1, 'SIM'),
	(638, '76.1.1.1', 'BANCARIOS', 53, 1, '2011-06-05 10:10:39', 1, 1, 'SIM'),
	(639, '76.1.1.2', 'OBRIGACOES', 53, 1, '2011-05-21 01:29:46', 1, 1, 'SIM'),
	(640, '76.1.1.3', 'TITULOS DE PARTICIPACAO', 53, 1, '2011-05-21 01:32:41', 1, 1, 'SIM'),
	(641, '76.1.2', 'DE DESCOBERTOS BANCARIOS', 53, 1, '2011-05-21 01:33:22', 1, 1, 'SIM'),
	(642, '76.1.3', 'DE MORA RELATIVOS A DIVIDAS A TERCEIROS', 53, 1, '2011-05-21 01:34:13', 1, 1, 'SIM'),
	(643, '76.1.4', 'DE DESCONTO DE TITULOS', 53, 1, '2011-05-21 01:34:59', 1, 1, 'SIM'),
	(644, '76.2', 'DIFERENCAS DE CAMBIO DESFAVORAVEL', 53, 1, '2011-05-21 01:35:36', 1, 1, 'SIM'),
	(645, '76.2.1', 'REALIZADAS', 53, 1, '2011-06-05 10:38:45', 1, 1, 'SIM'),
	(646, '76.2.2', 'NAO REALIZADAS', 53, 1, '2011-05-22 08:56:58', 1, 1, 'SIM'),
	(647, '76.3', 'DESCONTOS DE PRONTO PAGAMENTO CONCEDIDOS', 53, 1, '2011-05-22 08:57:16', 1, 1, 'SIM'),
	(648, '76.4', 'AMORTIZACOES DE INVESTIMENTOS EM IMOVEIS', 53, 1, '2011-05-22 08:58:01', 1, 1, 'SIM'),
	(649, '76.5', 'PROVISOES PARA APLICACOES FINANCEIRAS', 53, 1, '2011-05-22 08:59:01', 1, 1, 'SIM'),
	(650, '76.5.1', 'INVESTIMENTOS FINANCEIROS', 53, 1, '2011-05-22 08:59:51', 1, 1, 'SIM'),
	(651, '76.5.1.3', 'OUTRAS EMPRESAS', 53, 1, '2011-05-22 09:01:08', 1, 1, 'SIM'),
	(652, '76.5.1.4', 'FUNDOS', 53, 1, '2011-05-22 09:01:32', 1, 1, 'SIM'),
	(653, '76.5.1.9', 'OUTROS INVESTIMENTOS', 53, 1, '2011-05-22 09:02:22', 1, 1, 'SIM'),
	(654, '76.5.2', 'APLICACOES DE TESOURARIA', 53, 1, '2011-05-22 09:02:49', 1, 1, 'SIM'),
	(655, '76.5.2.1', 'TITULOS NEGOCIAVEIS', 53, 1, '2011-05-22 09:03:53', 1, 1, 'SIM'),
	(656, '76.5.2.2', 'DEPOSITOS A PRAZO', 53, 1, '2011-05-22 09:05:04', 1, 1, 'SIM'),
	(657, '76.5.2.3', 'OUTROS DEPOSITOS', 53, 1, '2011-05-22 09:05:35', 1, 1, 'SIM'),
	(658, '76.5.2.9', 'OUTROS', 53, 1, '2011-05-22 09:05:57', 1, 1, 'SIM'),
	(659, '76.6', 'PERDAS NA ALIENACAO DE APLICACOES FINANCEIRAS', 53, 1, '2011-05-22 09:06:24', 1, 1, 'SIM'),
	(660, '76.6.1', 'INVESTIMENTOS FINANCEIROS', 53, 1, '2011-05-22 09:07:06', 1, 1, 'SIM'),
	(661, '76.6.1.1', 'SUBSIDIARIAS', 53, 1, '2011-05-22 09:07:36', 1, 1, 'SIM'),
	(662, '76.6.1.3', 'OUTRAS EMPRESAS', 53, 1, '2011-05-22 09:10:12', 1, 1, 'SIM'),
	(663, '76.6.1.4', 'FUNDOS', 53, 1, '2011-05-22 09:11:21', 1, 1, 'SIM'),
	(664, '76.6.1.9', 'OUTROS INVESTIMENTOS', 53, 1, '2011-05-22 09:12:07', 1, 1, 'SIM'),
	(665, '76.6.2', 'APLICACOES DE TITULOS NEGOCIAVEIS', 53, 1, '2011-05-22 09:12:49', 1, 1, 'SIM'),
	(666, '76.7', 'SERVICOS BANCARIOS', 53, 1, '2011-05-22 09:13:41', 1, 1, 'SIM'),
	(667, '76.7.1', 'TAXAS, COMISSOES, JUROS, ETC', 53, 1, '2011-08-16 05:41:14', 1, 1, 'SIM'),
	(668, '76.7.2', 'EMISSAO DE CHEQUE', 53, 1, '2011-08-16 05:42:25', 1, 1, 'SIM'),
	(669, '76.7.3', 'EMISSAO DE EXTRACTOS', 53, 1, '2011-08-16 05:43:03', 1, 1, 'SIM'),
	(670, '76.9', 'TRANSFERENCIA PARA RESULTADOS FINANCEIROS', 53, 1, '2011-05-22 09:14:52', 1, 1, 'SIM'),
	(671, '77.9', 'TRANSFERENCIA PARA  RESULTADOS FINANCEIROS', 54, 1, '2011-05-22 11:23:09', 1, 1, 'SIM'),
	(672, '78.1', 'PROVISOES DO EXERCICIO', 55, 1, '2011-05-22 11:23:46', 1, 1, 'SIM'),
	(673, '78.1.1', 'EXISTENCIA', 55, 1, '2011-05-22 11:24:33', 1, 1, 'SIM'),
	(674, '78.1.1.1', 'MATERIAS-PRIMAS  SUBSIDIARIAS  E DE CONSUMO', 55, 1, '2011-05-22 11:24:49', 1, 1, 'SIM'),
	(675, '78.1.1.2', 'PRODUTOS E TRABALHOS EM CURSO', 55, 1, '2011-05-22 11:26:07', 1, 1, 'SIM'),
	(676, '78.1.1.3', 'PRODUTOS ACABADOS E INTERMEDIOS', 55, 1, '2011-05-22 11:26:35', 1, 1, 'SIM'),
	(677, '78.1.1.4', 'SUB-PRODUTOS , DESPERDICIOS, RESIDUOS E REFUGOS', 55, 1, '2011-05-22 11:28:51', 1, 1, 'SIM'),
	(678, '78.1.1.5', 'MERCADORIAS', 55, 1, '2011-05-22 11:30:16', 1, 1, 'SIM'),
	(679, '78.1.2', 'COBRANCAS DUVIDOSAS', 55, 1, '2011-05-22 11:30:49', 1, 1, 'SIM'),
	(680, '78.1.2.1', 'CLIENTES', 55, 1, '2011-05-22 11:31:29', 1, 1, 'SIM'),
	(681, '78.1.2.2', 'CLIENTES - TITULOS A RECEBER', 55, 1, '2011-05-22 11:31:49', 1, 1, 'SIM'),
	(682, '78.1.2.3', 'CLIENTES - COBRANCA DUVIDOSA', 55, 1, '2011-05-22 11:32:55', 1, 1, 'SIM'),
	(683, '78.1.2.4', 'SALDOS DEVEDORES DE FORNECEDORES', 55, 1, '2011-05-22 11:33:38', 1, 1, 'SIM'),
	(684, '78.1.2.5', 'PARTICIPANTES E PARTICIPADAS', 55, 1, '2011-05-22 11:36:40', 1, 1, 'SIM'),
	(685, '78.1.2.6', 'DIVIDAS DO PESSOAL', 55, 1, '2011-05-22 11:37:30', 1, 1, 'SIM'),
	(686, '78.1.2.9', 'OUTROS SALDOS A RECEBER', 55, 1, '2011-05-22 11:38:10', 1, 1, 'SIM'),
	(687, '78.1.3', 'RISCOS E ENCARGOS', 55, 1, '2011-05-22 11:38:46', 1, 1, 'SIM'),
	(688, '78.1.3.1', 'PENSOES', 55, 1, '2011-05-22 11:39:16', 1, 1, 'SIM'),
	(689, '78.1.3.2', 'PROCESSOS JUDICIAIS EM CURSO', 55, 1, '2011-05-22 11:39:30', 1, 1, 'SIM'),
	(690, '78.1.3.3', 'ACIDENTES DE TRABALHO', 55, 1, '2011-05-22 11:43:57', 1, 1, 'SIM'),
	(691, '78.1.3.4', 'GARANTIAS DADAS A CLIENTES', 55, 1, '2011-05-22 11:44:45', 1, 1, 'SIM'),
	(692, '78.1.3.9', 'OUTROS RISCOS E ENCARGOS', 55, 1, '2011-05-22 11:45:13', 1, 1, 'SIM'),
	(693, '78.10', 'CORRECCOES RELATIVAS A EXERCICIOS ANTERIORES', 55, 1, '2011-05-22 11:55:32', 1, 1, 'SIM'),
	(694, '78.10.1', 'ESTIMATIVA IMPOSTO', 55, 1, '2011-05-22 11:56:37', 1, 1, 'SIM'),
	(695, '78.10.2', 'DIVERSOS', 55, 1, '2011-06-06 01:15:04', 1, 1, 'SIM'),
	(696, '78.10.3', 'OUTRAS CORRECCOES', 55, 1, '2011-06-06 01:16:30', 1, 1, 'SIM'),
	(697, '78.11', 'OUTROS CUSTOS E PERDAS NAO OPERACIONAIS', 55, 1, '2011-05-22 11:57:03', 1, 1, 'SIM'),
	(698, '78.11.1', 'DONATIVOS', 55, 1, '2011-05-22 11:57:43', 1, 1, 'SIM'),
	(699, '78.11.1.1', 'CONDOLENCIAS', 55, 1, '2011-06-06 01:15:47', 1, 1, 'SIM'),
	(700, '78.11.2', 'REEMBOLSO DE SUBSIDIOS A EXPLORACAO', 55, 1, '2011-05-22 11:57:59', 1, 1, 'SIM'),
	(701, '78.11.3', 'REEMBOLSO DE SUBSIDIOS A INVESTIMENTOS', 55, 1, '2011-05-22 11:58:54', 1, 1, 'SIM'),
	(702, '78.11.4', 'CONDOLENCIAS', 55, 1, '2011-08-11 06:37:13', 1, 1, 'SIM'),
	(703, '78.11.5', 'REGULARIZACAO DOS IMPOSTOS', 55, 1, '2011-08-11 06:47:18', 1, 1, 'SIM'),
	(704, '78.19', 'TRANSFERENCIA PARA RESULTADOS NAO OPERACIONAIS', 55, 1, '2011-05-22 11:59:50', 1, 1, 'SIM'),
	(705, '78.2', 'AMORTIZACOES EXTRAORDIANARIAS', 55, 1, '2011-05-22 11:45:46', 1, 1, 'SIM'),
	(706, '78.2.1', 'IMOBILIZACOES CORPOREAS', 55, 1, '2011-05-22 11:46:36', 1, 1, 'SIM'),
	(707, '78.2.2', 'IMOBILIZACOES INCORPOREAS', 55, 1, '2011-05-22 11:47:33', 1, 1, 'SIM'),
	(708, '78.3', 'PERDAS EM IMOBILIZACOES', 55, 1, '2011-05-22 11:48:12', 1, 1, 'SIM'),
	(709, '78.3.1', 'VENDA DE IMOBILIZACOES CORPOREAS', 55, 1, '2011-05-22 11:48:39', 1, 1, 'SIM'),
	(710, '78.3.2', 'VENDA DE IMOBILIZACOES INCORPOREAS', 55, 1, '2011-05-22 11:49:18', 1, 1, 'SIM'),
	(711, '78.3.3', 'ABATES', 55, 1, '2011-05-22 11:50:06', 1, 1, 'SIM'),
	(712, '78.3.9', 'OUTRAS', 55, 1, '2011-05-22 11:50:16', 1, 1, 'SIM'),
	(713, '78.4', 'PERDAS EM EXISTENCIA', 55, 1, '2011-05-22 11:50:34', 1, 1, 'SIM'),
	(714, '78.4.1', 'QUEBRAS', 55, 1, '2011-05-22 11:51:01', 1, 1, 'SIM'),
	(715, '78.5', 'DIVIDAS INCOBRAVEIS', 55, 1, '2011-05-22 11:51:27', 1, 1, 'SIM'),
	(716, '78.6', 'MULTAS E PENALIDADES CONTRATUAIS', 55, 1, '2011-05-22 11:51:58', 1, 1, 'SIM'),
	(717, '78.6.1', 'FISCAIS', 55, 1, '2011-05-22 11:52:47', 1, 1, 'SIM'),
	(718, '78.6.2', 'NAO FISCAIS', 55, 1, '2011-05-22 11:53:06', 1, 1, 'SIM'),
	(719, '78.6.3', 'PENALIDADES CONTRATUAIS', 55, 1, '2011-05-22 11:53:20', 1, 1, 'SIM'),
	(720, '78.7', 'CUSTOS DE REESTRUTURACAO', 55, 1, '2011-05-22 11:53:51', 1, 1, 'SIM'),
	(721, '78.8', 'DESCONTINUIDADE DE OPERACOES', 55, 1, '2011-05-22 11:54:24', 1, 1, 'SIM'),
	(722, '78.9', 'ALTERACOES DE POLITICAS CONTABILISTICAS', 55, 1, '2011-05-22 11:54:58', 1, 1, 'SIM'),
	(723, '79.1', 'PERDAS RESULTANTES DE CATASTROFES NATURAIS', 56, 1, '2011-06-05 11:08:17', 1, 1, 'SIM'),
	(724, '79.2', 'PERDAS RESULTANTES DE CONVULSOES POLITICAS', 56, 1, '2011-05-23 00:24:03', 1, 1, 'SIM'),
	(725, '79.3', 'PERDAS RESULTANTES DE EXPROPRIACOES', 56, 1, '2011-05-23 00:24:56', 1, 1, 'SIM'),
	(726, '79.4', 'PERDAS RESULTANTES DE SNISTROS', 56, 1, '2011-05-23 00:26:08', 1, 1, 'SIM'),
	(727, '79.9', 'TRANSFERENCIA PARA RESULTADOS EXTRAORDINARIOS', 56, 1, '2011-05-23 00:27:18', 1, 1, 'SIM'),
	(728, '81.1', 'ANO', 57, 1, '2011-05-23 00:28:14', 4, 1, 'SIM'),
	(729, '81.1.1', 'RESULTADO DO ANO', 57, 1, '2011-05-23 00:29:23', 4, 1, 'SIM'),
	(730, '81.1.2', 'APLICAÃƒâ€¡AO DE RESULTADOS', 57, 1, '2011-05-23 00:29:44', 4, 1, 'SIM'),
	(731, '81.1.3', 'CORRECCOES DE ERROS FUNDAMENTAIS, NO EXERCICIO SEGUINTE', 57, 1, '2011-05-23 00:30:10', 4, 1, 'SIM'),
	(732, '81.1.4', 'EFEITO DAS ALTERACOES DE POLITICAS CONTABILISTICAS', 57, 1, '2011-05-23 00:31:22', 4, 1, 'SIM'),
	(733, '81.1.5', 'IMPOSTO RELATIVO A CORRECCOES DE ERROS FUNDAMENTAIS E ALTERACOES DE POLITICAS CONTABILISTICAS', 57, 1, '2011-05-23 00:32:25', 4, 1, 'SIM'),
	(734, '81.2', 'ANO', 57, 1, '2011-05-23 00:36:27', 4, 1, 'SIM'),
	(735, '81.2.1', 'RESULTADO DO ANO', 57, 1, '2011-05-23 00:36:39', 4, 1, 'SIM'),
	(736, '81.2.2', 'APLICACAO DE RESULTADOS', 57, 1, '2011-05-23 00:37:05', 4, 1, 'SIM'),
	(737, '81.2.3', 'CORRECCOES DE ERROS FUNDAMENTAIS, NO EXERCICIO SEGUINTE', 57, 1, '2011-05-23 00:37:24', 4, 1, 'SIM'),
	(738, '81.2.4', 'EFEITO DAS ALTERACOES DE POLITICAS CONTABILISTICAS', 57, 1, '2011-05-23 00:38:48', 4, 1, 'SIM'),
	(739, '81.2.5', 'IMPOSTO RELETIVO A CORRECCOES DE ERROS FUNDAMENTAIS E ALTERACOES DE POLITICAS CONTABILISTICAS', 57, 1, '2011-05-23 00:39:42', 4, 1, 'SIM'),
	(740, '82.1', 'VENDAS', 58, 1, '2011-05-23 00:41:09', 4, 1, 'SIM'),
	(741, '82.19', 'TRANSFERENCIA PARA RESULTADOS LIQUIDOS', 58, 1, '2011-05-23 00:48:02', 4, 1, 'SIM'),
	(742, '82.2', 'PRESTACOES DE SERVICO', 58, 1, '2011-05-23 00:41:45', 4, 1, 'SIM'),
	(743, '82.3', 'OUTROS PROVEITOS OPERACIONAIS', 58, 1, '2011-05-23 00:42:11', 4, 1, 'SIM'),
	(744, '82.4', 'VARIACAO NOS INVENTARIOS DE PRODUTOS ACABADOS E PRODUTOS EM VIAS DE FABRICO', 58, 1, '2011-05-23 00:42:47', 4, 1, 'SIM'),
	(745, '82.5', 'TRABALHOS PARA A PROPRIA EMPRESA', 58, 1, '2011-05-23 00:44:17', 4, 1, 'SIM'),
	(746, '82.6', 'CUSTO DAS MERCADORIAS VENDIDAS E DAS MATERIAS CONSUMIDAS', 58, 1, '2011-05-23 00:45:01', 4, 1, 'SIM'),
	(747, '82.7', 'CUSTO COM O PESSOAL', 58, 1, '2011-05-23 00:46:13', 4, 1, 'SIM'),
	(748, '82.8', 'AMORTIZACOES DO EXERCICO', 58, 1, '2011-05-23 00:46:36', 4, 1, 'SIM'),
	(749, '82.9', 'OUTROS CUSTOS OPERACIONAIS', 58, 1, '2011-05-23 00:47:33', 4, 1, 'SIM'),
	(750, '83.1', 'PROVEITOS E GANHOS FINACEIROS GERAIS', 59, 1, '2011-05-23 00:48:51', 4, 1, 'SIM'),
	(751, '83.2', 'CUSTOS E PERDAS FINANCEIROS GERAIS', 59, 1, '2011-06-05 11:08:21', 4, 1, 'SIM'),
	(752, '84.1', 'PROVEITOS E GANHOS EM FILIAIS E ASSOCIADAS', 60, 1, '2011-05-23 00:51:50', 4, 1, 'SIM'),
	(753, '84.2', 'CUSTOS E PERDAS EM FILIAIS E ASSOCIADS', 60, 1, '2011-05-23 00:52:48', 4, 1, 'SIM'),
	(754, '84.9', 'TRANSFERENCIA PARA RESULTADOS LIQUIDOS', 60, 1, '2011-05-23 00:53:46', 4, 1, 'SIM'),
	(755, '85.1', 'PROVEITOS E GANHOS NAO OPERACIONAIS', 61, 1, '2011-05-23 00:54:21', 4, 1, 'SIM'),
	(756, '85.9', 'TRANSFERENCIA PARA RESULTADOS LIQUIDOS', 61, 1, '2011-05-23 00:59:43', 4, 1, 'SIM'),
	(757, '86.2', 'CUSTOS E PERDAS EXTRAORDINARIOS', 62, 1, '2011-05-23 01:01:14', 4, 1, 'SIM'),
	(758, '86.9', 'TRANSFERENCIA PARA RESULTADOS LIQUIDOS', 62, 1, '2011-05-23 01:01:54', 4, 1, 'SIM'),
	(759, '87.1', 'IMPOSTO SOBRE SOBRE OS RESULTADOS CORRENTES', 62, 1, '2011-05-23 01:02:28', 4, 1, 'SIM'),
	(760, '87.2', 'IMPOSTO SOBRE OS RESULTADOS EXTRAORDINARIOS', 63, 1, '2011-05-23 01:05:03', 4, 1, 'SIM'),
	(761, '87.9', 'TRANSFERENCIA PARA RESULTADOS LIQUIDOS', 63, 1, '2011-05-23 01:06:03', 4, 1, 'SIM'),
	(762, '88.1', 'RESULTADOS OPERACIONAIS', 64, 1, '2011-05-23 01:06:42', 4, 1, 'SIM'),
	(763, '88.2', 'RESULTADOS FINANCEIROS GERAIS', 64, 1, '2011-05-23 01:07:25', 4, 1, 'SIM'),
	(764, '88.3', 'RESULTADOS EM FILIAIS E ASSOCIADS', 64, 1, '2011-05-23 01:07:53', 4, 1, 'SIM'),
	(765, '88.4', 'RESULTADOS NAO OPERACIONAIS', 64, 1, '2011-06-05 11:16:15', 4, 1, 'SIM'),
	(766, '88.5', 'IMPOSTO SOBRE  OS RESULTADOS CORRENTES', 64, 1, '2011-05-23 01:09:15', 4, 1, 'SIM'),
	(767, '88.6', 'RESULTADOS EXTRAORDINARIOS', 64, 1, '2011-05-23 01:14:16', 4, 1, 'SIM'),
	(768, '88.7', 'IMPOSTO SOBRE OS RESULTADOS EXTRAORDINARIOS', 64, 1, '2011-05-23 01:15:05', 4, 1, 'SIM'),
	(769, '88.9', 'TRANSFERENCIA PARA RESULTADOS LIQUIDOS', 64, 1, '2011-05-23 01:16:59', 4, 1, 'SIM'),
	(770, '89.9', 'TRANSFERENCIA PARA RESULTADOS TRANSITAIDOS', 65, 1, '2011-05-23 01:18:03', 4, 1, 'SIM'),
	(780, '75.2.29.1', 'REDES SOCIAIS', 52, 1, '2014-04-08 03:53:26', 1, 1, 'SIM'),
	(781, '75.2.29.2', 'BRINDES', 52, 1, '2014-04-08 03:54:27', 1, 1, 'SIM'),
	(784, '48.2.1', 'RECEBIMENTOS EM MULTI CAIXA', 30, 1, '2011-06-06 00:37:50', 3, 1, 'SIM'),
	(785, '32.1.2.1.1', 'FORNECEDOR DIVERSOS', 17, 1, '2011-05-17 11:37:40', 3, 1, 'SIM'),
	(793, '71.3.1', 'PRODUTOS MEDICOS E FARMACEUTICOS', 49, 1, '2011-05-21 00:15:25', 1, 1, 'SIM'),
	(795, '32.1.2.1.2', 'DIVERSOS', 17, 1, '2011-05-17 11:37:40', 3, 1, 'SIM'),
	(796, '31.1.2.1.2', 'DIVERSOS', 16, 1, '2020-05-11 00:00:00', 3, 1, 'SIM');
/*!40000 ALTER TABLE `subcontas` ENABLE KEYS */;

-- Dumping structure for table contsys.tipo_contas
CREATE TABLE IF NOT EXISTS `tipo_contas` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.tipo_contas: ~4 rows (approximately)
/*!40000 ALTER TABLE `tipo_contas` DISABLE KEYS */;
INSERT INTO `tipo_contas` (`Codigo`, `Descricao`) VALUES
	(1, 'Custo'),
	(2, ' Proveito'),
	(3, ' Activo'),
	(4, 'Passivo');
/*!40000 ALTER TABLE `tipo_contas` ENABLE KEYS */;

-- Dumping structure for table contsys.tipo_imobilizado
CREATE TABLE IF NOT EXISTS `tipo_imobilizado` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) NOT NULL,
  `CodigoClasse` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_tipo_imobilizado_1` (`CodigoClasse`),
  CONSTRAINT `FK_tipo_imobilizado_1` FOREIGN KEY (`CodigoClasse`) REFERENCES `classeimobilizado` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.tipo_imobilizado: ~0 rows (approximately)
/*!40000 ALTER TABLE `tipo_imobilizado` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo_imobilizado` ENABLE KEYS */;

-- Dumping structure for table contsys.tipo_movimentos
CREATE TABLE IF NOT EXISTS `tipo_movimentos` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.tipo_movimentos: ~3 rows (approximately)
/*!40000 ALTER TABLE `tipo_movimentos` DISABLE KEYS */;
INSERT INTO `tipo_movimentos` (`Codigo`, `Designacao`) VALUES
	(1, 'DEBITO'),
	(2, 'CREDITO'),
	(3, 'DIVERSSO');
/*!40000 ALTER TABLE `tipo_movimentos` ENABLE KEYS */;

-- Dumping structure for table contsys.tipo_utilizadores
CREATE TABLE IF NOT EXISTS `tipo_utilizadores` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Descricao` varchar(45) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.tipo_utilizadores: ~0 rows (approximately)
/*!40000 ALTER TABLE `tipo_utilizadores` DISABLE KEYS */;
INSERT INTO `tipo_utilizadores` (`Codigo`, `Descricao`) VALUES
	(1, 'administrator');
/*!40000 ALTER TABLE `tipo_utilizadores` ENABLE KEYS */;

-- Dumping structure for table contsys.utilizadores
CREATE TABLE IF NOT EXISTS `utilizadores` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(145) NOT NULL,
  `Username` varchar(45) DEFAULT NULL,
  `Password` varchar(45) DEFAULT NULL,
  `CodStatus` int(10) unsigned DEFAULT NULL,
  `CodTipoUser` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_utilizadores_1` (`CodStatus`),
  KEY `FK_utilizadores_2` (`CodTipoUser`),
  CONSTRAINT `FK_utilizadores_1` FOREIGN KEY (`CodStatus`) REFERENCES `status_utilizadores` (`Codigo`),
  CONSTRAINT `FK_utilizadores_2` FOREIGN KEY (`CodTipoUser`) REFERENCES `tipo_utilizadores` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table contsys.utilizadores: ~0 rows (approximately)
/*!40000 ALTER TABLE `utilizadores` DISABLE KEYS */;
INSERT INTO `utilizadores` (`Codigo`, `Nome`, `Username`, `Password`, `CodStatus`, `CodTipoUser`) VALUES
	(1, 'Administrador', 'root', 'root', 1, 1);
/*!40000 ALTER TABLE `utilizadores` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
