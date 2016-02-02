-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.26-log - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных gallery
CREATE DATABASE IF NOT EXISTS `gallery` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `gallery`;


-- Дамп структуры для таблица gallery.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gallery.categories: ~8 rows (приблизительно)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `title`) VALUES
	(1, 'Nature'),
	(2, 'Sea'),
	(3, 'Summer'),
	(4, 'Work'),
	(5, 'Girls'),
	(6, 'Animals'),
	(7, 'Fun'),
	(8, 'NSFW');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;


-- Дамп структуры для таблица gallery.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gallery.comments: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;


-- Дамп структуры для таблица gallery.photo
CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '0',
  `description` varchar(250) NOT NULL DEFAULT '0',
  `image` varchar(250) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL DEFAULT '0',
  `username_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gallery.photo: ~40 rows (приблизительно)
/*!40000 ALTER TABLE `photo` DISABLE KEYS */;
INSERT INTO `photo` (`id`, `title`, `description`, `image`, `category_id`, `username_id`) VALUES
	(1, 'Test 11', 'test', 'img/1300947.jpg', 1, 2),
	(2, '213213 11', '213132', 'img/1300947.jpg', 2, 2),
	(3, ' 123 11', '123123', 'img/1300947.jpg', 3, 2),
	(4, '21333 11', '213213', 'img/1300947.jpg', 4, 2),
	(5, 'asdwwwww', '2132131', 'img/1300947.jpg', 5, 1),
	(6, 'asdada', 'dsada', 'img/1300947.jpg', 6, 1),
	(7, 'adad', 'asddad', 'img/1300947.jpg', 7, 1),
	(8, 'sadad', 'adada', 'img/1300947.jpg', 8, 1),
	(9, 'asdadaadadaadad', 'adadada', 'img/1300947.jpg', 1, 1),
	(10, 'asdadaadadaadad', 'adadada', 'img/1300947.jpg', 2, 1),
	(11, 'asdadaadadaadad', 'adadada', 'img/1300947.jpg', 3, 2),
	(12, 'asdadaadadaadad', 'adadada', 'img/1300947.jpg', 4, 1),
	(13, 'asdadaadadaadad', 'adadada', 'img/1300947.jpg', 5, 2),
	(14, 'asdadaadadaadad', 'adadada', 'img/1300947.jpg', 6, 2),
	(15, 'asdadaadadaadad', 'adadada', 'img/1300947.jpg', 7, 2),
	(16, 'asdadaadadaadad', 'adadada', 'img/1300947.jpg', 8, 2),
	(17, 'asdssss', 'asd', 'img/1300947.jpg', 1, 1),
	(18, 'asd', '1', 'img/1300947.jpg', 2, 1),
	(19, 'asdsada', '2', 'img/1300947.jpg', 3, 1),
	(20, '3aassad', '3', 'img/1300947.jpg', 4, 1),
	(21, '4sadada', '4', 'img/1300947.jpg', 5, 1),
	(22, 'sdad', '5', 'img/1300947.jpg', 6, 1),
	(23, 'asda', '6', 'img/1300947.jpg', 7, 1),
	(24, 'asdadadadadadaaaaa', '7', 'img/1300947.jpg', 8, 1),
	(25, '8', '8', 'img/1300947.jpg', 1, 1),
	(26, 'asdsqz', '9', 'img/1300947.jpg', 2, 1),
	(27, 'ssdsdsaaa', '9', 'img/1300947.jpg', 3, 1),
	(28, 'asdssssq', '11', 'img/1300947.jpg', 4, 1),
	(29, 'asdad', 'qwewqeqweq', 'img/1300947.jpg', 5, 1),
	(44, 'asdad', 'qwewqeqweq', 'img/1300947.jpg', 6, 1),
	(45, 'asdad', 'qwewqeqweq', 'img/1300947.jpg', 7, 1),
	(46, 'asdad', 'qwewqeqweq', 'img/1300947.jpg', 8, 1),
	(47, 'asdad', 'qwewqeqweq', 'img/1300947.jpg', 1, 1),
	(48, 'asdad', 'qwewqeqweq', 'img/1300947.jpg', 2, 1),
	(49, 'asdad', 'qwewqeqweq', 'img/1300947.jpg', 3, 1),
	(50, 'asdad', 'qwewqeqweq', 'img/1300947.jpg', 4, 1);
/*!40000 ALTER TABLE `photo` ENABLE KEYS */;


-- Дамп структуры для таблица gallery.post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post` varchar(255) DEFAULT NULL,
  `username_id` int(11) DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gallery.post: ~58 rows (приблизительно)
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` (`id`, `post`, `username_id`, `image_id`) VALUES
	(76, '1', 2, 1),
	(77, '2', 2, 1),
	(78, '3', 2, 1),
	(79, '4', 2, 1),
	(80, '5', 2, 1),
	(81, '6', 2, 1),
	(82, '6', 2, 1),
	(83, 'sd', 2, 2),
	(84, 'asdad', 2, 2),
	(85, 'fg', 2, 2),
	(86, 'a', 2, 2),
	(87, 's', 2, 2),
	(88, 'd', 2, 2),
	(89, '1', 2, 4),
	(90, '2', 2, 4),
	(91, '3', 2, 4),
	(92, '4', 2, 4),
	(93, '1', 1, 2),
	(96, 'sadasaa', 1, 1),
	(97, 'qwe', 1, 1),
	(98, 'asd', 1, 1),
	(99, '1', 1, 1),
	(100, '1', 1, 1),
	(101, '123', 1, 1),
	(102, 'asdad', 1, 8),
	(103, 'asdqweqweqweqwewq', 1, 8),
	(104, 'sadadsadsadsadsadasdsadsadsadsadadsadadadad', 1, 8),
	(105, 'asdad', 1, 8),
	(106, 'sada', 1, 8),
	(107, '123', 1, 8),
	(108, '3', 1, 8),
	(109, '4', 1, 8),
	(110, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 1, 8),
	(111, '5', 1, 4),
	(112, 'asd', 1, 2),
	(113, 'asd', 1, 2),
	(114, 'asd', 1, 2),
	(129, '1', 2, 4),
	(217, 'asd', 2, 1),
	(218, 'sad', 2, 1),
	(219, 'sad', 2, 1),
	(220, 'asd', 2, 1),
	(221, 'asdd', 2, 1),
	(222, 'sdqwer', 2, 1),
	(223, 'asdsada', 2, 1),
	(224, 'sadsada', 2, 1),
	(225, 'asd', 2, 1),
	(226, '213213', 2, 1),
	(227, 'asdwqe', 2, 1),
	(228, 'asd', 2, 1),
	(229, 'sadsad', 2, 1),
	(230, 'adada', 2, 1),
	(231, 'sadsada', 2, 1),
	(232, 'sadsada', 2, 1),
	(233, 'adad', 2, 1),
	(234, '213213213', 2, 1),
	(235, 'sadadqwe', 2, 2),
	(236, '21321321', 2, 2),
	(237, 'asdsadada', 2, 4),
	(238, 'qwe', NULL, 5),
	(239, 'asdwqe', NULL, 5);
/*!40000 ALTER TABLE `post` ENABLE KEYS */;


-- Дамп структуры для таблица gallery.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gallery.users: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`) VALUES
	(1, 'defacto', '$2y$10$v90N1LWjTgGpHpTuL6RB0OYZBhDaOvPqoroXHGE8jBmOJX12iAi1q'),
	(2, 'user', '$2y$10$y7.fL6/4C87wIDCxBT/xaeRlpyAA1nU1E6AsDQF52sZteIWdikyxG');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
