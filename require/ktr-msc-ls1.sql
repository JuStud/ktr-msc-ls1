-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : jeu. 09 juin 2022 à 15:43
-- Version du serveur : 5.7.34
-- Version de PHP : 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ktr-msc-ls1`
--

-- --------------------------------------------------------

--
-- Structure de la table `business_card`
--

CREATE TABLE `business_card` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(56) DEFAULT NULL,
  `company_name` varchar(56) DEFAULT NULL,
  `email` text NOT NULL,
  `telephone_number` varchar(56) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `business_card`
--

INSERT INTO `business_card` (`id`, `user_id`, `name`, `company_name`, `email`, `telephone_number`) VALUES
(9, 5, NULL, 'Chase Pitkin', 'amir2004@gmail.com', '717-518-0721'),
(10, 6, 'Pam', NULL, 'arden_vonrued@gmail.com', '412-215-0925'),
(11, 6, 'Pam', 'Two Pesos', 'arden_vonrued@2pesos.com', '610-794-9700'),
(12, 7, 'Thomas S Pete', 'All Wound Up', 'ladarius_da@yahoo.com', '714-552-5356');

-- --------------------------------------------------------

--
-- Structure de la table `library`
--

CREATE TABLE `library` (
  `user_id` int(11) NOT NULL,
  `business_card_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `library`
--

INSERT INTO `library` (`user_id`, `business_card_id`) VALUES
(5, 9),
(6, 10),
(6, 11),
(7, 12),
(7, 11),
(7, 9);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(56) NOT NULL,
  `password` varchar(256) NOT NULL,
  `company_name` varchar(56) DEFAULT NULL,
  `email` text,
  `telephone_number` varchar(56) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `company_name`, `email`, `telephone_number`) VALUES
(4, 'peter', '$2y$10$h6sUBwEes/gvQ4s52TBxwuh66hBMrjtJHrFnZAo40VsJRMR/LL0Xy', NULL, NULL, NULL),
(5, 'jesse', '$2y$10$TMZdFXjlJpB.dXvP7aA63.HkCaVeZSfifbf8HVKWa4oSGpoVv30BG', NULL, NULL, NULL),
(6, 'pam', '$2y$10$/4QrEDAPbb0savshtmiF1.vQT7P3SaFo8fYhZLeAqF/s7a71GQJ76', NULL, NULL, NULL),
(7, 'thomas', '$2y$10$culvEOBu4RhBQs/Lr7y5f.qBVFqXOU8O7ftkU34RR5LcN1phmvE/O', '', 'ladarius_da@yahoo.com', '714-250-3145');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `business_card`
--
ALTER TABLE `business_card`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_created_by_business_card` (`user_id`);

--
-- Index pour la table `library`
--
ALTER TABLE `library`
  ADD KEY `fk_user_library` (`user_id`),
  ADD KEY `fk_business_card_library` (`business_card_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `business_card`
--
ALTER TABLE `business_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `business_card`
--
ALTER TABLE `business_card`
  ADD CONSTRAINT `fk_created_by_business_card` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `library`
--
ALTER TABLE `library`
  ADD CONSTRAINT `fk_business_card_library` FOREIGN KEY (`business_card_id`) REFERENCES `business_card` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_library` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
