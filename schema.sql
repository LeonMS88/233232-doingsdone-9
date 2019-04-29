-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.3.13-MariaDB - mariadb.org binary distribution
-- Операционная система:         Win64
-- HeidiSQL Версия:              10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных things are fine id233232
CREATE DATABASE IF NOT EXISTS `things are fine id233232` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `things are fine id233232`;

-- Дамп структуры для таблица things are fine id233232.progect
CREATE TABLE IF NOT EXISTS `progect` (
  `progect_id` int(11) NOT NULL AUTO_INCREMENT,
  `progect_name` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`progect_id`),
  KEY `FK_progect_user` (`user_id`),
  CONSTRAINT `FK_progect_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица things are fine id233232.task
CREATE TABLE IF NOT EXISTS `task` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `task_create` datetime NOT NULL,
  `task_status` int(11) NOT NULL,
  `task_name` varchar(50) NOT NULL,
  `task_file` varchar(50) NOT NULL,
  `task_completed` int(11) NOT NULL,
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `progect_id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`task_id`),
  KEY `FK_task_user` (`user_id`),
  KEY `FK_task_progect` (`progect_id`),
  CONSTRAINT `FK_task_progect` FOREIGN KEY (`progect_id`) REFERENCES `progect` (`progect_id`),
  CONSTRAINT `FK_task_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица things are fine id233232.user
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_add` datetime NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
