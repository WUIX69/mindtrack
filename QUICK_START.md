# 🚀 Quick Start Guide - UUID Migration & Registration

## ⚡ 3-Step Setup

### Step 1: Backup Your Database (30 seconds)

1. Open phpMyAdmin: `http://localhost/phpmyadmin`
2. Click on `mindtrack` database
3. Click **Export** tab
4. Click **Go** button
5. Save the `.sql` file (e.g., `mindtrack_backup.sql`)

✅ **Backup complete!** You can restore if anything goes wrong.

---

### Step 2: Run Migration (1 minute)

1. In phpMyAdmin, make sure `mindtrack` database is selected
2. Click **SQL** tab at the top
3. Open this file on your computer: `core/migrations/001_convert_to_uuid.sql`
4. Copy ALL the contents (Ctrl+A, Ctrl+C)
5. Paste into the SQL query box
6. Click **Go** button

**Expected Output:**

```
✓ Your SQL query has been executed successfully
✓ Affected rows: Multiple operations completed
```

**Verify Success:**

```sql
-- Run this query to check:
SELECT * FROM users;

-- You should see 3 users (admin, doctor, patient)
-- IDs should look like: a1b2c3d4-e5f6-7890-abcd-ef1234567890
```

---

### Step 3: Test Everything (2 minutes)

#### Test 1: Login with Default Users

Go to: `http://localhost/mindtrack/app/auth/`

**Admin:**

- Username: `admin`
- Password: `admin1234`
- ✅ Should redirect to patients dashboard

**Doctor:**

- Username: `doctor`
- Password: `doctor1234`
- ✅ Should redirect to doctors dashboard

**Patient:**

- Username: `patient`
- Password: `patient1234`
- ✅ Should redirect to patients dashboard

#### Test 2: Register New User

1. Click "Create Account" link
2. Fill in all fields:
   - First Name: `Test`
   - Last Name: `User`
   - Email: `test@example.com`
   - Username: `testuser`
   - Password: `test1234`
   - Confirm Password: `test1234`
   - Check "I agree to terms"
3. Click "Create Account"
4. ✅ Should auto-login and redirect to dashboard

#### Test 3: Verify in Database

```sql
-- Check newly created user
SELECT id, username, email, role FROM users ORDER BY created_at DESC LIMIT 1;

-- ID should be UUID format
-- Username should be 'testuser'
-- Email should be 'test@example.com'
```

---

## 🎉 Done!

If all tests pass, you're ready to go!

### What Changed?

- ✅ Database now uses UUIDs instead of auto-increment IDs
- ✅ New `users` table for authentication
- ✅ Registration page is live at `/app/auth/register.php`
- ✅ Login now uses database (not hardcoded)
- ✅ Secure password hashing with BCrypt

### Key URLs

- **Login:** `http://localhost/mindtrack/app/auth/`
- **Register:** `http://localhost/mindtrack/app/auth/register.php`
- **Landing:** `http://localhost/mindtrack/`

---

## 🔧 If Something Goes Wrong

### Issue: Migration Failed

**Solution:**

```sql
-- Drop the database and restore from backup
DROP DATABASE mindtrack;
CREATE DATABASE mindtrack;

-- Then import your backup file via phpMyAdmin Import tab
```

### Issue: Can't Login

**Check these:**

1. Did migration complete successfully?
2. Are there 3 users in `users` table?
3. Clear browser cookies
4. Check `logs/error.log` for PHP errors

**Quick Fix:**

```sql
-- Re-insert default admin user
INSERT INTO `users` (`id`, `email`, `username`, `password`, `first_name`, `last_name`, `role`, `status`, `email_verified`)
VALUES (
  UUID(),
  'admin@mindtrack.com',
  'admin',
  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
  'System',
  'Administrator',
  'admin',
  'active',
  TRUE
);
```

### Issue: Registration Page Not Found

**Check:**

- File exists at: `app/auth/register.php`
- Apache/XAMPP is running
- No typos in URL

---

## 📚 Full Documentation

For detailed information, see:

- `DATABASE_MIGRATION_GUIDE.md` - Complete migration instructions
- `REGISTRATION_SUMMARY.md` - Full feature documentation
- `AUTHENTICATION_FLOW.md` - How authentication works

---

## ✅ Checklist

After completing all steps:

- [ ] Database backed up
- [ ] Migration script executed
- [ ] 3 default users exist in database
- [ ] Can login as admin
- [ ] Can login as doctor
- [ ] Can login as patient
- [ ] Can register new user
- [ ] Registration auto-login works
- [ ] UUIDs are being generated
- [ ] No errors in `logs/error.log`

**All checked?** You're good to go! 🚀

---

**⏱️ Total Time:** ~5 minutes  
**Difficulty:** Easy  
**Version:** 1.0
