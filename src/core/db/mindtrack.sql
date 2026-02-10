-- MindTrack Database Schema
-- Version 1.0
-- Role-based architecture with separate user info tables

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mindtrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uuid` char(36) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` enum('patient','doctor','admin') NOT NULL DEFAULT 'patient',
  `status` enum('active','inactive','banned') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `email` (`email`);

-- --------------------------------------------------------

--
-- Table structure for table `user_patient_info`
--

CREATE TABLE `user_patient_info` (
  `id` int(11) NOT NULL,
  `user_uuid` char(36) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `address` text DEFAULT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_phone` varchar(50) DEFAULT NULL,
  `medical_history` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`medical_history`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for table `user_patient_info`
--
ALTER TABLE `user_patient_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_uuid` (`user_uuid`);

-- --------------------------------------------------------

--
-- Table structure for table `specializations`
--

CREATE TABLE `specializations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `specializations`
--

INSERT INTO `specializations` (`id`, `name`, `description`, `status`) VALUES
(1, 'Clinical Psychology', 'Diagnosis and treatment of mental disorders', 'active'),
(2, 'Counseling Psychology', 'Guidance for emotional and behavioral issues', 'active'),
(3, 'Child & Adolescent Psychology', 'Mental health care for children and teens', 'active'),
(4, 'Neuropsychology', 'Brain-behavior relationships and cognitive assessment', 'active'),
(5, 'Forensic Psychology', 'Psychology applied to legal and criminal contexts', 'active'),
(6, 'Health Psychology', 'Behavioral factors in physical health and illness', 'active'),
(7, 'Industrial-Organizational Psychology', 'Workplace behavior and organizational wellness', 'active'),
(8, 'General Psychologist', 'Broad-spectrum psychological assessment and care', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_doctor_info`
--

CREATE TABLE `user_doctor_info` (
  `id` int(11) NOT NULL,
  `user_uuid` char(36) NOT NULL,
  `specialization_id` int(11) DEFAULT NULL,
  `license_number` varchar(100) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `schedule` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`schedule`)),
  `consultation_fee` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for table `user_doctor_info`
--
ALTER TABLE `user_doctor_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_uuid` (`user_uuid`),
  ADD KEY `specialization_id` (`specialization_id`);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `reference_model` varchar(100) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `uuid` char(36) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `duration` int(11) NOT NULL DEFAULT 60 COMMENT 'Duration in minutes',
  `specialization_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `specialization_id` (`specialization_id`);

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE `attachments` (
  `id` int(11) NOT NULL,
  `reference_model` varchar(100) NOT NULL,
  `reference_uuid` char(36) NOT NULL,
  `folder` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reference_lookup` (`reference_model`,`reference_uuid`);

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `uuid` char(36) NOT NULL,
  `patient_uuid` char(36) NOT NULL,
  `doctor_uuid` char(36) NOT NULL,
  `service_uuid` char(36) NOT NULL,
  `sched_date` date NOT NULL,
  `sched_time` time NOT NULL,
  `status` enum('pending','confirmed','completed','cancelled','no_show') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `patient_uuid` (`patient_uuid`),
  ADD KEY `doctor_uuid` (`doctor_uuid`),
  ADD KEY `service_uuid` (`service_uuid`);

-- --------------------------------------------------------

--
-- Table structure for table `clinical_notes`
--

CREATE TABLE `clinical_notes` (
  `uuid` char(36) NOT NULL,
  `appointment_uuid` char(36) NOT NULL,
  `doctor_uuid` char(36) NOT NULL,
  `diagnosis` text DEFAULT NULL,
  `prescription` text DEFAULT NULL,
  `private_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for table `clinical_notes`
--
ALTER TABLE `clinical_notes`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `appointment_uuid` (`appointment_uuid`),
  ADD KEY `doctor_uuid` (`doctor_uuid`);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_uuid` char(36) NOT NULL,
  `type` varchar(50) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_read_lookup` (`user_uuid`,`is_read`),
  ADD KEY `type` (`type`);

-- --------------------------------------------------------

--
-- AUTO_INCREMENT for table `user_patient_info`
--
ALTER TABLE `user_patient_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_doctor_info`
--
ALTER TABLE `user_doctor_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_patient_info`
--
ALTER TABLE `user_patient_info`
  ADD CONSTRAINT `fk_patient_user` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE;

--
-- Constraints for table `user_doctor_info`
--
ALTER TABLE `user_doctor_info`
  ADD CONSTRAINT `fk_doctor_user` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_doctor_specialization` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `fk_service_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_service_specialization` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `fk_appt_patient` FOREIGN KEY (`patient_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_appt_doctor` FOREIGN KEY (`doctor_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_appt_service` FOREIGN KEY (`service_uuid`) REFERENCES `services` (`uuid`) ON DELETE CASCADE;

--
-- Constraints for table `clinical_notes`
--
ALTER TABLE `clinical_notes`
  ADD CONSTRAINT `fk_notes_appt` FOREIGN KEY (`appointment_uuid`) REFERENCES `appointments` (`uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_notes_doctor` FOREIGN KEY (`doctor_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
