-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2026 at 06:11 PM
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
-- Database: `volunteer_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `assignment_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `volunteer_id` int(11) NOT NULL,
  `status` enum('assigned','confirmed') DEFAULT 'assigned'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`assignment_id`, `role_id`, `volunteer_id`, `status`) VALUES
(12, 14, 17, 'confirmed'),
(13, 16, 18, 'confirmed'),
(14, 19, 20, 'confirmed'),
(15, 20, 20, 'confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `status` enum('upcoming','completed') DEFAULT 'upcoming'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `event_date`, `status`) VALUES
(13, 'marathon', '2026-01-10', 'upcoming'),
(14, 'Blood donation campaign', '2026-01-10', 'upcoming'),
(15, 'awareness campaign', '2026-01-10', 'upcoming'),
(16, 'Marathon', '2026-01-10', 'upcoming'),
(17, 'Marathon race', '2026-01-10', 'upcoming'),
(18, 'Blood donation campaign', '2026-01-11', 'upcoming');

-- --------------------------------------------------------

--
-- Table structure for table `event_roles`
--

CREATE TABLE `event_roles` (
  `role_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `required_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_roles`
--

INSERT INTO `event_roles` (`role_id`, `event_id`, `role_name`, `required_count`) VALUES
(14, 13, 'teaching', 1),
(15, 14, 'teaching', 1),
(16, 15, 'teaching', 1),
(17, 16, 'teaching', 1),
(18, 16, 'public speeaking', 1),
(19, 17, 'teaching', 1),
(20, 18, 'teaching', 1);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `skill_id` int(11) NOT NULL,
  `skill_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`skill_id`, `skill_name`) VALUES
(4, 'Crowd Management'),
(5, 'Event Coordination'),
(3, 'First Aid'),
(8, 'Guest Relations (Hospitality)'),
(11, 'Heavy Lifting/Setup'),
(2, 'Logistics'),
(7, 'Photography/Media'),
(9, 'Public Speaking'),
(10, 'Social Media Management'),
(1, 'Teaching'),
(6, 'Technical Support (IT/AV)');

-- --------------------------------------------------------

--
-- Table structure for table `volunteers`
--

CREATE TABLE `volunteers` (
  `volunteer_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`volunteer_id`, `name`, `dob`, `phone`, `email`, `password`) VALUES
(17, 'VISHAL D', '2004-02-24', '8088190603', 'vishalworks05@gmail.com', '$2y$10$rFTt3x.KF76b.LMuhvJxhOLP.PH4VUgTw6hOQ6I1XF3Ps2uhbzHa.'),
(18, 'yogi', '2004-02-10', '8088190603', 'vishaluma1975@gmail.com', '$2y$10$nqUuVkyTQs/8UPBbfu1l1ek0f2ORGGdtLCeDo9z6NVd3zy9fipPjm'),
(19, 'yadu', '2005-02-16', '8088190603', 'vishaluma1975@gmail.com', '$2y$10$OPQnlugbkwojSrKwe92W3.m8cOqUFjpL9Mu1lX/atfxsFHXxgn57O'),
(20, 'vishwas', '2003-11-14', '8789654535', 'vishwa@gmail.com', '$2y$10$xrkjdcuEkMCA5OOAYTsVcO7.t1dM.TP4VP1XObvab3k/T48rwtlv2'),
(21, 'yogesh', '2001-01-14', '8789654535', 'yogesh@gmail.com', '$2y$10$j/jayd3seu.CkyqjDacoBeCiQrNJ7nBy3Xag5xr4qB828eUJF6ut2');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_availability`
--

CREATE TABLE `volunteer_availability` (
  `availability_id` int(11) NOT NULL,
  `volunteer_id` int(11) NOT NULL,
  `busy_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteer_availability`
--

INSERT INTO `volunteer_availability` (`availability_id`, `volunteer_id`, `busy_date`) VALUES
(1, 17, '2026-01-10'),
(2, 18, '2026-01-10'),
(3, 19, '2026-01-10'),
(4, 20, '2026-01-11'),
(5, 21, '2026-01-11');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer_skills`
--

CREATE TABLE `volunteer_skills` (
  `id` int(11) NOT NULL,
  `volunteer_id` int(11) NOT NULL,
  `skill_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteer_skills`
--

INSERT INTO `volunteer_skills` (`id`, `volunteer_id`, `skill_id`) VALUES
(33, 17, 1),
(34, 17, 2),
(35, 18, 1),
(36, 18, 2),
(37, 19, 1),
(38, 19, 5),
(39, 19, 9),
(40, 20, 1),
(41, 20, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`assignment_id`),
  ADD UNIQUE KEY `role_id` (`role_id`,`volunteer_id`),
  ADD KEY `volunteer_id` (`volunteer_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `event_roles`
--
ALTER TABLE `event_roles`
  ADD PRIMARY KEY (`role_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`skill_id`),
  ADD UNIQUE KEY `skill_name` (`skill_name`);

--
-- Indexes for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`volunteer_id`),
  ADD KEY `phone` (`phone`);

--
-- Indexes for table `volunteer_availability`
--
ALTER TABLE `volunteer_availability`
  ADD PRIMARY KEY (`availability_id`),
  ADD KEY `volunteer_id` (`volunteer_id`);

--
-- Indexes for table `volunteer_skills`
--
ALTER TABLE `volunteer_skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `volunteer_id` (`volunteer_id`),
  ADD KEY `skill_id` (`skill_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `assignment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `event_roles`
--
ALTER TABLE `event_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `skill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `volunteer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `volunteer_availability`
--
ALTER TABLE `volunteer_availability`
  MODIFY `availability_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `volunteer_skills`
--
ALTER TABLE `volunteer_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `assignments_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `event_roles` (`role_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assignments_ibfk_2` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`volunteer_id`) ON DELETE CASCADE;

--
-- Constraints for table `event_roles`
--
ALTER TABLE `event_roles`
  ADD CONSTRAINT `event_roles_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `volunteer_availability`
--
ALTER TABLE `volunteer_availability`
  ADD CONSTRAINT `volunteer_availability_ibfk_1` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`volunteer_id`) ON DELETE CASCADE;

--
-- Constraints for table `volunteer_skills`
--
ALTER TABLE `volunteer_skills`
  ADD CONSTRAINT `volunteer_skills_ibfk_1` FOREIGN KEY (`volunteer_id`) REFERENCES `volunteers` (`volunteer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `volunteer_skills_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`skill_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
