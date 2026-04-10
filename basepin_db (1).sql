-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2026 at 08:09 AM
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer` varchar(100) DEFAULT NULL,
  `item_key` varchar(100) DEFAULT NULL,
  `is_selected` enum('select','unselect') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terminal_replacement`
--

CREATE TABLE `terminal_replacement` (
  `id` int(11) NOT NULL,
  `inspection_id` int(11) NOT NULL,
  `replacement_required` enum('yes','no') DEFAULT 'no',
  `reason_replacement` text DEFAULT NULL,
  `date_replaced` date DEFAULT NULL,
  `replacement_technician` varchar(100) DEFAULT NULL,
  `change_point_no` varchar(100) DEFAULT NULL,
  `replacement_terminal_replace_no` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terminal_status`
--

CREATE TABLE `terminal_status` (
  `id` int(11) NOT NULL,
  `inspection_id` int(11) NOT NULL,
  `terminal_part_no` varchar(255) DEFAULT NULL,
  `row_no` varchar(50) DEFAULT NULL,
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
  `photo_before_path` varchar(255) DEFAULT NULL,
  `photo_after_path` varchar(255) DEFAULT NULL,
  `total_inspected` int(11) DEFAULT NULL,
  `total_ok` int(11) DEFAULT NULL,
  `total_ng` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'CG LLOYD FRANZA', NULL, 'ADMIN', 'CGsoHandsome', '$2y$10$P6QBhaO5dL66Y.exaNO5MOZSPVrFyTKjY3gfO74z6noJfcDutDPua', '2026-04-10 05:35:56'),
(2, 'DPJ SAM', NULL, 'Preventive Maintenance', 'preventive_maintenance', '$2y$10$NSNf67qk35836tUvJymZW.bg/7Ec57N.S1xl175OJMxR0h68i7pxm', '2026-04-10 05:44:40'),
(3, 'Allan Parin', NULL, 'ADMIN', 'wetpakz', '$2y$10$oDIHzkNHW0w643PQFfPEreiI0NB8ws7Vd.eZewbxIJvBcp5kNPiZ2', '2026-04-10 05:53:36');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terminal_replacement`
--
ALTER TABLE `terminal_replacement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terminal_status`
--
ALTER TABLE `terminal_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
