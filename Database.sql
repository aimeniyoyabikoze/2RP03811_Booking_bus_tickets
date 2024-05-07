-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2024 at 09:46 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `transport`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bus_id` varchar(255) NOT NULL,
  `num_tickets` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `bus_id`, `num_tickets`, `created_at`) VALUES
(9, 15, 'RAE192', 4, '2024-04-02 20:17:39'),
(12, 18, 'RAC196', 2, '2024-04-03 09:32:09'),
(13, 18, 'RAC196', 3, '2024-04-03 10:05:07'),
(14, 18, 'RAC196', 3, '2024-05-06 09:46:10'),
(15, 14, 'RAE192', 2, '2024-05-06 09:49:25');

-- --------------------------------------------------------

--
-- Table structure for table `bus_schedules`
--

CREATE TABLE `bus_schedules` (
  `id` varchar(80) NOT NULL,
  `route` varchar(255) NOT NULL,
  `departure_time` time NOT NULL,
  `money` int(5) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bus_schedules`
--

INSERT INTO `bus_schedules` (`id`, `route`, `departure_time`, `money`, `created_at`) VALUES
('RAC196', 'Base-musanze', '14:30:00', 1000, '2024-03-31 17:44:31'),
('RAE192', 'Base-Gakenye', '16:30:00', 1000, '2024-03-31 16:47:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(12) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `phone`, `password`, `created_at`) VALUES
(14, 'izere', '0791266118', '123', '2024-03-31 17:14:04'),
(15, 'tuza', '078235654', '1234', '2024-04-01 21:04:52'),
(16, 'izere', '072126612', '123', '2024-04-02 07:03:08'),
(17, 'Ange Elyse', '0791211118', '1234', '2024-04-03 07:51:36'),
(18, 'Aime', '0780186548', '1234', '2024-04-03 08:32:18'),
(19, 'elyse', '072354562', '123', '2024-05-06 20:11:39'),
(20, 'elyse', '+250791266118', '123', '2024-05-06 20:21:23'),
(21, 'edissa', '+250782346561', '123', '2024-05-06 20:28:36'),
(22, 'jado', '+250782390978', '123', '2024-05-07 13:02:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `bookings_ibfk_2` (`bus_id`);

--
-- Indexes for table `bus_schedules`
--
ALTER TABLE `bus_schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`bus_id`) REFERENCES `bus_schedules` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
