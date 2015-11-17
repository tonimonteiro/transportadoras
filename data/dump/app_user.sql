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

-- Copiando estrutura para tabela local.transportadora.app_user
CREATE TABLE IF NOT EXISTS `app_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `active` int(1) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `expire_in` datetime DEFAULT NULL,
  `registered_by` varchar(45) NOT NULL,
  `registered_in` datetime NOT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `modified_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `fk_app_user_app_role1_idx` (`role_id`),
  CONSTRAINT `fk_app_user_app_role1` FOREIGN KEY (`role_id`) REFERENCES `app_role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela local.transportadora.app_user: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `app_user` DISABLE KEYS */;
INSERT INTO `app_user` (`id`, `role_id`, `name`, `email`, `username`, `password`, `active`, `salt`, `expire_in`, `registered_by`, `registered_in`, `modified_by`, `modified_in`) VALUES
	(1, 11, 'Administrador', 'tonimonteiro@gmail.com', 'administrador', 'S946hey8QLY=', 1, 'numiD7PT7o0=', NULL, 'SessionName', '2014-04-02 21:53:18', 'SessionName', '2015-11-16 11:12:28');
/*!40000 ALTER TABLE `app_user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
