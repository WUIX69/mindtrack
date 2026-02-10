-- 1. Create specializations table
CREATE TABLE `specializations` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `status` ENUM('active','inactive') NOT NULL DEFAULT 'active',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP() ON UPDATE CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2. Seed specializations (mental health context)
INSERT INTO `specializations` (`name`, `description`) VALUES
  ('Clinical Psychology', 'Diagnosis and treatment of mental disorders'),
  ('Counseling Psychology', 'Guidance for emotional and behavioral issues'),
  ('Child & Adolescent Psychology', 'Mental health care for children and teens'),
  ('Neuropsychology', 'Brain-behavior relationships and cognitive assessment'),
  ('Forensic Psychology', 'Psychology applied to legal and criminal contexts'),
  ('Health Psychology', 'Behavioral factors in physical health and illness'),
  ('Industrial-Organizational Psychology', 'Workplace behavior and organizational wellness'),
  ('General Psychologist', 'Broad-spectrum psychological assessment and care');

-- 3. Add specialization_id to services
ALTER TABLE `services`
  ADD COLUMN `specialization_id` INT(11) DEFAULT NULL AFTER `duration`,
  ADD KEY `specialization_id` (`specialization_id`),
  ADD CONSTRAINT `fk_service_specialization`
    FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`)
    ON DELETE SET NULL;

-- 4. Add specialization_id to user_doctor_info
ALTER TABLE `user_doctor_info`
  ADD COLUMN `specialization_id` INT(11) DEFAULT NULL AFTER `user_uuid`,
  ADD KEY `specialization_id` (`specialization_id`),
  ADD CONSTRAINT `fk_doctor_specialization`
    FOREIGN KEY (`specialization_id`) REFERENCES `specializations` (`id`)
    ON DELETE SET NULL;

-- Migrate existing text -> ID (best-effort match)
UPDATE `user_doctor_info` di
  JOIN `specializations` s ON s.name = di.specialization
  SET di.specialization_id = s.id;

-- Drop old text column
ALTER TABLE `user_doctor_info` DROP COLUMN `specialization`;
