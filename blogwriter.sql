-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  ven. 06 déc. 2019 à 16:30
-- Version du serveur :  5.7.24
-- Version de PHP :  7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blogwriter`
--

-- --------------------------------------------------------

--
-- Structure de la table `chapters`
--

CREATE TABLE `chapters` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `chapters`
--

INSERT INTO `chapters` (`id`, `title`, `content`, `created_at`, `updated_at`, `user_id`) VALUES
(7, 'article 1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris aliquam tincidunt turpis. Quisque aliquam mattis diam, vel tempor eros tincidunt ac. Sed scelerisque ipsum vel convallis fringilla. Praesent vel magna sed magna volutpat ullamcorper. Maecenas ultricies lobortis est, eget vestibulum urna bibendum fermentum. Ut posuere, sem non malesuada posuere, mauris lacus bibendum tortor, ut porttitor lectus mi eget sem. Fusce fermentum sed libero ac facilisis. Nullam mauris lorem, malesuada in lorem et, rutrum facilisis erat. Aliquam blandit mauris quis massa mollis, eu faucibus diam vulputate.\r\n\r\nMorbi faucibus lacus in posuere molestie. Maecenas convallis diam ipsum, vel rhoncus lacus dapibus id. Quisque pulvinar consequat augue nec scelerisque. Etiam scelerisque turpis eu arcu efficitur, eget ultrices dolor blandit. Phasellus sit amet interdum libero, nec vulputate urna. Aenean sed lacus odio. Donec ut mattis metus, nec pellentesque nibh. Interdum et malesuada fames ac ante ipsum primis in faucibus. ', '2019-12-06 14:09:29', '2019-12-06 14:09:29', 9),
(10, 'article 2', '\r\n\r\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Duis rhoncus dolor nulla, vitae accumsan sem sodales nec. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Proin quis tempor nisi. Ut imperdiet nisi sed tincidunt maximus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam volutpat neque eu leo auctor egestas. Nam tempus consequat eros, quis sagittis velit luctus sed. Proin nisl dolor, tincidunt a dui ut, condimentum pulvinar nisi. Duis eget risus eros. Sed tristique diam sed ante ullamcorper consectetur. Vivamus accumsan ultricies venenatis. Curabitur tristique tellus quis leo congue iaculis.\r\n\r\nSed cursus porta hendrerit. Nulla rhoncus vulputate nisl, a dapibus purus ornare et. Fusce ac mauris eget nibh condimentum dictum et non diam. Suspendisse laoreet interdum tempor. Maecenas consequat rutrum consectetur. Interdum et malesuada fames ac ante ipsum primis in faucibus. Ut mattis sapien nec erat hendrerit mollis. Aenean tincidunt odio sem, in tempus ligula vestibulum vel. Aenean eget finibus dui. Nam semper odio iaculis, tincidunt purus eget, scelerisque ipsum. Fusce a vehicula odio.\r\n\r\nNulla at consequat libero, id iaculis risus. Interdum et malesuada fames ac ante ipsum primis in faucibus. In lobortis consectetur orci, vel efficitur ante congue id. Phasellus tincidunt elit dui, nec gravida eros tristique non. Proin tempus a nulla at euismod. Nam sodales vitae enim fermentum varius. Nulla dui urna, ultrices non nisi cursus, scelerisque faucibus nisi. Suspendisse dignissim consequat massa, id mattis turpis. Nunc fringilla, est in scelerisque faucibus, nulla elit cursus orci, sit amet hendrerit mauris tellus at turpis. ', '2019-12-06 14:13:48', '2019-12-06 14:13:48', 9),
(13, 'article 31', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?', '2019-12-06 15:31:23', '2019-12-06 15:43:07', 10);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `chapter_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `flag` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role_id`) VALUES
(9, 'Rudy', NULL, '$2y$10$A4YKaN7AfifdIuCl4quoWOViGVQcrDl7vSnao6CVOMQE6KNh8uC92', '2019-12-04 10:57:07', 1),
(10, 'Carine', NULL, '$2y$10$LAz.UqSXA5.r77i04FiuLuDfZ8F8nkNO3y9cczbx49zjIPApI2hfO', '2019-12-04 10:57:49', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`) USING BTREE;

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_role_id` (`role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
