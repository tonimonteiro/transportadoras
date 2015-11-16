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

-- Copiando estrutura para tabela local.transportadora.app_history
CREATE TABLE IF NOT EXISTS `app_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `action` int(1) NOT NULL COMMENT '1=Create\n2=Read\n3=Update\n4=Delete',
  `description` varchar(255) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`id`,`user_id`),
  KEY `action` (`action`),
  KEY `fk_app_history_app_user1_idx` (`user_id`),
  CONSTRAINT `fk_app_history_app_user1` FOREIGN KEY (`user_id`) REFERENCES `app_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela local.transportadora.app_history: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `app_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_history` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
