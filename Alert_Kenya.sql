-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 05, 2024 at 10:59 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Alert_Kenya`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `email`, `username`, `password`, `created_at`) VALUES
(1, 'admin@gmail.com', 'admin', 'admin', '2024-08-05 13:29:19');

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`id`, `title`, `description`, `location`, `created_at`, `user_id`) VALUES
(1, 'Flood Warning', 'Heavy rains expected in the region. Be prepared for possible flooding.', 'Nairobi', '2024-08-05 14:06:57', 0),
(3, 'Earthquake Hits Nairobi', 'A magnitude 5.8 earthquake struck Nairobi, causing damage to buildings and infrastructure.', 'Nairobi', '2024-07-31 21:00:00', 0),
(4, 'Severe Flooding in Kisumu', 'Heavy rains have led to severe flooding across Kisumu, displacing many residents and causing damage.', 'Kisumu', '2024-07-19 21:00:00', 0),
(5, 'Landslide in Kericho', 'A landslide in Kericho has buried several homes and resulted in casualties and property damage.', 'Kericho', '2024-07-21 21:00:00', 0),
(6, 'Wildfire in Maasai Mara', 'A large wildfire is spreading through Maasai Mara National Reserve, threatening wildlife and natural habitats.', 'Maasai Mara', '2024-07-14 21:00:00', 0),
(7, 'Tornado Strikes Eldoret', 'A tornado has struck Eldoret, causing damage to buildings and infrastructure.', 'Eldoret', '2024-08-04 21:00:00', 0),
(8, 'Explosion at Nairobi Factory', 'An explosion at a factory in Nairobi has caused a fire and hazardous chemical spill.', 'Nairobi', '2024-07-24 21:00:00', 0),
(9, 'Bus Accident on Nairobi-Mombasa Road', 'A serious bus accident on the Nairobi-Mombasa road has resulted in multiple casualties.', 'Nairobi-Mombasa Road', '2024-08-02 21:00:00', 0),
(10, 'Bombing in Mombasa', 'A bombing in Mombasa has resulted in casualties and significant property damage.', 'Mombasa', '2024-08-03 21:00:00', 0),
(11, 'Building Collapse in Nairobi', 'A high-rise building in Nairobi has collapsed, trapping people and causing major damage.', 'Nairobi', '2024-07-29 21:00:00', 0),
(12, 'Chemical Spill in Kisumu', 'A chemical spill in Kisumu has caused contamination of water sources and environmental damage.', 'Kisumu', '2024-07-21 21:00:00', 0),
(13, 'dsa', 'asdsa', 'dada', '2024-08-05 17:13:18', 0),
(14, 'fefw', 'fewfwe', 'fwefwf', '2024-08-05 17:29:32', 0),
(15, 'vds', 'wfw', 'wf', '2024-08-05 17:29:40', 0),
(20, 'dsfs', 'dfs', 'ds', '2024-08-05 19:28:02', 8),
(24, 'last', 'last', 'last', '2024-08-05 20:46:38', 4);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `lat` float(10,6) NOT NULL,
  `lng` float(10,6) NOT NULL,
  `description` varchar(200) NOT NULL,
  `location_status` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `lat`, `lng`, `description`, `location_status`) VALUES
(1, -1.291444, 36.816814, 'floods', 0),
(2, -1.154963, 36.876587, 'Floods', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) DEFAULT 0,
  `role` enum('responder','citizen','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `email`, `phone`, `designation`, `age`, `bio`, `created_at`, `is_admin`, `role`) VALUES
(1, 'admin', 'admin', 'Admin1', 'admin@gmail.com', '1234567890', 'Administrator', 30, 'Admin user for the system', '2024-08-05 10:51:27', 0, 'admin'),
(2, 'waswaustin@gmail.com', '$2y$10$ukO/bIu/BjIFYj/Fi/LLeOU10HlKsxM/XqVPE0ggcZEwA5B0rR0we', 'Austin Waswa', 'waswaustin@gmail.com', '701051080', 'Nairobi', 34, 'few', '2024-08-05 11:16:05', 0, 'responder'),
(3, 'waswaustin@gmail.com', '$2y$10$1cGF/oeJ3JV0IguKhEclC.sU/G1STOIaT06UKADxZR5GylIO5qEbu', 'Austin Waswa', 'waswaustin@gmail.com', '701051080', 'Nairobi', 34, 'few', '2024-08-05 11:22:13', 0, 'responder'),
(4, 'austin1', '$2y$10$jATfP32lPjVReINfaSKf5./iULUTE/L4idC7d9I0n5ZARhkLOOhuG', 'Austin Waswa', 'waswaustin@gmail.com', '701051080', 'Nairobi', 34, 'responder', '2024-08-05 11:50:52', 0, 'responder'),
(5, 'austin2', '$2y$10$cMJHH8WxSccKJNfleycWUOgUR80TLc8KjRpldxINvMqxuHwAvwKKe', 'asdasd', 'dsdas@gmail.com', '701051043', 'Nairobi', 34, 'dsda', '2024-08-05 11:59:30', 0, 'citizen'),
(7, 'admin', '$2y$10$d0dEF1E67IKL/8.G9wjo.eABvTevdgi40SenJ./CsbnDIIwS/mFk2', 'admin', 'admin@gmail.com', '123456789', 'admin', 100, 'admin', '2024-08-05 13:21:02', 0, 'admin'),
(8, 'blue', '$2y$10$B7DfjLmoaSB7WvRXfA1QR.0ywBNw/nJY.2d1FQ8WVK6.Ie8iyUjey', 'blue', 'blue@gmail.com', '13224275378', 'blue', 22, 'blue', '2024-08-05 17:10:37', 0, 'citizen');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
