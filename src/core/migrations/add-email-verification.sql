ALTER TABLE users
  ADD COLUMN is_email_verified TINYINT(1) NOT NULL DEFAULT 0 AFTER status,
  ADD COLUMN email_verification_token VARCHAR(36) NULL AFTER is_email_verified;
