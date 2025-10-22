# Quick Admin Registration Setup

## 🚀 Fast Start Guide

### Step 1: Access the Admin Registration Page

**URL:**

```
http://localhost/mindtrack/app/auth/admin-register.php
```

### Step 2: Fill Out the Form

1. **Personal Information:**

   - First Name: `Admin`
   - Last Name: `User`

2. **Account Information:**

   - Email: `admin@mindtrack.local`
   - Username: `admin`
   - Phone: (optional)

3. **Security:**

   - Password: `Admin123!`
   - Confirm Password: `Admin123!`

4. **Confirmation:**

   - ☑️ Check "I am authorized to create an administrator account"

5. **Click:** "Create Admin Account"

### Step 3: Login

After successful registration, you'll be redirected to login.

**Login Credentials:**

- Username: `admin`
- Password: `Admin123!`

---

## ⚠️ Important Notes

- This page is **NOT linked** anywhere in the app
- Must be **manually accessed** via URL
- Creates **auto-active** admin accounts
- Use with **caution** - no approval needed
- Anyone who knows the URL can create admin accounts

---

## 🔒 Production Recommendations

1. **After creating first admin:**

   - Use Enrollments page for additional admins
   - Consider removing or renaming this file

2. **For additional security:**

   - Move to a non-standard filename
   - Add server-level authentication (.htaccess)
   - Disable after initial setup

3. **Regular users:**
   - Use Enrollments page in admin panel
   - Proper approval workflow

---

## 🆘 Need Help?

See full documentation: [ADMIN_REGISTRATION.md](ADMIN_REGISTRATION.md)
