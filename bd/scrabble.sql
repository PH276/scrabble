-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  lun. 20 nov. 2017 à 16:14
-- Version du serveur :  10.1.28-MariaDB
-- Version de PHP :  7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `scrabble`
--

-- --------------------------------------------------------

--
-- Structure de la table `infos`
--

CREATE TABLE `infos` (
  `id` int(3) NOT NULL,
  `info_type` varchar(50) NOT NULL,
  `info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `infos`
--

INSERT INTO `infos` (`id`, `info_type`, `info`) VALUES
(1, 'tirage', '');

-- --------------------------------------------------------

--
-- Structure de la table `jeu`
--

CREATE TABLE `jeu` (
  `id` int(3) NOT NULL,
  `position` varchar(3) NOT NULL,
  `lettre` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `lettres`
--

CREATE TABLE `lettres` (
  `id` int(3) NOT NULL,
  `lettre` varchar(1) NOT NULL,
  `nombre` int(2) NOT NULL,
  `points` int(2) NOT NULL,
  `nombreRestant` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lettres`
--

INSERT INTO `lettres` (`id`, `lettre`, `nombre`, `points`, `nombreRestant`) VALUES
(1, 'A', 9, 1, 9),
(2, 'B', 2, 3, 2),
(3, 'C', 2, 3, 2),
(4, 'D', 3, 2, 3),
(5, 'E', 15, 1, 15),
(6, 'F', 2, 4, 2),
(7, 'G', 2, 2, 2),
(8, 'H', 2, 4, 2),
(9, 'I', 8, 1, 8),
(10, 'J', 1, 8, 1),
(11, 'K', 1, 10, 1),
(12, 'L', 5, 1, 5),
(13, 'M', 3, 2, 3),
(14, 'N', 6, 1, 6),
(15, 'O', 6, 1, 6),
(16, 'P', 2, 3, 2),
(17, 'Q', 1, 8, 1),
(18, 'R', 6, 1, 6),
(19, 'S', 6, 1, 6),
(20, 'T', 6, 1, 6),
(21, 'U', 6, 1, 6),
(22, 'V', 2, 4, 2),
(23, 'W', 1, 10, 1),
(24, 'X', 1, 10, 1),
(25, 'Y', 1, 10, 1),
(26, 'Z', 1, 10, 1),
(27, '_', 2, 0, 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `infos`
--
ALTER TABLE `infos`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `jeu`
--
ALTER TABLE `jeu`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `lettres`
--
ALTER TABLE `lettres`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `infos`
--
ALTER TABLE `infos`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `jeu`
--
ALTER TABLE `jeu`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=220;

--
-- AUTO_INCREMENT pour la table `lettres`
--
ALTER TABLE `lettres`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
