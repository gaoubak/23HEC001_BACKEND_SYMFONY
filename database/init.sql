-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : jeu. 23 nov. 2023 à 08:51
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `23HEC001_BACKEND_SYMFONY`
--

-- --------------------------------------------------------

--
-- Structure de la table `association`
--

CREATE TABLE `association` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `chanel_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `chanel`
--

CREATE TABLE `chanel` (
  `id` int(11) NOT NULL,
  `nom` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chanel`
--

INSERT INTO `chanel` (`id`, `nom`) VALUES
(1, 'test');

-- --------------------------------------------------------

--
-- Structure de la table `chanel_user`
--

CREATE TABLE `chanel_user` (
  `chanel_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `chanel_user`
--

INSERT INTO `chanel_user` (`chanel_id`, `user_id`) VALUES
(1, 1),
(1, 7);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20231022175703', '2023-10-22 17:57:12', 117),
('DoctrineMigrations\\Version20231022180518', '2023-10-22 18:05:23', 49),
('DoctrineMigrations\\Version20231023102632', '2023-10-23 10:26:42', 85);

-- --------------------------------------------------------

--
-- Structure de la table `follower`
--

CREATE TABLE `follower` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `follower_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `follower`
--

INSERT INTO `follower` (`id`, `user_id`, `follower_id`) VALUES
(1, 1, 5),
(2, 1, 7);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `channel_id` int(11) DEFAULT NULL,
  `user_text` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id`, `user_id`, `channel_id`, `user_text`, `date`) VALUES
(1, 5, 1, 'test', '2023-10-25 16:51:22'),
(2, 5, 1, 'repond moi fdp', '2023-10-27 12:40:34');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_photo` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `user_photo`) VALUES
(1, 'newuser', 'newuser@example.com', '$2y$10$oGssfEMUCZg9A4f.HE.kYOIEm4PDOaU9yXtkHEZLJGc059k2Z9lEq', NULL),
(5, 'faust', 'kader@example.com', '$2y$10$Iuc9CFOnwIRFaksSAIpGUOSfqKzEDj1inbyoqgZdy.CL0qXvQW5Su', NULL),
(7, 'kader5', 'pute@example.com', '$2y$10$.68kPU0XG5zjRiKn6VdtuexxfGMZNUoVWEIUCYKVVL5/pYQVMQoqq', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `association`
--
ALTER TABLE `association`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_FD8521CCA76ED395` (`user_id`),
  ADD KEY `IDX_FD8521CC26F4971E` (`chanel_id`);

--
-- Index pour la table `chanel`
--
ALTER TABLE `chanel`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chanel_user`
--
ALTER TABLE `chanel_user`
  ADD PRIMARY KEY (`chanel_id`,`user_id`),
  ADD KEY `IDX_5ED4DF1326F4971E` (`chanel_id`),
  ADD KEY `IDX_5ED4DF13A76ED395` (`user_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `follower`
--
ALTER TABLE `follower`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B9D60946A76ED395` (`user_id`),
  ADD KEY `IDX_B9D60946AC24F853` (`follower_id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6BD307FA76ED395` (`user_id`),
  ADD KEY `IDX_B6BD307F72F5A1AA` (`channel_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1483A5E9F85E0677` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `association`
--
ALTER TABLE `association`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `chanel`
--
ALTER TABLE `chanel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `follower`
--
ALTER TABLE `follower`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `association`
--
ALTER TABLE `association`
  ADD CONSTRAINT `FK_FD8521CC26F4971E` FOREIGN KEY (`chanel_id`) REFERENCES `chanel` (`id`),
  ADD CONSTRAINT `FK_FD8521CCA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `chanel_user`
--
ALTER TABLE `chanel_user`
  ADD CONSTRAINT `FK_5ED4DF1326F4971E` FOREIGN KEY (`chanel_id`) REFERENCES `chanel` (`id`),
  ADD CONSTRAINT `FK_5ED4DF13A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `follower`
--
ALTER TABLE `follower`
  ADD CONSTRAINT `FK_B9D60946A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_B9D60946AC24F853` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_B6BD307F72F5A1AA` FOREIGN KEY (`channel_id`) REFERENCES `chanel` (`id`),
  ADD CONSTRAINT `FK_B6BD307FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
