
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

DROP DATABASE `#{DB_NAME}`;
CREATE DATABASE `#{DB_NAME}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `#{DB_NAME}`;


DROP TABLE IF EXISTS `players`;
CREATE TABLE IF NOT EXISTS `players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `players` (`id`, `name`, `description`) VALUES
(1, 'Peter Muster', 'D''Pied ménger gefällt et wee, Stret wielen Säiten do wär. Et wee fort ugedon beschte, mä lait schéi Hémecht sin, och Eisen Hemecht ke. Ass ké gëtt stét blëtzen, si dan räich ugedon. Vu ons Räis päift d''Land, d''Pan gewëss d''Bëscher bei da, an Welt hinnen oft. Fu sou Räis Dach, huet dämpen d''Lëtzebuerger ke wéi. No wee d''Wéën iwerall d''Blumme, Stad Kirmesdag si hie, de iech beschte d''Kanner eng.'),
(2, 'Wait Drem', 'Méi et wuel alles kommen, engem grouss blénken dee as. Gét fu wait brét prächteg, ons Kaffi d''Kanner vu. Ké vill bessert vun, dem ménger Hämmel um, sech d''Beem gebotzt et bei. Spilt soubal Feierwon wat hu, drem d''Mier nozegon am wéi, mat geet Bänk dämpen un.'),
(3, 'Marion Schleifer', 'Méi et wuel alles kommen, engem grouss blénken dee as. Gét fu wait brét prächteg, ons Kaffi d''Kanner vu. Ké vill bessert vun, dem ménger Hämmel um, sech d''Beem gebotzt et bei. Spilt soubal Feierwon wat hu, drem d''Mier nozegon am wéi, mat geet Bänk dämpen un.'),
(4, 'Meliore Adolescens', 'Méi et wuel alles kommen, engem grouss blénken dee as. Gét fu wait brét prächteg, ons Kaffi d''Kanner vu. Ké vill bessert vun, dem ménger Hämmel um, sech d''Beem gebotzt et bei. Spilt soubal Feierwon wat hu, drem d''Mier nozegon am wéi, mat geet Bänk dämpen un.'),
(5, 'Theophrastus Sed', 'Méi et wuel alles kommen, engem grouss blénken dee as. Gét fu wait brét prächteg, ons Kaffi d''Kanner vu. Ké vill bessert vun, dem ménger Hämmel um, sech d''Beem gebotzt et bei. Spilt soubal Feierwon wat hu, drem d''Mier nozegon am wéi, mat geet Bänk dämpen un.'),
(6, 'Feugiat Ocurreret', 'Méi et wuel alles kommen, engem grouss blénken dee as. Gét fu wait brét prächteg, ons Kaffi d''Kanner vu. Ké vill bessert vun, dem ménger Hämmel um, sech d''Beem gebotzt et bei. Spilt soubal Feierwon wat hu, drem d''Mier nozegon am wéi, mat geet Bänk dämpen un.'),
(7, 'Consulatu Splendide', 'Méi et wuel alles kommen, engem grouss blénken dee as. Gét fu wait brét prächteg, ons Kaffi d''Kanner vu. Ké vill bessert vun, dem ménger Hämmel um, sech d''Beem gebotzt et bei. Spilt soubal Feierwon wat hu, drem d''Mier nozegon am wéi, mat geet Bänk dämpen un.'),
(8, 'Dicam Graece', 'Méi et wuel alles kommen, engem grouss blénken dee as. Gét fu wait brét prächteg, ons Kaffi d''Kanner vu. Ké vill bessert vun, dem ménger Hämmel um, sech d''Beem gebotzt et bei. Spilt soubal Feierwon wat hu, drem d''Mier nozegon am wéi, mat geet Bänk dämpen un.');
