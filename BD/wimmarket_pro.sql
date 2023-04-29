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


-- Dumping database structure for wimmarket_pro
CREATE DATABASE IF NOT EXISTS `wimmarket_pro` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `wimmarket_pro`;

-- Dumping structure for table wimmarket_pro.actualizacao_stock
CREATE TABLE IF NOT EXISTS `actualizacao_stock` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  `Descricao` varchar(245) DEFAULT NULL,
  `TipoActualizacao` varchar(45) NOT NULL DEFAULT '',
  `ExistenciaAntiga` double NOT NULL DEFAULT '0',
  `ExistenciaNova` double NOT NULL DEFAULT '0',
  `CodigoProduto` int(10) unsigned NOT NULL,
  `DataActualizacao` datetime NOT NULL,
  `CodigoArmazem` int(11) DEFAULT '1',
  PRIMARY KEY (`Codigo`),
  KEY `FK_actualizacao_stock_1` (`CodigoProduto`),
  KEY `FK_actualizacao_stock_2` (`CodigoUtilizador`),
  CONSTRAINT `FK_actualizacao_stock_2` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.actualizacao_stock: ~0 rows (approximately)
/*!40000 ALTER TABLE `actualizacao_stock` DISABLE KEYS */;
/*!40000 ALTER TABLE `actualizacao_stock` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.agentes
CREATE TABLE IF NOT EXISTS `agentes` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(450) NOT NULL,
  `Endereco` varchar(45) NOT NULL,
  `Nif` varchar(45) NOT NULL,
  `Telefone1` varchar(45) NOT NULL,
  `Telefone2` varchar(45) NOT NULL,
  `Telefone3` varchar(45) DEFAULT NULL,
  `Telefone4` varchar(45) DEFAULT NULL,
  `Email` varchar(45) NOT NULL,
  `WebSite` varchar(45) DEFAULT NULL,
  `Municipio` varchar(45) NOT NULL,
  `CertificadoInapen` varchar(45) NOT NULL,
  `DiarioRepublica` varchar(45) NOT NULL,
  `LiquidacaoImpostos` varchar(45) NOT NULL,
  `ArrecadacaoReceitas` varchar(45) NOT NULL,
  `CertificadoSeguranca` varchar(45) NOT NULL,
  `RegistoInspensao` varchar(45) NOT NULL,
  `CodigoStatus` int(10) unsigned NOT NULL DEFAULT '1',
  `DataCadastro` varchar(45) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.agentes: ~0 rows (approximately)
/*!40000 ALTER TABLE `agentes` DISABLE KEYS */;
/*!40000 ALTER TABLE `agentes` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.ano
CREATE TABLE IF NOT EXISTS `ano` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Ano` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.ano: ~3 rows (approximately)
/*!40000 ALTER TABLE `ano` DISABLE KEYS */;
INSERT INTO `ano` (`Codigo`, `Ano`) VALUES
	(1, 2019),
	(2, 2018),
	(3, 2020);
/*!40000 ALTER TABLE `ano` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.armazens
CREATE TABLE IF NOT EXISTS `armazens` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(145) NOT NULL,
  `Localizacao` varchar(45) DEFAULT NULL,
  `DataCriacao` datetime NOT NULL,
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  `CodigoStatus` int(10) unsigned NOT NULL DEFAULT '1',
  `Sigla` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_armazens_1` (`CodigoUtilizador`),
  KEY `FK_armazens_2` (`CodigoStatus`),
  CONSTRAINT `FK_armazens_1` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_armazens_2` FOREIGN KEY (`CodigoStatus`) REFERENCES `status` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.armazens: ~0 rows (approximately)
/*!40000 ALTER TABLE `armazens` DISABLE KEYS */;
INSERT INTO `armazens` (`Codigo`, `Designacao`, `Localizacao`, `DataCriacao`, `CodigoUtilizador`, `CodigoStatus`, `Sigla`) VALUES
	(1, 'DIVERSOS', 'Luanda', '2013-10-18 00:00:00', 1, 1, 'DIVERSOS');
/*!40000 ALTER TABLE `armazens` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.caixa_movimentos
CREATE TABLE IF NOT EXISTS `caixa_movimentos` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Valor` double DEFAULT NULL,
  `Descricao` varchar(45) DEFAULT NULL,
  `Data` date DEFAULT NULL,
  `TipoMovimento` varchar(45) DEFAULT NULL,
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  `codigoFactura` int(10) unsigned NOT NULL,
  `codigoCliente` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_caixa_movimentos_1` (`CodigoUtilizador`),
  KEY `FK_caixa_movimentos_3` (`codigoFactura`),
  CONSTRAINT `FK_caixa_movimentos_1` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.caixa_movimentos: ~0 rows (approximately)
/*!40000 ALTER TABLE `caixa_movimentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `caixa_movimentos` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.carta_garantia
CREATE TABLE IF NOT EXISTS `carta_garantia` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Conteudo` varchar(1000) NOT NULL DEFAULT '',
  `Nota` varchar(1000) NOT NULL DEFAULT '',
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table wimmarket_pro.carta_garantia: ~0 rows (approximately)
/*!40000 ALTER TABLE `carta_garantia` DISABLE KEYS */;
INSERT INTO `carta_garantia` (`Codigo`, `Conteudo`, `Nota`) VALUES
	(1, 'Os Equipamentos Vendidos pela RAMOSSOFT ,Têm garantia de 1( um ) ano contra defeitos de fabrico, apartir da data da sua venda. A garantia cobre a substituição de peças  defeituosas e mão de obra. Para efeitos de troca por garantia, é obrigatória a entrega do produto na embalagem e em bom estado de conservação.', 'NOTA: Avisa-se ao Cliente que depois da compra do material deixar a embalagem/caixa do produto em mau estado de concervação, a estes mesmos que tiver um problema de fabrico no artigo não faremos devolução.');
/*!40000 ALTER TABLE `carta_garantia` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(145) NOT NULL,
  `CodigoStatus` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`Codigo`),
  KEY `FK_categorias_1` (`CodigoStatus`),
  CONSTRAINT `FK_categorias_1` FOREIGN KEY (`CodigoStatus`) REFERENCES `status` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.categorias: ~0 rows (approximately)
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` (`Codigo`, `Designacao`, `CodigoStatus`) VALUES
	(1, 'DIVERSOS', 1);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(145) DEFAULT 'Publico',
  `Morada` varchar(145) DEFAULT NULL,
  `Telefone` varchar(45) DEFAULT NULL,
  `Email` varchar(145) DEFAULT NULL,
  `CodigoTipoCliente` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Empresa, Especial, Normal, Familiar, Amigos, Vizinhos',
  `DataContrato` date DEFAULT NULL,
  `Saldo` float DEFAULT '0',
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  `CodigoStatus` int(10) unsigned NOT NULL DEFAULT '1',
  `dataCadastro` date DEFAULT NULL,
  `dataRenovacao` date DEFAULT NULL,
  `nif` varchar(45) DEFAULT ' ',
  `CodProdutoUso` int(10) unsigned DEFAULT '1',
  `pessoaContacto` varchar(45) DEFAULT NULL,
  `ContaCorrente` varchar(45) NOT NULL DEFAULT '',
  `Desconto` double NOT NULL DEFAULT '0',
  `LimiteCredito` double NOT NULL DEFAULT '0',
  `CodigoGestor` int(10) unsigned NOT NULL DEFAULT '0',
  `dataValidade` date DEFAULT '0000-00-00',
  `NumeroConta` varchar(45) DEFAULT '',
  `Referencia` varchar(45) DEFAULT '',
  `NContracto` varchar(45) DEFAULT '',
  PRIMARY KEY (`Codigo`),
  KEY `FK_clientes_1` (`CodigoTipoCliente`),
  KEY `FK_clientes_2` (`CodigoUtilizador`),
  KEY `FK_clientes_3` (`CodigoStatus`),
  CONSTRAINT `FK_clientes_1` FOREIGN KEY (`CodigoTipoCliente`) REFERENCES `tipo_cliente` (`Codigo`) ON DELETE CASCADE,
  CONSTRAINT `FK_clientes_2` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`) ON DELETE CASCADE,
  CONSTRAINT `FK_clientes_3` FOREIGN KEY (`CodigoStatus`) REFERENCES `status` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.clientes: ~0 rows (approximately)
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`Codigo`, `Nome`, `Morada`, `Telefone`, `Email`, `CodigoTipoCliente`, `DataContrato`, `Saldo`, `CodigoUtilizador`, `CodigoStatus`, `dataCadastro`, `dataRenovacao`, `nif`, `CodProdutoUso`, `pessoaContacto`, `ContaCorrente`, `Desconto`, `LimiteCredito`, `CodigoGestor`, `dataValidade`, `NumeroConta`, `Referencia`, `NContracto`) VALUES
	(1, 'DIVERSOS', 'Lunda', '999999999', '', 1, '2020-05-11', 0, 1, 1, '2020-05-11', '2020-05-11', '', 1, '', '31.1.2.1.2', 0, 0, 1, '2020-05-11', '', '', '');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.configuracoes
CREATE TABLE IF NOT EXISTS `configuracoes` (
  `idconfiguracoes` int(11) NOT NULL DEFAULT '0',
  `nomeempresa` varchar(555) DEFAULT NULL,
  `numcontribuinte` varchar(45) DEFAULT NULL,
  `endereco` varchar(555) DEFAULT NULL,
  `telefones` varchar(255) DEFAULT NULL,
  `nomeimpressora` varchar(255) DEFAULT NULL,
  `email` varchar(245) DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  `telemoveis` varchar(445) DEFAULT NULL,
  `nomebanco1` varchar(255) DEFAULT NULL,
  `nomebanco2` varchar(255) DEFAULT NULL,
  `numeroconta1` varchar(255) DEFAULT NULL,
  `numeroconta2` varchar(255) DEFAULT NULL,
  `numeroloja` varchar(45) DEFAULT NULL,
  `numeroconta3` varchar(255) DEFAULT '',
  `nomebanco3` varchar(255) DEFAULT '',
  `codigoTipoRegime` int(10) unsigned DEFAULT '3',
  `cidade` varchar(100) NOT NULL DEFAULT 'Luanda',
  PRIMARY KEY (`idconfiguracoes`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.configuracoes: ~0 rows (approximately)
/*!40000 ALTER TABLE `configuracoes` DISABLE KEYS */;
INSERT INTO `configuracoes` (`idconfiguracoes`, `nomeempresa`, `numcontribuinte`, `endereco`, `telefones`, `nomeimpressora`, `email`, `site`, `telemoveis`, `nomebanco1`, `nomebanco2`, `numeroconta1`, `numeroconta2`, `numeroloja`, `numeroconta3`, `nomebanco3`, `codigoTipoRegime`, `cidade`) VALUES
	(1, 'Mutue Negocio', '123456789MN034', 'Mutamba-Ingombota', '222 244 222 222', 'Generic2', 'mutuenegocio@gmail.com', 'https://www.mutue.ao', '921504961', 'Banco Keve', '', '241567389', '', '10', '', '', 1, 'Luanda');
