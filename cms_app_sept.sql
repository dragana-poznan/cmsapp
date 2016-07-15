
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


CREATE TABLE IF NOT EXISTS `korisnici` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `hpassword` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;


INSERT INTO `korisnici` (`id`, `username`, `hpassword`) VALUES
(5, 'admin', '$2y$10$YTFhMDQwYjc2Y2MzOTJmN.WyAcxWZNffRSHfH6foRDf1P2dzpWbwW');


CREATE TABLE IF NOT EXISTS `meni` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ime_dugmeta` varchar(30) NOT NULL,
  `pozicija` int(3) NOT NULL,
  `vidljivo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;


INSERT INTO `meni` (`id`, `ime_dugmeta`, `pozicija`, `vidljivo`) VALUES
(1, 'O nama', 1, 1),
(2, 'Proizvodi', 2, 1),
(3, 'Uluge', 3, 1),
(4, 'Obavestenja', 4, 0);



CREATE TABLE IF NOT EXISTS `podesavanja` (
  `ime_sajta` varchar(100) NOT NULL,
  `opis_sajta` varchar(160) NOT NULL,
  `kljucne_reci` varchar(160) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `podesavanja` (`ime_sajta`, `opis_sajta`, `kljucne_reci`) VALUES
('CMS APP v1.0', 'Moja aplikacija', 'cms, app, php');


CREATE TABLE IF NOT EXISTS `strane` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dugme_id` int(11) NOT NULL,
  `ime_strane` varchar(30) NOT NULL,
  `pozicija` int(3) NOT NULL,
  `vidljivo` tinyint(1) NOT NULL,
  `sadrzaj` text,
  PRIMARY KEY (`id`),
  KEY `dugme_id` (`dugme_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;


INSERT INTO `strane` (`id`, `dugme_id`, `ime_strane`, `pozicija`, `vidljivo`, `sadrzaj`) VALUES
(1, 1, 'Istorijat', 1, 1, 'Nas sitorijat ...'),
(2, 1, 'Tim', 2, 0, 'Nas tim ...'),
(4, 2, 'Aplikacije', 5, 1, 'Razvijamo aplikacije za vas ...'),
(5, 2, 'Web Development', 2, 0, '<p><strong>Web dizajn i marketing ...</strong></p>'),
(6, 3, 'Web dizajn', 1, 1, 'Dizajn sajtova ...'),
(7, 3, 'Internet marketing', 2, 1, 'Promocija sajtova ...'),
(8, 2, 'Proba', 3, 0, 'Test'),
(9, 2, 'Proba', 3, 0, 'Test'),
(10, 2, 'Proba', 5, 0, 'sdas'),
(11, 1, 'Test', 3, 1, 'dasdasds'),
(12, 1, 'Galerija', 4, 1, '<p>Lorem ipsum</p>'),
(13, 1, 'Kontakt', 5, 1, '<p>Kontakt info</p>');


