-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: Jan 08, 2024 at 11:03 AM
-- Server version: 11.1.3-MariaDB-1:11.1.3+maria~ubu2204
-- PHP Version: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat2_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `association`
--

CREATE TABLE `association` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `chanel_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `association`
--

INSERT INTO `association` (`id`, `user_id`, `chanel_id`) VALUES
(3, 5, 8),
(5, 5, 13),
(4, 7, 8),
(2, 12, 11),
(6, 12, 13),
(1, 13, 11);

-- --------------------------------------------------------

--
-- Table structure for table `chanel`
--

CREATE TABLE `chanel` (
  `id` int(11) NOT NULL,
  `nom` longtext NOT NULL,
  `chanel_photo` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chanel`
--

INSERT INTO `chanel` (`id`, `nom`, `chanel_photo`) VALUES
(1, 'test', NULL),
(2, 'Your Chanel Name', NULL),
(4, 'Follower', NULL),
(5, 'Follower', NULL),
(6, 'Follower', NULL),
(7, 'Follower', NULL),
(8, 'Follower', NULL),
(9, 'Follower', NULL),
(10, 'Follower', NULL),
(11, 'Follower', NULL),
(12, 'Your Chanel Name', NULL),
(13, 'Follower', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `chanel_user`
--

CREATE TABLE `chanel_user` (
  `chanel_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chanel_user`
--

INSERT INTO `chanel_user` (`chanel_id`, `user_id`) VALUES
(1, 1),
(1, 5),
(1, 7),
(1, 10),
(1, 12),
(2, 1),
(2, 13),
(6, 1),
(6, 10),
(6, 12),
(12, 5),
(12, 13);

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20231022175703', '2023-10-22 17:57:12', 117),
('DoctrineMigrations\\Version20231022180518', '2023-10-22 18:05:23', 49),
('DoctrineMigrations\\Version20231023102632', '2023-10-23 10:26:42', 85),
('DoctrineMigrations\\Version20240106003417', '2024-01-06 00:34:44', 48),
('DoctrineMigrations\\Version20240108092642', '2024-01-08 09:27:34', 13);

-- --------------------------------------------------------

--
-- Table structure for table `follower`
--

CREATE TABLE `follower` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `follower_id` int(11) DEFAULT NULL,
  `chanel_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `follower`
--

INSERT INTO `follower` (`id`, `user_id`, `follower_id`, `chanel_id`) VALUES
(1, 1, 5, 8),
(2, 1, 7, NULL),
(3, NULL, 12, NULL),
(4, NULL, 12, NULL),
(5, NULL, 13, NULL),
(6, NULL, 13, NULL),
(7, NULL, 13, NULL),
(8, NULL, 13, NULL),
(9, NULL, 13, NULL),
(10, 1, 13, 4),
(11, 13, 12, 5),
(18, 5, 12, 13);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `channel_id` int(11) DEFAULT NULL,
  `user_text` longtext NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `channel_id`, `user_text`, `date`) VALUES
(1, 5, 1, 'test', '2023-10-25 16:51:22'),
(2, 5, 1, 'repond moi fdp', '2023-10-27 12:40:34'),
(3, 1, 1, 'sale pute', '2023-10-27 12:40:34');

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` longtext NOT NULL,
  `user_photo` longtext DEFAULT NULL,
  `description` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `user_photo`, `description`) VALUES
(1, 'newuser', 'newuser@example.com', '$2y$10$oGssfEMUCZg9A4f.HE.kYOIEm4PDOaU9yXtkHEZLJGc059k2Z9lEq', NULL, NULL),
(5, 'faust', 'kader@example.com', '$2y$10$Iuc9CFOnwIRFaksSAIpGUOSfqKzEDj1inbyoqgZdy.CL0qXvQW5Su', NULL, NULL),
(7, 'kader5', 'pute@example.com', '$2y$10$.68kPU0XG5zjRiKn6VdtuexxfGMZNUoVWEIUCYKVVL5/pYQVMQoqq', NULL, NULL),
(10, 'kader6', 'pute@example.com', '$2y$10$ChuXfYsTcDSZynvmdeJjCO2Kr5UMz8eLQ0RtAYCw4DoUwKgBLJGXO', NULL, NULL),
(12, 'kader7', 'pute@example.com', '$2y$10$mDlFuuQ/2cpx2ztOanCRRODKsNgBrMnbWvTyfvV5giWLUGiKUpGSW', NULL, NULL),
(13, 'kader9', 'pute@example.com', '$2y$10$bjWorkxsWv/4p3Q4xOUkEOS8sfK1Z4IgDD.noP78Z2zT0tvE75Ase', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `association`
--
ALTER TABLE `association`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_FD8521CCA76ED39526F4971E` (`user_id`,`chanel_id`),
  ADD KEY `IDX_FD8521CCA76ED395` (`user_id`),
  ADD KEY `IDX_FD8521CC26F4971E` (`chanel_id`);

--
-- Indexes for table `chanel`
--
ALTER TABLE `chanel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chanel_user`
--
ALTER TABLE `chanel_user`
  ADD PRIMARY KEY (`chanel_id`,`user_id`),
  ADD KEY `IDX_5ED4DF1326F4971E` (`chanel_id`),
  ADD KEY `IDX_5ED4DF13A76ED395` (`user_id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `follower`
--
ALTER TABLE `follower`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_B9D60946A76ED395AC24F853` (`user_id`,`follower_id`),
  ADD KEY `IDX_B9D60946A76ED395` (`user_id`),
  ADD KEY `IDX_B9D60946AC24F853` (`follower_id`),
  ADD KEY `IDX_B9D6094626F4971E` (`chanel_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B6BD307FA76ED395` (`user_id`),
  ADD KEY `IDX_B6BD307F72F5A1AA` (`channel_id`);

--
-- Indexes for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1483A5E9F85E0677` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `association`
--
ALTER TABLE `association`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chanel`
--
ALTER TABLE `chanel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `follower`
--
ALTER TABLE `follower`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `association`
--
ALTER TABLE `association`
  ADD CONSTRAINT `FK_FD8521CC26F4971E` FOREIGN KEY (`chanel_id`) REFERENCES `chanel` (`id`),
  ADD CONSTRAINT `FK_FD8521CCA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `chanel_user`
--
ALTER TABLE `chanel_user`
  ADD CONSTRAINT `FK_5ED4DF1326F4971E` FOREIGN KEY (`chanel_id`) REFERENCES `chanel` (`id`),
  ADD CONSTRAINT `FK_5ED4DF13A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `follower`
--
ALTER TABLE `follower`
  ADD CONSTRAINT `FK_B9D6094626F4971E` FOREIGN KEY (`chanel_id`) REFERENCES `chanel` (`id`),
  ADD CONSTRAINT `FK_B9D60946A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_B9D60946AC24F853` FOREIGN KEY (`follower_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `FK_B6BD307F72F5A1AA` FOREIGN KEY (`channel_id`) REFERENCES `chanel` (`id`),
  ADD CONSTRAINT `FK_B6BD307FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