/*!40000 ALTER TABLE `configuracoes` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.contas_a_receber
CREATE TABLE IF NOT EXISTS `contas_a_receber` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ValorTotal` double NOT NULL DEFAULT '0',
  `CodigoFactura` int(10) unsigned DEFAULT NULL,
  `utilizador` int(10) unsigned NOT NULL,
  `Pago` varchar(3) NOT NULL DEFAULT 'NAO',
  PRIMARY KEY (`Codigo`),
  KEY `FK_contas_a_receber_1` (`CodigoFactura`),
  KEY `FK_contas_a_receber_2` (`utilizador`),
  CONSTRAINT `FK_contas_a_receber_1` FOREIGN KEY (`CodigoFactura`) REFERENCES `factura` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_contas_a_receber_2` FOREIGN KEY (`utilizador`) REFERENCES `utilizadores` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.contas_a_receber: ~0 rows (approximately)
/*!40000 ALTER TABLE `contas_a_receber` DISABLE KEYS */;
/*!40000 ALTER TABLE `contas_a_receber` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.contas_items
CREATE TABLE IF NOT EXISTS `contas_items` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CodigoConta` int(10) unsigned NOT NULL,
  `CodigoProduto` int(10) unsigned NOT NULL,
  `Quantidade` int(10) unsigned NOT NULL,
  `Preco` double NOT NULL DEFAULT '0',
  `Total` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`Codigo`),
  KEY `FK_contas_items_1` (`CodigoProduto`),
  KEY `FK_contas_items_2` (`CodigoConta`),
  CONSTRAINT `FK_contas_items_1` FOREIGN KEY (`CodigoProduto`) REFERENCES `produtos` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_contas_items_2` FOREIGN KEY (`CodigoConta`) REFERENCES `contas_mesa` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.contas_items: ~0 rows (approximately)
/*!40000 ALTER TABLE `contas_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `contas_items` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.contas_mesa
CREATE TABLE IF NOT EXISTS `contas_mesa` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DataConta` datetime NOT NULL,
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  `Mesa` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_contas_mesa_1` (`CodigoUtilizador`),
  CONSTRAINT `FK_contas_mesa_1` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.contas_mesa: ~0 rows (approximately)
/*!40000 ALTER TABLE `contas_mesa` DISABLE KEYS */;
/*!40000 ALTER TABLE `contas_mesa` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.conta_corrente
CREATE TABLE IF NOT EXISTS `conta_corrente` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CodigoCliente` int(10) unsigned NOT NULL DEFAULT '0',
  `TipoOperacao` int(10) unsigned DEFAULT NULL,
  `ValorDebito` double DEFAULT NULL,
  `Descrissao` varchar(45) NOT NULL DEFAULT '',
  `DataHora` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ValorCredito` double DEFAULT NULL,
  `Saldo` double DEFAULT NULL,
  `obs` varchar(45) DEFAULT '',
  `Valor` double DEFAULT '0',
  PRIMARY KEY (`Codigo`),
  KEY `FK_conta_corrente_1` (`CodigoCliente`),
  KEY `FK_conta_corrente_2` (`TipoOperacao`),
  CONSTRAINT `FK_conta_corrente_1` FOREIGN KEY (`CodigoCliente`) REFERENCES `clientes` (`Codigo`),
  CONSTRAINT `FK_conta_corrente_2` FOREIGN KEY (`TipoOperacao`) REFERENCES `tipos_pagamento` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.conta_corrente: ~0 rows (approximately)
/*!40000 ALTER TABLE `conta_corrente` DISABLE KEYS */;
/*!40000 ALTER TABLE `conta_corrente` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.credito_clientes
CREATE TABLE IF NOT EXISTS `credito_clientes` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CodigoCliente` int(10) unsigned NOT NULL,
  `CodigoFactura` int(10) unsigned NOT NULL,
  `DataCredito` datetime NOT NULL,
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_credito_clientes_1` (`CodigoCliente`),
  KEY `FK_credito_clientes_2` (`CodigoFactura`),
  KEY `FK_credito_clientes_3` (`CodigoUtilizador`),
  CONSTRAINT `FK_credito_clientes_1` FOREIGN KEY (`CodigoCliente`) REFERENCES `clientes` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_credito_clientes_2` FOREIGN KEY (`CodigoFactura`) REFERENCES `factura` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_credito_clientes_3` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.credito_clientes: ~0 rows (approximately)
/*!40000 ALTER TABLE `credito_clientes` DISABLE KEYS */;
/*!40000 ALTER TABLE `credito_clientes` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.debito_clientes
CREATE TABLE IF NOT EXISTS `debito_clientes` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CodigoCredito` int(10) unsigned NOT NULL,
  `DataDebito` datetime NOT NULL,
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_debito_clientes_1` (`CodigoCredito`),
  KEY `FK_debito_clientes_2` (`CodigoUtilizador`),
  CONSTRAINT `FK_debito_clientes_1` FOREIGN KEY (`CodigoCredito`) REFERENCES `credito_clientes` (`Codigo`),
  CONSTRAINT `FK_debito_clientes_2` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.debito_clientes: ~0 rows (approximately)
/*!40000 ALTER TABLE `debito_clientes` DISABLE KEYS */;
/*!40000 ALTER TABLE `debito_clientes` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.divisao_receitas
CREATE TABLE IF NOT EXISTS `divisao_receitas` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Descricao` varchar(245) NOT NULL,
  `Valor` float NOT NULL,
  `Percentagem` float NOT NULL,
  `Data` datetime NOT NULL,
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_divisao_receitas_1` (`CodigoUtilizador`),
  CONSTRAINT `FK_divisao_receitas_1` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.divisao_receitas: ~0 rows (approximately)
/*!40000 ALTER TABLE `divisao_receitas` DISABLE KEYS */;
/*!40000 ALTER TABLE `divisao_receitas` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.encomendas
CREATE TABLE IF NOT EXISTS `encomendas` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` char(100) NOT NULL,
  `Quantidade` float NOT NULL,
  `DataEncomenda` datetime NOT NULL,
  `CodigoFornecedor` int(10) unsigned NOT NULL,
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  `Status` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_encomendas_2` (`CodigoFornecedor`),
  KEY `FK_encomendas_3` (`CodigoUtilizador`),
  KEY `FK_encomendas_1` (`Designacao`),
  CONSTRAINT `FK_encomendas_2` FOREIGN KEY (`CodigoFornecedor`) REFERENCES `fornecedores` (`Codigo`),
  CONSTRAINT `FK_encomendas_3` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.encomendas: ~0 rows (approximately)
/*!40000 ALTER TABLE `encomendas` DISABLE KEYS */;
/*!40000 ALTER TABLE `encomendas` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.encomenda_items
CREATE TABLE IF NOT EXISTS `encomenda_items` (
  `CodigoEncomenda` int(10) unsigned NOT NULL,
  `CodigoProduto` int(10) unsigned NOT NULL,
  `Quantidade` int(10) unsigned NOT NULL,
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  KEY `FK_encomenda_items_1` (`CodigoEncomenda`),
  KEY `FK_encomenda_items_2` (`CodigoProduto`),
  KEY `FK_encomenda_items_3` (`CodigoUtilizador`),
  CONSTRAINT `FK_encomenda_items_1` FOREIGN KEY (`CodigoEncomenda`) REFERENCES `encomendas` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_encomenda_items_2` FOREIGN KEY (`CodigoProduto`) REFERENCES `produtos` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_encomenda_items_3` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.encomenda_items: ~0 rows (approximately)
/*!40000 ALTER TABLE `encomenda_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `encomenda_items` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.entrada_produtos
CREATE TABLE IF NOT EXISTS `entrada_produtos` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CodigoProduto` int(10) unsigned NOT NULL,
  `DataEntrada` date NOT NULL DEFAULT '0000-00-00',
  `Quantidade` double NOT NULL DEFAULT '0',
  `CodigoFornecedor` int(10) unsigned NOT NULL,
  `CodigoUtilizador` int(10) unsigned NOT NULL DEFAULT '0',
  `PrecoUnitarioCompra` double DEFAULT '0',
  `PrecoUnitarioVenda` double DEFAULT '0',
  `TotalCompra` double DEFAULT '0',
  `TotalVenda` double DEFAULT '0',
  `LucroUnitario` double DEFAULT '0',
  `TotalLucros` double DEFAULT '0',
  `TipoEntrada` varchar(45) DEFAULT NULL,
  `FacturaFornecedor` varchar(45) DEFAULT NULL,
  `CodigoArmazem` int(10) unsigned NOT NULL DEFAULT '1',
  `DataFactura` date NOT NULL DEFAULT '0000-00-00',
  `StatusPagamento` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '0 nao pagou,1 pagou',
  PRIMARY KEY (`Codigo`),
  KEY `FK_entrada_produtos_1` (`CodigoProduto`),
  KEY `FK_entrada_produtos_2` (`CodigoFornecedor`),
  KEY `FK_entrada_produtos_3` (`CodigoUtilizador`),
  KEY `FK_entrada_produtos_4` (`CodigoArmazem`),
  CONSTRAINT `FK_entrada_produtos_1` FOREIGN KEY (`CodigoProduto`) REFERENCES `produtos` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_entrada_produtos_2` FOREIGN KEY (`CodigoFornecedor`) REFERENCES `fornecedores` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_entrada_produtos_3` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_entrada_produtos_4` FOREIGN KEY (`CodigoArmazem`) REFERENCES `armazens` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.entrada_produtos: ~0 rows (approximately)
/*!40000 ALTER TABLE `entrada_produtos` DISABLE KEYS */;
/*!40000 ALTER TABLE `entrada_produtos` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.existencias
CREATE TABLE IF NOT EXISTS `existencias` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CodigoProduto` int(10) unsigned NOT NULL,
  `CodigoArmazem` int(10) unsigned NOT NULL,
  `Existencia` double NOT NULL DEFAULT '0',
  `DataActualizacao` datetime NOT NULL,
  `codigoUtilizador` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Codigo`),
  KEY `FK_existencias_1` (`CodigoProduto`),
  KEY `FK_existencias_2` (`CodigoArmazem`),
  KEY `FK_existencias_3` (`codigoUtilizador`),
  CONSTRAINT `FK_existencias_2` FOREIGN KEY (`CodigoArmazem`) REFERENCES `armazens` (`Codigo`),
  CONSTRAINT `FK_existencias_3` FOREIGN KEY (`codigoUtilizador`) REFERENCES `utilizadores` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.existencias: ~0 rows (approximately)
/*!40000 ALTER TABLE `existencias` DISABLE KEYS */;
INSERT INTO `existencias` (`Codigo`, `CodigoProduto`, `CodigoArmazem`, `Existencia`, `DataActualizacao`, `codigoUtilizador`) VALUES
	(1, 1, 1, 0, '2020-05-11 00:13:51', 1);
