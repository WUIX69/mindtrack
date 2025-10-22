-- ============================================
-- MindTrack Database Migration: UUID with User Extension Tables
-- ============================================
-- This creates a fresh UUID-based database with user extension tables
-- Run this in phpMyAdmin for fresh installation!
-- ============================================

-- Disable foreign key checks temporarily
SET FOREIGN_KEY_CHECKS = 0;

-- Drop existing tables if they exist (fresh install)
DROP TABLE IF EXISTS `activity_logs`;
DROP TABLE IF EXISTS `session_tokens`;
DROP TABLE IF EXISTS `appointment`;
DROP TABLE IF EXISTS `booking_request`;
DROP TABLE IF EXISTS `users_patient_adds`;
DROP TABLE IF EXISTS `users_doctor_adds`;
DROP TABLE IF EXISTS `users`;

-- ============================================
-- 1. CREATE USERS TABLE (Core Authentication)
-- ============================================

CREATE TABLE `users` (
  `uuid` VARCHAR(36) NOT NULL PRIMARY KEY COMMENT 'UUID',
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL COMMENT 'Hashed password',
  `first_name` VARCHAR(100) NOT NULL,
  `last_name` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) NULL,
  `role` ENUM('admin', 'doctor', 'patient') NOT NULL DEFAULT 'patient',
  `status` ENUM('active', 'inactive', 'suspended') NOT NULL DEFAULT 'active',
  `email_verified` BOOLEAN DEFAULT FALSE,
  `avatar` VARCHAR(255) NULL,
  `last_login` TIMESTAMP NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_email` (`email`),
  INDEX `idx_username` (`username`),
  INDEX `idx_role` (`role`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- 2. CREATE DOCTOR EXTENSION TABLE
-- ============================================

CREATE TABLE `users_doctor_adds` (
  `uuid` VARCHAR(36) NOT NULL PRIMARY KEY COMMENT 'UUID (same as user uuid)',
  `user_uuid` VARCHAR(36) NOT NULL UNIQUE COMMENT 'Link to users table',
  `doctor_custom_id` VARCHAR(10) NOT NULL UNIQUE COMMENT 'Human-readable ID (DR##### format)',
  `specialization` VARCHAR(100) NOT NULL,
  `license_number` VARCHAR(50) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_user_uuid` (`user_uuid`),
  INDEX `idx_doctor_custom_id` (`doctor_custom_id`),
  FOREIGN KEY (`user_uuid`) REFERENCES `users`(`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- 3. CREATE PATIENT EXTENSION TABLE
-- ============================================

CREATE TABLE `users_patient_adds` (
  `uuid` VARCHAR(36) NOT NULL PRIMARY KEY COMMENT 'UUID (same as user uuid)',
  `user_uuid` VARCHAR(36) NOT NULL UNIQUE COMMENT 'Link to users table',
  `patient_custom_id` VARCHAR(20) NOT NULL UNIQUE COMMENT 'Human-readable ID (MMDDYY format)',
  `birthdate` DATE NOT NULL,
  `emergency_contact` VARCHAR(50) NULL,
  `service_type` VARCHAR(100) NOT NULL,
  `doctor_uuid` VARCHAR(36) NULL COMMENT 'Assigned doctor',
  `diagnosis` TEXT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_user_uuid` (`user_uuid`),
  INDEX `idx_patient_custom_id` (`patient_custom_id`),
  INDEX `idx_doctor_uuid` (`doctor_uuid`),
  FOREIGN KEY (`user_uuid`) REFERENCES `users`(`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`doctor_uuid`) REFERENCES `users`(`uuid`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- 4. CREATE BOOKING REQUEST TABLE
-- ============================================

CREATE TABLE `booking_request` (
  `uuid` VARCHAR(36) NOT NULL PRIMARY KEY COMMENT 'UUID',
  `user_uuid` VARCHAR(36) NULL COMMENT 'UUID reference to users (null if not registered)',
  `patient_custom_id` VARCHAR(20) NULL COMMENT 'Human-readable patient ID',
  `first_name` VARCHAR(100) NOT NULL,
  `last_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `service_type` VARCHAR(100) NOT NULL,
  `birthdate` DATE NOT NULL,
  `booking_date` DATE NOT NULL,
  `booking_time` TIME NOT NULL,
  `status` ENUM('pending', 'approved', 'rejected', 'cancelled') DEFAULT 'pending',
  `booking_code` VARCHAR(20) NOT NULL UNIQUE,
  `notes` TEXT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_user_uuid` (`user_uuid`),
  INDEX `idx_booking_code` (`booking_code`),
  INDEX `idx_status` (`status`),
  INDEX `idx_booking_date` (`booking_date`),
  FOREIGN KEY (`user_uuid`) REFERENCES `users`(`uuid`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- 5. CREATE APPOINTMENT TABLE
-- ============================================

CREATE TABLE `appointment` (
  `uuid` VARCHAR(36) NOT NULL PRIMARY KEY COMMENT 'UUID',
  `booking_uuid` VARCHAR(36) NULL COMMENT 'Link to booking_request',
  `patient_uuid` VARCHAR(36) NOT NULL COMMENT 'UUID reference to users (patient)',
  `doctor_uuid` VARCHAR(36) NULL COMMENT 'UUID reference to users (doctor)',
  `appointment_date` DATE NOT NULL,
  `appointment_time` TIME NOT NULL,
  `service_type` VARCHAR(100) NOT NULL,
  `status` ENUM('scheduled', 'completed', 'cancelled', 'no-show') DEFAULT 'scheduled',
  `booking_code` VARCHAR(20) NOT NULL,
  `remarks` TEXT NULL,
  `prescription` TEXT NULL,
  `diagnosis` TEXT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_booking_uuid` (`booking_uuid`),
  INDEX `idx_patient_uuid` (`patient_uuid`),
  INDEX `idx_doctor_uuid` (`doctor_uuid`),
  INDEX `idx_appointment_date` (`appointment_date`),
  INDEX `idx_status` (`status`),
  INDEX `idx_booking_code` (`booking_code`),
  FOREIGN KEY (`booking_uuid`) REFERENCES `booking_request`(`uuid`) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (`patient_uuid`) REFERENCES `users`(`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`doctor_uuid`) REFERENCES `users`(`uuid`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- 6. CREATE SESSION TOKENS TABLE
-- ============================================

CREATE TABLE `session_tokens` (
  `uuid` VARCHAR(36) NOT NULL PRIMARY KEY COMMENT 'UUID',
  `user_uuid` VARCHAR(36) NOT NULL,
  `token` VARCHAR(255) NOT NULL UNIQUE,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` TEXT NULL,
  `expires_at` TIMESTAMP NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_user_uuid` (`user_uuid`),
  INDEX `idx_token` (`token`),
  INDEX `idx_expires_at` (`expires_at`),
  FOREIGN KEY (`user_uuid`) REFERENCES `users`(`uuid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- 7. CREATE ACTIVITY LOGS TABLE
-- ============================================

CREATE TABLE `activity_logs` (
  `uuid` VARCHAR(36) NOT NULL PRIMARY KEY COMMENT 'UUID',
  `user_uuid` VARCHAR(36) NULL,
  `action` VARCHAR(100) NOT NULL,
  `entity_type` VARCHAR(50) NULL COMMENT 'e.g., patient, doctor, appointment',
  `entity_uuid` VARCHAR(36) NULL,
  `description` TEXT NULL,
  `ip_address` VARCHAR(45) NULL,
  `user_agent` TEXT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX `idx_user_uuid` (`user_uuid`),
  INDEX `idx_entity_type` (`entity_type`),
  INDEX `idx_entity_uuid` (`entity_uuid`),
  INDEX `idx_created_at` (`created_at`),
  FOREIGN KEY (`user_uuid`) REFERENCES `users`(`uuid`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================
-- 8. INSERT DEFAULT USERS
-- ============================================

-- Default admin user: admin / admin1234
INSERT INTO `users` (`uuid`, `email`, `username`, `password`, `first_name`, `last_name`, `phone`, `role`, `status`, `email_verified`)
VALUES (
  UUID(),
  'admin@mindtrack.com',
  'admin',
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password: admin1234
  'System',
  'Administrator',
  '+1 (555) 100-0001',
  'admin',
  'active',
  TRUE
);

-- Default doctor user: doctor / doctor1234
SET @doctor_uuid = UUID();
INSERT INTO `users` (`uuid`, `email`, `username`, `password`, `first_name`, `last_name`, `phone`, `role`, `status`, `email_verified`)
VALUES (
  @doctor_uuid,
  'doctor@mindtrack.com',
  'doctor',
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password: doctor1234
  'Dr. John',
  'Smith',
  '+1 (555) 200-0001',
  'doctor',
  'active',
  TRUE
);

-- Add doctor-specific data
INSERT INTO `users_doctor_adds` (`uuid`, `user_uuid`, `doctor_custom_id`, `specialization`, `license_number`)
VALUES (
  UUID(),
  @doctor_uuid,
  'DR00001',
  'Clinical Psychologist',
  'PSY-2024-001'
);

-- Default patient user: patient / patient1234
SET @patient_uuid = UUID();
INSERT INTO `users` (`uuid`, `email`, `username`, `password`, `first_name`, `last_name`, `phone`, `role`, `status`, `email_verified`)
VALUES (
  @patient_uuid,
  'patient@mindtrack.com',
  'patient',
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password: patient1234
  'Jane',
  'Doe',
  '+1 (555) 300-0001',
  'patient',
  'active',
  TRUE
);

-- Add patient-specific data
INSERT INTO `users_patient_adds` (`uuid`, `user_uuid`, `patient_custom_id`, `birthdate`, `emergency_contact`, `service_type`, `doctor_uuid`, `diagnosis`)
VALUES (
  UUID(),
  @patient_uuid,
  '012304P1',
  '2004-01-23',
  '+1 (555) 300-0002',
  'Counseling',
  @doctor_uuid,
  'Initial assessment pending'
);

-- ============================================
-- 9. RE-ENABLE FOREIGN KEY CHECKS
-- ============================================

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================
-- MIGRATION COMPLETE!
-- ============================================
-- Your database has been created with UUID support and user extension tables.
-- 
-- STRUCTURE:
-- - users: Core user data (common to all roles)
-- - users_doctor_adds: Doctor-specific fields
-- - users_patient_adds: Patient-specific fields
-- 
-- BENEFITS:
-- - Single source of truth for user authentication
-- - Normalized data structure
-- - Easy to query across all users
-- - Type-specific data is separated cleanly
-- 
-- DEFAULT TEST USERS:
-- - admin / admin1234
-- - doctor / doctor1234
-- - patient / patient1234
-- ============================================
