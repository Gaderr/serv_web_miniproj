-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  mar. 05 déc. 2017 à 20:55
-- Version du serveur :  10.1.29-MariaDB
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gabrield_solitaire`
--

-- --------------------------------------------------------

--
-- Structure de la table `joueurs`
--

CREATE TABLE `joueurs` (
  `pseudo` varchar(20) NOT NULL,
  `motDePasse` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `joueurs`
--

INSERT INTO `joueurs` (`pseudo`, `motDePasse`) VALUES
('elias', '$1$QFnhAa9N$Dj1rqLuJNE5r657BbqM8k.'),
('gabriel', '$1$BwK3h5ea$WmFI5.pFsOIScUHiV3fiW1'),
('jean-f', '$1$efcZuOAt$uxg1RMlLQsGjzb0ryQTul/'),
('machin', '$1$mPl3OClq$rLbrboKHvZC6IZijuqfxY1'),
('titi', '$1$d3A.edie$ARHvBjojiIKMx1wMI43OA1'),
('toto', '$1$LY0WzFDZ$doUx1b5D0fKdaAfkRiEXU/');

-- --------------------------------------------------------

--
-- Structure de la table `parties`
--

CREATE TABLE `parties` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `partieGagnee` tinyint(1) NOT NULL,
  `partiePerdue` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `parties`
--

INSERT INTO `parties` (`id`, `pseudo`, `partieGagnee`, `partiePerdue`) VALUES
(1, 'toto', 4, 7),
(2, 'titi', 0, 1),
(3, 'machin', 2, 3),
(4, 'gabriel', 3, 2);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `ratios`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `ratios` (
`id` int(11)
,`pseudo` varchar(20)
,`partieGagnee` tinyint(1)
,`partiePerdue` tinyint(1)
,`ratio` decimal(7,4)
);

-- --------------------------------------------------------

--
-- Structure de la vue `ratios`
--
DROP TABLE IF EXISTS `ratios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`gabrield`@`localhost` SQL SECURITY DEFINER VIEW `ratios`  AS  select `parties`.`id` AS `id`,`parties`.`pseudo` AS `pseudo`,`parties`.`partieGagnee` AS `partieGagnee`,`parties`.`partiePerdue` AS `partiePerdue`,(`parties`.`partieGagnee` / `parties`.`partiePerdue`) AS `ratio` from `parties` ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `joueurs`
--
ALTER TABLE `joueurs`
  ADD PRIMARY KEY (`pseudo`);

--
-- Index pour la table `parties`
--
ALTER TABLE `parties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pseudo` (`pseudo`),
  ADD KEY `pseudo_2` (`pseudo`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `parties`
--
ALTER TABLE `parties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `parties`
--
ALTER TABLE `parties`
  ADD CONSTRAINT `parties_ibfk_1` FOREIGN KEY (`pseudo`) REFERENCES `joueurs` (`pseudo`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
