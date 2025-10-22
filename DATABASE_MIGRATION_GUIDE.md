# Database Migration Guide - UUID Conversion

## 📋 Overview

This guide will help you migrate your MindTrack database from auto-increment IDs to UUID-based primary keys.

**Migration Date:** October 22, 2025  
**Database:** mindtrack  
**Migration Version:** 001_convert_to_uuid

---

## ⚠️ IMPORTANT: Before You Start

### 1. **Backup Your Database**

```sql
-- In phpMyAdmin, go to Export tab and download a complete backup
-- OR use command line:
mysqldump -u root -p mindtrack > mindtrack_backup_$(date +%Y%m%d_%H%M%S).sql
```

### 2. **Stop All Running Applications**

- Stop Apache/XAMPP
- Close all MindTrack browser windows
- Make sure no active sessions are running

### 3. **Test Migration on Development First**

- Never run migrations directly on production
- Test on a local copy first
- Verify all functionality works after migration

---

## 🚀 Migration Steps

### Step 1: Access phpMyAdmin

1. Open your browser
2. Go to: `http://localhost/phpmyadmin`
3. Login with your MySQL credentials (usually `root` with no password for XAMPP)
4. Select the `mindtrack` database from the left sidebar

### Step 2: Run the Migration Script

1. Click on the **SQL** tab at the top
2. Open the migration file: `core/migrations/001_convert_to_uuid.sql`
3. Copy the entire contents
4. Paste into the SQL query box in phpMyAdmin
5. Click **Go** button

**Expected Output:**

```
✓ Tables backed up successfully
✓ Old tables dropped
✓ New UUID-based tables created
✓ Users table created with default users
✓ Session tokens table created
✓ Activity logs table created
```

### Step 3: Verify Migration

Run these verification queries in phpMyAdmin:

```sql
-- Check if users table exists and has data
SELECT * FROM users;

-- Expected: 3 default users (admin, doctor, patient)

-- Check tables structure
SHOW TABLES;

-- Expected tables:
-- users
-- patients
-- doctors
-- appointment
-- booking_request
-- session_tokens
-- activity_logs
-- patients_backup (backup table)
-- doctors_backup (backup table)
-- appointment_backup (backup table)
-- booking_request_backup (backup table)

-- Verify UUID format in users table
SELECT id, username, email, role FROM users;

-- Expected: IDs should be in UUID format (e.g., 'a1b2c3d4-e5f6-7890-abcd-ef1234567890')
```

### Step 4: Update Application Configuration

The migration is complete! The application code has already been updated to work with UUIDs.

**Changes Made in Code:**

- ✅ `models/users.php` - Updated to use UUID primary keys
- ✅ `utils/uuid.php` - New UUID helper functions
- ✅ `features/auth/servers/login.php` - Uses new Users model
- ✅ `features/auth/servers/register.php` - Generates UUIDs for new users
- ✅ `core/app.php` - Loads UUID utilities

---

## 🧪 Testing

### Test 1: Login with Default Users

Try logging in with these credentials:

**Admin:**

- Username: `admin`
- Password: `admin1234`
- Expected: Redirects to `/app/patients/`

**Doctor:**

- Username: `doctor`
- Password: `doctor1234`
- Expected: Redirects to `/app/doctors/`

**Patient:**

- Username: `patient`
- Password: `patient1234`
- Expected: Redirects to `/app/patients/`

### Test 2: User Registration

1. Go to: `http://localhost/mindtrack/app/auth/register.php`
2. Fill in the registration form
3. Submit
4. Expected: Auto-login and redirect to dashboard

### Test 3: Verify UUID in Database

```sql
-- Check newly registered user
SELECT id, username, email FROM users ORDER BY created_at DESC LIMIT 1;

-- ID should be a valid UUID (36 characters with dashes)
```

---

## 📊 Database Schema Changes

### Before Migration (Old Schema)

```sql
-- OLD: Auto-increment IDs
CREATE TABLE users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  ...
);
```

### After Migration (New Schema)

```sql
-- NEW: UUID Primary Keys
CREATE TABLE users (
  id VARCHAR(36) NOT NULL COMMENT 'UUID',
  ...
  PRIMARY KEY (id)
);
```

### New Tables Added

1. **users** - Authentication table for all users

   - Replaces separate authentication logic
   - Unified user management
   - Password hashing with bcrypt

2. **session_tokens** - Session management

   - Tracks user sessions
   - IP address and user agent logging
   - Token expiration

3. **activity_logs** - Audit trail
   - Logs all user actions
   - Entity tracking (patient, doctor, appointment)
   - Full audit history

### Updated Tables

1. **patients**

   - `id` changed from `INT AUTO_INCREMENT` to `VARCHAR(36)` UUID
   - Added `user_id` foreign key to `users` table
   - `doctor` changed to `doctor_id` UUID foreign key
   - Kept `patient_custom_id` for human-readable IDs

