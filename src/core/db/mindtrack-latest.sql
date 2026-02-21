-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2026 at 05:41 AM
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
-- Database: `mindtrack`
--

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
  `status` enum('pending','confirmed','completed','cancelled','no_show','rescheduled') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`uuid`, `patient_uuid`, `doctor_uuid`, `service_uuid`, `sched_date`, `sched_time`, `status`, `notes`, `created_at`, `updated_at`) VALUES
('012fa952-f98c-4c9a-923c-c400ffc1b3eb', '698e9399-ec7b-4588-a59d-a192ef9c7a8b', 'f5c3f66b-f45b-4b15-9c9c-1e957e4504c3', '97935744-ae67-41e6-ad4a-77392f89bb66', '2026-02-21', '04:45:00', 'confirmed', NULL, '2026-02-11 13:08:51', '2026-02-11 13:08:51'),
('04c629eb-bf55-4269-bffb-2cdcd570458a', 'c00e118f-f060-4cf5-bfa5-ab1626415550', 'f5c3f66b-f45b-4b15-9c9c-1e957e4504c3', 'a787340a-12ed-4d09-8cdd-13e8fec5c704', '2026-02-20', '04:45:00', 'rescheduled', NULL, '2026-02-09 14:39:24', '2026-02-19 10:25:58'),
('180be8f2-f4c0-47e2-93e4-e2589ab022ef', '7e14b177-c405-4631-9146-eaa5515ddcad', '61702d1b-e347-4fbf-9990-4207762f65ef', 'dd2258c4-532c-4a35-a2ac-134619c32d18', '2026-02-20', '10:30:00', 'confirmed', NULL, '2026-02-11 05:01:34', '2026-02-19 10:24:02'),
('20ae3f99-4ec0-4535-822a-cfeba3fff86f', 'c00e118f-f060-4cf5-bfa5-ab1626415550', '14825fe7-9077-46a7-8a08-9ea8842320cd', '97935744-ae67-41e6-ad4a-77392f89bb66', '2026-02-11', '11:00:00', 'pending', NULL, '2026-02-11 04:54:20', '2026-02-11 04:54:20'),
('21600cb8-ef3b-4a3b-be74-693169dd06e9', '03d62498-1062-4221-9c79-abd797a02d32', '12a72b38-3c78-44e1-a73c-d1fd9453e474', '23c0453e-9e6a-4116-b00e-dda73952c4a9', '2026-02-10', '14:30:00', 'completed', 'Test appointment from automation.', '2026-02-09 06:20:59', '2026-02-11 03:05:17'),
('3ce45d2c-06f3-4d88-bae5-52cf16a001ac', '1467959f-c473-49ad-84ce-1b5656012873', '14825fe7-9077-46a7-8a08-9ea8842320cd', 'a787340a-12ed-4d09-8cdd-13e8fec5c704', '2026-02-20', '02:00:00', 'confirmed', NULL, '2026-02-11 04:06:06', '2026-02-11 04:06:06'),
('4081527f-8424-4c6b-bfb7-098d3834f206', 'c00e118f-f060-4cf5-bfa5-ab1626415550', '61702d1b-e347-4fbf-9990-4207762f65ef', 'dd2258c4-532c-4a35-a2ac-134619c32d18', '2026-02-27', '09:00:00', 'pending', NULL, '2026-02-11 03:49:07', '2026-02-19 10:24:16'),
('4687ba68-6ced-422b-911b-85c56552d407', 'c00e118f-f060-4cf5-bfa5-ab1626415550', '14825fe7-9077-46a7-8a08-9ea8842320cd', '97935744-ae67-41e6-ad4a-77392f89bb66', '2026-02-20', '02:00:00', 'pending', NULL, '2026-02-11 13:10:19', '2026-02-11 13:10:19'),
('4b3dcd3b-5723-4f4b-a829-f427e88a3a70', 'c00e118f-f060-4cf5-bfa5-ab1626415550', '74ee1977-38d0-47f3-8e14-a38c20ca251f', 'a787340a-12ed-4d09-8cdd-13e8fec5c704', '2026-02-11', '11:00:00', 'completed', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2026-02-09 07:43:26', '2026-02-11 03:04:38'),
('4f991dbb-d199-47bd-a704-0806527198d4', '1467959f-c473-49ad-84ce-1b5656012873', '14825fe7-9077-46a7-8a08-9ea8842320cd', '97935744-ae67-41e6-ad4a-77392f89bb66', '2026-02-11', '02:00:00', 'confirmed', NULL, '2026-02-11 04:48:23', '2026-02-11 04:48:23'),
('583ca623-0cf2-4073-ba2f-37aba0f0d42f', 'c00e118f-f060-4cf5-bfa5-ab1626415550', '61702d1b-e347-4fbf-9990-4207762f65ef', 'dd2258c4-532c-4a35-a2ac-134619c32d18', '2026-02-20', '10:30:00', 'rescheduled', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2026-02-09 14:44:11', '2026-02-19 10:25:32'),
('67ec7ee8-16e0-4bf8-87dd-d175f72f0c44', 'c00e118f-f060-4cf5-bfa5-ab1626415550', '74ee1977-38d0-47f3-8e14-a38c20ca251f', '97935744-ae67-41e6-ad4a-77392f89bb66', '2026-02-09', '09:00:00', 'completed', '\nWhy do we use it?\n\nIt is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '2026-02-09 13:15:39', '2026-02-09 15:40:42'),
('830ef6a5-43fe-44d3-aabd-85a6b281dde0', '03d62498-1062-4221-9c79-abd797a02d32', '14825fe7-9077-46a7-8a08-9ea8842320cd', 'a787340a-12ed-4d09-8cdd-13e8fec5c704', '2026-02-11', '09:00:00', 'confirmed', NULL, '2026-02-11 03:43:20', '2026-02-11 03:43:20'),
('cfa6ebc4-ac27-4c38-96d0-724c202500d2', 'c00e118f-f060-4cf5-bfa5-ab1626415550', 'f5c3f66b-f45b-4b15-9c9c-1e957e4504c3', '97935744-ae67-41e6-ad4a-77392f89bb66', '2026-02-26', '02:00:00', 'pending', 'null', '2026-02-11 03:55:36', '2026-02-11 13:10:42'),
('ee096e1b-5541-4a4b-a5b9-a7e2575b5b9a', 'c00e118f-f060-4cf5-bfa5-ab1626415550', '61702d1b-e347-4fbf-9990-4207762f65ef', 'dd2258c4-532c-4a35-a2ac-134619c32d18', '2026-02-11', '09:00:00', 'completed', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2026-02-10 02:10:37', '2026-02-18 03:34:44'),
('f58ec160-3ac1-42d1-a454-4d993dbf2df6', '03d62498-1062-4221-9c79-abd797a02d32', '12a72b38-3c78-44e1-a73c-d1fd9453e474', '23c0453e-9e6a-4116-b00e-dda73952c4a9', '2026-02-10', '14:30:00', 'pending', 'Test appointment from automation.', '2026-02-09 06:20:27', '2026-02-09 06:20:27'),
('fa3f3e6b-3976-4ff4-b8d2-bf9e692a0b65', '1405ee52-bf65-4f06-b94b-ef77ea9c71c3', '61702d1b-e347-4fbf-9990-4207762f65ef', 'dd2258c4-532c-4a35-a2ac-134619c32d18', '2026-02-19', '11:00:00', 'confirmed', 'Seeded appointment (pending)', '2026-02-10 04:51:33', '2026-02-19 10:24:38'),
('fb4d2598-ebb5-4060-af93-debc5d755af6', '1405ee52-bf65-4f06-b94b-ef77ea9c71c3', 'f5c3f66b-f45b-4b15-9c9c-1e957e4504c3', '97935744-ae67-41e6-ad4a-77392f89bb66', '2026-02-12', '11:00:00', 'confirmed', 'Seeded appointment (confirmed)', '2026-02-10 04:51:33', '2026-02-11 04:52:50'),
('fe474137-ea14-4f46-a848-caa6bc1cc18f', '1405ee52-bf65-4f06-b94b-ef77ea9c71c3', 'dfadf3bf-8dd2-4d95-98fd-b67dca0c0d00', 'cd876220-a3e5-4dcf-be94-bac520d20049', '2026-02-20', '02:00:00', 'confirmed', NULL, '2026-02-11 03:58:43', '2026-02-11 03:58:43');

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
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `reference_model`, `icon`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'services', 'psychology', 'Therapy', 'Various therapeutic interventions for mental health.', 'active', '2026-02-09 06:10:57', '2026-02-09 06:10:57'),
(2, 'services', 'family_restroom', 'WORKING', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...\"', 'inactive', '2026-02-09 06:10:57', '2026-02-13 10:10:21'),
(3, 'services', 'medical_services', 'Consultation', 'Initial and follow-up clinical consultations.', 'active', '2026-02-09 06:10:57', '2026-02-09 06:10:57'),
(4, 'services', 'groups', 'Programs', 'Training and development programs.', 'active', '2026-02-09 06:10:57', '2026-02-09 06:10:57'),
(7, 'service', 'local_hospital', 'General', 'General Services', 'active', '2026-02-10 04:51:33', '2026-02-10 04:51:33'),
(8, 'services', 'groups', 'GAMING FINAL', 'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...\"', 'inactive', '2026-02-13 10:10:39', '2026-02-15 10:47:43'),
(9, 'services', 'emergency', 'Therapy 3.0', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'inactive', '2026-02-13 12:43:45', '2026-02-13 12:46:18'),
(11, 'services', 'psychology', 'GENERAL', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'active', '2026-02-13 14:20:29', '2026-02-13 14:20:29'),
(13, 'services', 'psychology', 'New category', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry', 'inactive', '2026-02-13 15:45:06', '2026-02-13 15:45:06');

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
-- Dumping data for table `services`
--

INSERT INTO `services` (`uuid`, `category_id`, `name`, `description`, `status`, `price`, `duration`, `specialization_id`, `created_at`, `updated_at`) VALUES
('23c0453e-9e6a-4116-b00e-dda73952c4a9', 1, 'Psychotherapy', 'Individual therapeutic sessions for emotional well-being.', 'active', 1500.00, 60, 1, '2026-02-09 06:10:57', '2026-02-10 03:16:59'),
('422f135d-e29f-4be8-8531-e2d18ba0b5f9', 2, 'GAMING THERAPY', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.', 'inactive', 500.00, 120, 13, '2026-02-13 13:29:36', '2026-02-13 15:31:51'),
('4351870f-b3ba-4c4d-94a4-36d3a34abda2', 1, 'Family / Couple Therapy', 'Support for relationship and family dynamics.', 'active', 2000.00, 90, 8, '2026-02-09 06:10:57', '2026-02-10 03:13:47'),
('503a281c-ee71-4398-8c1b-ec794b485608', 1, 'Occupational Therapy', 'Support for daily living and working skills.', 'active', 1600.00, 60, 7, '2026-02-09 06:10:57', '2026-02-10 03:13:47'),
('7ddb39fc-913c-4e20-bcaa-d3fdd946c6d9', 2, 'Psychological Testing', 'Comprehensive psychological and diagnostic testing.', 'active', 5000.00, 180, 8, '2026-02-09 06:10:57', '2026-02-10 03:13:47'),
('97935744-ae67-41e6-ad4a-77392f89bb66', 1, 'Applied Behavioral Analysis (ABA)', 'Specialized therapy for developmental disorders.', 'active', 2500.00, 120, 4, '2026-02-09 06:10:57', '2026-02-10 03:18:20'),
('a787340a-12ed-4d09-8cdd-13e8fec5c704', 1, 'Cognitive / Behavior Therapy (CBT)', 'Targeted sessions for behavior and thought patterns.', 'active', 1800.00, 45, 4, '2026-02-09 06:10:57', '2026-02-10 03:18:05'),
('c4f5aec0-f361-4432-9f0a-84d9ca983764', 8, 'GAMING THERAPY FINAL', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'active', 600.00, 120, 2, '2026-02-13 15:37:30', '2026-02-15 10:47:53'),
('cd876220-a3e5-4dcf-be94-bac520d20049', 11, 'General Checkup 202', 'Routine checkup', 'inactive', 150.00, 30, 1, '2026-02-10 04:51:33', '2026-02-13 15:31:58'),
('dd2258c4-532c-4a35-a2ac-134619c32d18', 3, 'General Consultation', 'Initial clinical assessment and referral.', 'active', 1000.00, 30, 8, '2026-02-09 06:10:57', '2026-02-10 03:26:36');

-- --------------------------------------------------------

--
-- Table structure for table `specializations`
--

CREATE TABLE `specializations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `specializations`
--

INSERT INTO `specializations` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Clinical Psychology', 'Diagnosis and treatment of mental disorders', 'active', '2026-02-10 03:03:23', '2026-02-10 03:03:23'),
(2, 'Counseling Psychology', 'Guidance for emotional and behavioral issues', 'active', '2026-02-10 03:03:23', '2026-02-10 03:03:23'),
(3, 'Child & Adolescent Psychology', 'Mental health care for children and teens', 'active', '2026-02-10 03:03:23', '2026-02-10 03:03:23'),
(4, 'Neuropsychology', 'Brain-behavior relationships and cognitive assessment', 'active', '2026-02-10 03:03:23', '2026-02-10 03:03:23'),
(5, 'Forensic Psychology', 'Psychology applied to legal and criminal contexts', 'active', '2026-02-10 03:03:23', '2026-02-10 03:03:23'),
(6, 'Health Psychology', 'Behavioral factors in physical health and illness', 'active', '2026-02-10 03:03:23', '2026-02-10 03:03:23'),
(7, 'Industrial-Organizational Psychology', 'Workplace behavior and organizational wellness', 'active', '2026-02-10 03:03:23', '2026-02-10 03:03:23'),
(8, 'General Psychologist', 'Broad-spectrum psychological assessment and care', 'active', '2026-02-10 03:03:23', '2026-02-10 03:03:23'),
(12, 'Batikan 2.0', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'active', '2026-02-12 17:21:32', '2026-02-12 17:26:05'),
(13, 'Batikan 3.0', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'active', '2026-02-12 17:26:26', '2026-02-12 17:26:26');

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
  `role` enum('patient','doctor','admin') NOT NULL DEFAULT 'patient',
  `status` enum('active','inactive','banned') NOT NULL DEFAULT 'active',
  `is_email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `email_verification_token` varchar(36) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uuid`, `firstname`, `lastname`, `email`, `password`, `phone`, `role`, `status`, `is_email_verified`, `email_verification_token`, `created_at`, `updated_at`) VALUES
('03d62498-1062-4221-9c79-abd797a02d32', 'pat3', 'men', 'pat3@mail.com', '$2y$10$tDw8sDAcdbItUyflbYNcJui6bA52h6DqA7FEyCjEDjd3.NvotbhAK', NULL, 'patient', 'active', 0, NULL, '2026-02-08 17:57:32', '2026-02-08 17:57:32'),
('0879151b-c48b-47db-b4f0-d170d8935a1b', 'carl6', 'abong', 'carl6@mail.com', '$2y$10$ctpjtW6SSKqi8pnt2EEvau2u6Ib9kb54M9Fk8Ll8sEJklt5cq95gG', NULL, 'doctor', 'active', 0, NULL, '2026-02-12 04:50:00', '2026-02-12 04:50:00'),
('0e222c36-e75d-450f-bddc-c477071fec94', 'Sarah', 'Jenkins', 'sarah.j@example.com', '$2y$10$qWQoGYSG9PuQXxOt8NyTqO555U1ZCJ0KyNF8o/OCxpGrJJmQm8fXK', '(555) 123-4567', 'patient', 'active', 0, NULL, '2026-02-15 11:58:07', '2026-02-15 11:58:07'),
('12a72b38-3c78-44e1-a73c-d1fd9453e474', 'David', 'Lee', 'david.lee@mindtrack.com', '$2y$10$zEZFucER3.eNGhKeNMD8k.taHG/cd6Zxznl4Y3UR5RCsozYhudY7W', '09123456785', 'doctor', 'active', 0, NULL, '2026-02-09 06:10:57', '2026-02-09 06:10:57'),
('1405ee52-bf65-4f06-b94b-ef77ea9c71c3', 'John', 'Doe', 'patient.one@test.com', '$2y$10$T1GSzK1XtHQW3SZfTmxBR.grKfcWiHLIiPHO5E6RSmdvF7LU3K1T2', '555-5678', 'patient', 'active', 0, NULL, '2026-02-10 04:51:33', '2026-02-10 04:51:33'),
('1467959f-c473-49ad-84ce-1b5656012873', 'pat11', 'men', 'pat11@mail.com', '$2y$10$2ChYv9BSgi7ok9D3D.NCneD8tQqdisTU0kQjYhyq5YJfnvVsAKVq6', NULL, 'patient', 'active', 0, NULL, '2026-02-09 05:39:58', '2026-02-09 05:39:58'),
('14825fe7-9077-46a7-8a08-9ea8842320cd', 'Maria', 'Garcia', 'maria.garcia@mindtrack.com', '$2y$10$biE/S7u.31L9NYsjXqImSuwcUGVE34Vvu11xBuCcxV1iBINum4GQ2', '09123456784', 'doctor', 'active', 0, NULL, '2026-02-09 06:10:57', '2026-02-09 06:10:57'),
('1b39c42c-7c12-41e0-9c79-83116f666a77', 'Sarah', 'Mitchell', 'sarah.mitchell@mindtrack.com', '$2y$10$fvc4hJSN.7v4reoXbxcR0e3bghb6awJc8Kztd8HFuv/ixHFtGAjhm', '09123456780', 'doctor', 'inactive', 0, NULL, '2026-02-09 06:10:57', '2026-02-12 00:49:54'),
('3e4974b2-4f7c-4af3-963f-3bc88747f42e', 'carl', 'abong', 'carl@mail.com', '$2y$10$anOJtzyeBPoKwaxO.JzpXODx.kPKqm5h.R8C4fNQ.Pr9FityEOKvS', NULL, 'doctor', 'active', 0, '57546ebe-b4f4-4464-8ef0-421b0f2447d1', '2026-02-20 16:00:26', '2026-02-20 16:00:26'),
('3ee0647d-71af-4743-ac69-d7bb9033818e', 'Lisa', 'Anderson', 'lisa.anderson@mindtrack.com', '$2y$10$NJdmwesf86LnBmEzc8vgdu/2i4eG8j/4E.evo/qfQZfuVmb5UyuPa', '09123456788', 'doctor', 'active', 0, NULL, '2026-02-09 06:10:57', '2026-02-09 06:10:57'),
('4a4cd105-75b1-4ea4-a25f-435e966aa8f2', 'Gregory', 'House', 'dr.house@mindtrack.com', '$2y$10$925J4S781i1bRiWPDwj/iuu3jT2lWkF3ELvhRfJjEohNUqyMhbAHi', '555-1234', 'doctor', 'active', 0, NULL, '2026-02-10 04:51:33', '2026-02-10 04:51:33'),
('4e45083b-478e-467e-b4f3-86011255848f', 'Jonathan', 'Violeta', 'jonavioleta19@gmail.com', '$2y$10$naf5xBBmACx0AB3AzGU5EOoxRfPefOuL.R.ZyAVItXGcATANzX9Dy', NULL, 'patient', 'active', 1, NULL, '2026-02-20 15:22:41', '2026-02-20 15:24:16'),
('4e5e90c0-1bba-4b38-83d1-b822ee05d564', 'AdminTest', 'Doctor', 'admin.test.doc@example.com', '$2y$10$nJyKQG01olkvyhxkoHTDMOG8HOxecFHf6l4OV0nQ2PaE9pkvXFanK', '(555) 999-8888', 'doctor', 'active', 0, 'a2642848-2756-4ac6-be65-8c4962bb9ef8', '2026-02-20 15:52:04', '2026-02-20 15:52:04'),
('5e322731-c009-4c77-9eda-06ac88edfe25', 'Admin', 'Test', 'admin@example.com', '$2y$10$bnrI6XLMrdsNP2xqdH3xhuegjcvOjkqbGJjo/T3NRd.xbCpV5LhZ6', '5551234567', 'patient', 'active', 0, '8325f745-c712-495b-b77e-ce4079f44269', '2026-02-20 15:49:52', '2026-02-20 15:49:52'),
('61702d1b-e347-4fbf-9990-4207762f65ef', 'doctor', 'kwak-kwak', 'doctor@mail.com', '$2y$10$umTjRWPOWkl0NuqS/KOn.OlmD30VIo343fyMWKCb4yH1e4/gcP.nS', '123-456-789', 'doctor', 'active', 1, NULL, '2026-02-16 13:26:38', '2026-02-20 16:20:35'),
('6393ab9a-c24c-4be2-b34a-d4233c92bfa9', 'John', 'Doe', 'test.user.1@example.com', '$2y$10$W4K/JoYRH/O0IKz3T.eeLuJxr/R7kCB4O74EM.aEDx4Vqp1fQdXGm', '1234567890', 'patient', 'active', 1, NULL, '2026-02-20 14:48:38', '2026-02-20 15:32:02'),
('698e9399-ec7b-4588-a59d-a192ef9c7a8b', 'pat4', 'men', 'pat4@mail.com', '$2y$10$egmYYUvmxsH0U0cknx9QmuRdLs1.BxMnLaagwhjbbNJGF5vOxLDE2', NULL, 'patient', 'active', 0, NULL, '2026-02-08 18:01:04', '2026-02-08 18:01:04'),
('6fb2df93-0635-11f1-aa35-d843aec4afd7', 'admin', 'password', 'admin@mail.com', '$2y$10$6ZO3U22/MnXwSPggnbLk1.a/.IybzpUGUwPouzLjRa5IK.TLB/C0u', NULL, 'admin', 'active', 0, NULL, '2026-02-10 04:03:20', '2026-02-10 04:03:20'),
('74ee1977-38d0-47f3-8e14-a38c20ca251f', 'Elena', 'Rodriguez', 'elena.rodriguez@mindtrack.com', '$2y$10$Mi2aGVC61Q3z5KHa9ZzZDe.iTM6.GDMml1fR6wZG8xCyrCN3pCR0u', '09123456782', 'doctor', 'active', 0, NULL, '2026-02-09 06:10:57', '2026-02-09 06:10:57'),
('7e14b177-c405-4631-9146-eaa5515ddcad', 'pat5', 'men', 'pat5@mail.com', '$2y$10$U1th5gEX3RBwPLHveezskeXnqYITEbWAaxgTBohmlxY1xKIMB30Oq', '123-456-789', 'patient', 'active', 0, NULL, '2026-02-08 18:19:24', '2026-02-16 03:19:25'),
('7f5d57b2-4b68-4f88-b355-7556abaf4867', 'Robert', 'Taylor', 'robert.taylor@mindtrack.com', '$2y$10$BCLqBgKhFiZAbxUqQkDdqezUSuZsX.RaYY8LLYnZWXJKts9045dp2', '09123456787', 'doctor', 'active', 0, NULL, '2026-02-09 06:10:57', '2026-02-09 06:10:57'),
('9193f4b9-b0d5-4284-8817-46d8a95eec16', 'Elena', 'Rodriguez', 'elena.r@example.com', '$2y$10$M1cfzbe7.oy/9guXvXMR2OpSfrxCNAVjMt6ZGIghm0BAkPdCjn01a', '(555) 444-5566', 'patient', 'active', 0, NULL, '2026-02-15 11:58:07', '2026-02-16 09:52:14'),
('9aba2cac-9d8e-4e9a-8f97-ad8026c7b36a', 'Michael', 'Chen', 'm.chen@example.com', '$2y$10$VGDFZZybVg7paUWjR32nPOmKKDZePgcnWyWuaMDsSpEUYtAqSkXlC', '(555) 222-3333', 'patient', 'active', 0, NULL, '2026-02-15 11:58:07', '2026-02-15 11:58:07'),
('a7a421af-e436-4496-8c12-d8dcc1ee530d', 'Admin', 'User', 'admin@mindtrack.com', '$2y$10$yToKFNcpsxdQw9kQY5mmwOSZC1JrmC3tlpCYRajmFJXWt3Os2yIuS', '1234567890', 'admin', 'active', 0, NULL, '2026-02-10 04:51:00', '2026-02-10 04:51:00'),
('a922ea38-3cb4-44e4-aacd-d7384773f660', 'Michael', 'Brown', 'michael.brown@mindtrack.com', '$2y$10$oUXMY6E37zOlO3ggDY7qUOHzKvNsAAGbN8mcPaja5whjiS1qr7Vqy', '09123456789', 'doctor', 'active', 0, NULL, '2026-02-09 06:10:57', '2026-02-09 06:10:57'),
('b3a7792c-1fc4-4528-9161-5d14f6f71d1c', 'Test', 'Patient', 'test.patient@example.com', '$2y$10$XfnbhYa6HWTwraAmSvePdOBGjZUjGLqyZfcSIVe4pQfWT4NhDwPt.', '5551234567', 'patient', 'active', 0, '92a420ae-e420-4c73-b390-4b596d7ec607', '2026-02-20 15:49:17', '2026-02-20 15:49:17'),
('b78dae2b-e2dd-45e9-a7d1-7be92d590acc', 'pat9', 'men', 'pat9@mail.com', '$2y$10$2f.Yll2gaWPetFWxiFeZSeHtRXsi7VM7faYsQTu1LmqaXEemf0kR.', NULL, 'patient', 'active', 1, NULL, '2026-02-20 15:12:49', '2026-02-20 15:19:32'),
('c00e118f-f060-4cf5-bfa5-ab1626415550', 'pat7', 'abong', 'pat7@mail.com', '$2y$10$OE32bXD7Z.WYN86fzVyCBuYlW9sIJS3kFrkWYckb9ZEMW4Jfk5efm', '123-456-789', 'patient', 'active', 1, NULL, '2026-02-09 03:23:50', '2026-02-20 14:47:27'),
('c130beb5-8f6c-4665-a4e3-73434b47fa01', 'James', 'Wilson', 'james.wilson@mindtrack.com', '$2y$10$LYcm43vBPc9J21JWbHZSBe62hCLjPBaWE6G.C0FI3GbFiBViUK2FK', '09123456781', 'doctor', 'active', 0, NULL, '2026-02-09 06:10:57', '2026-02-09 06:10:57'),
('c8997eaf-eaa2-4617-be3b-30e66d115185', 'carl3', 'abong', 'carl3@mail.com', '$2y$10$16C5OBw1H6jxmRvG1Mf8/ul2OeWoihNzbqKxJgB.mpz13cti4o4mq', NULL, 'doctor', 'active', 0, NULL, '2026-02-12 04:12:04', '2026-02-12 04:12:04'),
('cad19000-75b3-4758-a911-9d3d15d76337', 'John', 'Doe', 'test.user.10@example.com', '$2y$10$kAtzJbDNR8lr43IwIeQ6RuAuA4A.Qni.Jd//aCkrKeC.q1Lw9AF1C', '1234567890', 'patient', 'active', 1, NULL, '2026-02-20 14:52:20', '2026-02-20 15:17:05'),
('dfadf3bf-8dd2-4d95-98fd-b67dca0c0d00', 'Amanda', 'White', 'amanda.white@mindtrack.com', '$2y$10$kUMs5gwSxiLO7T85dx8YWebHMPoaboAeQCey3akBQNFCfO9v5bEF6', '09123456786', 'doctor', 'active', 0, NULL, '2026-02-09 06:10:57', '2026-02-09 06:10:57'),
('e115a3ad-8462-4015-9cbc-3bb7cfafa5c6', 'pat6', 'men', 'pat6@mail.com', '$2y$10$jgzcPrb0GIcVBdi9LIqCHOv4XUTnqzH9EctGyizwWDvGWhoRvQ61S', NULL, 'patient', 'active', 0, NULL, '2026-02-08 18:27:41', '2026-02-08 18:27:41'),
('f5c3f66b-f45b-4b15-9c9c-1e957e4504c3', 'Kevin', 'Park', 'kevin.park@mindtrack.com', '$2y$10$LT3ozeYfShKaoEvxDihzB.X07aOA0bFdHCGZV9dJHCznhS4iUu/Aa', '09123456783', 'doctor', 'active', 0, NULL, '2026-02-09 06:10:57', '2026-02-09 06:10:57'),
('fa90f878-2626-4c62-9074-37e8a2731b7c', 'Carl7', 'Abong', 'carl7@mail.com', '$2y$10$YDpJKzGNkHE9iRpUJafpV.OvBOizbCI6YmekzfYIqINj.EPzOh.Cm', '09353679542', 'doctor', 'active', 0, NULL, '2026-02-12 14:55:23', '2026-02-12 14:55:23');

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
  `availability` text DEFAULT NULL,
  `consultation_fee` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_doctor_info`
--

INSERT INTO `user_doctor_info` (`id`, `user_uuid`, `specialization_id`, `license_number`, `bio`, `availability`, `consultation_fee`) VALUES
(1, '1b39c42c-7c12-41e0-9c79-83116f666a77', 8, 'LIC-614E535B', NULL, '{\"monday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true,\"note\":\"Face-to-Face Consultations\"},\"tuesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true},\"wednesday\":{\"start\":\"00:00\",\"end\":\"00:00\",\"active\":false,\"note\":\"Closed \\/ Unavailable\"},\"thursday\":{\"start\":\"10:00\",\"end\":\"18:00\",\"active\":true},\"friday\":{\"start\":\"09:00\",\"end\":\"15:00\",\"active\":true},\"saturday\":{\"active\":false},\"sunday\":{\"active\":false}}', 1500.00),
(2, 'c130beb5-8f6c-4665-a4e3-73434b47fa01', 7, 'LIC-0496DF1F', NULL, '{\"monday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true,\"note\":\"Face-to-Face Consultations\"},\"tuesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true},\"wednesday\":{\"start\":\"00:00\",\"end\":\"00:00\",\"active\":false,\"note\":\"Closed \\/ Unavailable\"},\"thursday\":{\"start\":\"10:00\",\"end\":\"18:00\",\"active\":true},\"friday\":{\"start\":\"09:00\",\"end\":\"15:00\",\"active\":true},\"saturday\":{\"active\":false},\"sunday\":{\"active\":false}}', 2500.00),
(3, '74ee1977-38d0-47f3-8e14-a38c20ca251f', 8, 'LIC-4CAD1CF0', NULL, '{\"monday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true,\"note\":\"Face-to-Face Consultations\"},\"tuesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true},\"wednesday\":{\"start\":\"00:00\",\"end\":\"00:00\",\"active\":false,\"note\":\"Closed \\/ Unavailable\"},\"thursday\":{\"start\":\"10:00\",\"end\":\"18:00\",\"active\":true},\"friday\":{\"start\":\"09:00\",\"end\":\"15:00\",\"active\":true},\"saturday\":{\"active\":false},\"sunday\":{\"active\":false}}', 1200.00),
(4, 'f5c3f66b-f45b-4b15-9c9c-1e957e4504c3', 4, 'LIC-45B0FB2A', NULL, '{\"monday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true,\"note\":\"Face-to-Face Consultations\"},\"tuesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true},\"wednesday\":{\"start\":\"00:00\",\"end\":\"00:00\",\"active\":false,\"note\":\"Closed \\/ Unavailable\"},\"thursday\":{\"start\":\"10:00\",\"end\":\"18:00\",\"active\":true},\"friday\":{\"start\":\"09:00\",\"end\":\"15:00\",\"active\":true},\"saturday\":{\"active\":false},\"sunday\":{\"active\":false}}', 2000.00),
(5, '14825fe7-9077-46a7-8a08-9ea8842320cd', 4, 'LIC-35E4D8E0', NULL, '{\"monday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true,\"note\":\"Face-to-Face Consultations\"},\"tuesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true},\"wednesday\":{\"start\":\"00:00\",\"end\":\"00:00\",\"active\":false,\"note\":\"Closed \\/ Unavailable\"},\"thursday\":{\"start\":\"10:00\",\"end\":\"18:00\",\"active\":true},\"friday\":{\"start\":\"09:00\",\"end\":\"15:00\",\"active\":true},\"saturday\":{\"active\":false},\"sunday\":{\"active\":false}}', 1800.00),
(6, '12a72b38-3c78-44e1-a73c-d1fd9453e474', 6, 'LIC-28F9F532', NULL, '{\"monday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true,\"note\":\"Face-to-Face Consultations\"},\"tuesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true},\"wednesday\":{\"start\":\"00:00\",\"end\":\"00:00\",\"active\":false,\"note\":\"Closed \\/ Unavailable\"},\"thursday\":{\"start\":\"10:00\",\"end\":\"18:00\",\"active\":true},\"friday\":{\"start\":\"09:00\",\"end\":\"15:00\",\"active\":true},\"saturday\":{\"active\":false},\"sunday\":{\"active\":false}}', 2200.00),
(7, 'dfadf3bf-8dd2-4d95-98fd-b67dca0c0d00', 8, 'LIC-E3414CB9', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '{\"monday\":{\"start\":\"07:00\",\"end\":\"19:00\"},\"tuesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"wednesday\":{\"start\":\"08:00\",\"end\":\"18:00\",\"active\":\"1\"},\"thursday\":{\"start\":\"10:00\",\"end\":\"18:00\",\"active\":\"1\"},\"friday\":{\"start\":\"09:00\",\"end\":\"15:00\",\"active\":\"1\"},\"saturday\":{\"start\":\"09:00\",\"end\":\"17:00\"},\"sunday\":{\"start\":\"09:00\",\"end\":\"17:00\"}}', 1400.00),
(8, '7f5d57b2-4b68-4f88-b355-7556abaf4867', 1, 'LIC-F181451E', NULL, '{\"monday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true,\"note\":\"Face-to-Face Consultations\"},\"tuesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true},\"wednesday\":{\"start\":\"00:00\",\"end\":\"00:00\",\"active\":false,\"note\":\"Closed \\/ Unavailable\"},\"thursday\":{\"start\":\"10:00\",\"end\":\"18:00\",\"active\":true},\"friday\":{\"start\":\"09:00\",\"end\":\"15:00\",\"active\":true},\"saturday\":{\"active\":false},\"sunday\":{\"active\":false}}', 3000.00),
(9, '3ee0647d-71af-4743-ac69-d7bb9033818e', 2, 'LIC-ED684AE5', NULL, '{\"monday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true,\"note\":\"Face-to-Face Consultations\"},\"tuesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true},\"wednesday\":{\"start\":\"00:00\",\"end\":\"00:00\",\"active\":false,\"note\":\"Closed \\/ Unavailable\"},\"thursday\":{\"start\":\"10:00\",\"end\":\"18:00\",\"active\":true},\"friday\":{\"start\":\"09:00\",\"end\":\"15:00\",\"active\":true},\"saturday\":{\"active\":false},\"sunday\":{\"active\":false}}', 1600.00),
(10, 'a922ea38-3cb4-44e4-aacd-d7384773f660', 8, 'LIC-12F9548C', NULL, '{\"monday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true,\"note\":\"Face-to-Face Consultations\"},\"tuesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true},\"wednesday\":{\"start\":\"00:00\",\"end\":\"00:00\",\"active\":false,\"note\":\"Closed \\/ Unavailable\"},\"thursday\":{\"start\":\"10:00\",\"end\":\"18:00\",\"active\":true},\"friday\":{\"start\":\"09:00\",\"end\":\"15:00\",\"active\":true},\"saturday\":{\"active\":false},\"sunday\":{\"active\":false}}', 1900.00),
(16, '4a4cd105-75b1-4ea4-a25f-435e966aa8f2', 1, 'MD-12345', NULL, '{\"monday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true,\"note\":\"Face-to-Face Consultations\"},\"tuesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":true},\"wednesday\":{\"start\":\"00:00\",\"end\":\"00:00\",\"active\":false,\"note\":\"Closed \\/ Unavailable\"},\"thursday\":{\"start\":\"10:00\",\"end\":\"18:00\",\"active\":true},\"friday\":{\"start\":\"09:00\",\"end\":\"15:00\",\"active\":true},\"saturday\":{\"active\":false},\"sunday\":{\"active\":false}}', 200.00),
(19, 'c8997eaf-eaa2-4617-be3b-30e66d115185', 8, NULL, NULL, '{\"monday\":{\"start\":\"09:00\",\"end\":\"17:00\"},\"tuesday\":{\"start\":\"09:00\",\"end\":\"17:00\"},\"wednesday\":{\"start\":\"09:00\",\"end\":\"17:00\"},\"thursday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"friday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"saturday\":{\"start\":\"09:00\",\"end\":\"17:00\"},\"sunday\":{\"start\":\"09:00\",\"end\":\"17:00\"}}', NULL),
(22, '0879151b-c48b-47db-b4f0-d170d8935a1b', 3, NULL, NULL, '{\"monday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"tuesday\":{\"start\":\"09:00\",\"end\":\"17:00\"},\"wednesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"thursday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"friday\":{\"start\":\"09:00\",\"end\":\"17:00\"},\"saturday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"sunday\":{\"start\":\"09:00\",\"end\":\"17:00\"}}', NULL),
(33, 'fa90f878-2626-4c62-9074-37e8a2731b7c', 1, 'MD-12345678', NULL, '{\"monday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"tuesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"wednesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"thursday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"friday\":{\"start\":\"09:00\",\"end\":\"17:00\"},\"saturday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"sunday\":{\"start\":\"09:00\",\"end\":\"17:00\"}}', NULL),
(36, '61702d1b-e347-4fbf-9990-4207762f65ef', 8, 'MD-123456789', NULL, '{\"monday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"tuesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"wednesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"thursday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"friday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"saturday\":{\"start\":\"09:00\",\"end\":\"17:00\"},\"sunday\":{\"start\":\"09:00\",\"end\":\"17:00\"}}', NULL),
(38, '4e5e90c0-1bba-4b38-83d1-b822ee05d564', 12, '98765', NULL, '{\"monday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"tuesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"wednesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"thursday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"friday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"saturday\":{\"start\":\"09:00\",\"end\":\"17:00\"},\"sunday\":{\"start\":\"09:00\",\"end\":\"17:00\"}}', NULL),
(39, '3e4974b2-4f7c-4af3-963f-3bc88747f42e', 1, NULL, NULL, '{\"monday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"tuesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"wednesday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"thursday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"friday\":{\"start\":\"09:00\",\"end\":\"17:00\",\"active\":\"1\"},\"saturday\":{\"start\":\"09:00\",\"end\":\"17:00\"},\"sunday\":{\"start\":\"09:00\",\"end\":\"17:00\"}}', NULL);

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
-- Dumping data for table `user_patient_info`
--

INSERT INTO `user_patient_info` (`id`, `user_uuid`, `date_of_birth`, `gender`, `address`, `emergency_contact_name`, `emergency_contact_phone`, `medical_history`) VALUES
(18, '03d62498-1062-4221-9c79-abd797a02d32', NULL, NULL, NULL, NULL, NULL, '{\"conditions\":\"\",\"allergies\":\"\",\"alerts\":[\"critical\"]}'),
(21, '698e9399-ec7b-4588-a59d-a192ef9c7a8b', NULL, NULL, NULL, NULL, NULL, NULL),
(26, '7e14b177-c405-4631-9146-eaa5515ddcad', '2026-02-19', 'male', 'N/A', 'carl robes abong', '123-456-789', '{\"conditions\":\"Nigga\",\"allergies\":\"White\",\"alerts\":[\"critical\"]}'),
(35, 'e115a3ad-8462-4015-9cbc-3bb7cfafa5c6', NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'c00e118f-f060-4cf5-bfa5-ab1626415550', '2026-02-18', 'male', 'N/A', 'abong', '123-456-789', NULL),
(66, '1467959f-c473-49ad-84ce-1b5656012873', NULL, NULL, NULL, NULL, NULL, NULL),
(77, '1405ee52-bf65-4f06-b94b-ef77ea9c71c3', NULL, NULL, NULL, NULL, NULL, '{\"conditions\":\"\",\"allergies\":\"\",\"alerts\":[\"critical\"]}'),
(78, '0e222c36-e75d-450f-bddc-c477071fec94', '1990-05-15', 'female', '123 Willow Lane, Springfield', 'John Jenkins', '(555) 987-6543', '{\"conditions\":\"Asthma\",\"allergies\":\"Peanuts\",\"alerts\":[\"critical\",\"warning\"]}'),
(79, '9aba2cac-9d8e-4e9a-8f97-ad8026c7b36a', '1985-11-20', 'male', '456 Oak St, Riverside', 'Linda Chen', '(555) 444-5555', '{\"conditions\":\"Hypertension\",\"allergies\":\"Penicillin\",\"alerts\":[\"warning\"]}'),
(80, '9193f4b9-b0d5-4284-8817-46d8a95eec16', '1995-02-10', 'female', '789 Pine Ave, Mountain View', 'Carlos Rodriguez', '(555) 666-7777', '{\"conditions\":\"None\",\"allergies\":\"None\",\"alerts\":[\"success\"]}'),
(125, '6393ab9a-c24c-4be2-b34a-d4233c92bfa9', NULL, NULL, NULL, NULL, NULL, NULL),
(126, 'cad19000-75b3-4758-a911-9d3d15d76337', NULL, NULL, NULL, NULL, NULL, NULL),
(127, 'b78dae2b-e2dd-45e9-a7d1-7be92d590acc', NULL, NULL, NULL, NULL, NULL, NULL),
(128, '4e45083b-478e-467e-b4f3-86011255848f', NULL, NULL, NULL, NULL, NULL, NULL),
(144, 'b3a7792c-1fc4-4528-9161-5d14f6f71d1c', NULL, NULL, NULL, NULL, NULL, NULL),
(145, '5e322731-c009-4c77-9eda-06ac88edfe25', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_appointments_datatable`
-- (See below for the actual view)
--
CREATE TABLE `vw_appointments_datatable` (
`uuid` char(36)
,`patient_uuid` char(36)
,`doctor_uuid` char(36)
,`service_uuid` char(36)
,`sched_date` date
,`sched_time` time
,`status` enum('pending','confirmed','completed','cancelled','no_show','rescheduled')
,`notes` text
,`created_at` timestamp
,`service_name` varchar(255)
,`doctor_name` varchar(511)
,`patient_name` varchar(511)
,`patient_email` varchar(255)
,`patient_firstname` varchar(255)
,`doctor_firstname` varchar(255)
,`doctor_lastname` varchar(255)
,`service_duration` int(11)
);

-- --------------------------------------------------------

--
-- Structure for view `vw_appointments_datatable`
--
DROP TABLE IF EXISTS `vw_appointments_datatable`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_appointments_datatable`  AS SELECT `a`.`uuid` AS `uuid`, `a`.`patient_uuid` AS `patient_uuid`, `a`.`doctor_uuid` AS `doctor_uuid`, `a`.`service_uuid` AS `service_uuid`, `a`.`sched_date` AS `sched_date`, `a`.`sched_time` AS `sched_time`, `a`.`status` AS `status`, `a`.`notes` AS `notes`, `a`.`created_at` AS `created_at`, `s`.`name` AS `service_name`, concat(`u`.`firstname`,' ',`u`.`lastname`) AS `doctor_name`, concat(`p`.`firstname`,' ',`p`.`lastname`) AS `patient_name`, `p`.`email` AS `patient_email`, `p`.`firstname` AS `patient_firstname`, `u`.`firstname` AS `doctor_firstname`, `u`.`lastname` AS `doctor_lastname`, `s`.`duration` AS `service_duration` FROM (((`appointments` `a` left join `services` `s` on(`a`.`service_uuid` = `s`.`uuid`)) left join `users` `u` on(`a`.`doctor_uuid` = `u`.`uuid`)) left join `users` `p` on(`a`.`patient_uuid` = `p`.`uuid`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `patient_uuid` (`patient_uuid`),
  ADD KEY `doctor_uuid` (`doctor_uuid`),
  ADD KEY `service_uuid` (`service_uuid`);

--
-- Indexes for table `attachments`
--
ALTER TABLE `attachments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reference_lookup` (`reference_model`,`reference_uuid`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clinical_notes`
--
ALTER TABLE `clinical_notes`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `appointment_uuid` (`appointment_uuid`),
  ADD KEY `doctor_uuid` (`doctor_uuid`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_read_lookup` (`user_uuid`,`is_read`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`uuid`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `specialization_id` (`specialization_id`);

--
-- Indexes for table `specializations`
--
ALTER TABLE `specializations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_doctor_info`
--
ALTER TABLE `user_doctor_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_uuid` (`user_uuid`),
  ADD KEY `specialization_id` (`specialization_id`);

--
-- Indexes for table `user_patient_info`
--
ALTER TABLE `user_patient_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_uuid` (`user_uuid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attachments`
--
ALTER TABLE `attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `specializations`
--
ALTER TABLE `specializations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_doctor_info`
--
ALTER TABLE `user_doctor_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user_patient_info`
--
ALTER TABLE `user_patient_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `fk_appt_doctor` FOREIGN KEY (`doctor_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_appt_patient` FOREIGN KEY (`patient_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE,
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

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `fk_service_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_service_specialization` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_doctor_info`
--
ALTER TABLE `user_doctor_info`
  ADD CONSTRAINT `fk_doctor_specialization` FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_doctor_user` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE;

--
-- Constraints for table `user_patient_info`
--
ALTER TABLE `user_patient_info`
  ADD CONSTRAINT `fk_patient_user` FOREIGN KEY (`user_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
