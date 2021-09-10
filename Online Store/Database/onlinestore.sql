-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 09 juin 2021 à 20:37
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `onlinestore`
--

-- --------------------------------------------------------

--
-- Structure de la table `brandes`
--

CREATE TABLE `brandes` (
  `brande_id` int(11) NOT NULL,
  `Brand_cat` int(250) NOT NULL,
  `brande_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `brandes`
--

INSERT INTO `brandes` (`brande_id`, `Brand_cat`, `brande_title`) VALUES
(1, 1, 'Dell'),
(2, 2, 'Samsung'),
(7, 2, 'iphone');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `cat_id` int(11) NOT NULL,
  `cat_title` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`cat_id`, `cat_title`) VALUES
(1, 'Computer'),
(2, 'Phone');

-- --------------------------------------------------------

--
-- Structure de la table `fakeorder`
--

CREATE TABLE `fakeorder` (
  `order_id` int(11) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `order_total` float DEFAULT NULL,
  `order_users` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `fakeorder`
--

INSERT INTO `fakeorder` (`order_id`, `order_date`, `order_total`, `order_users`) VALUES
(5, '2021-06-03', 0, 7);

-- --------------------------------------------------------

--
-- Structure de la table `fakeorderinfo`
--

CREATE TABLE `fakeorderinfo` (
  `order_id` int(11) DEFAULT NULL,
  `order_info_id` int(11) NOT NULL,
  `order_info_price` float DEFAULT NULL,
  `order_product` int(11) DEFAULT NULL,
  `order_amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `fakeorderinfo`
--

INSERT INTO `fakeorderinfo` (`order_id`, `order_info_id`, `order_info_price`, `order_product`, `order_amount`) VALUES
(5, 290, 2000, 4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_users` int(11) DEFAULT NULL,
  `order_date` date NOT NULL,
  `order_total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`order_id`, `order_users`, `order_date`, `order_total`) VALUES
(5, 7, '2021-06-03', 2000),
(6, 14, '2021-06-03', 8000);

-- --------------------------------------------------------

--
-- Structure de la table `orders_info`
--

CREATE TABLE `orders_info` (
  `order_info_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_product` int(11) NOT NULL,
  `order_amount` int(11) NOT NULL,
  `order_info_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `orders_info`
--

INSERT INTO `orders_info` (`order_info_id`, `order_id`, `order_product`, `order_amount`, `order_info_price`) VALUES
(60, 5, 4, 1, 2000);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_cat` int(11) NOT NULL,
  `product_brande` int(11) NOT NULL,
  `product_title` varchar(100) NOT NULL,
  `product_price` float NOT NULL,
  `product_description` varchar(500) NOT NULL,
  `product_prom` int(11) NOT NULL,
  `product_image` varchar(250) NOT NULL,
  `product_amount` int(11) NOT NULL,
  `product_keywords` varchar(500) DEFAULT NULL
) ;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`product_id`, `product_cat`, `product_brande`, `product_title`, `product_price`, `product_description`, `product_prom`, `product_image`, `product_amount`, `product_keywords`) VALUES
(4, 2, 7, 'iphone 7', 2000, 'the best product of apple company                                                                                                                                                                                                                                                                                                                                ', 0, '1621511250mobile2.jpg', 130, '                                                                                '),
(5, 2, 2, 'samsung s8', 900, 'The Best Product of samsung company                                        ', 10, '1621587522mobile1.jpg', 122, 'samsung \r\ns8'),
(6, 2, 7, 'iphone 6', 2000, 'the best                                        ', 10, '1621590813mobile5.jpg', 124, '');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `users_id` int(11) NOT NULL,
  `user_fname` varchar(100) NOT NULL,
  `user_lname` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(250) NOT NULL,
  `user_type` int(11) DEFAULT NULL,
  `user_randome` int(250) NOT NULL
) ;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`users_id`, `user_fname`, `user_lname`, `user_email`, `user_password`, `user_type`, `user_randome`) VALUES
(7, 'kbala', 'issil', 'issilk12@gmail.com', '$2y$10$gQF86yxKK5fbURFxy4HEou0jOjY4bqx4vhhGdtHQABEyU7Vscg4S6', 1, 843284093),
(14, 'ilham', 'bennani', 'ilham12@gmail.com', '$2y$10$Dee82zw9Kx/ek/Rq6P.hNu6cY1u.90c8ZWhuB52K.BdUPIZTfVAlK', 0, 163311889),
(15, 'khalid', 'issil', 'issilk13@gmail.com', '$2y$10$vsXNkJbSptZSlZUSuDB05uhbfQL64FBrlLkb3X8KxvLC.r8OmoXTu', 0, 602416648),
(16, 'khalid', 'issil', 'issilk16@gmail.com', '$2y$10$LilCAfmIkx.vFndwHPSnge4N/U/1RWXUzVMhpgZ7JaaPcZq7lXZa.', 1, 113497596);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `brandes`
--
ALTER TABLE `brandes`
  ADD PRIMARY KEY (`brande_id`),
  ADD UNIQUE KEY `brande_title` (`brande_title`),
  ADD KEY `Brand_cat` (`Brand_cat`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`cat_id`),
  ADD UNIQUE KEY `cat_title` (`cat_title`);

--
-- Index pour la table `fakeorderinfo`
--
ALTER TABLE `fakeorderinfo`
  ADD PRIMARY KEY (`order_info_id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_users` (`order_users`);

--
-- Index pour la table `orders_info`
--
ALTER TABLE `orders_info`
  ADD PRIMARY KEY (`order_info_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `order_product` (`order_product`);

--
-- Index pour la table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD UNIQUE KEY `product_title` (`product_title`),
  ADD KEY `product_cat` (`product_cat`),
  ADD KEY `product_brande` (`product_brande`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD UNIQUE KEY `user_randome` (`user_randome`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `brandes`
--
ALTER TABLE `brandes`
  MODIFY `brande_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `fakeorderinfo`
--
ALTER TABLE `fakeorderinfo`
  MODIFY `order_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `orders_info`
--
ALTER TABLE `orders_info`
  MODIFY `order_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT pour la table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `brandes`
--
ALTER TABLE `brandes`
  ADD CONSTRAINT `brandes_ibfk_1` FOREIGN KEY (`Brand_cat`) REFERENCES `categorie` (`cat_id`);

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`order_users`) REFERENCES `users` (`users_id`);

--
-- Contraintes pour la table `orders_info`
--
ALTER TABLE `orders_info`
  ADD CONSTRAINT `orders_info_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `orders_info_ibfk_2` FOREIGN KEY (`order_product`) REFERENCES `product` (`product_id`);

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`product_cat`) REFERENCES `categorie` (`cat_id`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`product_brande`) REFERENCES `brandes` (`brande_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
