# UUID Naming Convention - MindTrack

## 📝 Overview

The MindTrack database has been updated to use **explicit UUID naming** for all primary keys and foreign keys. This makes the code more self-documenting and easier to understand.

---

## 🔄 Naming Convention

### Old vs New

| Old Column Name | New Column Name | Description                          |
| --------------- | --------------- | ------------------------------------ |
| `id`            | `uuid`          | Primary key (UUID)                   |
| `user_id`       | `user_uuid`     | Foreign key to users table           |
| `patient_id`    | `patient_uuid`  | Foreign key to patients table        |
| `doctor_id`     | `doctor_uuid`   | Foreign key to doctors table         |
| `booking_id`    | `booking_uuid`  | Foreign key to booking_request table |
| `entity_id`     | `entity_uuid`   | Generic foreign key reference        |

---

## 📊 Updated Tables

### 1. **users** Table

```sql
CREATE TABLE `users` (
  `uuid` VARCHAR(36) PRIMARY KEY,  -- ✅ Changed from `id`
  `email` VARCHAR(150) UNIQUE NOT NULL,
  `username` VARCHAR(100) UNIQUE NOT NULL,
  ...
);
```

### 2. **patients** Table

```sql
CREATE TABLE `patients` (
  `uuid` VARCHAR(36) PRIMARY KEY,              -- ✅ Changed from `id`
  `user_uuid` VARCHAR(36) NULL,                -- ✅ Changed from `user_id`
  `doctor_uuid` VARCHAR(36) NULL,              -- ✅ Changed from `doctor_id`
  `patient_custom_id` VARCHAR(20) UNIQUE,      -- Kept human-readable ID
  ...
  FOREIGN KEY (`user_uuid`) REFERENCES `users`(`uuid`),
  FOREIGN KEY (`doctor_uuid`) REFERENCES `doctors`(`uuid`)
);
```

### 3. **doctors** Table

```sql
CREATE TABLE `doctors` (
  `uuid` VARCHAR(36) PRIMARY KEY,              -- ✅ Changed from `id`
  `user_uuid` VARCHAR(36) NULL,                -- ✅ Changed from `user_id`
  `doctor_custom_id` VARCHAR(10) UNIQUE,       -- Kept human-readable ID
  ...
  FOREIGN KEY (`user_uuid`) REFERENCES `users`(`uuid`)
);
```

### 4. **booking_request** Table

```sql
CREATE TABLE `booking_request` (
  `uuid` VARCHAR(36) PRIMARY KEY,              -- ✅ Changed from `id`
  `patient_uuid` VARCHAR(36) NULL,             -- ✅ Changed from `patient_id`
  ...
  FOREIGN KEY (`patient_uuid`) REFERENCES `patients`(`uuid`)
);
```

### 5. **appointment** Table

```sql
CREATE TABLE `appointment` (
  `uuid` VARCHAR(36) PRIMARY KEY,              -- ✅ Changed from `id`
  `booking_uuid` VARCHAR(36) NULL,             -- ✅ Changed from `booking_id`
  `patient_uuid` VARCHAR(36) NOT NULL,         -- ✅ Changed from `patient_id`
  `doctor_uuid` VARCHAR(36) NULL,              -- ✅ Changed from `doctor_id`
  ...
  FOREIGN KEY (`booking_uuid`) REFERENCES `booking_request`(`uuid`),
  FOREIGN KEY (`patient_uuid`) REFERENCES `patients`(`uuid`),
  FOREIGN KEY (`doctor_uuid`) REFERENCES `doctors`(`uuid`)
);
```

### 6. **session_tokens** Table

```sql
CREATE TABLE `session_tokens` (
  `uuid` VARCHAR(36) PRIMARY KEY,              -- ✅ Changed from `id`
  `user_uuid` VARCHAR(36) NOT NULL,            -- ✅ Changed from `user_id`
  ...
  FOREIGN KEY (`user_uuid`) REFERENCES `users`(`uuid`)
);
```

### 7. **activity_logs** Table

```sql
CREATE TABLE `activity_logs` (
  `uuid` VARCHAR(36) PRIMARY KEY,              -- ✅ Changed from `id`
  `user_uuid` VARCHAR(36) NULL,                -- ✅ Changed from `user_id`
  `entity_uuid` VARCHAR(36) NULL,              -- ✅ Changed from `entity_id`
  ...
  FOREIGN KEY (`user_uuid`) REFERENCES `users`(`uuid`)
);
```

---

## 🔧 Updated PHP Code

### Users Model (`models/users.php`)

**Before:**

```php
public static function single($id = null)
{
    $stmt = self::conn()->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    ...
}
```

**After:**

