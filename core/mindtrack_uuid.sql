-- phpMyAdmin SQL Dump
-- MindTrack Database Schema with UUID and User Extension Tables
-- Version: 2.0 (Normalized Structure)
-- Generated: October 22, 2025
--
-- This is the UPDATED schema using UUIDs and user extension tables
-- Use this for fresh installations
--

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
-- Core authentication table for all users
--

CREATE TABLE `users` (
  `uuid` varchar(36) NOT NULL COMMENT 'UUID',
  `email` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'Hashed password',
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','doctor','patient') NOT NULL DEFAULT 'patient',
  `status` enum('active','inactive','suspended') NOT NULL DEFAULT 'active',
  `email_verified` tinyint(1) DEFAULT 0,
  `avatar` varchar(255) DEFAULT NULL,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_doctor_adds`
-- Extension table for doctor-specific fields
--

CREATE TABLE `users_doctor_adds` (
  `uuid` varchar(36) NOT NULL COMMENT 'UUID',
  `user_uuid` varchar(36) NOT NULL COMMENT 'Link to users table',
  `doctor_custom_id` varchar(10) NOT NULL COMMENT 'Human-readable ID (DR##### format)',
  `specialization` varchar(100) NOT NULL,
  `license_number` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_patient_adds`
-- Extension table for patient-specific fields
--

CREATE TABLE `users_patient_adds` (
  `uuid` varchar(36) NOT NULL COMMENT 'UUID',
  `user_uuid` varchar(36) NOT NULL COMMENT 'Link to users table',
  `patient_custom_id` varchar(20) NOT NULL COMMENT 'Human-readable ID (MMDDYY format)',
  `birthdate` date NOT NULL,
  `emergency_contact` varchar(50) DEFAULT NULL,
  `service_type` varchar(100) NOT NULL,
  `doctor_uuid` varchar(36) DEFAULT NULL COMMENT 'Assigned doctor',
  `diagnosis` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_request`
--

CREATE TABLE `booking_request` (
  `uuid` varchar(36) NOT NULL COMMENT 'UUID',
  `user_uuid` varchar(36) DEFAULT NULL COMMENT 'UUID reference to users (null if not registered)',
  `patient_custom_id` varchar(20) DEFAULT NULL COMMENT 'Human-readable patient ID',
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `birthdate` date NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `status` enum('pending','approved','rejected','cancelled') DEFAULT 'pending',
  `booking_code` varchar(20) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `uuid` varchar(36) NOT NULL COMMENT 'UUID',
  `booking_uuid` varchar(36) DEFAULT NULL COMMENT 'Link to booking_request',
  `patient_uuid` varchar(36) NOT NULL COMMENT 'UUID reference to users (patient)',
  `doctor_uuid` varchar(36) DEFAULT NULL COMMENT 'UUID reference to users (doctor)',
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `service_type` varchar(100) NOT NULL,
  `status` enum('scheduled','completed','cancelled','no-show') DEFAULT 'scheduled',
  `booking_code` varchar(20) NOT NULL,
  `remarks` text DEFAULT NULL,
  `prescription` text DEFAULT NULL,
  `diagnosis` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `session_tokens`
--

CREATE TABLE `session_tokens` (
  `uuid` varchar(36) NOT NULL COMMENT 'UUID',
  `user_uuid` varchar(36) NOT NULL,
  `token` varchar(255) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `expires_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `uuid` varchar(36) NOT NULL COMMENT 'UUID',
  `user_uuid` varchar(36) DEFAULT NULL,
  `action` varchar(100) NOT NULL,
  `entity_type` varchar(50) DEFAULT NULL COMMENT 'e.g., patient, doctor, appointment',
  `entity_uuid` varchar(36) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_status` (`status`);

--
-- Indexes for table `users_doctor_adds`
--
ALTER TABLE `users_doctor_adds`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `user_uuid` (`user_uuid`),
  ADD UNIQUE KEY `doctor_custom_id` (`doctor_custom_id`),
  ADD KEY `idx_user_uuid` (`user_uuid`),
  ADD KEY `idx_doctor_custom_id` (`doctor_custom_id`);

--
-- Indexes for table `users_patient_adds`
--
ALTER TABLE `users_patient_adds`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `user_uuid` (`user_uuid`),
  ADD UNIQUE KEY `patient_custom_id` (`patient_custom_id`),
  ADD KEY `idx_user_uuid` (`user_uuid`),
  ADD KEY `idx_patient_custom_id` (`patient_custom_id`),
  ADD KEY `idx_doctor_uuid` (`doctor_uuid`);

--
-- Indexes for table `booking_request`
--
ALTER TABLE `booking_request`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD KEY `idx_user_uuid` (`user_uuid`),
  ADD KEY `idx_booking_code` (`booking_code`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_booking_date` (`booking_date`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `idx_booking_uuid` (`booking_uuid`),
  ADD KEY `idx_patient_uuid` (`patient_uuid`),
  ADD KEY `idx_doctor_uuid` (`doctor_uuid`),
  ADD KEY `idx_appointment_date` (`appointment_date`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_booking_code` (`booking_code`);

--
-- Indexes for table `session_tokens`
--
ALTER TABLE `session_tokens`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `idx_user_uuid` (`user_uuid`),
  ADD KEY `idx_token` (`token`),
  ADD KEY `idx_expires_at` (`expires_at`);

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `idx_user_uuid` (`user_uuid`),
  ADD KEY `idx_entity_type` (`entity_type`),
  ADD KEY `idx_entity_uuid` (`entity_uuid`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_doctor_adds`
--
ALTER TABLE `users_doctor_adds`
  ADD CONSTRAINT `users_doctor_adds_ibfk_1` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_patient_adds`
--
ALTER TABLE `users_patient_adds`
  ADD CONSTRAINT `users_patient_adds_ibfk_1` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_patient_adds_ibfk_2` FOREIGN KEY (`doctor_uuid`) REFERENCES `users` (`uuid`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `booking_request`
--
ALTER TABLE `booking_request`
  ADD CONSTRAINT `booking_request_ibfk_1` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`booking_uuid`) REFERENCES `booking_request` (`uuid`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`patient_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointment_ibfk_3` FOREIGN KEY (`doctor_uuid`) REFERENCES `users` (`uuid`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `session_tokens`
--
ALTER TABLE `session_tokens`
  ADD CONSTRAINT `session_tokens_ibfk_1` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE SET NULL ON UPDATE CASCADE;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