/*!40000 ALTER TABLE `existencias` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.existencia_diaria
CREATE TABLE IF NOT EXISTS `existencia_diaria` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Existencia` double DEFAULT NULL,
  `CodigoProduto` int(10) unsigned NOT NULL,
  `DataActualizacao` date NOT NULL,
  `EntradasPorto` double DEFAULT '0',
  `EntradaTransferencia` double DEFAULT '0',
  `SaidasVendas` double DEFAULT '0',
  `Descontos` double DEFAULT '0',
  `Total` double DEFAULT '0',
  `Perca` double DEFAULT '0',
  `TransferenciaEnviada` double DEFAULT '0',
  `Oferta` double DEFAULT '0',
  `VendasEscritorio` double DEFAULT '0',
  PRIMARY KEY (`Codigo`),
  KEY `FK_New Table_1` (`CodigoProduto`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.existencia_diaria: ~0 rows (approximately)
/*!40000 ALTER TABLE `existencia_diaria` DISABLE KEYS */;
INSERT INTO `existencia_diaria` (`Codigo`, `Existencia`, `CodigoProduto`, `DataActualizacao`, `EntradasPorto`, `EntradaTransferencia`, `SaidasVendas`, `Descontos`, `Total`, `Perca`, `TransferenciaEnviada`, `Oferta`, `VendasEscritorio`) VALUES
	(1, 0, 1, '2020-08-05', 0, 0, 0, 0, 0, 0, 0, 0, 0);
/*!40000 ALTER TABLE `existencia_diaria` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.existencia_historico
CREATE TABLE IF NOT EXISTS `existencia_historico` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `existencia` double NOT NULL DEFAULT '0',
  `dataActualizacao` date NOT NULL DEFAULT '0000-00-00',
  `codigoProduto` int(10) unsigned NOT NULL,
  PRIMARY KEY (`codigo`),
  KEY `FK_tb_existencia_historico_1` (`codigoProduto`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.existencia_historico: ~0 rows (approximately)
/*!40000 ALTER TABLE `existencia_historico` DISABLE KEYS */;
INSERT INTO `existencia_historico` (`codigo`, `existencia`, `dataActualizacao`, `codigoProduto`) VALUES
	(1, 0, '2020-05-11', 1),
	(2, 0, '2020-05-27', 1),
	(3, 0, '2020-06-29', 1),
	(4, 0, '2020-08-05', 1);
/*!40000 ALTER TABLE `existencia_historico` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.fabricantes
CREATE TABLE IF NOT EXISTS `fabricantes` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) NOT NULL,
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_fabricantes_1` (`CodigoUtilizador`),
  CONSTRAINT `FK_fabricantes_1` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.fabricantes: ~0 rows (approximately)
/*!40000 ALTER TABLE `fabricantes` DISABLE KEYS */;
INSERT INTO `fabricantes` (`Codigo`, `Designacao`, `CodigoUtilizador`) VALUES
	(1, 'Diversos', 1);
/*!40000 ALTER TABLE `fabricantes` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.factura
CREATE TABLE IF NOT EXISTS `factura` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DataFactura` datetime NOT NULL,
  `TotalPreco` double NOT NULL DEFAULT '0',
  `TipoPagamento` varchar(30) NOT NULL DEFAULT '1',
  `CodigoUtilizador` int(10) unsigned NOT NULL DEFAULT '1',
  `ValorEntregue` double DEFAULT '0',
  `Desconto` double DEFAULT '0',
  `ValorAPagar` double DEFAULT '0',
  `Troco` double DEFAULT '0',
  `NomeCliente` varchar(145) DEFAULT NULL,
  `CodigoClientes` int(10) unsigned DEFAULT '1',
  `Forma` int(10) unsigned NOT NULL DEFAULT '1',
  `StatusFactura` int(10) unsigned NOT NULL DEFAULT '1',
  `Mesa` int(10) unsigned DEFAULT NULL,
  `CodigoArmazem` int(10) unsigned NOT NULL DEFAULT '1',
  `ValorAPagarExtenso` varchar(245) DEFAULT NULL,
  `NItems` int(10) unsigned NOT NULL DEFAULT '1',
  `Descricao` varchar(500) DEFAULT NULL,
  `ValorDescricao` double DEFAULT NULL,
  `ValorEntregueMltCX` double NOT NULL DEFAULT '0',
  `totalIVA` double NOT NULL DEFAULT '0',
  `retencaoP` double DEFAULT '0',
  `retencaoV` double DEFAULT '0',
  `NextFactura` varchar(100) DEFAULT NULL,
  `telefoneCliente` varchar(45) DEFAULT '',
  `nifCliente` varchar(45) DEFAULT '',
  `CodigoVendedor` int(11) DEFAULT '0',
  `dataVencimento` date DEFAULT '0000-00-00',
  `obs` varchar(45000) DEFAULT '',
  `nEncomenda` varchar(450) DEFAULT '',
  `localEmissao` varchar(450) DEFAULT '',
  `localEntrega` varchar(450) DEFAULT '',
  `nRef` varchar(45) DEFAULT '',
  `dataServico` date DEFAULT '0000-00-00',
  `cabecalho` varchar(4500) DEFAULT '',
  `codigoMoeda` int(10) unsigned DEFAULT '1',
  `hashValor` varchar(400) DEFAULT '',
  `CodigoSerie` int(10) unsigned DEFAULT '0',
  `faturacol` varchar(45) DEFAULT '',
  `emailCliente` varchar(200) DEFAULT '',
  `contaCorrente` varchar(45) DEFAULT '',
  `morada` varchar(300) DEFAULT '',
  `faturaReference` varchar(1000) DEFAULT '',
  `dataViagem` varchar(100) DEFAULT '',
  `origemViagem` varchar(100) DEFAULT '',
  `destinoViagem` varchar(100) DEFAULT '',
  `numContentor` varchar(100) DEFAULT '',
  `motorista` varchar(100) DEFAULT '',
  `viatura` varchar(100) DEFAULT '',
  `status` int(10) unsigned NOT NULL DEFAULT '1',
  `solicitacao` varchar(45) DEFAULT '',
  `retificada` enum('SIM','NAO') NOT NULL DEFAULT 'NAO',
  `TipoDocumento` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_factura_3` (`CodigoUtilizador`),
  KEY `FK_factura_2` (`TipoPagamento`),
  KEY `FK_factura_1` (`CodigoClientes`),
  KEY `FK_factura_22` (`Forma`),
  KEY `FK_factura_4` (`StatusFactura`),
  KEY `FK_factura_5` (`CodigoArmazem`),
  KEY `FK_vendedor` (`CodigoVendedor`),
  CONSTRAINT `FK_vendedor` FOREIGN KEY (`CodigoVendedor`) REFERENCES `vendedor` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.factura: ~0 rows (approximately)
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
INSERT INTO `factura` (`Codigo`, `DataFactura`, `TotalPreco`, `TipoPagamento`, `CodigoUtilizador`, `ValorEntregue`, `Desconto`, `ValorAPagar`, `Troco`, `NomeCliente`, `CodigoClientes`, `Forma`, `StatusFactura`, `Mesa`, `CodigoArmazem`, `ValorAPagarExtenso`, `NItems`, `Descricao`, `ValorDescricao`, `ValorEntregueMltCX`, `totalIVA`, `retencaoP`, `retencaoV`, `NextFactura`, `telefoneCliente`, `nifCliente`, `CodigoVendedor`, `dataVencimento`, `obs`, `nEncomenda`, `localEmissao`, `localEntrega`, `nRef`, `dataServico`, `cabecalho`, `codigoMoeda`, `hashValor`, `CodigoSerie`, `faturacol`, `emailCliente`, `contaCorrente`, `morada`, `faturaReference`, `dataViagem`, `origemViagem`, `destinoViagem`, `numContentor`, `motorista`, `viatura`, `status`, `solicitacao`, `retificada`, `TipoDocumento`) VALUES
	(1, '2020-05-27 10:49:58', 33, '1', 1, 0, 0, 33, 0, 'DIVERSOS', 1, 2, 1, 1, 1, 'trinta e três Kwanzas', 1, '', 0, 33, 0, 0, 0, '2020/1 -REF 1', '999999999', 'Consumidor final', 1, '2020-06-11', '', '', '', '', '', '2020-05-27', '', 1, 'd2DLZFuwgvRi/A008wyxGdU/WPG9Kn7c4YlNHGse6mSl9lhTEWiveM+LeJUR92L/2itiV2KCNPZQ893UpnryTjG+ZEdLFj85ZH8Yz+raV3qrCewyyEvFoQniDIqooRTQgm1TM/fqPW5TEEX7l4Z8RSb7qFgCcaXiAmoHpZfW03s=', 0, '', '', '31.1.2.1.2', 'Lunda', 'DRG7', 'null', 'null', 'null', 'null', 'null', 'null', 1, '', 'NAO', 'FACTURA RECIBO');
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.factura_items
CREATE TABLE IF NOT EXISTS `factura_items` (
  `CodigoProduto` int(10) unsigned NOT NULL DEFAULT '0',
  `CodigoFactura` int(10) unsigned NOT NULL,
  `Quantidade` double NOT NULL DEFAULT '0',
  `Total` double NOT NULL DEFAULT '0',
  `CodigoCategoria` int(10) unsigned NOT NULL DEFAULT '0',
  `OBS` varchar(45) DEFAULT NULL,
  `TotalIPC` double NOT NULL DEFAULT '0',
  `preco` double NOT NULL DEFAULT '0',
  `descontoProduto` double DEFAULT '0',
  `dia` int(10) unsigned DEFAULT '1',
  `precoCompra` double DEFAULT '0',
  `motivoIsencao` varchar(850) DEFAULT '',
  `codigoTipoTaxa` int(10) unsigned DEFAULT '31',
  `Descricao` varchar(250) DEFAULT '',
  `ExistenciaAnterior` double DEFAULT '0',
  `ExistenciaActual` double DEFAULT '0',
  `retencao` double DEFAULT '0',
  KEY `FK_factura_items_1` (`CodigoProduto`),
  KEY `FK_factura_items_2` (`CodigoFactura`),
  CONSTRAINT `FK_factura_items_1` FOREIGN KEY (`CodigoProduto`) REFERENCES `produtos` (`Codigo`),
  CONSTRAINT `FK_factura_items_2` FOREIGN KEY (`CodigoFactura`) REFERENCES `factura` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.factura_items: ~0 rows (approximately)
/*!40000 ALTER TABLE `factura_items` DISABLE KEYS */;
INSERT INTO `factura_items` (`CodigoProduto`, `CodigoFactura`, `Quantidade`, `Total`, `CodigoCategoria`, `OBS`, `TotalIPC`, `preco`, `descontoProduto`, `dia`, `precoCompra`, `motivoIsencao`, `codigoTipoTaxa`, `Descricao`, `ExistenciaAnterior`, `ExistenciaActual`, `retencao`) VALUES
	(1, 1, 1, 33, 1, '', 0, 33, 0, 1, 0, 'IVA-Regime de não sujeição', 31, 'dd', 0, 0, 0);