2. **doctors**

   - `id` changed from `INT AUTO_INCREMENT` to `VARCHAR(36)` UUID
   - Added `user_id` foreign key to `users` table
   - Kept `doctor_custom_id` for human-readable IDs

3. **appointment**

   - `appointment_id` renamed to `id` and changed to UUID
   - All foreign keys updated to UUID references

4. **booking_request**
   - `booking_id` renamed to `id` and changed to UUID
   - All foreign keys updated to UUID references

---

## 🔄 Rollback Procedure

If you need to rollback the migration:

### Option 1: Restore from Backup

```sql
-- In phpMyAdmin SQL tab:
DROP DATABASE mindtrack;
CREATE DATABASE mindtrack;

-- Then import your backup file via Import tab
```

### Option 2: Use Backup Tables

```sql
-- Restore from backup tables created during migration
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS patients;
DROP TABLE IF EXISTS doctors;
DROP TABLE IF EXISTS appointment;
DROP TABLE IF EXISTS booking_request;

CREATE TABLE patients LIKE patients_backup;
INSERT INTO patients SELECT * FROM patients_backup;

CREATE TABLE doctors LIKE doctors_backup;
INSERT INTO doctors SELECT * FROM doctors_backup;

CREATE TABLE appointment LIKE appointment_backup;
INSERT INTO appointment SELECT * FROM appointment_backup;

CREATE TABLE booking_request LIKE booking_request_backup;
INSERT INTO booking_request SELECT * FROM booking_request_backup;

SET FOREIGN_KEY_CHECKS = 1;
```

---

## 🗑️ Cleanup (After Successful Migration)

Once you've verified everything works correctly, you can remove backup tables:

```sql
-- Remove backup tables (DO THIS ONLY AFTER THOROUGH TESTING!)
DROP TABLE IF EXISTS patients_backup;
DROP TABLE IF EXISTS doctors_backup;
DROP TABLE IF EXISTS appointment_backup;
DROP TABLE IF EXISTS booking_request_backup;
```

---

## 🔧 Troubleshooting

### Issue 1: Foreign Key Constraint Errors

**Error:** `Cannot add or update a child row: a foreign key constraint fails`

**Solution:**

```sql
-- Temporarily disable foreign key checks
SET FOREIGN_KEY_CHECKS = 0;

-- Run your query

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;
```

### Issue 2: Table Already Exists

**Error:** `Table 'users' already exists`

**Solution:**

```sql
-- Drop the table first
DROP TABLE IF EXISTS users;

-- Then re-run the migration
```

### Issue 3: Invalid UUID Format

**Error:** UUIDs appear as empty or invalid

**Solution:**

- Make sure `ramsey/uuid` package is installed
- Run: `composer require ramsey/uuid`
- Check that `utils/uuid.php` is loaded in `core/app.php`

### Issue 4: Login Not Working After Migration

**Solution:**

1. Clear browser cookies and cache
2. Clear PHP sessions:

```php
// In browser console or create temp file:
<?php
session_start();
session_destroy();
?>
```

3. Verify users table has default users:

```sql
SELECT * FROM users WHERE username IN ('admin', 'doctor', 'patient');
```

---

## 📝 Post-Migration Checklist

- [ ] Database migration completed successfully
- [ ] Default users can login (admin, doctor, patient)
- [ ] New user registration works
- [ ] UUIDs are being generated correctly
- [ ] All foreign key relationships work
- [ ] Patient registration works
- [ ] Doctor registration works
- [ ] Appointment booking works
- [ ] No PHP errors in `logs/error.log`
- [ ] Backup tables can be safely deleted

---

## 🎯 Benefits of UUID Migration

### 1. **Global Uniqueness**

- IDs are unique across all tables and databases
- No collision risk when merging data
- Safe for distributed systems

### 2. **Security**

- Harder to guess next ID
- No sequential ID enumeration attacks
- Better privacy protection

### 3. **Scalability**

- Generate IDs before database insert
- Easier database sharding
- Better for microservices architecture

### 4. **Data Portability**

- Easy to merge databases
- Safe replication
- Import/export without ID conflicts

### 5. **Modern Best Practice**

- Industry standard for new applications
- Compatible with modern frameworks
- Better for API integration

---

## 📚 Additional Resources

- **UUID RFC:** https://tools.ietf.org/html/rfc4122
- **Ramsey UUID Docs:** https://github.com/ramsey/uuid
- **PDO Documentation:** https://www.php.net/manual/en/book.pdo.php
- **MySQL UUID Functions:** https://dev.mysql.com/doc/refman/8.0/en/miscellaneous-functions.html#function_uuid

---

## ✅ Migration Complete!

Your MindTrack database is now using UUID-based primary keys! 🎉

**Next Steps:**

1. Test all features thoroughly
2. Monitor error logs for any issues
3. Once stable, delete backup tables
4. Update any external integrations to use UUIDs

If you encounter any issues, refer to the troubleshooting section or restore from backup.

---

**Version:** 1.0  
**Last Updated:** October 22, 2025  
**Maintained by:** MindTrack Development Team
