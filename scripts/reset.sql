
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

DROP DATABASE `#{DB_NAME}`;
CREATE DATABASE `#{DB_NAME}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `#{DB_NAME}`;


DROP TABLE IF EXISTS `players`;
CREATE TABLE IF NOT EXISTS `players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `date_of_birth` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `position` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

INSERT INTO `players` (`date_of_birth`, `nationality`, `first_name`, `last_name`, `description`, `position`) VALUES
('15. Mai 1981', '', 'Peter', 'Muster', '<p>D''Pied ménger gefällt et wee, Stret wielen Säiten do wär. Et wee fort ugedon beschte, mä lait schéi Hémecht sin, och Eisen Hemecht ke. Ass ké gëtt stét blëtzen, si dan räich ugedon. Vu ons Räis päift d''Land, d''Pan gewëss d''Bëscher bei da, an Welt hinnen oft. Fu sou Räis Dach, huet dämpen d''Lëtzebuerger ke wéi. No wee d''Wéën iwerall d''Blumme, Stad Kirmesdag si hie, de iech beschte d''Kanner eng.</p>', 1),
('1921', 'Kanada', 'Wait', 'Drem', '<p>Méi et wuel alles kommen, engem grouss blénken dee as. Gét fu wait brét prächteg, ons Kaffi d''Kanner vu. Ké vill bessert vun, dem ménger Hämmel um, sech d''Beem gebotzt et bei. Spilt soubal Feierwon wat hu, drem d''Mier nozegon am wéi, mat geet Bänk dämpen un.</p>', 2),
('15. Mai 1981', '', 'Marion', 'Schleifer', '<p>Méi et wuel alles kommen, engem grouss blénken dee as. Gét fu wait brét prächteg, ons Kaffi d''Kanner vu. Ké vill bessert vun, dem ménger Hämmel um, sech d''Beem gebotzt et bei. Spilt soubal Feierwon wat hu, drem d''Mier nozegon am wéi, mat geet Bänk dämpen un.</p>', 3),
('30. Mai 1981', '', 'Meliore', 'Adolescens', '<p>Méi et wuel alles kommen, engem grouss blénken dee as. Gét fu wait brét prächteg, ons Kaffi d''Kanner vu. Ké vill bessert vun, dem ménger Hämmel um, sech d''Beem gebotzt et bei. Spilt soubal Feierwon wat hu, drem d''Mier nozegon am wéi, mat geet Bänk dämpen un.</p>', 4),
('15. Mai 1981', '', 'Theophrastus', 'Sed', '<p>Méi et wuel alles kommen, engem grouss blénken dee as. Gét fu wait brét prächteg, ons Kaffi d''Kanner vu. Ké vill bessert vun, dem ménger Hämmel um, sech d''Beem gebotzt et bei. Spilt soubal Feierwon wat hu, drem d''Mier nozegon am wéi, mat geet Bänk dämpen un.</p>', 5),
('15. Mai 1981', 'Deutschland', 'Feugiat', 'Ocurreret', '<p>Méi et wuel alles kommen, engem grouss blénken dee as. Gét fu wait brét prächteg, ons Kaffi d''Kanner vu. Ké vill bessert vun, dem ménger Hämmel um, sech d''Beem gebotzt et bei. Spilt soubal Feierwon wat hu, drem d''Mier nozegon am wéi, mat geet Bänk dämpen un.</p>', 6),
('15. Mai 1981', '', 'Consulatu', 'Splendide', '<p>Méi et wuel alles kommen, engem grouss blénken dee as. Gét fu wait brét prächteg, ons Kaffi d''Kanner vu. Ké vill bessert vun, dem ménger Hämmel um, sech d''Beem gebotzt et bei. Spilt soubal Feierwon wat hu, drem d''Mier nozegon am wéi, mat geet Bänk dämpen un.</p>', 7),
('15. Mai 1981', '', 'Dicam', 'Graece', '<p>Méi et wuel alles kommen, engem grouss blénken dee as. Gét fu wait brét prächteg, ons Kaffi d''Kanner vu. Ké vill bessert vun, dem ménger Hämmel um, sech d''Beem gebotzt et bei. Spilt soubal Feierwon wat hu, drem d''Mier nozegon am wéi, mat geet Bänk dämpen un.</p>', 8);
