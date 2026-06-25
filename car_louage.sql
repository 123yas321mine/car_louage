-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2026 at 01:42 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `car_louage`
--

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id_reservation` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `id_voyage` int(11) DEFAULT NULL,
  `nb_places` int(11) DEFAULT 1,
  `statut` enum('confirmée','annulée') DEFAULT 'confirmée',
  `date_reservation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `id_user`, `id_voyage`, `nb_places`, `statut`, `date_reservation`) VALUES
(1, 1, 1, 1, 'confirmée', '2026-04-04 14:52:08'),
(2, 8, 2, 1, 'confirmée', '2026-04-05 23:11:44'),
(3, 1, 3, 1, 'confirmée', '2026-04-11 11:35:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nom`, `prenom`, `email`, `mot_de_passe`, `role`, `created_at`) VALUES
(1, 'Yasmine', 'Charaa', '123yas321mine@gmail.com', '$2y$10$m9puZSzouXtaMVN.O49N..hd3ozswZ0zZ67By7MHjfVMvuvXKZP9K', 'admin', '2026-03-28 11:32:50'),
(5, 'charaa', 'sirine', 'sirine.charaa@gmail.com', '$2y$10$zvYskCj1FDvsWKqU74ITyu5qHaL1WSEqU7ncpowW5FEx68DwvsM8.', 'user', '2026-03-28 17:51:05'),
(7, 'ber', 'oum', 'oum@gmail.com', '$2y$10$jDOZKI6IFbwAMZq7ZcQ9leiSD70uq2rsjrxDXWOoCz3spH.EgSRh2', 'user', '2026-04-04 12:08:17'),
(8, '123yas321mine', '123yas321mine', 'yasminetunisienne@hotmail.com', '$2y$10$jjUU5dBcsZW/20IK4YLZjus0UISzX7LC8ebXkhzHdXt3QYKdW7/6S', 'user', '2026-04-05 23:07:30'),
(9, 'sami', 'charaa', 'sami@gmail.com', '$2y$10$gpOeYCBf.diYzJXYyDFha.6tSF96AxqYErNYGVYZpE98E3swyWo..', 'user', '2026-04-11 11:29:34');

-- --------------------------------------------------------

--
-- Table structure for table `voyages`
--

CREATE TABLE `voyages` (
  `id_voyage` int(11) NOT NULL,
  `ville_depart` varchar(100) DEFAULT NULL,
  `ville_arrivee` varchar(100) DEFAULT NULL,
  `date_voyage` date DEFAULT NULL,
  `heure_depart` time DEFAULT NULL,
  `places_total` int(11) DEFAULT NULL,
  `places_dispo` int(11) DEFAULT NULL,
  `prix` decimal(8,3) DEFAULT NULL,
  `type_vehicule` enum('louage','bus') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `voyages`
--

INSERT INTO `voyages` (`id_voyage`, `ville_depart`, `ville_arrivee`, `date_voyage`, `heure_depart`, `places_total`, `places_dispo`, `prix`, `type_vehicule`) VALUES
(2, 'qarqna', 'jerba', '2026-05-16', '13:00:00', 2, 1, 23.000, 'bus'),
(4, 'sfax', 'jerba', '2026-04-24', '03:00:00', 14, 14, 17.000, 'bus'),
(5, 'bizerte', 'sousse', '2026-04-15', '15:50:00', 19, 19, 14.000, 'louage');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_voyage` (`id_voyage`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `voyages`
--
ALTER TABLE `voyages`
  ADD PRIMARY KEY (`id_voyage`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `voyages`
--
ALTER TABLE `voyages`
  MODIFY `id_voyage` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
