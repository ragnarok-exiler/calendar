/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

DROP DATABASE IF EXISTS `calendar`;
CREATE DATABASE IF NOT EXISTS `calendar` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `calendar`;

DROP TABLE IF EXISTS `auth_assignment`;
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `auth_assignment_user_id_idx` (`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DELETE FROM `auth_assignment`;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;

DROP TABLE IF EXISTS `auth_item`;
CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DELETE FROM `auth_item`;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;

DROP TABLE IF EXISTS `auth_item_child`;
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DELETE FROM `auth_item_child`;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;

DROP TABLE IF EXISTS `auth_rule`;
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DELETE FROM `auth_rule`;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;

DROP TABLE IF EXISTS `festive`;
CREATE TABLE IF NOT EXISTS `festive` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `free_day` date NOT NULL,
  `festive_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_festive_festive_type` (`festive_type_id`),
  CONSTRAINT `FK_festive_festive_type` FOREIGN KEY (`festive_type_id`) REFERENCES `festive_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Días festivos';

DELETE FROM `festive`;
/*!40000 ALTER TABLE `festive` DISABLE KEYS */;
INSERT INTO `festive` (`id`, `free_day`, `festive_type_id`) VALUES
	(1, '2018-12-25', 1),
	(2, '2018-12-26', 1),
	(3, '2019-01-01', 1),
	(4, '2018-12-06', 1),
	(5, '2018-12-08', 1),
	(6, '2018-11-01', 1),
	(7, '2018-10-12', 1),
	(8, '2018-09-11', 1),
	(9, '2018-05-01', 1),
	(10, '2018-04-02', 1),
	(11, '2019-01-09', 1),
	(12, '2019-01-06', 1),
	(13, '2018-03-30', 1),
	(14, '2018-08-15', 1),
	(15, '2018-09-24', 2),
	(16, '2018-05-21', 2);
/*!40000 ALTER TABLE `festive` ENABLE KEYS */;

DROP TABLE IF EXISTS `festive_type`;
CREATE TABLE IF NOT EXISTS `festive_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requestable` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Tipos de fastivos';

DELETE FROM `festive_type`;
/*!40000 ALTER TABLE `festive_type` DISABLE KEYS */;
INSERT INTO `festive_type` (`id`, `name`, `requestable`) VALUES
	(1, 'Fiestas Laborales', 0),
	(2, 'Fiestas Locales Barcelona', 0),
	(3, 'Fiestas Locales Madrid', 0);
/*!40000 ALTER TABLE `festive_type` ENABLE KEYS */;

DROP TABLE IF EXISTS `holidays`;
CREATE TABLE IF NOT EXISTS `holidays` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `days_number` int(11) NOT NULL,
  `departmen_responsable_accepted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `boss_accepted` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_holidays_user` (`user_id`),
  CONSTRAINT `FK_holidays_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DELETE FROM `holidays`;
/*!40000 ALTER TABLE `holidays` DISABLE KEYS */;
INSERT INTO `holidays` (`id`, `user_id`, `start_date`, `end_date`, `days_number`, `departmen_responsable_accepted`, `boss_accepted`) VALUES
	(1, 2, '2018-12-24', '2018-12-26', 3, 0, 0),
	(2, 1, '2018-12-29', '2019-01-01', 3, 0, 0),
	(4, 1, '2018-11-21', '2018-11-27', 3, 0, 0),
	(5, 1, '2019-01-01', '2019-01-10', 6, 0, 0),
	(6, 1, '2019-01-14', '2019-01-22', 7, 0, 0),
	(7, 1, '2019-01-10', '2019-01-15', 4, 0, 0);
/*!40000 ALTER TABLE `holidays` ENABLE KEYS */;

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DELETE FROM `migration`;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1541434732),
	('m130524_201442_init', 1541435120),
	('m140506_102106_rbac_init', 1541437177),
	('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1541437177);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '1',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `name`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'jsalgado', 'Juan Salgado', '2xcN6hTQ-QGqtPAeyjyFwSQNeHn5QBr8', '$2y$13$0glk551urP.y3of1wZ0Oj.fEIIVBuwrg8JMEKLzF.ychwwhVQ5Oqy', NULL, 'jsalgado@factorenergia.com', 10, 1541508268, 1541508268),
	(2, 'mpascale', 'Marco Pascale', 'QyGVjCW3V3TbhGCjEGqk0BAygYnWFfxD', '$2y$13$0glk551urP.y3of1wZ0Oj.fEIIVBuwrg8JMEKLzF.ychwwhVQ5Oqy', NULL, 'mpascale@factorenergia.com', 10, 1541517434, 1541517434),
	(3, 'mpeirato', 'Manel Peirato', 'QyGVjCW3V3TbhGCjEGqk0BAygYnWFfxD', '$2y$13$0glk551urP.y3of1wZ0Oj.fEIIVBuwrg8JMEKLzF.ychwwhVQ5Oqy', NULL, 'mpeirato@factorenergia.com', 10, 1541517434, 1541517434);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
