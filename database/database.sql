-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Dim 02 Octobre 2016 à 13:13
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `quick_chat`
--

-- --------------------------------------------------------

--
-- Structure de la table `connect_to_youpi`
--

CREATE TABLE IF NOT EXISTS `connect_to_youpi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `connect` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `connect_to_youpi`
--

INSERT INTO `connect_to_youpi` (`id`, `connect`) VALUES
(1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `happy_messages`
--

CREATE TABLE IF NOT EXISTS `happy_messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `nombre` int(30) NOT NULL,
  `nouveau` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `actuel` varchar(255) NOT NULL,
  `genre` tinyint(1) NOT NULL,
  `classe` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `name`, `password`, `status`, `actuel`, `genre`, `classe`) VALUES
(1, 'youpi', 'fd227166f995dceef435509b9194a553', 0, 'happy', 1, 'GL2'),
(2, 'happy', 'fd227166f995dceef435509b9194a553', 0, 'youpi', 1, 'GL2');

-- --------------------------------------------------------

--
-- Structure de la table `youpi_happy`
--

CREATE TABLE IF NOT EXISTS `youpi_happy` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `commentaires` text NOT NULL,
  `nouveau` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `youpi_happy`
--

INSERT INTO `youpi_happy` (`id`, `nom`, `commentaires`, `nouveau`) VALUES
(1, 'youpi', 'Mr happy, l''Ã©quipe youpi\r\n                             ainsi que tous ses utilisateurs vous souhaitent la bienvenue.', 0),
(2, 'happy', 'merci :)', 0);

-- --------------------------------------------------------

--
-- Structure de la table `youpi_messages`
--

CREATE TABLE IF NOT EXISTS `youpi_messages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `nombre` int(30) NOT NULL,
  `nouveau` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
