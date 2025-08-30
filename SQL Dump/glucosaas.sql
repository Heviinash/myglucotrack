-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2025 at 09:17 AM
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
-- Database: `glucosaas`
--

-- --------------------------------------------------------

--
-- Table structure for table `bloodsugarlevel`
--

CREATE TABLE `bloodsugarlevel` (
  `id` int(11) NOT NULL,
  `patient_name` varchar(255) NOT NULL,
  `blood_sugar_level` decimal(5,2) NOT NULL,
  `before_after` varchar(50) NOT NULL,
  `measurement_time` time NOT NULL,
  `measurement_date` date NOT NULL,
  `measurement_by` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `systemdatetime` datetime NOT NULL,
  `tenant_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bloodsugarlevel`
--

INSERT INTO `bloodsugarlevel` (`id`, `patient_name`, `blood_sugar_level`, `before_after`, `measurement_time`, `measurement_date`, `measurement_by`, `notes`, `systemdatetime`, `tenant_id`) VALUES
(3, 'Parugavelu Veerayan', 8.10, 'After Lunch', '16:26:00', '2025-05-18', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(4, 'Heviinash Parugavelu', 5.50, 'Before Lunch', '16:29:00', '2025-05-18', 'Naveennash Parugavelu', NULL, '2025-07-12 10:28:08', 7),
(5, 'Parugavelu Veerayan', 7.10, 'Before Breakfast', '10:36:00', '2025-05-24', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(6, 'Parugavelu Veerayan', 9.20, 'After Lunch', '17:13:00', '2025-05-26', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(7, 'Parugavelu Veerayan', 10.60, 'After Breakfast', '11:26:00', '2025-05-28', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(8, 'Parugavelu Veerayan', 7.40, 'After Lunch', '14:51:00', '2025-05-28', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(9, 'Parugavelu Veerayan', 7.90, 'Before Tea', '17:02:00', '2025-05-28', 'Paramesvari Muniandy', 'After taking mexican bun and gyemma tea', '2025-07-12 10:28:08', 7),
(10, 'Parugavelu Veerayan', 6.50, 'Before Breakfast', '10:33:00', '2025-06-01', 'Paramesvari Muniandy', 'Taking herbal med', '2025-07-12 10:28:08', 7),
(12, 'Parugavelu Veerayan', 7.20, 'Before Breakfast', '10:06:00', '2025-06-03', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(13, 'Parugavelu Veerayan', 7.30, 'Before Breakfast', '10:35:00', '2025-06-05', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(14, 'Parugavelu Veerayan', 7.20, 'Before Dinner', '20:48:00', '2025-06-05', 'Paramesvari Muniandy', 'After take black seed water', '2025-07-12 10:28:08', 7),
(15, 'Parugavelu Veerayan', 7.40, 'After Lunch', '14:51:00', '2025-05-28', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(16, 'Parugavelu Veerayan', 7.60, 'Before Tea', '18:07:00', '2025-06-09', 'Paramesvari Muniandy', 'After eating ice cream and dorritos', '2025-07-12 10:28:08', 7),
(17, 'Parugavelu Veerayan', 6.30, 'Before Breakfast', '06:04:00', '2025-06-12', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(18, 'Parugavelu Veerayan', 6.30, 'Before Breakfast', '11:11:00', '2025-06-15', 'Paramesvari Muniandy', 'Take Siddhaherbal after dinner', '2025-07-12 10:28:08', 7),
(19, 'Naveennash Parugavelu', 4.60, 'Before Breakfast', '11:15:00', '2025-06-15', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(20, 'Heviinash Parugavelu', 4.40, 'Before Breakfast', '11:16:00', '2025-06-15', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(21, 'Dinooshiini Parugavelu', 4.90, 'Before Breakfast', '11:18:00', '2025-06-15', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(22, 'Paramesvari Muniandy', 4.90, 'Before Breakfast', '11:20:00', '2025-06-15', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(23, 'Parugavelu Veerayan', 6.30, 'Before Breakfast', '09:47:00', '2025-06-22', 'Naveennash Parugavelu', NULL, '2025-07-12 10:28:08', 7),
(26, 'Parugavelu Veerayan', 6.00, 'Before Dinner', '20:00:00', '2025-06-26', 'Paramesvari Muniandy', 'After eat durian and took herb tablets', '2025-07-12 10:28:08', 7),
(27, 'Paramesvari Muniandy', 7.70, 'Before Dinner', '20:03:00', '2025-06-26', 'Paramesvari Muniandy', 'After eat durian', '2025-07-12 10:28:08', 7),
(29, 'Parugavelu Veerayan', 6.30, 'Before Breakfast', '09:45:00', '2025-06-27', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(30, 'Paramesvari Muniandy', 4.90, 'Before Breakfast', '09:47:00', '2025-06-27', 'Paramesvari Muniandy', 'Next day after eat durian,night take sidha', '2025-07-12 10:28:08', 7),
(31, 'Naveennash Parugavelu', 4.80, 'Before Dinner', '20:00:00', '2025-06-27', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(32, 'Heviinash Parugavelu', 4.30, 'Before Dinner', '20:04:00', '2025-06-27', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(33, 'Parugavelu Veerayan', 6.70, 'Before Breakfast', '10:57:00', '2025-06-29', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(34, 'Paramesvari Muniandy', 4.50, 'Before Breakfast', '11:00:00', '2025-06-29', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(35, 'Parugavelu Veerayan', 6.10, 'Before Breakfast', '10:43:00', '2025-07-03', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(36, 'Parugavelu Veerayan', 6.70, 'Before Breakfast', '10:39:00', '2025-07-06', 'Paramesvari Muniandy', NULL, '2025-07-12 10:28:08', 7),
(37, 'Paramesvari Muniandy', 5.20, 'Before Breakfast', '10:52:00', '2025-07-06', 'Paramesvari Muniandy', 'Dinner take ghee rice with chicken', '2025-07-12 10:28:08', 7),
(38, 'Paramesvari Muniandy', 9.80, 'Before Dinner', '20:03:00', '2025-06-26', 'Paramesvari Muniandy', 'After eat durian', '2025-07-12 10:28:08', 7),
(39, 'Parugavelu Veerayan', 7.20, 'Before Breakfast', '12:16:00', '2025-07-13', 'Heviinash Parugavelu', 'Last night dinner took rice', '2025-07-13 00:16:29', 7),
(40, 'Parugavelu Veerayan', 7.20, 'Before Breakfast', '10:30:00', '2025-07-15', 'Paramesvari Muniandy', 'Night take Lexus biscuits n Bangali bread', '2025-07-14 22:32:16', 7),
(41, 'Parugavelu Veerayan', 7.00, 'After Breakfast', '12:57:00', '2025-07-15', 'Paramesvari Muniandy', 'After Sattu Flour 2 hours breakfast', '2025-07-15 00:57:47', 7),
(42, 'Paramesvari Muniandy', 5.00, 'Before Breakfast', '10:30:00', '2025-07-15', 'Paramesvari Muniandy', 'Last night sattu mavuu porridge', '2025-07-15 00:59:15', 7),
(43, 'Paramesvari Muniandy', 4.70, 'After Breakfast', '12:59:00', '2025-07-15', 'Paramesvari Muniandy', '1 hour after breakfast sattu mavuu', '2025-07-15 00:59:50', 7),
(45, 'Parugavelu Veerayan', 2.00, 'Before Breakfast', '10:33:00', '2025-07-20', 'Paramesvari Muniandy', 'Take fenugreek tablets not taking herbal medicine', '2025-07-19 22:34:45', 7);

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` int(11) NOT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `tenant_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `patient_name`, `age`, `tenant_id`, `created_at`) VALUES
(4, 'Parugavelu Veerayan', 58, 7, '2025-07-23 19:39:42'),
(5, 'Paramesvari Muniandy', 48, 7, '2025-07-23 19:39:50'),
(6, 'Heviinash Parugavelu', 22, 7, '2025-07-23 19:39:55'),
(7, 'Naveennash Parugavelu', 18, 7, '2025-07-23 19:40:04'),
(8, 'Dinooshiini Parugavelu', 16, 7, '2025-07-23 19:40:11');

-- --------------------------------------------------------

--
-- Table structure for table `sessions_log`
--

CREATE TABLE `sessions_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `device_info` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `login_time` datetime NOT NULL,
  `logout_time` datetime DEFAULT NULL,
  `still_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sessions_log`
--

INSERT INTO `sessions_log` (`id`, `user_id`, `tenant_id`, `device_info`, `ip_address`, `login_time`, `logout_time`, `still_active`) VALUES
(1, 11, 10, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '::1', '2025-08-21 23:33:46', '2025-08-21 23:33:58', 0),
(2, 11, 10, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36', '::1', '2025-08-30 14:06:25', '2025-08-30 14:06:28', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

CREATE TABLE `tenants` (
  `id` int(11) NOT NULL,
  `tenant_name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`id`, `tenant_name`, `created_at`) VALUES
(4, 'House of Codes', '2025-07-23 16:17:07'),
(7, 'Paramesvari Muniandy', '2025-07-23 19:38:33'),
(8, 'Raven', '2025-08-12 16:58:25'),
(9, 'Nash', '2025-08-12 16:58:38'),
(10, 'House of Codes', '2025-08-12 17:04:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','System God','User') DEFAULT 'User',
  `status` enum('Active','Inactive') DEFAULT 'Inactive',
  `tenant_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_temp_password` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `role`, `status`, `tenant_id`, `created_at`, `is_temp_password`) VALUES
(7, 'Paramesvari Muniandy', 'mparames9', '$2y$10$1G..inOCZDMq5TWeEpYmS.esPgvJz9KC.76uI3ToJHTZNb2Cflvd2', 'Admin', 'Active', 7, '2025-07-23 11:38:33', 0),
(9, 'Nash', 'nash22', '$2y$10$Wu/PCZ18BssL3bXc0q9X6uCrNQvDdJYE6.cCaiOkFCoF7XQT1UqiS', 'Admin', 'Active', 9, '2025-08-12 08:58:39', 0),
(11, 'Heviinash Parugavelu', 'heviinash22', '$2y$10$yeOTo99Z1ktdiuyCIMz0H.5IowdNwTL0juHjJAgcNazgrJ1iM9RW.', 'System God', 'Active', 10, '2025-08-12 09:04:03', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bloodsugarlevel`
--
ALTER TABLE `bloodsugarlevel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions_log`
--
ALTER TABLE `sessions_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tenants`
--
ALTER TABLE `tenants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `tenant_id` (`tenant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bloodsugarlevel`
--
ALTER TABLE `bloodsugarlevel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sessions_log`
--
ALTER TABLE `sessions_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tenants`
--
ALTER TABLE `tenants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bloodsugarlevel`
--
ALTER TABLE `bloodsugarlevel`
  ADD CONSTRAINT `bloodsugarlevel_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
