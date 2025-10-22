# Database Structure - MindTrack

## 📊 Overview

MindTrack uses a **normalized database structure** with user extension tables. This approach provides a single source of truth for all users while maintaining type-specific data separately.

---

## 🎯 Design Philosophy

### Single User Table + Extensions

Instead of separate `doctors` and `patients` tables, we use:

1. **`users`** - Core table with common fields for all user types
2. **`users_doctor_adds`** - Extension table for doctor-specific fields
3. **`users_patient_adds`** - Extension table for patient-specific fields

### Benefits

✅ **Single Source of Truth** - All authentication in one place  
✅ **Normalized Data** - No duplicate fields across tables  
✅ **Easy Queries** - Query all users or filter by role  
✅ **Clean Relationships** - All foreign keys point to `users.uuid`  
✅ **Scalable** - Easy to add new user types (e.g., `users_admin_adds`)

---

## 📋 Table Structure

### 1. `users` (Core Table)

**Purpose:** Authentication and common user data

| Column           | Type                | Description                       |
| ---------------- | ------------------- | --------------------------------- |
| `uuid`           | VARCHAR(36) PK      | Primary key (UUID)                |
| `email`          | VARCHAR(150) UNIQUE | User email                        |
| `username`       | VARCHAR(100) UNIQUE | Login username                    |
| `password`       | VARCHAR(255)        | Hashed password (bcrypt)          |
| `first_name`     | VARCHAR(100)        | First name                        |
| `last_name`      | VARCHAR(100)        | Last name                         |
| `phone`          | VARCHAR(20)         | Contact number                    |
| `role`           | ENUM                | 'admin', 'doctor', 'patient'      |
| `status`         | ENUM                | 'active', 'inactive', 'suspended' |
| `email_verified` | BOOLEAN             | Email verification status         |
| `avatar`         | VARCHAR(255)        | Avatar image path                 |
| `last_login`     | TIMESTAMP           | Last login time                   |
| `created_at`     | TIMESTAMP           | Record creation time              |
| `updated_at`     | TIMESTAMP           | Last update time                  |

**Indexes:**

- PRIMARY KEY: `uuid`
- UNIQUE: `email`, `username`
- INDEX: `role`, `status`

---

### 2. `users_doctor_adds` (Doctor Extension)

**Purpose:** Doctor-specific fields only

| Column             | Type                  | Description                 |
| ------------------ | --------------------- | --------------------------- |
| `uuid`             | VARCHAR(36) PK        | Primary key (UUID)          |
| `user_uuid`        | VARCHAR(36) UNIQUE FK | Links to `users.uuid`       |
| `doctor_custom_id` | VARCHAR(10) UNIQUE    | Human-readable ID (DR00001) |
| `specialization`   | VARCHAR(100)          | Medical specialization      |
| `license_number`   | VARCHAR(50)           | Professional license number |
| `created_at`       | TIMESTAMP             | Record creation time        |
| `updated_at`       | TIMESTAMP             | Last update time            |

**Foreign Keys:**

- `user_uuid` → `users(uuid)` CASCADE DELETE

**Note:** When a user with `role='doctor'` is created, a corresponding record is added here.

---

### 3. `users_patient_adds` (Patient Extension)

**Purpose:** Patient-specific fields only

| Column              | Type                  | Description                  |
| ------------------- | --------------------- | ---------------------------- |
| `uuid`              | VARCHAR(36) PK        | Primary key (UUID)           |
| `user_uuid`         | VARCHAR(36) UNIQUE FK | Links to `users.uuid`        |
| `patient_custom_id` | VARCHAR(20) UNIQUE    | Human-readable ID (012304P1) |
| `birthdate`         | DATE                  | Date of birth                |
| `emergency_contact` | VARCHAR(50)           | Emergency contact number     |
| `service_type`      | VARCHAR(100)          | Type of service needed       |
| `doctor_uuid`       | VARCHAR(36) FK        | Assigned doctor              |
| `diagnosis`         | TEXT                  | Medical diagnosis            |
| `created_at`        | TIMESTAMP             | Record creation time         |
| `updated_at`        | TIMESTAMP             | Last update time             |

**Foreign Keys:**

- `user_uuid` → `users(uuid)` CASCADE DELETE
- `doctor_uuid` → `users(uuid)` SET NULL

**Note:** When a user with `role='patient'` is created, a corresponding record is added here.

---

### 4. `booking_request`

**Purpose:** Patient booking requests (can be from non-registered users)

