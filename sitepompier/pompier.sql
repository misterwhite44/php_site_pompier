-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 25 mai 2023 à 08:57
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pompier`
--

-- --------------------------------------------------------

--
-- Structure de la table `intervention`
--

DROP TABLE IF EXISTS `intervention`;
CREATE TABLE IF NOT EXISTS `intervention` (
  `id_intervention` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(35) NOT NULL,
  `date` varchar(50) NOT NULL,
  `lieu` varchar(70) NOT NULL,
  PRIMARY KEY (`id_intervention`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `intervention`
--

INSERT INTO `intervention` (`id_intervention`, `nom`, `date`, `lieu`) VALUES
(1, 'amarilio', '2023-04-13', 'Nantes'),
(2, 'rfdd', '2022-05-12', 'natttes'),
(3, 'dsgdf', '2022-10-21', 'nanteeeeees');

-- --------------------------------------------------------

--
-- Structure de la table `materiel`
--

DROP TABLE IF EXISTS `materiel`;
CREATE TABLE IF NOT EXISTS `materiel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `numero` varchar(50) NOT NULL,
  `nom` varchar(25) NOT NULL,
  `denomination` varchar(25) NOT NULL,
  `dlc` varchar(10) DEFAULT NULL,
  `nbre_utilisation` int NOT NULL DEFAULT '0',
  `nbre_utilisation_max` int DEFAULT NULL,
  `date_maintenance` varchar(10) DEFAULT NULL,
  `id_vehicule` int DEFAULT NULL,
  `stock` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_vehicul` (`id_vehicule`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `materiel`
--

INSERT INTO `materiel` (`id`, `numero`, `nom`, `denomination`, `dlc`, `nbre_utilisation`, `nbre_utilisation_max`, `date_maintenance`, `id_vehicule`, `stock`) VALUES
(1, '82000707', 'TPS', 'AIR', '1970-01-01', 8, 1, '2024-02-02', 1, 1),
(2, '55201247', 'BO2 20L', 'GRIMPE', '1970-01-01', 31, 3, '2025-10-14', 1, 1),
(9, '99999999', 'BO2 20L', 'FEU', '18/04/2035', 2, 18, '02/06/2023', NULL, NULL),
(10, 'NUMERO', 'NOM', 'DENOMINATION', '1970-01-01', 0, 0, '1970-01-01', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  `prenom` text NOT NULL,
  `id_materiel` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `id_materiel`) VALUES
(1, 'salut', 'salut', 0),
(2, 'thr', 'rthr', 0);

-- --------------------------------------------------------

--
-- Structure de la table `utilisation`
--

DROP TABLE IF EXISTS `utilisation`;
CREATE TABLE IF NOT EXISTS `utilisation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_intervention` int NOT NULL,
  `id_vehicule` int NOT NULL,
  `id_materiel` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `utile` (`id_intervention`,`id_materiel`,`id_vehicule`) USING BTREE,
  KEY `id_vehicule` (`id_vehicule`),
  KEY `id_materiel` (`id_materiel`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisation`
--

INSERT INTO `utilisation` (`id`, `id_intervention`, `id_vehicule`, `id_materiel`) VALUES
(1, 1, 1, 1),
(2, 1, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

DROP TABLE IF EXISTS `vehicule`;
CREATE TABLE IF NOT EXISTS `vehicule` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `immatriculation` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `vehicule`
--

INSERT INTO `vehicule` (`id`, `nom`, `immatriculation`) VALUES
(1, 'Francis', 'EZ-123-EZ'),
(9, 'ezfzes', 'SQ-156-SL');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `materiel`
--
ALTER TABLE `materiel`
  ADD CONSTRAINT `materiel` FOREIGN KEY (`id_vehicule`) REFERENCES `vehicule` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `materiel_ibfk_1` FOREIGN KEY (`id_vehicule`) REFERENCES `vehicule` (`id`);

--
-- Contraintes pour la table `utilisation`
--
ALTER TABLE `utilisation`
  ADD CONSTRAINT `utilisation_ibfk_1` FOREIGN KEY (`id_intervention`) REFERENCES `intervention` (`id_intervention`),
  ADD CONSTRAINT `utilisation_ibfk_2` FOREIGN KEY (`id_vehicule`) REFERENCES `vehicule` (`id`),
  ADD CONSTRAINT `utilisation_ibfk_3` FOREIGN KEY (`id_materiel`) REFERENCES `materiel` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
