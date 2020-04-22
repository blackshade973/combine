-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mer. 22 avr. 2020 à 06:46
-- Version du serveur :  10.3.16-MariaDB
-- Version de PHP :  7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `combine`
--

-- --------------------------------------------------------

--
-- Structure de la table `deposits_types`
--

CREATE TABLE `deposits_types` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `deposits_types`
--

INSERT INTO `deposits_types` (`id`, `name`) VALUES
(1, 'Quantum'),
(2, 'Meleenium'),
(3, 'Ardanium'),
(4, 'Rudic'),
(5, 'Ryll'),
(6, 'Duracrete'),
(7, 'Alazhi'),
(8, 'Laboi'),
(9, 'Adegan'),
(10, 'Rockivory'),
(11, 'Tibannagas'),
(12, 'Nova'),
(13, 'Varium'),
(14, 'Varmigio'),
(15, 'Lommite'),
(16, 'Hibridium'),
(17, 'Durelium'),
(18, 'Lowickan'),
(19, 'Vertex'),
(20, 'Berubian'),
(21, 'Bacta');

-- --------------------------------------------------------

--
-- Structure de la table `planet`
--

CREATE TABLE `planet` (
  `id` int(11) NOT NULL,
  `name` varchar(55) NOT NULL,
  `type` int(11) NOT NULL,
  `size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `planet_deposit`
--

CREATE TABLE `planet_deposit` (
  `id` int(11) NOT NULL,
  `planet_id` int(11) NOT NULL,
  `deposit_type_id` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `coord_x` int(11) NOT NULL,
  `coord_y` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `terrains_types`
--

CREATE TABLE `terrains_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `terrains_types`
--

INSERT INTO `terrains_types` (`id`, `type_name`) VALUES
(2, 'Hot Toxic'),
(3, 'Hot Breathable'),
(4, 'Temperate Breathable'),
(5, 'Cold Breathable	'),
(6, 'Cold Toxic'),
(7, 'Cold No Atmos'),
(8, 'Gas Giant');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `deposits_types`
--
ALTER TABLE `deposits_types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `planet`
--
ALTER TABLE `planet`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `planet_deposit`
--
ALTER TABLE `planet_deposit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `planet_id` (`planet_id`,`coord_x`,`coord_y`);

--
-- Index pour la table `terrains_types`
--
ALTER TABLE `terrains_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `deposits_types`
--
ALTER TABLE `deposits_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT pour la table `planet`
--
ALTER TABLE `planet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT pour la table `planet_deposit`
--
ALTER TABLE `planet_deposit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT pour la table `terrains_types`
--
ALTER TABLE `terrains_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