| Column              | Type               | Description                                    |
| ------------------- | ------------------ | ---------------------------------------------- |
| `uuid`              | VARCHAR(36) PK     | Primary key (UUID)                             |
| `user_uuid`         | VARCHAR(36) FK     | Links to `users.uuid` (nullable)               |
| `patient_custom_id` | VARCHAR(20)        | Human-readable patient ID                      |
| `first_name`        | VARCHAR(100)       | First name                                     |
| `last_name`         | VARCHAR(100)       | Last name                                      |
| `email`             | VARCHAR(150)       | Email address                                  |
| `service_type`      | VARCHAR(100)       | Requested service                              |
| `birthdate`         | DATE               | Date of birth                                  |
| `booking_date`      | DATE               | Requested appointment date                     |
| `booking_time`      | TIME               | Requested appointment time                     |
| `status`            | ENUM               | 'pending', 'approved', 'rejected', 'cancelled' |
| `booking_code`      | VARCHAR(20) UNIQUE | Booking reference code                         |
| `notes`             | TEXT               | Additional notes                               |
| `created_at`        | TIMESTAMP          | Record creation time                           |
| `updated_at`        | TIMESTAMP          | Last update time                               |

**Foreign Keys:**

- `user_uuid` → `users(uuid)` SET NULL

---

### 5. `appointment`

**Purpose:** Confirmed appointments

| Column             | Type           | Description                                      |
| ------------------ | -------------- | ------------------------------------------------ |
| `uuid`             | VARCHAR(36) PK | Primary key (UUID)                               |
| `booking_uuid`     | VARCHAR(36) FK | Links to `booking_request`                       |
| `patient_uuid`     | VARCHAR(36) FK | Patient (from `users`)                           |
| `doctor_uuid`      | VARCHAR(36) FK | Doctor (from `users`)                            |
| `appointment_date` | DATE           | Appointment date                                 |
| `appointment_time` | TIME           | Appointment time                                 |
| `service_type`     | VARCHAR(100)   | Type of service                                  |
| `status`           | ENUM           | 'scheduled', 'completed', 'cancelled', 'no-show' |
| `booking_code`     | VARCHAR(20)    | Reference code                                   |
| `remarks`          | TEXT           | Appointment remarks                              |
| `prescription`     | TEXT           | Medical prescription                             |
| `diagnosis`        | TEXT           | Diagnosis notes                                  |
| `created_at`       | TIMESTAMP      | Record creation time                             |
| `updated_at`       | TIMESTAMP      | Last update time                                 |

**Foreign Keys:**

- `booking_uuid` → `booking_request(uuid)` SET NULL
- `patient_uuid` → `users(uuid)` CASCADE DELETE
- `doctor_uuid` → `users(uuid)` SET NULL

---

### 6. `session_tokens`

**Purpose:** Session management and tracking

| Column       | Type                | Description             |
| ------------ | ------------------- | ----------------------- |
| `uuid`       | VARCHAR(36) PK      | Primary key (UUID)      |
| `user_uuid`  | VARCHAR(36) FK      | User owning the session |
| `token`      | VARCHAR(255) UNIQUE | Session token           |
| `ip_address` | VARCHAR(45)         | Client IP address       |
| `user_agent` | TEXT                | Browser user agent      |
| `expires_at` | TIMESTAMP           | Token expiration time   |
| `created_at` | TIMESTAMP           | Session creation time   |

**Foreign Keys:**

- `user_uuid` → `users(uuid)` CASCADE DELETE

---

### 7. `activity_logs`

**Purpose:** Audit trail for all user actions

| Column        | Type           | Description                                   |
| ------------- | -------------- | --------------------------------------------- |
| `uuid`        | VARCHAR(36) PK | Primary key (UUID)                            |
| `user_uuid`   | VARCHAR(36) FK | User who performed action                     |
| `action`      | VARCHAR(100)   | Action performed                              |
| `entity_type` | VARCHAR(50)    | Type of entity (patient, doctor, appointment) |
| `entity_uuid` | VARCHAR(36)    | UUID of affected entity                       |
| `description` | TEXT           | Action description                            |
| `ip_address`  | VARCHAR(45)    | Client IP address                             |
| `user_agent`  | TEXT           | Browser user agent                            |
| `created_at`  | TIMESTAMP      | Action timestamp                              |

**Foreign Keys:**

- `user_uuid` → `users(uuid)` SET NULL

---

## 🔄 How It Works

