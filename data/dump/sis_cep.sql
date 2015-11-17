-- --------------------------------------------------------
-- Servidor:                     192.168.56.110
-- Versão do servidor:           5.6.20 - MySQL Community Server (GPL)
-- OS do Servidor:               Linux
-- HeidiSQL Versão:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura para tabela local.transportadora.sis_cep
CREATE TABLE IF NOT EXISTS `sis_cep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transportadora_id` int(11) NOT NULL,
  `cep_inicial` varchar(8) DEFAULT NULL,
  `cep_final` varchar(8) DEFAULT NULL,
  `peso` int(5) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`,`transportadora_id`),
  KEY `cep` (`cep_final`,`cep_inicial`),
  KEY `fk_sis_cep_sis_transportadora_idx` (`transportadora_id`),
  CONSTRAINT `fk_sis_cep_sis_transportadora` FOREIGN KEY (`transportadora_id`) REFERENCES `sis_transportadora` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela local.transportadora.sis_cep: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `sis_cep` DISABLE KEYS */;
INSERT INTO `sis_cep` (`id`, `transportadora_id`, `cep_inicial`, `cep_final`, `peso`, `valor`) VALUES
	(5, 1, '88888888', '88888999', 5, 50.00),
	(6, 2, '88888888', '88888999', 5, 20.00);
/*!40000 ALTER TABLE `sis_cep` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
