-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2016 at 06:22 PM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `korisnici`
--

CREATE TABLE IF NOT EXISTS `korisnici` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `hpassword` varchar(60) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korisnici`
--

INSERT INTO `korisnici` (`id`, `username`, `hpassword`, `password`) VALUES
(5, 'admin', '$2y$10$YTU4Y2Y5MDk0OGE1ZjVjMOcm4yQXra0msFSxCvQywede7tSHN7cgC', 'test1234');

-- --------------------------------------------------------

--
-- Table structure for table `meni`
--

CREATE TABLE IF NOT EXISTS `meni` (
  `id` int(11) NOT NULL,
  `ime_dugmeta` varchar(30) NOT NULL,
  `pozicija` int(3) NOT NULL,
  `vidljivo` tinyint(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meni`
--

INSERT INTO `meni` (`id`, `ime_dugmeta`, `pozicija`, `vidljivo`) VALUES
(1, 'O nama', 1, 1),
(2, 'Proizvodi', 2, 1),
(3, 'Uluge', 3, 1),
(4, 'Obavestenja', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `podesavanja`
--

CREATE TABLE IF NOT EXISTS `podesavanja` (
  `ime_sajta` varchar(100) NOT NULL,
  `opis_sajta` varchar(160) NOT NULL,
  `kljucne_reci` varchar(160) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `podesavanja`
--

INSERT INTO `podesavanja` (`ime_sajta`, `opis_sajta`, `kljucne_reci`) VALUES
('CMS APP v1.0', 'Moja aplikacija', 'cms, app, php');

-- --------------------------------------------------------

--
-- Table structure for table `strane`
--

CREATE TABLE IF NOT EXISTS `strane` (
  `id` int(11) NOT NULL,
  `dugme_id` int(11) NOT NULL,
  `ime_strane` varchar(30) NOT NULL,
  `pozicija` int(3) NOT NULL,
  `vidljivo` tinyint(1) NOT NULL,
  `sadrzaj` text
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `strane`
--

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisnici`
--
ALTER TABLE `korisnici`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `meni`
--
ALTER TABLE `meni`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `strane`
--
ALTER TABLE `strane`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dugme_id` (`dugme_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `korisnici`
--
ALTER TABLE `korisnici`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `meni`
--
ALTER TABLE `meni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `strane`
--
ALTER TABLE `strane`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
