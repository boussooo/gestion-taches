-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 31 déc. 2025 à 23:33
-- Version du serveur : 10.4.20-MariaDB
-- Version de PHP : 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `todo_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `tache`
--

CREATE TABLE `tache` (
  `id_tache` int(11) NOT NULL,
  `titre` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` enum('en cours','terminée') COLLATE utf8mb4_unicode_ci DEFAULT 'en cours',
  `date_creation` datetime DEFAULT current_timestamp(),
  `id_utilisateur` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tache`
--

INSERT INTO `tache` (`id_tache`, `titre`, `description`, `statut`, `date_creation`, `id_utilisateur`) VALUES
(1, 'la tache', 'probablite', 'en cours', '2025-12-26 13:46:44', NULL),
(2, 'ma tache', 'laa laa', 'terminée', '2025-12-26 13:47:09', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `prenom` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profil` enum('admin','user') COLLATE utf8mb4_unicode_ci DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `prenom`, `nom`, `login`, `mdp`, `profil`) VALUES
(1, 'Fama', 'Bousso', 'famafama', 'bd5002823769a7304ace09a542d9301599b7d855', 'admin'),
(2, 'Elimane', 'Ndiaye', 'elimane4pf', 'bd5002823769a7304ace09a542d9301599b7d855', 'user');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tache`
--
ALTER TABLE `tache`
  ADD PRIMARY KEY (`id_tache`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tache`
--
ALTER TABLE `tache`
  MODIFY `id_tache` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tache`
--
ALTER TABLE `tache`
  ADD CONSTRAINT `tache_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
