-- ============================================
-- Add Lab Results Table
-- ============================================

CREATE TABLE IF NOT EXISTS `lab_results` (
  `uuid` VARCHAR(36) NOT NULL PRIMARY KEY COMMENT 'UUID',
  `patient_uuid` VARCHAR(36) NOT NULL COMMENT 'UUID reference to users (patient)',
  `doctor_uuid` VARCHAR(36) NULL COMMENT 'UUID reference to users (doctor who ordered)',
  `appointment_uuid` VARCHAR(36) NULL COMMENT 'Link to appointment if applicable',
  `test_name` VARCHAR(200) NOT NULL COMMENT 'Name of the test/examination',
  `test_type` VARCHAR(100) NOT NULL COMMENT 'Category: Blood Test, X-Ray, MRI, etc.',
  `test_date` DATE NOT NULL COMMENT 'Date when test was conducted',
  `result_status` ENUM('pending', 'completed', 'reviewed') DEFAULT 'pending',
  `result_summary` TEXT NULL COMMENT 'Brief summary of results',
  `detailed_results` TEXT NULL COMMENT 'Detailed test results',
  `findings` TEXT NULL COMMENT 'Medical findings and interpretation',
  `recommendations` TEXT NULL COMMENT 'Recommendations based on results',
  `reference_values` TEXT NULL COMMENT 'Normal range/reference values',
  `attachments` TEXT NULL COMMENT 'JSON array of file paths for PDFs, images, etc.',
  `notes` TEXT NULL COMMENT 'Additional notes',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_patient_uuid` (`patient_uuid`),
  INDEX `idx_doctor_uuid` (`doctor_uuid`),
  INDEX `idx_appointment_uuid` (`appointment_uuid`),
  INDEX `idx_test_date` (`test_date`),
  INDEX `idx_result_status` (`result_status`),
  FOREIGN KEY (`patient_uuid`) REFERENCES `users`(`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`doctor_uuid`) REFERENCES `users`(`uuid`) ON DELETE SET NULL ON UPDATE CASCADE,
  FOREIGN KEY (`appointment_uuid`) REFERENCES `appointment`(`uuid`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

