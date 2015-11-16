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

-- Copiando estrutura para tabela local.transportadora.app_privilege
CREATE TABLE IF NOT EXISTS `app_privilege` (
  `app_role_id` int(11) NOT NULL,
  `app_navigation_id` int(11) NOT NULL,
  PRIMARY KEY (`app_role_id`,`app_navigation_id`),
  KEY `fk_app_role_has_app_navigation_app_navigation1_idx` (`app_navigation_id`),
  KEY `fk_app_role_has_app_navigation_app_role1_idx` (`app_role_id`),
  CONSTRAINT `fk_app_role_has_app_navigation_app_role1` FOREIGN KEY (`app_role_id`) REFERENCES `app_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela local.transportadora.app_privilege: ~28 rows (aproximadamente)
/*!40000 ALTER TABLE `app_privilege` DISABLE KEYS */;
INSERT INTO `app_privilege` (`app_role_id`, `app_navigation_id`) VALUES
	(11, 23),
	(11, 24),
	(11, 25),
	(11, 26),
	(11, 67),
	(11, 68),
	(11, 69),
	(11, 70),
	(11, 71),
	(11, 72),
	(11, 73),
	(11, 74),
	(11, 75),
	(11, 76),
	(11, 81),
	(11, 172),
	(11, 174),
	(11, 176),
	(11, 177),
	(11, 178),
	(11, 179),
	(11, 180),
	(11, 181),
	(11, 182),
	(11, 183),
	(11, 184),
	(11, 185),
	(11, 186);
/*!40000 ALTER TABLE `app_privilege` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
