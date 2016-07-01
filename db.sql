-- --------------------------------------------------------
-- Хост:                         localhost
-- Версия сервера:               5.6.26 - MySQL Community Server (GPL)
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
  `title` varchar(255) NOT NULL,
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


-- Дамп структуры для таблица gallery.photo
CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `categories_id` int(11) DEFAULT NULL,
  `username_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_14B78418A21214B7` (`categories_id`),
  KEY `IDX_14B78418ED766068` (`username_id`),
  CONSTRAINT `FK_14B78418A21214B7` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `FK_14B78418ED766068` FOREIGN KEY (`username_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gallery.photo: ~32 rows (приблизительно)
/*!40000 ALTER TABLE `photo` DISABLE KEYS */;
INSERT INTO `photo` (`id`, `title`, `description`, `image`, `categories_id`, `username_id`) VALUES
	(1, 'Test 11', 'test', 'img/1300947.jpg', 6, 17),
	(2, '213213 11', '213132', 'img/1300947.jpg', 6, 16),
	(3, ' 123 11', '123123', 'img/1300947.jpg', 7, 16),
	(4, '21333 11', '213213', 'img/1300947.jpg', 7, 1),
	(5, 'asdwwwww', '2132131', 'img/1300947.jpg', 7, 2),
	(6, 'asdada', 'dsada', 'img/1300947.jpg', 8, 2),
	(7, 'adad', 'asddad', 'img/1300947.jpg', 8, 17),
	(8, 'sadad', 'adada', 'img/1300947.jpg', 8, 16),
	(9, 'asdadaadadaadad', 'adadada', 'img/1300947.jpg', 5, 17),
	(10, 'asdadaadadaadad', 'adadada', 'img/1300947.jpg', 6, 16),
	(11, 'asdadaadadaadad', 'adadada', 'img/1300947.jpg', 1, 1),
	(12, 'asdadaadadaadad', 'adadada', 'img/1300947.jpg', 3, 16),
	(13, 'asdadaadadaadad', 'adadada', 'img/1300947.jpg', 1, 17),
	(14, 'asdadaadadaadad', 'adadada', 'img/1300947.jpg', 1, 16),
	(15, 'asdadaadadaadad', 'adadada', 'img/1300947.jpg', 3, 2),
	(16, 'asdadaadadaadad', 'adadada', 'img/1300947.jpg', 3, 1),
	(17, 'asdssss', 'asd', 'img/1300947.jpg', 2, 1),
	(18, 'asd', '1', 'img/1300947.jpg', 2, 17),
	(19, 'asdsada', '2', 'img/1300947.jpg', 2, 1),
	(20, '3aassad', '3', 'img/1300947.jpg', 2, 17),
	(21, '4sadada', '4', 'img/1300947.jpg', 4, 1),
	(22, 'sdad', '5', 'img/1300947.jpg', 4, 2),
	(23, 'asda', '6', 'img/1300947.jpg', 4, 2),
	(24, 'asdadadadadadaaaaa', '7', 'img/1300947.jpg', 5, 17),
	(25, '8', '8', 'img/1300947.jpg', 5, 17),
	(27, 'ssdsdsaaa', '9', 'img/1300947.jpg', 8, 16),
	(44, 'asdad', 'qwewqeqweq', 'img/1300947.jpg', 1, 2),
	(45, 'asdad', 'qwewqeqweq', 'img/1300947.jpg', 3, 1),
	(46, 'asdad', 'qwewqeqweq', 'img/1300947.jpg', 4, 2),
	(47, 'asdad', 'qwewqeqweq', 'img/1300947.jpg', 5, 17),
	(48, 'asdad', 'qwewqeqweq', 'img/1300947.jpg', 6, 16),
	(50, 'Hello', 'test', 'img/e7991ae89a5a14eea60b95b83fb26cdd.jpg', 2, 16);
/*!40000 ALTER TABLE `photo` ENABLE KEYS */;


-- Дамп структуры для таблица gallery.post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post` varchar(255) NOT NULL,
  `username_id` int(11) DEFAULT NULL,
  `image_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A8A6C8DED766068` (`username_id`),
  CONSTRAINT `FK_5A8A6C8DED766068` FOREIGN KEY (`username_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=287 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gallery.post: ~84 rows (приблизительно)
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
	(234, '213213213asd', 2, 1),
	(235, 'sadadqwe', 2, 2),
	(236, '21321321', 2, 2),
	(237, 'asdsadada', 2, 4),
	(240, 'asd', 1, 27),
	(241, 'asd', 1, 27),
	(251, 'asd', 1, 27),
	(252, 'asd', 1, 17),
	(253, '1', 1, 17),
	(254, '2', 1, 17),
	(255, '123', 17, 3),
	(256, '345', 17, 3),
	(257, '2332', 17, 3),
	(258, '123', 17, 3),
	(259, '222', 17, 3),
	(260, '3333', 17, 3),
	(261, '231', 17, 1),
	(262, '1111111111111111111111111111111111111111111111111111111111111111111111111111', 17, 3),
	(263, '123', 17, 3),
	(264, '1 2 3', 17, 3),
	(265, 'asdsadadsadsadasdsadadadsada', 17, 3),
	(266, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 17, 3),
	(267, '12', 16, 3),
	(268, '1111', 16, 3),
	(269, '1111', 16, 3),
	(270, '123', 16, 6),
	(271, 'asd', 16, 6),
	(272, '123', 16, 45),
	(273, '123', 16, 7),
	(274, '256', 16, 4),
	(275, 'asd', 16, 1),
	(276, 'wqewqe', 16, 1),
	(277, 'asd', 16, 14),
	(278, '123', 16, 14),
	(279, '123', 16, 2),
	(280, 'asd', 16, 2),
	(281, 'asd', 16, 1),
	(282, '213', 16, 1),
	(283, 'asd', 16, 1),
	(284, '123', 16, 1),
	(285, 'asd', 16, 1),
	(286, '213', 16, 1);
/*!40000 ALTER TABLE `post` ENABLE KEYS */;


-- Дамп структуры для таблица gallery.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы gallery.user: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `password`) VALUES
	(1, 'defacto', 'mangos'),
	(2, 'user', '$2y$10$y7.fL6/4C87wIDCxBT/xaeRlpyAA1nU1E6AsDQF52sZteIWdikyxG'),
	(16, 'test', '$2y$13$8dL7uAnbjVVGJI2iUNFJausbsxybK83elQr50F04sLzIj0bFpsGai'),
	(17, 'mangos', '$2y$13$TRan7GAuwJNht3VZo9jul.3gTbAZFv9Rdy.78lnyUAcd/Tuqg0dlO');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
