-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2026 at 07:33 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terminal_inspections`
--

INSERT INTO `terminal_inspections` (`id`, `section`, `control_number`, `technician_name`, `date_of_verification`, `quarter`, `photo_before_path`, `photo_after_path`, `created_at`) VALUES
(1, 'section_b', 'asdfa', 'dasfs', '2026-03-31', 'Q1', '1774972307_before_Screenshot 2025-11-07 014914.png', '1774972307_after_Screenshot 2025-11-11 141426.png', '2026-03-31 15:51:47'),
(2, 'section_b', 'asdfa', 'dasfs', '2026-03-31', 'Q1', '1774973779_before_Screenshot 2025-11-07 014914.png', '1774973779_after_Screenshot 2025-11-11 141426.png', '2026-03-31 16:16:19'),
(3, 'section_a', 'asdf', 'adsas', '2026-04-01', 'Q1', '1774977132_before_', '', '2026-03-31 17:12:12');

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
(1, 1, 'yes', 'asdf', 'af', '2026-03-31', 'asdf', 'asfd', '2026-03-31 15:51:47'),
(2, 2, 'yes', 'asdf', 'af', '2026-03-31', 'asdf', 'asfd', '2026-03-31 16:16:19'),
(3, 3, 'no', '', '', '0000-00-00', '', '', '2026-03-31 17:12:12');

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
(1, 1, 'ok', 'asd', 'ok', 'asdf', 'ok', 'afd', 'ok', 'asdf', 'ok', 'asdf', 0, 0, 0, '2026-03-31 15:51:47'),
(2, 2, 'ok', 'asd', 'ok', 'asdf', 'ok', 'afd', 'ok', 'asdf', 'ok', 'asdf', 0, 0, 0, '2026-03-31 16:16:19'),
(3, 3, 'ok', 'asdf', 'ok', 'asdf', 'ok', 'asdf', 'ok', 'asfd', 'ok', 'asdf', 0, 0, 0, '2026-03-31 17:12:12');

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `terminal_inspections`
--
ALTER TABLE `terminal_inspections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `terminal_replacement`
--
ALTER TABLE `terminal_replacement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `terminal_status`
--
ALTER TABLE `terminal_status`
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
