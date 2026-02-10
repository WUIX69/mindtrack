-- Add 'rescheduled' to appointments status enum
ALTER TABLE `appointments` 
MODIFY COLUMN `status` ENUM('pending','confirmed','completed','cancelled','no_show','rescheduled') NOT NULL DEFAULT 'pending';
