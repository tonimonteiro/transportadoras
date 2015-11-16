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

-- Copiando estrutura para tabela local.transportadora.app_navigation
CREATE TABLE IF NOT EXISTS `app_navigation` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Fields: resource / privilege',
  `parent_id` int(11) DEFAULT NULL COMMENT 'Pages',
  `name_group` varchar(45) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `route` varchar(45) DEFAULT NULL,
  `controller` varchar(45) DEFAULT NULL,
  `name_action` varchar(45) DEFAULT NULL,
  `resource` varchar(125) DEFAULT 'null',
  `privilege` varchar(45) DEFAULT NULL,
  `uri` varchar(255) DEFAULT NULL,
  `fragment` varchar(45) DEFAULT NULL,
  `identification` varchar(45) DEFAULT NULL COMMENT 'Attribute: id',
  `class` varchar(45) DEFAULT NULL,
  `title` varchar(45) DEFAULT NULL,
  `target` varchar(45) DEFAULT NULL,
  `rel` varchar(45) DEFAULT NULL,
  `rev` varchar(45) DEFAULT NULL,
  `number_order` int(3) DEFAULT NULL,
  `active` int(1) DEFAULT NULL COMMENT '1=Sim/0=Nao',
  `visible` int(1) DEFAULT NULL COMMENT '1=Sim/0=Nao',
  `params` varchar(255) DEFAULT NULL,
  `registered_by` varchar(45) DEFAULT NULL,
  `registered_in` datetime DEFAULT NULL,
  `modified_by` varchar(45) DEFAULT NULL,
  `modified_in` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_app_navigation_app_navigation1_idx` (`parent_id`),
  CONSTRAINT `fk_app_navigation_app_navigation1` FOREIGN KEY (`parent_id`) REFERENCES `app_navigation` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=187 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela local.transportadora.app_navigation: ~29 rows (aproximadamente)
/*!40000 ALTER TABLE `app_navigation` DISABLE KEYS */;
INSERT INTO `app_navigation` (`id`, `parent_id`, `name_group`, `label`, `route`, `controller`, `name_action`, `resource`, `privilege`, `uri`, `fragment`, `identification`, `class`, `title`, `target`, `rel`, `rev`, `number_order`, `active`, `visible`, `params`, `registered_by`, `registered_in`, `modified_by`, `modified_in`) VALUES
	(1, NULL, '', 'Raíz', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
	(23, 1, 'navigation_admin', 'Navegação', 'simnavigation-admin/default', 'navigation', 'index', 'SimNavigation', 'index', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 6, 1, 1, NULL, 'SessionName', '2014-05-22 20:45:16', 'SessionName', '2014-05-22 20:45:16'),
	(24, 23, 'navigation_admin', 'Novo', 'simnavigation-admin/default', 'navigation', 'new', 'SimNavigation', 'new', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, NULL, 'SessionName', '2014-05-22 20:56:32', 'SessionName', '2014-05-22 20:56:32'),
	(25, 23, 'navigation_admin', 'Editar', 'simnavigation-admin/default', 'navigation', 'edit', 'SimNavigation', 'edit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, 2, NULL, 'SessionName', '2014-05-22 20:56:28', 'SessionName', '2014-05-22 20:56:28'),
	(26, 23, 'navigation_admin', 'Remover', 'simnavigation-admin/default', 'navigation', 'removeResponse', 'SimNavigation', 'removeResponse', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, 2, NULL, 'SessionName', '2014-05-20 11:32:47', 'SessionName', '2014-05-22 20:56:35'),
	(67, 1, 'navigation_admin', 'Usuários do Sistema', 'simuser-admin/default', 'user', 'index', 'SimUser', 'index', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 1, 1, NULL, 'SessionName', '2014-05-19 18:06:05', 'SessionName', '2014-05-22 20:45:04'),
	(68, 67, 'navigation_admin', 'Novo', 'simuser-admin/default', 'user', 'new', 'SimUser', 'new', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, NULL, 'SessionName', '2014-05-19 18:06:20', 'SessionName', '2014-05-22 20:56:22'),
	(69, 67, 'navigation_admin', 'Editar', 'simuser-admin/default', 'user', 'edit', 'SimUser', 'edit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, 2, NULL, 'SessionName', '2014-05-19 18:06:29', 'SessionName', '2014-05-22 20:56:18'),
	(70, 67, 'navigation_admin', 'Remover', 'simuser-admin/default', 'user', 'removeResponse', 'SimUser', 'removeResponse', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, 2, NULL, 'SessionName', '2014-05-19 18:06:39', 'SessionName', '2014-05-22 20:56:25'),
	(71, 1, 'navigation_admin', 'Grupos e Permissões', 'simacl-admin/default', 'role', 'index', 'SimAcl', 'index', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 8, 1, 1, NULL, 'SessionName', '2014-05-20 11:30:38', 'Sim Tecnologia', '2015-03-02 17:02:05'),
	(72, 71, 'navigation_admin', 'Novo', 'simacl-admin/default', 'role', 'new', 'SimAcl', 'new', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, NULL, 'SessionName', '2014-05-20 11:31:03', 'SessionName', '2014-05-22 20:56:12'),
	(73, 71, 'navigation_admin', 'Editar', 'simacl-admin/default', 'role', 'edit', 'SimAcl', 'edit', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, 2, NULL, 'SessionName', '2014-05-20 11:31:11', 'SessionName', '2014-05-22 20:56:08'),
	(74, 71, 'navigation_admin', 'Remover', 'simacl-admin/default', 'role', 'removeResponse', 'SimAcl', 'removeResponse', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, 2, NULL, 'SessionName', '2014-05-20 11:31:20', 'SessionName', '2014-05-22 20:56:15'),
	(75, 1, 'navigation_admin', 'Autenticação', 'simauth-admin', 'admin', 'index', 'SimAuth', 'index', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 2, NULL, 'SessionName', '2014-05-20 11:41:31', 'SessionName', '2014-05-23 03:03:21'),
	(76, 75, 'navigation_admin', 'Autenticação (Logout)', 'simauth-logout', 'admin', 'logout', 'SimAuth', 'logout', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2, NULL, 'SessionName', '2014-05-20 11:41:57', 'SessionName', '2014-05-20 11:41:57'),
	(81, 1, 'navigation_admin', 'Painel', 'admin/default', 'index', 'index', 'Application', 'index', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 1, 1, NULL, 'SessionName', '2014-05-22 21:11:27', 'SessionName', '2014-05-22 21:14:00'),
	(172, 23, 'navigation_admin', 'Filtros', 'simnavigation-admin/default', 'navigation', 'unset-search', 'SimNavigation', 'unset-search', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 2, NULL, 'SessionName', '2014-07-31 03:10:55', 'SessionName', '2014-07-31 03:10:55'),
	(174, 67, 'navigation_admin', 'Filtros', 'simuser-admin/default', 'user', 'unset-search', 'SimUser', 'unset-search', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 2, NULL, 'SessionName', '2014-07-31 03:13:08', 'SessionName', '2014-07-31 03:13:08'),
	(176, 23, 'navigation_admin', 'Árvore de Navegação', 'simnavigation-admin/default', 'navigation', 'name-group', 'SimNavigation', 'name-group', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 2, 2, NULL, 'SessionName', '2014-07-31 11:35:18', 'SessionName', '2014-07-31 11:35:18'),
	(177, 1, 'navigation_admin', 'Transportadoras', 'admin-transportadora/default', 'transportadora', 'index', 'SisTransportadora', 'index', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, 'Sim Tecnologia', '2015-11-16 08:57:48', 'Sim Tecnologia', '2015-11-16 08:58:19'),
	(178, 177, 'navigation_admin', 'Filtros', 'admin-transportadora/default', 'transportadora', 'unset-search', 'SisTransportadora', 'unset-search', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 2, NULL, 'Sim Tecnologia', '2015-11-16 08:59:16', 'Sim Tecnologia', '2015-11-16 08:59:16'),
	(179, 177, 'navigation_admin', 'Novo', 'admin-transportadora/default', 'transportadora', 'new', 'SisTransportadora', 'new', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, NULL, 'Sim Tecnologia', '2015-11-16 08:59:56', 'Sim Tecnologia', '2015-11-16 08:59:56'),
	(180, 177, 'navigation_admin', 'Editar', 'admin-transportadora/default', 'transportadora', 'edit', 'SisTransportadora', 'edit', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, 2, NULL, 'Sim Tecnologia', '2015-11-16 09:00:25', 'Sim Tecnologia', '2015-11-16 09:00:25'),
	(181, 177, 'navigation_admin', 'Remover', 'admin-transportadora/default', 'transportadora', 'removeResponse', 'SisTransportadora', 'removeresponse', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, 2, NULL, 'Sim Tecnologia', '2015-11-16 09:01:06', 'Sim Tecnologia', '2015-11-16 09:01:06'),
	(182, 1, 'navigation_admin', 'Faixas de CEP', 'admin-siscep/default', 'cep', 'index', 'SisCep', 'index', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, 1, NULL, 'Sim Tecnologia', '2015-11-16 09:03:15', 'Sim Tecnologia', '2015-11-16 09:03:15'),
	(183, 182, 'navigation_admin', 'Filtros', 'admin-siscep/default', 'cep', 'unset-search', 'SisCep', 'unset-search', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 2, 2, NULL, 'Sim Tecnologia', '2015-11-16 09:03:54', 'Sim Tecnologia', '2015-11-16 09:03:54'),
	(184, 182, 'navigation_admin', 'Novo', 'admin-siscep/default', 'cep', 'new', 'SisCep', 'new', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 2, NULL, 'Sim Tecnologia', '2015-11-16 09:04:26', 'Sim Tecnologia', '2015-11-16 09:04:26'),
	(185, 182, 'navigation_admin', 'Editar', 'admin-siscep/default', 'cep', 'edit', 'SisCep', 'edit', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, 2, NULL, 'Sim Tecnologia', '2015-11-16 09:04:51', 'Sim Tecnologia', '2015-11-16 09:04:51'),
	(186, 182, 'navigation_admin', 'Remover', 'admin-siscep/default', 'cep', 'removeResponse', 'SisCep', 'removeresponse', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 1, 2, NULL, 'Sim Tecnologia', '2015-11-16 09:05:27', 'Sim Tecnologia', '2015-11-16 09:05:27');
/*!40000 ALTER TABLE `app_navigation` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
