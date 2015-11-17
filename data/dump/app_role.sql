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

-- Copiando estrutura para tabela local.transportadora.app_role
CREATE TABLE IF NOT EXISTS `app_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `is_admin` int(1) DEFAULT '2' COMMENT '1=Sim2=Nao',
  `registered_by` varchar(45) NOT NULL,
  `registered_in` datetime NOT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `modified_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_app_roles_app_roles1_idx` (`role_id`),
  CONSTRAINT `fk_app_roles_app_roles1` FOREIGN KEY (`role_id`) REFERENCES `app_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela local.transportadora.app_role: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `app_role` DISABLE KEYS */;
INSERT INTO `app_role` (`id`, `role_id`, `name`, `is_admin`, `registered_by`, `registered_in`, `modified_by`, `modified_in`) VALUES
	(11, NULL, 'Administrador', 1, 'SessionName', '2014-04-02 19:45:27', 'SessionName', '2015-11-16 11:05:01');
/*!40000 ALTER TABLE `app_role` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