/*!40000 ALTER TABLE `factura_items` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.factura_items_original
CREATE TABLE IF NOT EXISTS `factura_items_original` (
  `CodigoProduto` int(10) unsigned NOT NULL DEFAULT '0',
  `CodigoFactura` int(10) unsigned NOT NULL,
  `Quantidade` double NOT NULL DEFAULT '0',
  `Total` double NOT NULL DEFAULT '0',
  `CodigoCategoria` int(10) unsigned NOT NULL DEFAULT '0',
  `OBS` varchar(45) DEFAULT NULL,
  `TotalIPC` double NOT NULL DEFAULT '0',
  `preco` double NOT NULL DEFAULT '0',
  `descontoProduto` double DEFAULT '0',
  `dia` int(10) unsigned DEFAULT '1',
  `precoCompra` double DEFAULT '0',
  `motivoIsencao` varchar(850) DEFAULT '',
  `codigoTipoTaxa` int(10) unsigned DEFAULT '31',
  `Descricao` varchar(250) DEFAULT '',
  `ExistenciaAnterior` double DEFAULT '0',
  `ExistenciaActual` double DEFAULT '0',
  `retencao` double DEFAULT '0',
  KEY `FK_factura_items_original_1` (`CodigoFactura`),
  KEY `FK_factura_items_original_2` (`CodigoProduto`),
  CONSTRAINT `FK_factura_items_original_2` FOREIGN KEY (`CodigoProduto`) REFERENCES `produtos` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.factura_items_original: ~0 rows (approximately)
/*!40000 ALTER TABLE `factura_items_original` DISABLE KEYS */;
/*!40000 ALTER TABLE `factura_items_original` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.factura_original
CREATE TABLE IF NOT EXISTS `factura_original` (
  `Codigo` int(10) unsigned NOT NULL DEFAULT '0',
  `DataFactura` datetime NOT NULL,
  `TotalPreco` double NOT NULL DEFAULT '0',
  `TipoPagamento` varchar(30) NOT NULL DEFAULT '1',
  `CodigoUtilizador` int(10) unsigned NOT NULL DEFAULT '1',
  `ValorEntregue` double DEFAULT '0',
  `Desconto` double DEFAULT '0',
  `ValorAPagar` double DEFAULT '0',
  `Troco` double DEFAULT '0',
  `NomeCliente` varchar(145) DEFAULT NULL,
  `CodigoClientes` int(10) unsigned DEFAULT '1',
  `Forma` int(10) unsigned NOT NULL DEFAULT '1',
  `StatusFactura` int(10) unsigned NOT NULL DEFAULT '1',
  `Mesa` int(10) unsigned DEFAULT NULL,
  `CodigoArmazem` int(10) unsigned NOT NULL DEFAULT '1',
  `ValorAPagarExtenso` varchar(245) DEFAULT NULL,
  `NItems` int(10) unsigned NOT NULL DEFAULT '1',
  `Descricao` varchar(500) DEFAULT NULL,
  `ValorDescricao` double DEFAULT NULL,
  `ValorEntregueMltCX` double NOT NULL DEFAULT '0',
  `totalIVA` double NOT NULL DEFAULT '0',
  `retencaoP` double DEFAULT '0',
  `retencaoV` double DEFAULT '0',
  `NextFactura` varchar(45) DEFAULT '',
  `telefoneCliente` varchar(45) DEFAULT '',
  `nifCliente` varchar(45) DEFAULT '',
  `CodigoVendedor` int(11) DEFAULT '0',
  `dataVencimento` date DEFAULT '0000-00-00',
  `obs` varchar(45000) DEFAULT '',
  `nEncomenda` varchar(450) DEFAULT '',
  `localEmissao` varchar(450) DEFAULT '',
  `localEntrega` varchar(450) DEFAULT '',
  `nRef` varchar(45) DEFAULT '',
  `dataServico` date DEFAULT '0000-00-00',
  `cabecalho` varchar(4500) DEFAULT '',
  `codigoMoeda` int(10) unsigned DEFAULT '1',
  `hashValor` varchar(400) DEFAULT '',
  `CodigoSerie` int(10) unsigned DEFAULT '0',
  `faturacol` varchar(45) DEFAULT '',
  `emailCliente` varchar(200) DEFAULT '',
  `contaCorrente` varchar(45) DEFAULT '',
  `morada` varchar(300) DEFAULT '',
  `faturaReference` varchar(1000) DEFAULT '',
  `dataViagem` varchar(100) DEFAULT '',
  `origemViagem` varchar(100) DEFAULT '',
  `destinoViagem` varchar(100) DEFAULT '',
  `numContentor` varchar(100) DEFAULT '',
  `motorista` varchar(100) DEFAULT '',
  `viatura` varchar(100) DEFAULT '',
  `status` int(10) unsigned NOT NULL DEFAULT '1',
  `solicitacao` varchar(45) DEFAULT '',
  `documentoRetificativo` varchar(45) NOT NULL,
  `retornouProdutos` enum('SIM','NAO') NOT NULL DEFAULT 'NAO',
  `TipoDocumento` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.factura_original: ~0 rows (approximately)
/*!40000 ALTER TABLE `factura_original` DISABLE KEYS */;
/*!40000 ALTER TABLE `factura_original` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.formas_pagamento
CREATE TABLE IF NOT EXISTS `formas_pagamento` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) NOT NULL DEFAULT '',
  `ContaCorrente` varchar(45) NOT NULL DEFAULT '',
  `NumeroConta` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.formas_pagamento: ~6 rows (approximately)
/*!40000 ALTER TABLE `formas_pagamento` DISABLE KEYS */;
INSERT INTO `formas_pagamento` (`Codigo`, `Designacao`, `ContaCorrente`, `NumeroConta`) VALUES
	(1, 'NUMERARIO', 'BANCO BFA', '42.1.1'),
	(2, 'MULTICAIXA', 'OBRIGACOES', '41.2'),
	(3, 'VENDA A CREDITO', 'ASSOCIADAS', '31.1.1.2'),
	(4, 'Transferência', 'EMPRESAS DO GRUPO', '41.1.1'),
	(5, 'PAGAMENTO DUPLO', 'ASSOCIADAS', '31.1.1.2'),
	(6, 'DEPÓSITO', 'EMPRESAS DO GRUPO', '31.1.1.2');
/*!40000 ALTER TABLE `formas_pagamento` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.fornecedores
CREATE TABLE IF NOT EXISTS `fornecedores` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(145) NOT NULL,
  `Morada` varchar(145) DEFAULT NULL,
  `Contacto` varchar(45) DEFAULT NULL,
  `Email` varchar(145) DEFAULT NULL,
  `DataContrato` date NOT NULL,
  `Saldo` double NOT NULL DEFAULT '0',
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  `CodigoTipoFornecedor` int(10) unsigned NOT NULL,
  `CodigoStatus` int(10) unsigned NOT NULL DEFAULT '1',
  `contaCorrente` varchar(45) DEFAULT 'null',
  `nif` varchar(450) NOT NULL DEFAULT '',
  PRIMARY KEY (`Codigo`),
  KEY `FK_fornecedores_1` (`CodigoUtilizador`),
  KEY `FK_fornecedores_2` (`CodigoTipoFornecedor`),
  KEY `FK_fornecedores_3` (`CodigoStatus`),
  CONSTRAINT `FK_fornecedores_1` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`),
  CONSTRAINT `FK_fornecedores_2` FOREIGN KEY (`CodigoTipoFornecedor`) REFERENCES `tipo_cliente` (`Codigo`),
  CONSTRAINT `FK_fornecedores_3` FOREIGN KEY (`CodigoStatus`) REFERENCES `status` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.fornecedores: ~0 rows (approximately)
/*!40000 ALTER TABLE `fornecedores` DISABLE KEYS */;
INSERT INTO `fornecedores` (`Codigo`, `Nome`, `Morada`, `Contacto`, `Email`, `DataContrato`, `Saldo`, `CodigoUtilizador`, `CodigoTipoFornecedor`, `CodigoStatus`, `contaCorrente`, `nif`) VALUES
	(1, 'DIVERSOS', 'Luanda', '999999999', '', '2020-05-11', 0, 1, 1, 1, '32.1.2.1.2', '999999999');
