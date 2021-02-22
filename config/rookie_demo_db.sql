-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mer 20 Mars 2019 à 15:49
-- Version du serveur: 5.5.59-0ubuntu0.14.04.1
-- Version de PHP: 5.5.9-1ubuntu4.23



SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `Rookie`
--

-- --------------------------------------------------------

--
-- Structure de la table `cat`
--

CREATE TABLE IF NOT EXISTS Rookie.cat (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `owner` varchar(20) NOT NULL,
  `style` varchar(20) NOT NULL,
  `age` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Contenu de la table `actor`
--

INSERT INTO Rookie.cat ( `name`, `owner`, `style`, `age`) VALUES
( 'Rookie', 'Cyril VASSALLO', 'gray angora',0),
( 'Figaro', 'Geppetto', 'Polisson', 1),
( 'Azraël', 'John Doe', 'Impitoyable', 5),
( 'Garfield', 'Jonathan Q. Arbuckle', 'Paresseux', 6),
( 'Sylvestre', 'Mémé', 'Tenace', 4),
( 'Lucifer', 'Madame de Trémaine', 'Diabolique', 7)

--
-- Structure de la table `actor`
--

CREATE TABLE IF NOT EXISTS `actor` (  
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `nationality` varchar(20) NOT NULL,
  `age` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Contenu de la table `actor`
--

INSERT INTO `actor` (`id`, `name`, `firstname`, `nationality`, `age`) VALUES
(1, 'Johansson', 'Scarlette', 'americaine', 55),
(2, 'Downey Jr', 'Robert', 'Americain', 53),
(3, 'Bosemun', 'Chadwick', 'Americain', 40),
(4, 'Kirigaya', 'Kazuto', 'Jap', 19);

-- --------------------------------------------------------

--
-- Structure de la table `movie`
--

CREATE TABLE IF NOT EXISTS `movie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Contenu de la table `movie`
--

INSERT INTO `movie` (`id`, `title`, `created_at`, `duration`) VALUES
(1, 'Deadpool 3', '2016-09-04', 124),
(2, 'Le château sur le nuage', '1983-01-15', 111),
(3, 'Le voyage de Chihiro', '2002-04-10', 126),
(4, 'Princesse Mononoké', '2000-01-12', 135),
(5, 'Avenger 3.5', '2019-05-19', 199),
(6, 'Captain Marvel', '2019-02-27', 189),
(7, 'X force', '2020-05-19', 188);


-- --------------------------------------------------------

--
-- Structure de la table `movie__actor`
--

CREATE TABLE IF NOT EXISTS `movie__actor` (
  `id_movie` int(11) NOT NULL,
  `id_actor` int(11) NOT NULL,
  PRIMARY KEY (`id_movie`,`id_actor`),
  KEY `FK_movie__actor_id` (`id_actor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `movie__actor`
--

INSERT INTO `movie__actor` (`id_movie`, `id_actor`) VALUES
(2, 2);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `movie__actor`
--
ALTER TABLE `movie__actor`
  ADD CONSTRAINT `FK_movie__actor_id` FOREIGN KEY (`id_actor`) REFERENCES `actor` (`id`),
  ADD CONSTRAINT `FK_movie__movie_id` FOREIGN KEY (`id_movie`) REFERENCES `movie` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

