-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2026 at 08:50 AM
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
  `replacement_required` enum('yes','no') DEFAULT 'no',
  `terminal_part_no` varchar(100) DEFAULT NULL,
  `reason_replacement` text DEFAULT NULL,
  `date_replaced` date DEFAULT NULL,
  `replacement_technician` varchar(100) DEFAULT NULL,
  `change_point_no` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `terminal_inspections`
--
ALTER TABLE `terminal_inspections`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `terminal_inspections`
--
ALTER TABLE `terminal_inspections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
