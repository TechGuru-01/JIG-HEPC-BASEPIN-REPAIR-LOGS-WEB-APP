-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2026 at 09:50 AM
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
-- Database: `basepin_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `terminal_inspections`
--

CREATE TABLE `terminal_inspections` (
  `id` int(11) NOT NULL,
  `section` varchar(50) NOT NULL,
  `control_number` varchar(100) DEFAULT NULL,
  `technician_name` varchar(100) DEFAULT NULL,
  `date_of_verification` date NOT NULL,
  `quarter` varchar(10) DEFAULT NULL,
  `photo_before_path` varchar(255) DEFAULT NULL,
  `photo_after_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer` varchar(100) DEFAULT NULL,
  `item_key` varchar(100) DEFAULT NULL,
  `is_selected` enum('select','unselect') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terminal_inspections`
--

INSERT INTO `terminal_inspections` (`id`, `section`, `control_number`, `technician_name`, `date_of_verification`, `quarter`, `photo_before_path`, `photo_after_path`, `created_at`, `customer`, `item_key`, `is_selected`) VALUES
(37, 'AUD', '12', '12', '2025-12-31', 'Q4', '1775450892_before_image-removebg-preview (1).png', '1775450892_after_zucky.webp', '2026-04-06 04:48:12', '12', '12', NULL),
(38, 'AUD', '32', '32', '2026-01-03', 'Q1', '1775450934_before_images.jpg', '1775450934_after_images.webp', '2026-04-06 04:48:54', '54', '5454', NULL),
(39, 'AOD', 'AED-12345', 'sdkufgnkb dshg', '2026-04-18', 'Q4', '1775460288_before_folder-structure.png', '1775460288_after_pexels-witchagron-buapa-357821189-14721096.jpg', '2026-04-06 07:24:48', 'dhfskdv svb fv', 'wdfhnkj gkenfkvkfbvfkjevbks', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `terminal_replacement`
--

CREATE TABLE `terminal_replacement` (
  `id` int(11) NOT NULL,
  `inspection_id` int(11) NOT NULL,
  `replacement_required` enum('yes','no') DEFAULT 'no',
  `terminal_part_no` varchar(100) DEFAULT NULL,
  `reason_replacement` text DEFAULT NULL,
  `date_replaced` date DEFAULT NULL,
  `replacement_technician` varchar(100) DEFAULT NULL,
  `change_point_no` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terminal_replacement`
--

INSERT INTO `terminal_replacement` (`id`, `inspection_id`, `replacement_required`, `terminal_part_no`, `reason_replacement`, `date_replaced`, `replacement_technician`, `change_point_no`, `created_at`) VALUES
(37, 37, 'no', '', '', '0000-00-00', '', '', '2026-04-06 04:48:12'),
(38, 38, 'no', '', '', '0000-00-00', '', '', '2026-04-06 04:48:54'),
(39, 39, 'no', '', '', '0000-00-00', '', '', '2026-04-06 07:24:48');

-- --------------------------------------------------------

--
-- Table structure for table `terminal_status`
--

CREATE TABLE `terminal_status` (
  `id` int(11) NOT NULL,
  `inspection_id` int(11) NOT NULL,
  `deformation_status` varchar(5) DEFAULT NULL,
  `deformation_remarks` text DEFAULT NULL,
  `corrosion_status` varchar(5) DEFAULT NULL,
  `corrosion_remarks` text DEFAULT NULL,
  `crack_status` varchar(5) DEFAULT NULL,
  `crack_remarks` text DEFAULT NULL,
  `foreign_material_status` varchar(5) DEFAULT NULL,
  `foreign_material_remarks` text DEFAULT NULL,
  `alignment_status` varchar(5) DEFAULT NULL,
  `alignment_remarks` text DEFAULT NULL,
  `total_inspected` int(11) DEFAULT NULL,
  `total_ok` int(11) DEFAULT NULL,
  `total_ng` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terminal_status`
--

INSERT INTO `terminal_status` (`id`, `inspection_id`, `deformation_status`, `deformation_remarks`, `corrosion_status`, `corrosion_remarks`, `crack_status`, `crack_remarks`, `foreign_material_status`, `foreign_material_remarks`, `alignment_status`, `alignment_remarks`, `total_inspected`, `total_ok`, `total_ng`, `created_at`) VALUES
(37, 37, 'ok', '12', 'ok', '12', 'ok', '12', 'ok', '12', 'ok', '21', 1, 1, 0, '2026-04-06 04:48:12'),
(38, 38, 'ok', '233', 'ng', '23', 'ng', '2', 'ng', '2', 'ng', '2', 12, 2, 2, '2026-04-06 04:48:54'),
(39, 39, 'ok', 'n/a', 'ng', 'n/a', 'ok', 'n/a', 'ng', 'n/a', 'ok', 'n/a', NULL, 3, 2, '2026-04-06 07:24:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `profile_pic`, `position`, `username`, `password`, `created_at`) VALUES
(1, 'Elijah Boon', '../../src/profiles/profile_0_1775454665.webp', 'ADMIN', 'elijahboon1987', '$2y$10$GeQFSO6YTeJZSFtedgkbFu6U26nBEyeyUPhLk55uHDgSlWSLjIdw2', '2026-04-06 00:11:22'),
(3, 'Chaz Honrada', '../../src/profiles/profile_3_1775459293.webp', 'Technician', 'zxhc123', '$2y$10$4uCmErLPUGmBNWORP1ooyutLxiRwOvhIm6HsR6C8/ekV6q8nYR86a', '2026-04-06 07:06:09'),
(4, 'Donald Duck', '../../src/profiles/profile_4_1775459501.jpg', 'admin', 'sprikitik_itik', '$2y$10$uSv9GRKPuXKULm2Ors4X9eJ3Pwo8wEObs0DpqZO/SQuYlRAgM55B.', '2026-04-06 07:11:13'),
(5, 'wario', '../../src/profiles/profile_5_1775460724.jpg', 'wario', 'wario', '$2y$10$QV.ngPT.8J1EgTYmAf32RuaRVwdSfi5oX6BF.axOWCdHMaYFXs/pa', '2026-04-06 07:31:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `terminal_inspections`
--
ALTER TABLE `terminal_inspections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terminal_replacement`
--
ALTER TABLE `terminal_replacement`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_replacement_inspection` (`inspection_id`);

--
-- Indexes for table `terminal_status`
--
ALTER TABLE `terminal_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_status_inspection` (`inspection_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `terminal_inspections`
--
ALTER TABLE `terminal_inspections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `terminal_replacement`
--
ALTER TABLE `terminal_replacement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `terminal_status`
--
ALTER TABLE `terminal_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `terminal_replacement`
--
ALTER TABLE `terminal_replacement`
  ADD CONSTRAINT `fk_replacement_inspection` FOREIGN KEY (`inspection_id`) REFERENCES `terminal_inspections` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `terminal_status`
--
ALTER TABLE `terminal_status`
  ADD CONSTRAINT `fk_status_inspection` FOREIGN KEY (`inspection_id`) REFERENCES `terminal_inspections` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