### Creating a Doctor

```php
// 1. Create user record
$user_uuid = generateUUID();
INSERT INTO users (uuid, email, username, password, first_name, last_name, role)
VALUES ($user_uuid, 'dr@example.com', 'drsmith', $hashed_pwd, 'John', 'Smith', 'doctor');

// 2. Create doctor-specific record
INSERT INTO users_doctor_adds (uuid, user_uuid, doctor_custom_id, specialization)
VALUES (generateUUID(), $user_uuid, 'DR00001', 'Clinical Psychologist');
```

### Creating a Patient

```php
// 1. Create user record
$user_uuid = generateUUID();
INSERT INTO users (uuid, email, username, password, first_name, last_name, role)
VALUES ($user_uuid, 'patient@example.com', 'janedoe', $hashed_pwd, 'Jane', 'Doe', 'patient');

// 2. Create patient-specific record
INSERT INTO users_patient_adds (uuid, user_uuid, patient_custom_id, birthdate, service_type)
VALUES (generateUUID(), $user_uuid, '012304P1', '2004-01-23', 'Counseling');
```

### Querying a Doctor with Details

```sql
SELECT
    u.*,
    d.doctor_custom_id,
    d.specialization,
    d.license_number
FROM users u
LEFT JOIN users_doctor_adds d ON u.uuid = d.user_uuid
WHERE u.role = 'doctor'
AND u.uuid = ?;
```

### Querying a Patient with Details

```sql
SELECT
    u.*,
    p.patient_custom_id,
    p.birthdate,
    p.emergency_contact,
    p.service_type,
    p.doctor_uuid,
    p.diagnosis,
    doc.first_name AS doctor_first_name,
    doc.last_name AS doctor_last_name
FROM users u
LEFT JOIN users_patient_adds p ON u.uuid = p.user_uuid
LEFT JOIN users doc ON p.doctor_uuid = doc.uuid
WHERE u.role = 'patient'
AND u.uuid = ?;
```

### Getting All Patients of a Doctor

```sql
SELECT
    u.*,
    p.patient_custom_id,
    p.service_type,
    p.diagnosis
FROM users u
INNER JOIN users_patient_adds p ON u.uuid = p.user_uuid
WHERE p.doctor_uuid = ?
AND u.status = 'active';
```

---

## 🎯 Advantages Over Separate Tables

### Before (Separate Tables)

```
❌ doctors table: id, first_name, last_name, email, phone, ...
❌ patients table: id, first_name, last_name, email, contact, ...
❌ Duplicate fields (first_name, last_name, email, phone)
❌ Need to JOIN both tables to get all users
❌ Foreign keys point to different tables
```

### After (Extension Tables)

```
✅ users table: uuid, first_name, last_name, email, phone, role, ...
✅ users_doctor_adds: only doctor-specific fields
✅ users_patient_adds: only patient-specific fields
✅ No duplicate fields
✅ Single table for all users
✅ All foreign keys point to users.uuid
```

---

## 📝 Best Practices

### 1. Always Use Transactions

```php
$conn->beginTransaction();
try {
    // Insert into users
    // Insert into users_doctor_adds or users_patient_adds
    $conn->commit();
} catch (Exception $e) {
    $conn->rollBack();
}
```

### 2. Cascade Deletes

When a user is deleted, their extension record is automatically deleted due to `ON DELETE CASCADE`.

### 3. Consistent UUID Usage

Always use `generateUUID()` for new records.

### 4. Role-Based Queries

Always filter by `role` when querying specific user types:

```sql
WHERE role = 'doctor'
WHERE role = 'patient'
```

---

## 🔍 Common Queries

### Get All Doctors

```sql
SELECT u.*, d.specialization, d.doctor_custom_id
FROM users u
INNER JOIN users_doctor_adds d ON u.uuid = d.user_uuid
WHERE u.role = 'doctor'
ORDER BY u.last_name;
```

### Get All Patients

```sql
SELECT u.*, p.patient_custom_id, p.birthdate
FROM users u
INNER JOIN users_patient_adds p ON u.uuid = p.user_uuid
WHERE u.role = 'patient'
ORDER BY u.last_name;
```

### Get User Count by Role

```sql
SELECT role, COUNT(*) as total
FROM users
GROUP BY role;
```

---

**Version:** 2.0 (Normalized Structure)  
**Updated:** October 22, 2025  
**Status:** ✅ Complete

🎉 **Modern, normalized database structure with UUID support!**
