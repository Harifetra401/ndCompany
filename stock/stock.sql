-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  ven. 08 sep. 2023 à 15:08
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `filao`
--

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_poisson` varchar(255) NOT NULL,
  `qtt` double NOT NULL,
  `nombre_sac` int(11) NOT NULL,
  `place` int(11) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`id`, `id_poisson`, `qtt`, `nombre_sac`, `place`, `date`) VALUES
(1, '10', 56, 3, 1, '2023-09-08 16:52:47'),
(2, '27', 15, 2, 2, '2023-09-08 17:41:04'),
(3, '27', 50, 4, 2, '2023-09-08 17:58:55'),
(4, '4', 30, 2, 2, '2023-09-08 17:59:49'),
(5, '6', 39, 10, 1, '2023-09-08 18:00:08'),
(6, '30', 3, 2, 1, '2023-09-08 18:01:27'),
(7, '5', 15, 1, 2, '2023-09-08 18:01:46'),
(8, '24', 45, 12, 1, '2023-09-08 18:07:26');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
