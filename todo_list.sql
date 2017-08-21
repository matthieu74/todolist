drop database if exists todolist_test;
create database todolist_test;

use todolist_test;

-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 07 Juillet 2017 à 14:01
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `todo_list`
--

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `is_done` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `task`
--

INSERT INTO `task` (`id`, `user_id`, `created_at`, `title`, `content`, `is_done`) VALUES
(3, NULL, '2017-06-15 00:00:00', 'tache anomyne', 'tache non rattachee', 0),
(5, 1, '2017-07-03 14:24:33', 'tache cree par user', 'tache super simple', 0),
(6, 2, '2017-07-03 14:53:19', 'tache administrative', 'dure', 0),
(7, 2, '2017-07-03 14:53:20', 'tache finie', 'super dure', 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:json_array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `roles`) VALUES
(1, 'user', '$2y$13$OwdzD2AqTOlyBKhYwV84P.3PPFfkTU6gBWB1actX8yorvca3nQV6K', 'dessin.pero@gmail.com', '["ROLE_USER"]'),
(2, 'admin', '$2y$13$P8pLY5PMfY5NcE4V3daWwOEBoKsjw8gf5Xyv3mdCFsYw.1ngML/8C', 'admin@admin.com', '["ROLE_USER","ROLE_ADMIN"]');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_527EDB25A76ED395` (`user_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `FK_527EDB25A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