/*!40000 ALTER TABLE `fornecedores` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.gestor_clientes
CREATE TABLE IF NOT EXISTS `gestor_clientes` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(45) NOT NULL,
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_gestor_clientes_1` (`CodigoUtilizador`),
  CONSTRAINT `FK_gestor_clientes_1` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.gestor_clientes: ~0 rows (approximately)
/*!40000 ALTER TABLE `gestor_clientes` DISABLE KEYS */;
INSERT INTO `gestor_clientes` (`Codigo`, `Nome`, `CodigoUtilizador`) VALUES
	(1, 'DIVERSOS', 1);
/*!40000 ALTER TABLE `gestor_clientes` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.logs
CREATE TABLE IF NOT EXISTS `logs` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Descricao` varchar(545) NOT NULL,
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  `Data` datetime DEFAULT NULL,
  `OBS` varchar(245) DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_logs_1` (`CodigoUtilizador`),
  CONSTRAINT `FK_logs_1` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.logs: ~0 rows (approximately)
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` (`Codigo`, `Descricao`, `CodigoUtilizador`, `Data`, `OBS`) VALUES
	(1, 'actualizacao de stock do produto 1, para 0.0', 1, '2020-05-11 00:13:52', 'actualização direita');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.moedas
CREATE TABLE IF NOT EXISTS `moedas` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) DEFAULT '',
  `Cambio` double DEFAULT '0',
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.moedas: ~3 rows (approximately)
/*!40000 ALTER TABLE `moedas` DISABLE KEYS */;
INSERT INTO `moedas` (`Codigo`, `Designacao`, `Cambio`) VALUES
	(1, 'AKZ', 1),
	(2, 'USD', 0),
	(3, 'EUR', 0);
/*!40000 ALTER TABLE `moedas` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.motivo
CREATE TABLE IF NOT EXISTS `motivo` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codigoMotivo` varchar(45) NOT NULL,
  `descricacao` varchar(45) NOT NULL,
  `codigoStatus` int(10) unsigned NOT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- Dumping data for table wimmarket_pro.motivo: ~23 rows (approximately)
/*!40000 ALTER TABLE `motivo` DISABLE KEYS */;
INSERT INTO `motivo` (`codigo`, `codigoMotivo`, `descricacao`, `codigoStatus`) VALUES
	(7, 'M04', 'IVA-Regime de não sujeição', 1),
	(8, 'M02', 'Transmissão de Bens e serviços não sujeita', 1),
	(9, 'M00', 'Regime Transitório', 1),
	(10, 'M10', 'a) Isento Artigo 12.º ', 1),
	(11, 'M11', 'b) Isento Artigo 12.º', 1),
	(12, 'M12', 'c) Isento Artigo 12.º', 1),
	(13, 'M13', 'd) Isento Artigo 12.º', 1),
	(14, 'M14', 'e) Isento Artigo 12.º', 1),
	(15, 'M15', 'f) Isento Artigo 12.º', 1),
	(16, 'M16', 'g) Isento Artigo 12.º', 1),
	(17, 'M17', 'h) Isento Artigo 12.º', 1),
	(18, 'M18', 'i) Isento Artigo 12.º', 1),
	(19, 'M19', 'j) Isento Artigo 12.º', 1),
	(20, 'M20', 'k) Isento Artigo 12.º', 1),
	(21, 'M30', 'a) Isento Artigo 15º 1', 1),
	(22, 'M31', 'b) Isento Artigo 15.º 1', 1),
	(23, 'M32', 'c) Isento Artigo 15.º 1', 1),
	(24, 'M33', 'd) Isento Artigo 15.º 1', 1),
	(25, 'M34', 'e) Isento Artigo 15.º 1', 1),
	(26, 'M35', 'f) Isento Artigo 15.º 1', 1),
	(27, 'M36', 'g) Isento Artigo 15.º 1', 1),
	(28, 'M37', 'h) Isento Artigo 15.º 1', 1),
	(29, 'M38', 'i) Isento Artigo 12.º', 1);
/*!40000 ALTER TABLE `motivo` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.numeracao_documento
CREATE TABLE IF NOT EXISTS `numeracao_documento` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) NOT NULL,
  `Next` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.numeracao_documento: ~9 rows (approximately)
/*!40000 ALTER TABLE `numeracao_documento` DISABLE KEYS */;
INSERT INTO `numeracao_documento` (`Codigo`, `Designacao`, `Next`) VALUES
	(1, 'FACTURA CREDITO', 1),
	(2, 'PROFORMA', 1),
	(3, 'FACTURA RECIBO', 2),
	(4, 'RECIBO', 1),
	(5, 'NOTA CREDITO', 1),
	(6, 'NOTA DEBITO', 1),
	(7, 'GUIA DE CONSIGNAÇÃO', 1),
	(8, 'GUIA DE REMESSA', 1),
	(9, 'GUIA DE TRANSPORTE', 1);
/*!40000 ALTER TABLE `numeracao_documento` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.outros_documentos
CREATE TABLE IF NOT EXISTS `outros_documentos` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DataFactura` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TotalPreco` double DEFAULT NULL,
  `TipoPagamento` int(10) unsigned NOT NULL,
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  `TotalIVA` double DEFAULT NULL,
  `Desconto` double DEFAULT NULL,
  `ValorAPagar` double DEFAULT NULL,
  `TotalRetencao` double DEFAULT NULL,
  `NomeCliente` varchar(145) DEFAULT NULL,
  `CodigoClientes` int(10) unsigned DEFAULT NULL,
  `Forma` int(10) unsigned DEFAULT NULL,
  `NIF` varchar(45) DEFAULT NULL,
  `MORADA` varchar(45) DEFAULT NULL,
  `EMAIL` varchar(45) DEFAULT NULL,
  `TELEFONE` varchar(45) DEFAULT NULL,
  `LocalCarga` varchar(45) DEFAULT NULL,
  `LocalDescarga` varchar(45) DEFAULT NULL,
  `HoradeCarga` varchar(45) DEFAULT NULL,
  `HoradeDescarga` varchar(45) DEFAULT NULL,
  `ModoExpedicao` varchar(45) DEFAULT NULL,
  `NextDocumento` varchar(45) DEFAULT NULL,
  `hashValor` varchar(500) DEFAULT NULL,
  `documentoReferences` varchar(45) DEFAULT NULL,
  `TipoDocumento` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_outros_documentos_1` (`CodigoClientes`),
  KEY `FK_outros_documentos_3` (`CodigoUtilizador`),
  KEY `FK_outros_documentos_2` (`TipoPagamento`),
  CONSTRAINT `FK_outros_documentos_1` FOREIGN KEY (`CodigoClientes`) REFERENCES `clientes` (`Codigo`),
  CONSTRAINT `FK_outros_documentos_2` FOREIGN KEY (`TipoPagamento`) REFERENCES `tipos_documentos` (`Codigo`),
  CONSTRAINT `FK_outros_documentos_3` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.outros_documentos: ~0 rows (approximately)
/*!40000 ALTER TABLE `outros_documentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `outros_documentos` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.outro_documentos_items
CREATE TABLE IF NOT EXISTS `outro_documentos_items` (
  `CodigoProduto` int(10) unsigned DEFAULT NULL,
  `CodigoFactura` int(10) unsigned DEFAULT NULL,
  `Quantidade` double DEFAULT NULL,
  `UNI` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `TotalDesconto` double DEFAULT NULL,
  `IVA` double DEFAULT NULL,
  `Total` double DEFAULT NULL,
  `Preco` double DEFAULT NULL,
  `Descricao` varchar(450) DEFAULT '',
  `retencao` double DEFAULT '0',
  `codigoTipoTaxa` int(10) unsigned DEFAULT '31',
  KEY `FK_outro_documentos_items_1` (`CodigoProduto`),
  KEY `FK_outro_documentos_items_2` (`CodigoFactura`),
  KEY `FK_outro_documentos_items_3` (`codigoTipoTaxa`),
  CONSTRAINT `FK_outro_documentos_items_1` FOREIGN KEY (`CodigoProduto`) REFERENCES `produtos` (`Codigo`),
  CONSTRAINT `FK_outro_documentos_items_2` FOREIGN KEY (`CodigoFactura`) REFERENCES `outros_documentos` (`Codigo`),
  CONSTRAINT `FK_outro_documentos_items_3` FOREIGN KEY (`codigoTipoTaxa`) REFERENCES `tipotaxa` (`codigo`),
  CONSTRAINT `FK_outro_documentos_items_4` FOREIGN KEY (`CodigoFactura`) REFERENCES `outros_documentos` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table wimmarket_pro.outro_documentos_items: ~0 rows (approximately)
/*!40000 ALTER TABLE `outro_documentos_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `outro_documentos_items` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.pagamento_fornecedores
CREATE TABLE IF NOT EXISTS `pagamento_fornecedores` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CodigoEntrada` int(10) unsigned NOT NULL,
  `DataPagamento` datetime NOT NULL,
  `Valor` double NOT NULL DEFAULT '0',
  `CodigoFormaPagamento` int(10) unsigned NOT NULL DEFAULT '1',
  `Conta` varchar(45) NOT NULL DEFAULT '',
  `CodigoForneceDor` int(10) unsigned NOT NULL DEFAULT '0',
  `CodigoUtilizador` int(10) unsigned NOT NULL DEFAULT '1',
  `nFactura` varchar(45) NOT NULL DEFAULT '0',
  `CodigoStatus` int(10) unsigned NOT NULL DEFAULT '1',
  `nextPagamento` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_pagamento_fornecedores_1` (`CodigoEntrada`),
  KEY `FK_pagamento_fornecedores_2` (`CodigoFormaPagamento`),
  KEY `FK_pagamento_fornecedores_3` (`CodigoForneceDor`),
  KEY `FK_pagamento_fornecedores_4` (`CodigoStatus`),
  CONSTRAINT `FK_pagamento_fornecedores_1` FOREIGN KEY (`CodigoEntrada`) REFERENCES `entrada_produtos` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_pagamento_fornecedores_2` FOREIGN KEY (`CodigoFormaPagamento`) REFERENCES `formas_pagamento` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_pagamento_fornecedores_3` FOREIGN KEY (`CodigoForneceDor`) REFERENCES `fornecedores` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_pagamento_fornecedores_4` FOREIGN KEY (`CodigoStatus`) REFERENCES `status` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.pagamento_fornecedores: ~0 rows (approximately)
/*!40000 ALTER TABLE `pagamento_fornecedores` DISABLE KEYS */;
/*!40000 ALTER TABLE `pagamento_fornecedores` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.parametros
CREATE TABLE IF NOT EXISTS `parametros` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) DEFAULT NULL,
  `Valor` varchar(45) DEFAULT NULL,
  `Vida` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.parametros: ~24 rows (approximately)
/*!40000 ALTER TABLE `parametros` DISABLE KEYS */;
INSERT INTO `parametros` (`Codigo`, `Designacao`, `Valor`, `Vida`) VALUES
	(1, 'SRVPRIMAVERA', '1', 30),
	(2, '2016-12-24', '1', 1),
	(3, 'root', NULL, NULL),
	(4, 'root', NULL, NULL),
	(5, 'nFacturas', NULL, 1),
	(6, '2018-08-17', NULL, NULL),
	(7, 'impressao direita ao salvar', NULL, 2),
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
	(24, 'Sigla da empresa', 'AGT', 0);