```php
public static function single($uuid = null)
{
    $stmt = self::conn()->prepare('SELECT * FROM users WHERE uuid = ? LIMIT 1');
    $stmt->execute([$uuid]);
    ...
}
```

### Login Server (`features/auth/servers/login.php`)

**Before:**

```php
$_SESSION['user_id'] = $user['id'];
Users::updateLastLogin($user['id']);

$response['data']['user'] = [
    'id' => $user['id'],
    ...
];
```

**After:**

```php
$_SESSION['user_uuid'] = $user['uuid'];
Users::updateLastLogin($user['uuid']);

$response['data']['user'] = [
    'uuid' => $user['uuid'],
    ...
];
```

### Registration Server (`features/auth/servers/register.php`)

**Before:**

```php
$userData = [
    'id' => generateUUID(),
    ...
];

$_SESSION['user_id'] = $userData['id'];

$response['data']['user'] = [
    'id' => $userData['id'],
    ...
];
```

**After:**

```php
$userData = [
    'uuid' => generateUUID(),
    ...
];

$_SESSION['user_uuid'] = $userData['uuid'];

$response['data']['user'] = [
    'uuid' => $userData['uuid'],
    ...
];
```

---

## 🎯 Benefits

### 1. **Self-Documenting Code**

```php
// ❌ Old way - not clear what type of ID
$userId = $user['id'];

// ✅ New way - explicitly a UUID
$userUuid = $user['uuid'];
```

### 2. **Clear Foreign Key References**

```php
// ❌ Old way - ambiguous
WHERE user_id = ?

// ✅ New way - clearly a UUID reference
WHERE user_uuid = ?
```

### 3. **Prevents Confusion**

- No ambiguity between integer IDs and UUIDs
- Clear distinction from custom IDs (e.g., `patient_custom_id`)
- Easier to understand code at a glance

### 4. **Better Type Hints**

```php
/**
 * Update user password
 *
 * @param string $new_password Hashed password
 * @param string $user_uuid UUID  // ✅ Clear parameter type
 * @return array
 */
public static function updatePassword($new_password = null, $user_uuid = null)
```

---

## 📋 Migration Checklist

If you're updating an existing installation:

- [ ] **Backup database** before running migration
- [ ] Run migration script: `core/migrations/001_convert_to_uuid.sql`
- [ ] Verify all tables use `uuid` column naming
- [ ] Check foreign key constraints are correct
- [ ] Test login functionality
- [ ] Test registration functionality
- [ ] Verify session variables use `user_uuid`
- [ ] Update any custom code that references `id` or `user_id`

---

## 🔍 Finding All References

To find any remaining `id` references in your code:

```bash
# Search for id column references in models
grep -r "WHERE id" models/

# Search for user_id in PHP files
grep -r "user_id" --include="*.php" .

# Search for ['id'] array access
grep -r "\['id'\]" --include="*.php" .
```

---

## ⚠️ Important Notes

### 1. **Human-Readable IDs Preserved**

Custom ID fields remain unchanged:

- `patient_custom_id` → Format: `MMDDYY` (e.g., `012304`)
- `doctor_custom_id` → Format: `DR#####` (e.g., `DR00123`)

These are for **display purposes only**, not primary keys.

### 2. **Session Variables Updated**

```php
// ❌ Old
$_SESSION['user_id']

// ✅ New
$_SESSION['user_uuid']
```

### 3. **API Responses Updated**

```json
// ❌ Old
{
  "user": {
    "id": "123",
    ...
  }
}

// ✅ New
{
  "user": {
    "uuid": "a1b2c3d4-e5f6-7890-abcd-ef1234567890",
    ...
  }
}
```

---

## 📚 Related Documentation

- `DATABASE_MIGRATION_GUIDE.md` - Complete migration instructions
- `REGISTRATION_SUMMARY.md` - Registration system documentation
- `QUICK_START.md` - Quick setup guide

---

## ✅ Verification Queries

After migration, verify the naming convention:

```sql
-- Check users table structure
DESCRIBE users;
-- Should show `uuid` as PRIMARY KEY

-- Check foreign keys
SELECT
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = 'mindtrack'
AND TABLE_NAME = 'patients'
AND REFERENCED_TABLE_NAME IS NOT NULL;
-- Should show user_uuid → users(uuid) and doctor_uuid → doctors(uuid)

-- Test a query
SELECT uuid, username, email FROM users WHERE uuid = (
    SELECT uuid FROM users LIMIT 1
);
-- Should work without errors
```

---

**Version:** 1.0  
**Updated:** October 22, 2025  
**Status:** ✅ Complete

🎉 **All UUID naming conventions have been updated!**
