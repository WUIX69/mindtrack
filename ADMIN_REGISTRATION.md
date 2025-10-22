# Admin Registration - Setup Guide

**Date:** October 22, 2025  
**System:** MindTrack - Wayside Psyche Resources Center  
**Access:** Direct URL (Hidden)

---

## 📋 Overview

The Admin Registration page (`app/auth/admin-register.php`) is a **hidden page** that allows creation of system administrator accounts. This page is NOT linked anywhere in the application and must be accessed manually via URL.

---

## 🔑 Access Method

### Direct URL Access

**Development:**

```
http://localhost/mindtrack/app/auth/admin-register.php
```

**Production:**

```
https://yourdomain.com/app/auth/admin-register.php
```

⚠️ **Note:** Anyone who knows this URL can create admin accounts. Keep it confidential.

---

## 📋 Step-by-Step Usage

### For System Setup (First Time)

1. **Open Browser and Navigate:**

   ```
   http://localhost/mindtrack/app/auth/admin-register.php
   ```

2. **Fill Out Registration Form:**

   - **Personal Information:**
     - First Name (required)
     - Last Name (required)
   - **Account Information:**
     - Email Address (required)
     - Username (required, min 4 chars)
     - Phone Number (optional)
   - **Security:**
     - Password (required)
     - Confirm Password (required, must match)
   - **Confirmation:**
     - ☑️ Check "I am authorized to create an administrator account"

3. **Click "Create Admin Account"**

4. **Automatic Actions:**

   - Account created with `role='admin'` and `status='active'`
   - Success message displayed
   - Auto-redirect to login page after 2 seconds

5. **Login with New Admin Credentials**

---

## 🛡️ Security Considerations

### Current Setup

- Page is **hidden** (not linked in navigation)
- Requires **manual URL access**
- Creates **auto-active** admin accounts
- No additional authentication

### Recommendations

**For Production:**

1. **After First Admin:**

   - Use Enrollments page for additional admins
   - Consider renaming or removing this file
   - Document the first admin creation

2. **Additional Security (Optional):**

   - Rename file to something non-obvious
   - Add `.htaccess` password protection
   - Disable/delete after initial setup
   - Add IP whitelist

3. **Best Practices:**
   - Keep URL confidential
   - Only share with authorized IT staff
   - Monitor admin account creations
   - Use strong passwords

---

## 🎨 Page Design

### Visual Features

- **Purple/Indigo gradient background** - Distinguishes from normal registration
- **Info banner** - Indicates admin registration
- **Shield icon** - Visual security indicator
- **Professional layout** - Clean, modern design
- **Clear sections** - Personal, Account, Security
- **Admin confirmation checkbox** - Yellow warning segment
- **Responsive design** - Works on all devices

### User Experience

- **Inline validation** - Real-time feedback
- **Password strength indicator** - (via minimum length)
- **Clear error messages** - User-friendly
- **Auto-redirect** - Seamless post-registration
- **Loading states** - Visual feedback during submission

---

## 🔄 Integration with System

### Related Pages

- **Login:** `app/auth/index.php` - Where admins login after registration
- **Enrollments:** `app/admin/enrollments.php` - Where admins create other users
- **Registration API:** `features/auth/servers/register.php` - Backend handler

### Database Tables

- **users** - Main user record (`role='admin'`, `status='active'`)
- No extension tables needed for admin role (unlike doctor/patient)

### Session Flow

```
admin-register.php (create)
  → register.php API (save to DB)
  → Redirect to login
  → User logs in
  → Redirect to app/admin
```

---

## ✅ Testing Checklist

### Functionality Tests

- [ ] Page loads correctly
- [ ] Form validation works
- [ ] Password matching enforced
- [ ] Email validation works
- [ ] Username length validated
- [ ] Admin checkbox required
- [ ] Registration creates admin account
- [ ] Auto-redirect to login works
- [ ] Can login with new admin account

### UI/UX Tests

- [ ] Page renders correctly
- [ ] Responsive on mobile
- [ ] Error messages display
- [ ] Success messages display
- [ ] Loading states work
- [ ] Icons display properly

---

## 📝 Sample Usage

### Example 1: Development Setup

```bash
# Browser
http://localhost/mindtrack/app/auth/admin-register.php

# Fill form:
First Name: System
Last Name: Administrator
Email: admin@mindtrack.local
Username: sysadmin
Password: AdminPass2025!
☑️ I confirm authorization

# Click "Create Admin Account"
# → Success! Redirecting...
# → Login page opens
# → Login with sysadmin / AdminPass2025!
```

### Example 2: Production Deployment

```bash
# Browser (secure connection)
https://mindtrack.production.com/app/auth/admin-register.php

# Fill form with real admin details
# Create account
# Consider disabling/removing the page after use
# Document admin creation in system logs
```

---

## 🚀 Post-Registration Steps

1. **Login to Admin Dashboard:**

   ```
   http://localhost/mindtrack/app/auth
   Username: [your_username]
   Password: [your_password]
   ```

2. **Verify Admin Access:**

   - Check admin sidebar menu
   - Verify all admin pages accessible
   - Test Enrollments page

3. **Create Additional Users:**

   - Use Enrollments page for doctors, patients, staff
   - Assign appropriate roles
   - Set initial passwords

4. **Secure the System:**
   - Consider renaming/removing admin-register.php
   - Use Enrollments page for future admin accounts
   - Enable activity logging
   - Review security settings

---

## 🆘 Troubleshooting

### Problem: Page not found (404)

**Solutions:**

- Check URL spelling
- Ensure file exists at `app/auth/admin-register.php`
- Verify web server is running

### Problem: Registration succeeds but can't login

**Solutions:**

- Wait a few seconds and try again
- Check database for user record
- Verify `role='admin'` in database
- Check `status='active'` in database
- Clear browser cache and try login

### Problem: Form validation errors

**Solutions:**

- Ensure all required fields filled
- Passwords must match
- Email must be valid format
- Username must be at least 4 characters
- Admin checkbox must be checked

---

## 📚 Related Documentation

- **System Flow:** [MINDTRACK_SYSTEM_FLOW.md](MINDTRACK_SYSTEM_FLOW.md)
- **Authentication:** `features/auth/servers/register.php`
- **User Model:** `models/users.php`
- **Admin Management:** [ADMIN_MANAGEMENT_SUMMARY.md](ADMIN_MANAGEMENT_SUMMARY.md)
- **Enrollments:** `app/admin/enrollments.php`

---

## 🎯 Summary

The Admin Registration page provides a **simple, direct method** for creating system administrator accounts:

✅ **Hidden access** - Not linked from public pages  
✅ **Auto-active accounts** - No approval needed  
✅ **Professional UI** - Clear, modern design  
✅ **Full validation** - Client and server-side  
✅ **Redirect flow** - Seamless user experience  
✅ **Simple setup** - No complex authentication

**Default URL:**

```
http://localhost/mindtrack/app/auth/admin-register.php
```

**Remember:** Keep this URL confidential and use Enrollments page for regular user creation! 🔒

---

## ⚠️ Security Warning

Since this page has no authentication beyond being hidden:

1. **Do not share the URL publicly**
2. **Consider disabling after first admin creation**
3. **Use Enrollments page for additional admins**
4. **Monitor admin account creations**
5. **Add server-level protection if needed**

---

**Version:** 2.0 (Simplified)  
**Last Updated:** October 22, 2025  
**Status:** 🟢 Production Ready