/*!40000 ALTER TABLE `parametros` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.parcelas
CREATE TABLE IF NOT EXISTS `parcelas` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Valor` float NOT NULL,
  `DataPagamento` datetime DEFAULT NULL,
  `DataVencimento` datetime DEFAULT NULL,
  `CodigoContaReceber` int(10) unsigned NOT NULL,
  `numeroParcela` int(10) unsigned NOT NULL,
  `utilizador` int(10) unsigned NOT NULL,
  `Obs` varchar(145) DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_parcelas_1` (`CodigoContaReceber`),
  CONSTRAINT `FK_parcelas_1` FOREIGN KEY (`CodigoContaReceber`) REFERENCES `contas_a_receber` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.parcelas: ~0 rows (approximately)
/*!40000 ALTER TABLE `parcelas` DISABLE KEYS */;
/*!40000 ALTER TABLE `parcelas` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.permissao
CREATE TABLE IF NOT EXISTS `permissao` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Permissao` varchar(45) NOT NULL,
  `Menu` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.permissao: ~59 rows (approximately)
/*!40000 ALTER TABLE `permissao` DISABLE KEYS */;
INSERT INTO `permissao` (`Codigo`, `Permissao`, `Menu`) VALUES
	(1, 'PRODUTOS', 1),
	(2, 'ENTRADA DE STOCK', 1),
	(3, 'SAIDAS', 1),
	(4, 'CLIENTES', 1),
	(5, 'FORNECEDORES', 1),
	(6, 'ENCOMENDAS', 1),
	(7, 'ELIMINAR FACTURA', 2),
	(8, 'ACTUALIZAR STOCK', 2),
	(9, 'PESQUISAR PRODUTO', 2),
	(10, 'PAGAMENTOS DE CLIENTE', 2),
	(11, 'PAGAMENTO A FORNECEDORES', 2),
	(12, 'ALTERAR CODIGO DE BARRAS', 2),
	(13, 'PESQUISAR FACTURA', 2),
	(14, 'TRANSFERENCIA PRODUTOS', 2),
	(15, 'UNIDADE DE MEDIDA', 3),
	(16, 'FABRICANTE', 3),
	(17, 'CATEGORIA', 3),
	(18, 'ARMAZEM', 3),
	(19, 'LISTAR PRODUTOS', 4),
	(20, 'LISTAR ENTRADA POR CATEGORIA', 4),
	(21, 'LISTAR EXISTENCIA', 4),
	(22, 'LISTAR ENTRADA POR PRODUTO', 4),
	(23, 'Listar Entradas de Produtos no Stock', 4),
	(24, 'LISTAR FORNECEDORES', 4),
	(25, 'LISTAR DOS PRODUTOS MAIS VENDIDOS', 4),
	(26, 'Listar Baixas de Produtos', 4),
	(27, 'CRIAR NOVO UTILIZADOR', 5),
	(28, 'ALTERAR SENHA', 5),
	(29, 'ACTIVAR OU DESACTIVAR USER', 5),
	(30, 'RESET DA SENHA', 5),
	(31, 'LISTAR UTILIZADORES', 5),
	(32, 'PERMISSOES', 5),
	(33, 'ACTIVAR OU DESACTIVAR CLIENTE', 5),
	(34, 'ACTIVAR OU DESACTIVAR FORNECEDOR', 5),
	(35, 'VER MOVIMENTOS DIARIOS', 4),
	(36, 'LISTAR ACTUALIZACOES DO STOCK', 4),
	(37, 'LISTAR CONTA A RECEBER', 4),
	(38, 'LISTAR VENDAS POR PRODUTO', 4),
	(39, 'DESCONTO', 6),
	(40, 'DESCONTO PERCENTUAL', 6),
	(41, 'DESCRICAO ADICIONAL', 6),
	(42, 'NOTA DE CRÉDITO', 2),
	(43, 'NOTA DE DÉBITO', 2),
	(44, 'DEPÓSITO DE VALORES', 2),
	(45, 'NUMERAÇÃO DE FACTURAS', 2),
	(46, 'ALTERAR TIPO DE UTILIZADOR', 6),
	(47, 'BECKUP DE DADOS', 6),
	(48, 'EMPRESA', 1),
	(49, 'CARTA DE GARANTIA', 1),
	(50, 'VER RELATORIO MENSAL', 4),
	(51, 'TABELA DE PRECOS', 3),
	(52, 'IVA', 3),
	(53, 'PARAMENTROS', 3),
	(54, 'ACTUALIZAR DATA FACTURA', 2),
	(55, 'REIMPRIMIR FECHO DE CAIXA', 3),
	(56, 'CONSULTAS DE STOCK', 4),
	(57, 'HISTORICO DE PRODUTO', 4),
	(58, 'LISTAR MOVIMENTOS PRODUTO', 4),
	(59, 'Extractos de Movimentos', 4);
/*!40000 ALTER TABLE `permissao` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.permissoes
CREATE TABLE IF NOT EXISTS `permissoes` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CodigoUtilizador` int(10) unsigned NOT NULL DEFAULT '0',
  `CodigoPermissao` int(10) unsigned NOT NULL,
  `Valor` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Codigo`,`CodigoUtilizador`,`CodigoPermissao`),
  KEY `FK_permissoes_1` (`CodigoUtilizador`),
  CONSTRAINT `FK_permissoes_1` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.permissoes: ~0 rows (approximately)
/*!40000 ALTER TABLE `permissoes` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissoes` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.produtos
CREATE TABLE IF NOT EXISTS `produtos` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(245) NOT NULL,
  `Preco` double NOT NULL DEFAULT '0',
  `DataExpiracao` date NOT NULL,
  `CodigoUnidadeMedida` int(10) unsigned NOT NULL,
  `CodigoFabricante` int(10) unsigned NOT NULL DEFAULT '0',
  `CodigoUtilizador` int(10) unsigned NOT NULL DEFAULT '0',
  `CodigoBarra` varchar(45) DEFAULT NULL,
  `Existencia` double DEFAULT '0',
  `CodigoCategoria` int(10) unsigned DEFAULT '0',
  `DescricaoProduto` varchar(345) DEFAULT NULL,
  `DataCadastro` datetime DEFAULT NULL,
  `Stocavel` varchar(3) NOT NULL DEFAULT 'SIM',
  `PrecoCompra` double DEFAULT NULL,
  `CodigoStatus` int(10) unsigned NOT NULL DEFAULT '1',
  `CodigoProduto` varchar(45) NOT NULL,
  `QuantMin` double DEFAULT NULL,
  `QuantCritica` double DEFAULT NULL,
  `NomeAlternativo` varchar(45) DEFAULT NULL,
  `diaAlertaExpiracao` int(10) unsigned DEFAULT NULL,
  `cartaDeGarantia` varchar(45) DEFAULT 'NAO',
  `Cor` varchar(45) DEFAULT NULL,
  `Tamanho` varchar(45) DEFAULT NULL,
  `IPC` varchar(45) NOT NULL DEFAULT 'NAO',
  `CodigoConta` varchar(45) NOT NULL DEFAULT '',
  `codigoTipoTaxa` int(10) unsigned DEFAULT '31',
  PRIMARY KEY (`Codigo`),
  KEY `FK_produtos_1` (`CodigoUtilizador`),
  KEY `FK_produtos_2` (`CodigoFabricante`),
  KEY `FK_produtos_3` (`CodigoUnidadeMedida`),
  KEY `FK_produtos_4` (`CodigoCategoria`),
  KEY `FK_produtos_5` (`CodigoStatus`),
  CONSTRAINT `FK_produtos_1` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_produtos_2` FOREIGN KEY (`CodigoFabricante`) REFERENCES `fabricantes` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_produtos_3` FOREIGN KEY (`CodigoUnidadeMedida`) REFERENCES `unidade_medida` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_produtos_4` FOREIGN KEY (`CodigoCategoria`) REFERENCES `categorias` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_produtos_5` FOREIGN KEY (`CodigoStatus`) REFERENCES `status` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.produtos: ~2 rows (approximately)
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` (`Codigo`, `Designacao`, `Preco`, `DataExpiracao`, `CodigoUnidadeMedida`, `CodigoFabricante`, `CodigoUtilizador`, `CodigoBarra`, `Existencia`, `CodigoCategoria`, `DescricaoProduto`, `DataCadastro`, `Stocavel`, `PrecoCompra`, `CodigoStatus`, `CodigoProduto`, `QuantMin`, `QuantCritica`, `NomeAlternativo`, `diaAlertaExpiracao`, `cartaDeGarantia`, `Cor`, `Tamanho`, `IPC`, `CodigoConta`, `codigoTipoTaxa`) VALUES
	(1, 'DIVERSOS', 1.5, '2020-05-11', 5, 1, 1, '2010000101', 0, 1, '', '2020-05-11 00:13:51', 'NAO', 0, 1, '', 0, 0, '', 0, 'NAO', NULL, NULL, '0', '', 31),
	(2, 'DIVERSOS IVA', 0, '2029-05-13', 5, 1, 1, '20100B001', 0, 1, '', '2020-05-13 06:23:43', 'NAO', 0, 1, '', 0, 0, '', 0, 'NAO', NULL, NULL, '0', '', 26);
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.produtosalternativo
CREATE TABLE IF NOT EXISTS `produtosalternativo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prod` varchar(450) NOT NULL DEFAULT '',
  `codprod` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_produtosalternativo_1` (`codprod`),
  CONSTRAINT `FK_produtosalternativo_1` FOREIGN KEY (`codprod`) REFERENCES `produtos` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.produtosalternativo: ~0 rows (approximately)
/*!40000 ALTER TABLE `produtosalternativo` DISABLE KEYS */;
/*!40000 ALTER TABLE `produtosalternativo` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.produto_uso
CREATE TABLE IF NOT EXISTS `produto_uso` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.produto_uso: ~0 rows (approximately)
/*!40000 ALTER TABLE `produto_uso` DISABLE KEYS */;
/*!40000 ALTER TABLE `produto_uso` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.serie
CREATE TABLE IF NOT EXISTS `serie` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) NOT NULL DEFAULT '',
  `Ano` int(11) NOT NULL DEFAULT '0',
  `Status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Codigo`),
  KEY `FK_serie_1` (`Ano`),
  CONSTRAINT `FK_serie_1` FOREIGN KEY (`Ano`) REFERENCES `ano` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.serie: ~4 rows (approximately)
/*!40000 ALTER TABLE `serie` DISABLE KEYS */;
INSERT INTO `serie` (`Codigo`, `Designacao`, `Ano`, `Status`) VALUES
	(1, 'C', 3, 1),
	(2, 'F', 3, 1),
	(3, 'D', 3, 1),
	(4, 'R', 3, 1);
