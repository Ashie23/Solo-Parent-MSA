-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2024 at 07:25 PM
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
-- Database: `spmsa_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `barangays`
--

CREATE TABLE `barangays` (
  `barangay_id` int(11) NOT NULL,
  `barangay_name` varchar(50) NOT NULL,
  `captain_name` varchar(255) NOT NULL,
  `captain_contact` int(11) NOT NULL,
  `secretary_name` varchar(255) DEFAULT NULL,
  `secretary_contact` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barangays`
--

INSERT INTO `barangays` (`barangay_id`, `barangay_name`, `captain_name`, `captain_contact`, `secretary_name`, `secretary_contact`, `created_at`, `updated_at`) VALUES
(1, 'Marikit', 'Carrie', 2147483647, 'marie', '09876543210', '2024-05-02 16:32:23', '2024-05-02 16:35:00'),
(3, 'Cadaclan', 'Adan', 91234, 'Eve', '0912334', '2024-05-03 04:57:17', '2024-05-03 04:57:17');

-- --------------------------------------------------------

--
-- Table structure for table `children`
--

CREATE TABLE `children` (
  `id` int(11) NOT NULL,
  `solo_parent_id` int(11) DEFAULT NULL,
  `child_name` varchar(255) DEFAULT NULL,
  `child_dob` date DEFAULT NULL,
  `child_relationship` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `children`
--

INSERT INTO `children` (`id`, `solo_parent_id`, `child_name`, `child_dob`, `child_relationship`) VALUES
(10, 4, 'Mina', '2022-05-05', 'daughter'),
(13, 1, 'Gene', '2004-01-11', 'son'),
(14, 14, 'venice', '2023-11-11', 'daughter'),
(15, 14, 'vince', '2023-11-11', 'son'),
(16, 15, 'nichole', '2022-05-23', 'daughter');

-- --------------------------------------------------------

--
-- Table structure for table `municipal_info`
--

CREATE TABLE `municipal_info` (
  `id` int(11) NOT NULL,
  `municipal_name` varchar(255) NOT NULL,
  `mswdo_head` varchar(255) NOT NULL,
  `municipal_mayor` varchar(255) NOT NULL,
  `expiration_of_id` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `municipal_info`
--

INSERT INTO `municipal_info` (`id`, `municipal_name`, `mswdo_head`, `municipal_mayor`, `expiration_of_id`) VALUES
(1, 'Pantabangan', 'Charlie Dunno', 'Roberto T. Agdipa', '2025-05-31');

-- --------------------------------------------------------

--
-- Table structure for table `solo_parents`
--

CREATE TABLE `solo_parents` (
  `id` int(11) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `place_of_birth` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `solo_parent_category` enum('Widow','Unmarried','Separated','Victim of Violence','PWD') NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_relation` varchar(255) DEFAULT NULL,
  `emergency_contact_number` varchar(20) DEFAULT NULL,
  `emergency_contact_address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `solo_parents`
--

INSERT INTO `solo_parents` (`id`, `barangay`, `first_name`, `middle_name`, `last_name`, `birthdate`, `place_of_birth`, `address`, `solo_parent_category`, `contact_number`, `emergency_contact_name`, `emergency_contact_relation`, `emergency_contact_number`, `emergency_contact_address`) VALUES
(1, 'Cadaclan', 'Eurie', 'mantile', 'pilande', '2000-04-02', 'palayan', 'palayan, nueva ecija', 'Widow', '', 'jiro', 'brother', '09876543210', 'palayan'),
(4, 'Marikit', 'Mona', 'vine', 'lala', '2000-01-11', 'kjdfndj', 'djvfvn', 'Widow', '', 'jvdvnjfvn', 'fdvhhvdhv', '045985', 'jfgdhff'),
(14, 'Marikit', 'Jiro', 'Payla', 'Linsangan', '2000-09-11', 'bongabon', 'marikit', 'Separated', '', 'mimi', 'sister', '09122334445', 'marikit'),
(15, 'Cadaclan', 'Shai', 'Laguisma', 'Prado', '2000-03-15', 'natividad', 'cadaclan', 'Unmarried', '', 'princess', 'aunt', '09123456789', 'cadaclan');

-- --------------------------------------------------------

--
-- Table structure for table `solo_parent_benefits`
--

CREATE TABLE `solo_parent_benefits` (
  `id` int(11) NOT NULL,
  `solo_parent_id` int(11) DEFAULT NULL,
  `parental_leave` enum('yes','no') DEFAULT 'no',
  `health_insurance_coverage` enum('yes','no') DEFAULT 'no',
  `monthly_allowances` decimal(10,2) DEFAULT NULL,
  `discounts` enum('yes','no') DEFAULT 'no',
  `scholarship_programs` enum('yes','no') DEFAULT 'no',
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `solo_parent_benefits`
--

INSERT INTO `solo_parent_benefits` (`id`, `solo_parent_id`, `parental_leave`, `health_insurance_coverage`, `monthly_allowances`, `discounts`, `scholarship_programs`, `added_at`, `updated_at`) VALUES
(2, 1, 'yes', 'yes', 1000.00, 'yes', 'yes', '2024-05-03 07:03:36', '2024-05-03 07:03:36'),
(4, 4, 'no', 'yes', 0.00, 'yes', 'no', '2024-05-03 09:19:27', '2024-05-03 09:19:27'),
(5, 14, 'no', 'yes', 0.00, 'yes', 'yes', '2024-05-06 19:18:09', '2024-05-06 19:18:09');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff','head') NOT NULL,
  `approval_status` enum('Pending','Approved','Rejected') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `approval_status`, `created_at`) VALUES
(1, 'April Jacinto', 'jacintoapril48@gmail.com', '$2y$10$DLnskVhquOlppHl7oKvMKu7AOPbzzCBsGx0PBLFFO0Cnvhn6ebOFe', 'admin', 'Approved', '2024-05-02 07:03:58'),
(2, 'Eurie Pilande', 'eurie@gmail.com', '$2y$10$ce2DGfX7Nrfheh8HDZETF.oY.dLxmEd6om4ZB2x2abfpq8UfC3NBC', 'staff', 'Approved', '2024-05-02 17:08:53'),
(3, 'Shai Prado', 'shai@gmail.com', '$2y$10$LxxwzDXV2vt0vXYmLz7u5OHw6379W/rElOcsjHI5Z5YnQOOqyjsR2', 'head', 'Approved', '2024-05-03 09:23:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barangays`
--
ALTER TABLE `barangays`
  ADD PRIMARY KEY (`barangay_id`);

--
-- Indexes for table `children`
--
ALTER TABLE `children`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solo_parent_id` (`solo_parent_id`);

--
-- Indexes for table `municipal_info`
--
ALTER TABLE `municipal_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `solo_parents`
--
ALTER TABLE `solo_parents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `solo_parent_benefits`
--
ALTER TABLE `solo_parent_benefits`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solo_parent_id` (`solo_parent_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barangays`
--
ALTER TABLE `barangays`
  MODIFY `barangay_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `children`
--
ALTER TABLE `children`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `municipal_info`
--
ALTER TABLE `municipal_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `solo_parents`
--
ALTER TABLE `solo_parents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `solo_parent_benefits`
--
ALTER TABLE `solo_parent_benefits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `children`
--
ALTER TABLE `children`
  ADD CONSTRAINT `children_ibfk_1` FOREIGN KEY (`solo_parent_id`) REFERENCES `solo_parents` (`id`);

--
-- Constraints for table `solo_parent_benefits`
--
ALTER TABLE `solo_parent_benefits`
  ADD CONSTRAINT `solo_parent_benefits_ibfk_1` FOREIGN KEY (`solo_parent_id`) REFERENCES `solo_parents` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
