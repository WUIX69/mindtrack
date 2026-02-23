-- Migration: Update clinical_notes table to use SOAP format and add patient_uuid

-- First, drop the old columns that don't match the new model
ALTER TABLE `clinical_notes` 
  DROP COLUMN `diagnosis`,
  DROP COLUMN `prescription`,
  DROP COLUMN `private_notes`;

-- Add the new columns (SOAP format, status, and patient_uuid)
ALTER TABLE `clinical_notes`
  ADD COLUMN `patient_uuid` CHAR(36) NOT NULL AFTER `uuid`,
  ADD COLUMN `subjective` TEXT DEFAULT NULL AFTER `doctor_uuid`,
  ADD COLUMN `objective` TEXT DEFAULT NULL AFTER `subjective`,
  ADD COLUMN `assessment` TEXT DEFAULT NULL AFTER `objective`,
  ADD COLUMN `plan` TEXT DEFAULT NULL AFTER `assessment`,
  ADD COLUMN `status` ENUM('draft', 'signed') NOT NULL DEFAULT 'draft' AFTER `plan`;

-- Add foreign key constraint for patient_uuid
ALTER TABLE `clinical_notes`
  ADD CONSTRAINT `fk_notes_patient` FOREIGN KEY (`patient_uuid`) REFERENCES `users` (`uuid`) ON DELETE CASCADE;

-- Also add index for patient_uuid for faster lookups
ALTER TABLE `clinical_notes`
  ADD INDEX `patient_uuid_idx` (`patient_uuid`);