/*!40000 ALTER TABLE `serie` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.status
CREATE TABLE IF NOT EXISTS `status` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.status: ~6 rows (approximately)
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` (`Codigo`, `Designacao`) VALUES
	(1, 'Activo'),
	(2, 'Desactivo'),
	(3, 'Proforma'),
	(4, 'Venda a Credito'),
	(5, 'Oferta'),
	(6, 'Cobranca');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.stock_movimentos
CREATE TABLE IF NOT EXISTS `stock_movimentos` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CodigoUtilizador` int(10) unsigned NOT NULL DEFAULT '0',
  `DataMovimento` datetime NOT NULL,
  `Quantidade` double NOT NULL DEFAULT '0',
  `PrecoProduto` double NOT NULL DEFAULT '0',
  `TotalMovimento` double NOT NULL DEFAULT '0',
  `TipoMovimento` varchar(145) NOT NULL COMMENT 'venda, actualizacao, transferencia ou entrada stock',
  `ExistenciaAntes` double NOT NULL DEFAULT '0',
  `ExistenciaDepois` double NOT NULL DEFAULT '0',
  `CodigoArmazem` double NOT NULL DEFAULT '0',
  `CodigoProduto` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Codigo`),
  KEY `FK_stock_movimentos_1` (`CodigoProduto`),
  KEY `FK_stock_movimentos_2` (`CodigoUtilizador`),
  KEY `FK_stock_movimentos_3` (`CodigoArmazem`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.stock_movimentos: ~0 rows (approximately)
/*!40000 ALTER TABLE `stock_movimentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `stock_movimentos` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.tb_preco
CREATE TABLE IF NOT EXISTS `tb_preco` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Preco` double DEFAULT NULL,
  `Designacao` varchar(45) DEFAULT NULL,
  `CodigoProduto` int(10) unsigned DEFAULT NULL,
  `CodigoUtilizador` int(10) unsigned DEFAULT NULL,
  `CodigoStatus` int(10) unsigned DEFAULT '1',
  PRIMARY KEY (`Codigo`),
  KEY `FK_tb_Produto` (`CodigoProduto`),
  KEY `FK_tb_Utilizadores` (`CodigoUtilizador`),
  KEY `FK_tb_Status` (`CodigoStatus`),
  CONSTRAINT `FK_tb_Produto` FOREIGN KEY (`CodigoProduto`) REFERENCES `produtos` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_tb_Status` FOREIGN KEY (`CodigoStatus`) REFERENCES `status` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_tb_Utilizadores` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.tb_preco: ~0 rows (approximately)
/*!40000 ALTER TABLE `tb_preco` DISABLE KEYS */;
/*!40000 ALTER TABLE `tb_preco` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.termos_de_contrato
CREATE TABLE IF NOT EXISTS `termos_de_contrato` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numeroContrato` varchar(45) NOT NULL,
  `pr` varchar(45) NOT NULL,
  `dataIncial` varchar(45) NOT NULL,
  `dataFinal` varchar(45) NOT NULL,
  `CodigoFactura` int(10) unsigned NOT NULL DEFAULT '1',
  `Base` varchar(45) NOT NULL DEFAULT 'TESTE',
  PRIMARY KEY (`Codigo`),
  KEY `FK_termos_de_contrato_1` (`CodigoFactura`),
  CONSTRAINT `FK_termos_de_contrato_1` FOREIGN KEY (`CodigoFactura`) REFERENCES `factura` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.termos_de_contrato: ~0 rows (approximately)
/*!40000 ALTER TABLE `termos_de_contrato` DISABLE KEYS */;
/*!40000 ALTER TABLE `termos_de_contrato` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.tipos_documentos
CREATE TABLE IF NOT EXISTS `tipos_documentos` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table wimmarket_pro.tipos_documentos: ~3 rows (approximately)
/*!40000 ALTER TABLE `tipos_documentos` DISABLE KEYS */;
INSERT INTO `tipos_documentos` (`Codigo`, `Designacao`) VALUES
	(1, 'GUIA DE CONSIGNAÇÃO'),
	(3, 'GUIA DE REMESSA'),
	(4, 'GUIA DE TRANSPORTE');
/*!40000 ALTER TABLE `tipos_documentos` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.tipos_pagamento
CREATE TABLE IF NOT EXISTS `tipos_pagamento` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(100) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.tipos_pagamento: ~6 rows (approximately)
/*!40000 ALTER TABLE `tipos_pagamento` DISABLE KEYS */;
INSERT INTO `tipos_pagamento` (`Codigo`, `Designacao`) VALUES
	(1, 'NUMERARIO'),
	(2, 'MULTICAIXA'),
	(3, 'DEP. BFA'),
	(4, 'DEP. BPC'),
	(5, 'DEP. BIC'),
	(6, 'DEP. FINIBANCO');
/*!40000 ALTER TABLE `tipos_pagamento` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.tipos_permissoes
CREATE TABLE IF NOT EXISTS `tipos_permissoes` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.tipos_permissoes: ~35 rows (approximately)
/*!40000 ALTER TABLE `tipos_permissoes` DISABLE KEYS */;
INSERT INTO `tipos_permissoes` (`Codigo`, `Designacao`) VALUES
	(1, 'Cria Novo User'),
	(2, 'Ver Todos Utilizador'),
	(3, 'Alterar Premissoes de Outros Utilizadores'),
	(4, 'Bloquear Utilizadores'),
	(5, 'Actualizar Permissoes de Utilizadores'),
	(6, 'Permitir Tudo'),
	(7, 'Alterar Passwords de Utilizadores'),
	(8, 'Desbloquear Utilizadores'),
	(9, 'Ver Permissoes de Utilizadores'),
	(10, 'Listar Produtos'),
	(11, 'Listar Existencias de produtos'),
	(12, 'Listar Entradas de Produtos no Stock'),
	(13, 'Listar Baixas de Produtos'),
	(14, 'Ver Creditos ÃƒÆ’Ã‚Â  Clientes'),
	(15, 'Listar Fornecedores'),
	(16, 'Listar Encomendas'),
	(17, 'Ver Movimentos DiÃƒÆ’Ã‚Â¡rios'),
	(18, 'Alterar Produtos'),
	(19, 'Alterar Clientes'),
	(20, 'Alterar Fornecedores'),
	(21, 'Alterar Entradas de Stock'),
	(22, 'Alterar Facturas'),
	(23, 'Alterar Encomendas'),
	(24, 'Actualizar Stock'),
	(25, 'Debito a Clientes'),
	(26, 'DÃƒÆ’Ã‚Â©bito a Fornecedores'),
	(27, 'Cadastrar Novos Produtos'),
	(28, 'Cadastrar Clientes'),
	(29, 'Cadastrar Fornecedores'),
	(30, 'Registar Entradas de Stock'),
	(31, 'Salvar Facturas'),
	(32, 'Cadastrar Encomendas'),
	(33, 'Salvar Actualizacoes de Stock'),
	(34, 'Gravar Debito a Clientes'),
	(35, 'Gravar DÃƒÆ’Ã‚Â©bito a Fornecedores');
/*!40000 ALTER TABLE `tipos_permissoes` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.tipos_regimes
CREATE TABLE IF NOT EXISTS `tipos_regimes` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(100) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table wimmarket_pro.tipos_regimes: ~3 rows (approximately)
/*!40000 ALTER TABLE `tipos_regimes` DISABLE KEYS */;
INSERT INTO `tipos_regimes` (`Codigo`, `Designacao`) VALUES
	(1, 'Regime Geral'),
	(2, 'Regime Transitório'),
	(3, 'Regime de Não sujeição (Lei nº 7/19 de 24 de Abril)');
/*!40000 ALTER TABLE `tipos_regimes` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.tipotaxa
CREATE TABLE IF NOT EXISTS `tipotaxa` (
  `codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `taxa` int(11) NOT NULL,
  `codigoMotivo` int(10) unsigned DEFAULT NULL,
  `codigostatus` int(10) unsigned NOT NULL,
  `descricao` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`codigo`),
  KEY `FK_tipotaxa_2` (`codigostatus`),
  KEY `FK_tipotaxa_1` (`codigoMotivo`),
  CONSTRAINT `FK_tipotaxa_1` FOREIGN KEY (`codigoMotivo`) REFERENCES `motivo` (`codigo`),
  CONSTRAINT `FK_tipotaxa_2` FOREIGN KEY (`codigostatus`) REFERENCES `status` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- Dumping data for table wimmarket_pro.tipotaxa: ~25 rows (approximately)
/*!40000 ALTER TABLE `tipotaxa` DISABLE KEYS */;
INSERT INTO `tipotaxa` (`codigo`, `taxa`, `codigoMotivo`, `codigostatus`, `descricao`) VALUES
	(4, 0, 8, 1, NULL),
	(5, 0, 9, 1, NULL),
	(6, 0, 10, 1, NULL),
	(7, 0, 11, 1, NULL),
	(8, 0, 12, 1, NULL),
	(9, 0, 13, 1, NULL),
	(10, 0, 14, 1, NULL),
	(11, 0, 15, 1, NULL),
	(12, 0, 16, 1, NULL),
	(13, 0, 17, 1, NULL),
	(14, 0, 18, 1, NULL),
	(15, 0, 19, 1, NULL),
	(16, 0, 20, 1, NULL),
	(17, 0, 21, 1, NULL),
	(18, 0, 22, 1, NULL),
	(19, 0, 23, 1, NULL),
	(20, 0, 24, 1, NULL),
	(21, 0, 25, 1, NULL),
	(22, 0, 26, 1, NULL),
	(23, 0, 27, 1, NULL),
	(24, 0, 28, 1, NULL),
	(25, 0, 29, 1, NULL),
	(26, 14, NULL, 1, 'IVA'),
	(31, 0, 7, 1, ''),
	(32, 25, NULL, 1, 'IVA');
/*!40000 ALTER TABLE `tipotaxa` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.tipo_cliente
CREATE TABLE IF NOT EXISTS `tipo_cliente` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.tipo_cliente: ~4 rows (approximately)
/*!40000 ALTER TABLE `tipo_cliente` DISABLE KEYS */;
INSERT INTO `tipo_cliente` (`Codigo`, `Designacao`) VALUES
	(1, 'Singular'),
	(2, 'Instituição Publico'),
	(3, 'Instituição Privada'),
	(4, 'Empresa');
/*!40000 ALTER TABLE `tipo_cliente` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.tipo_estado_viatura
CREATE TABLE IF NOT EXISTS `tipo_estado_viatura` (
  `Id_viatura` int(10) unsigned NOT NULL,
  `Id_tipo_estado` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.tipo_estado_viatura: ~0 rows (approximately)
/*!40000 ALTER TABLE `tipo_estado_viatura` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo_estado_viatura` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.tipo_utilizador
CREATE TABLE IF NOT EXISTS `tipo_utilizador` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) NOT NULL,
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.tipo_utilizador: ~3 rows (approximately)
/*!40000 ALTER TABLE `tipo_utilizador` DISABLE KEYS */;
INSERT INTO `tipo_utilizador` (`Codigo`, `Designacao`) VALUES
	(1, 'Administrador'),
	(2, 'Caixa'),
	(3, 'Convidado');
/*!40000 ALTER TABLE `tipo_utilizador` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.transferencias_produtos
CREATE TABLE IF NOT EXISTS `transferencias_produtos` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `DataTransferencia` datetime NOT NULL,
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  `OBS` varchar(45) DEFAULT NULL,
  `CodigoProduto` int(10) unsigned NOT NULL,
  `CodigoArmazemOrigem` int(10) unsigned NOT NULL,
  `CodigoArmazemDestino` int(10) unsigned NOT NULL,
  `Quantidade` double NOT NULL DEFAULT '0',
  `armazemOrigem` varchar(300) DEFAULT NULL,
  `armazemDestino` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_transferencias_produtos_4` (`CodigoUtilizador`),
  KEY `FK_transferencias_produtos_2` (`CodigoProduto`),
  CONSTRAINT `FK_transferencias_produtos_2` FOREIGN KEY (`CodigoProduto`) REFERENCES `produtos` (`Codigo`),
  CONSTRAINT `FK_transferencias_produtos_4` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.transferencias_produtos: ~0 rows (approximately)
/*!40000 ALTER TABLE `transferencias_produtos` DISABLE KEYS */;
/*!40000 ALTER TABLE `transferencias_produtos` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.unidade_medida
CREATE TABLE IF NOT EXISTS `unidade_medida` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Designacao` varchar(45) DEFAULT NULL,
  `CodigoUtilizador` int(10) unsigned DEFAULT NULL,
  `NItems` float NOT NULL DEFAULT '1',
  `CodigoStatus` int(10) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`Codigo`),
  KEY `FK_unidade_medida_1` (`CodigoStatus`),
  CONSTRAINT `FK_unidade_medida_1` FOREIGN KEY (`CodigoStatus`) REFERENCES `status` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.unidade_medida: ~7 rows (approximately)
/*!40000 ALTER TABLE `unidade_medida` DISABLE KEYS */;
INSERT INTO `unidade_medida` (`Codigo`, `Designacao`, `CodigoUtilizador`, `NItems`, `CodigoStatus`) VALUES
	(1, 'Un', 1, 1, 1),
	(2, 'm', 1, 1, 1),
	(3, 'm2', 1, 1, 1),
	(5, 'div', 1, 1, 1),
	(7, 'ml', NULL, 1, 1),
	(9, 'Kg', NULL, 1, 1),
	(10, 'L', NULL, 1, 1);
/*!40000 ALTER TABLE `unidade_medida` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.utilizadores
CREATE TABLE IF NOT EXISTS `utilizadores` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(95) NOT NULL,
  `Username` varchar(45) NOT NULL,
  `Password` varchar(45) DEFAULT NULL,
  `CodigoTipoUtilizador` int(10) unsigned NOT NULL,
  `CodigoStatus` int(10) unsigned NOT NULL DEFAULT '1',
  `MSG_BENVINDO` varchar(45) NOT NULL DEFAULT 'SIM',
  `FeixarCaixa` varchar(45) NOT NULL DEFAULT 'NAO',
  `estado_password` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`Codigo`),
  KEY `FK_utilizadores_1` (`CodigoTipoUtilizador`),
  CONSTRAINT `FK_utilizadores_1` FOREIGN KEY (`CodigoTipoUtilizador`) REFERENCES `tipo_utilizador` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.utilizadores: ~0 rows (approximately)
/*!40000 ALTER TABLE `utilizadores` DISABLE KEYS */;
INSERT INTO `utilizadores` (`Codigo`, `Nome`, `Username`, `Password`, `CodigoTipoUtilizador`, `CodigoStatus`, `MSG_BENVINDO`, `FeixarCaixa`, `estado_password`) VALUES
	(1, 'Ramossoft', 'root', '63a9f0ea7bb98050796b649e85481845', 1, 1, 'SIM', 'NAO', 1);
/*!40000 ALTER TABLE `utilizadores` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.utilizadores_permissoes
CREATE TABLE IF NOT EXISTS `utilizadores_permissoes` (
  `Codigo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `CodigoUtilizador` int(10) unsigned NOT NULL,
  `CodigoTipoPermissao` int(10) unsigned NOT NULL,
  PRIMARY KEY (`Codigo`),
  KEY `FK_utilizadores_permissoes_1` (`CodigoUtilizador`),
  KEY `FK_utilizadores_permissoes_2` (`CodigoTipoPermissao`),
  CONSTRAINT `FK_utilizadores_permissoes_1` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_utilizadores_permissoes_2` FOREIGN KEY (`CodigoTipoPermissao`) REFERENCES `tipos_permissoes` (`Codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.utilizadores_permissoes: ~0 rows (approximately)
/*!40000 ALTER TABLE `utilizadores_permissoes` DISABLE KEYS */;
/*!40000 ALTER TABLE `utilizadores_permissoes` ENABLE KEYS */;

-- Dumping structure for table wimmarket_pro.vendedor
CREATE TABLE IF NOT EXISTS `vendedor` (
  `Codigo` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(45) NOT NULL DEFAULT '',
  `Endereco` varchar(450) DEFAULT '',
  `Email` varchar(450) DEFAULT '',
  `Bi` varchar(45) DEFAULT '',
  `DataNascimento` date NOT NULL DEFAULT '0000-00-00',
  `CodigoStatus` int(10) unsigned NOT NULL DEFAULT '0',
  `CodigoUtilizador` int(10) unsigned NOT NULL DEFAULT '0',
  `Telefone` varchar(45) DEFAULT '',
  PRIMARY KEY (`Codigo`),
  KEY `FK_vendedor_1` (`CodigoStatus`),
  KEY `FK_vendedor_2` (`CodigoUtilizador`),
  CONSTRAINT `FK_vendedor_1` FOREIGN KEY (`CodigoStatus`) REFERENCES `status` (`Codigo`),
  CONSTRAINT `FK_vendedor_2` FOREIGN KEY (`CodigoUtilizador`) REFERENCES `utilizadores` (`Codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table wimmarket_pro.vendedor: ~0 rows (approximately)
/*!40000 ALTER TABLE `vendedor` DISABLE KEYS */;
INSERT INTO `vendedor` (`Codigo`, `Nome`, `Endereco`, `Email`, `Bi`, `DataNascimento`, `CodigoStatus`, `CodigoUtilizador`, `Telefone`) VALUES
	(1, 'DIVERSOS', 'LUANDA', 'teste@gmail.com', '001012604LA032', '2019-05-08', 1, 1, '992949982');
/*!40000 ALTER TABLE `vendedor` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
