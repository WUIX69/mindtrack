# MindTrack Architecture - Domain Isolation

## 🎯 Core Principle: Complete Domain Isolation

MindTrack follows **complete domain isolation** where each business domain (Patients, Doctors) is fully self-contained with its own complete set of features.

---

## 📂 Domain Structure

### The `app/` Directory Rule

**The `app/` directory contains ONLY business domains:**

```
app/
├── landing/          # Public-facing domain
├── auth/             # Authentication domain
├── patients/         # Patient management domain (COMPLETE)
└── doctors/          # Doctor management domain (COMPLETE)
```

**Rule:** Each domain must be completely self-contained.

---

## 🏗️ Domain Anatomy

### Patient Domain (`app/patients/`)

**Complete and self-contained:**

| File                | Purpose                   |
| ------------------- | ------------------------- |
| `index.php`         | Patient Dashboard         |
| `list.php`          | All patients list         |
| `register.php`      | Register new patient      |
| `check.php`         | Patient verification      |
| `timeline.php`      | Patient profile/timeline  |
| `history.php`       | Medical history           |
| `prescriptions.php` | Prescriptions management  |
| `appointments.php`  | **Patient** appointments  |
| `calendar.php`      | **Patient** calendar view |
| `settings.php`      | **Patient** settings      |
| `logs.php`          | **Patient** activity logs |

### Doctor Domain (`app/doctors/`)

**Complete and self-contained:**

| File               | Purpose                  |
| ------------------ | ------------------------ |
| `index.php`        | Doctor Dashboard         |
| `list.php`         | All doctors list         |
| `register.php`     | Register new doctor      |
| `appointments.php` | **Doctor** appointments  |
| `calendar.php`     | **Doctor** calendar view |
| `settings.php`     | **Doctor** settings      |
| `logs.php`         | **Doctor** activity logs |

---

## 🔄 Complete Flow Diagram

### Entry & Authentication

```
┌─────────────────────────────────────────────────────────────┐
│ User visits: http://localhost/mindtrack/                   │
└──────────────────┬──────────────────────────────────────────┘
                   │
                   ▼
           ┌───────────────┐
           │  index.php    │
           │  (Redirects)  │
           └───────┬───────┘
                   │
                   ▼
      ┌────────────────────────┐
      │ app/landing/index.php  │
      │  (Public page)         │
      └────────┬───────────────┘
               │
               ▼ (User clicks Login)
      ┌────────────────────────┐
      │  app/auth/index.php    │
      │  (Login form)          │
      └────────┬───────────────┘
               │
               ▼ (AJAX POST)
   ┌───────────────────────────────────┐
   │ features/auth/servers/login.php   │
   │ • Validates credentials           │
   │ • Creates session with role       │
   │ • Returns redirect URL            │
   └───────────┬───────────────────────┘
               │
               ▼
        ┌──────────────┐
        │ mindtrack.php│
        │ (Router)     │
        └──────┬───────┘
               │
     ┌─────────┴─────────┐
     │                   │
     ▼                   ▼
┌────────────┐    ┌────────────┐
│role='patient'│    │role='doctor'│
└─────┬──────┘    └─────┬──────┘
      │                 │
      ▼                 ▼
app/patients/    app/doctors/
index.php        index.php
```

### Domain Navigation (Patient)

```
┌────────────────────────────────────┐
│ app/patients/index.php (Dashboard) │
└─────────────┬──────────────────────┘
              │
      ┌───────┴───────┐
      │  Sidebar Nav  │
      └───────┬───────┘
              │
    ┌─────────┼─────────┬──────────┬──────────┐
    │         │         │          │          │
    ▼         ▼         ▼          ▼          ▼
┌─────┐  ┌────────┐ ┌────────┐ ┌─────┐  ┌────────┐
│List │  │Appoint.│ │Calendar│ │Hist.│  │Settings│
└─────┘  └────────┘ └────────┘ └─────┘  └────────┘
   │          │         │         │         │
   ▼          ▼         ▼         ▼         ▼
patients/  patients/ patients/ patients/ patients/
list.php   appoint.  calendar  history   settings
           ments.php .php      .php      .php
```

---

## 🎯 URL Convention

### Patient Domain

```php
// Dashboard
app('patients')                      → /app/patients/index.php

// Features
app('patients/appointments')          → /app/patients/appointments.php
app('patients/calendar')              → /app/patients/calendar.php
app('patients/list')                  → /app/patients/list.php
app('patients/register')              → /app/patients/register.php
app('patients/timeline')              → /app/patients/timeline.php
app('patients/history')               → /app/patients/history.php
app('patients/prescriptions')         → /app/patients/prescriptions.php
app('patients/settings')              → /app/patients/settings.php
app('patients/logs')                  → /app/patients/logs.php
```

### Doctor Domain

```php
// Dashboard
app('doctors')                        → /app/doctors/index.php

// Features
app('doctors/appointments')           → /app/doctors/appointments.php
app('doctors/calendar')               → /app/doctors/calendar.php
app('doctors/list')                   → /app/doctors/list.php
app('doctors/register')               → /app/doctors/register.php
app('doctors/settings')               → /app/doctors/settings.php
app('doctors/logs')                   → /app/doctors/logs.php
```

---

## 🔑 Key Design Decisions

### 1. Why Domain Isolation?

❌ **Old Approach (Shared):**

```
Root level:
├── appointments.php     (Used by both patients & doctors)
├── calendar.php         (Shared)
├── settings.php         (Shared)

Problems:
- Who owns this feature?
- Different requirements for patients vs doctors
- Hard to customize per domain
- Tight coupling
```

✅ **New Approach (Isolated):**

```
app/patients/
├── appointments.php     (Patient-specific)
├── calendar.php         (Patient view)
├── settings.php         (Patient settings)

app/doctors/
├── appointments.php     (Doctor-specific)
├── calendar.php         (Doctor view)
├── settings.php         (Doctor settings)

Benefits:
- Clear ownership
- Independent evolution
- Domain-specific customization
- Loose coupling
```

### 2. Why mindtrack.php as Router?

```php
// mindtrack.php
switch ($userRole) {
    case 'doctor':
        header('Location: ' . app('doctors'));
        break;
    case 'patient':
        header('Location: ' . app('patients'));
        break;
}
```

**Benefits:**

- Single entry point after authentication
- Automatic routing based on role
- Easy to add new roles (admin, nurse, etc.)
- Clean separation

### 3. Why Smart Sidebar?

The sidebar adapts to the current domain:

```php
// In sidebar.php
$isDoctorDomain = strpos($_SERVER['REQUEST_URI'], '/doctors/') !== false;
$isPatientDomain = strpos($_SERVER['REQUEST_URI'], '/patients/') !== false;

if ($isDoctorDomain) {
    $domain = 'doctors';
} elseif ($isPatientDomain) {
    $domain = 'patients';
}

// Links automatically adjust
app($domain . '/appointments')  // patients/appointments OR doctors/appointments
```

**Benefits:**

- Single sidebar component
- Automatically adapts to context
- Reduces code duplication

---

## 📋 Adding New Features

### Example: Add "Reports" to Patient Domain

**Question:** Is this patient-specific or shared?

**Answer:** Patient-specific (medical reports)

**Action:**

```
1. Create: app/patients/reports.php
2. Add navigation link in patient dashboard
3. Create: features/reports/servers/ (if needed)
4. Create: models/reports.php (if needed)
```

### Example: Add "Schedules" to Doctor Domain

**Question:** Is this doctor-specific or shared?

**Answer:** Doctor-specific (doctor schedules)

**Action:**

```
1. Create: app/doctors/schedules.php
2. Add navigation link in doctor dashboard
3. Create: features/schedules/servers/ (if needed)
```

---

## 🏢 Multi-Layer Architecture

```
┌─────────────────────────────────────────┐
│         Presentation Layer              │
│  (app/patients/, app/doctors/)          │
│  • Shows UI to users                    │
│  • Handles user interaction             │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│         Server Layer                    │
│  (features/*/servers/)                  │
│  • API endpoints                        │
│  • Request validation                   │
│  • JSON responses                       │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│         Service Layer                   │
│  (services/)                            │
│  • Business logic                       │
│  • Reusable operations                  │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│         Model Layer                     │
│  (models/)                              │
│  • Database access                      │
│  • CRUD operations                      │
└──────────────┬──────────────────────────┘
               │
               ▼
┌─────────────────────────────────────────┐
│         Database                        │
│  (MySQL via PDO)                        │
└─────────────────────────────────────────┘
```

---

## ✅ Best Practices

### 1. Domain Ownership

```php
// ✅ CORRECT
app/patients/prescriptions.php    // Patients own prescriptions
app/doctors/schedules.php          // Doctors own schedules

// ❌ INCORRECT
app/prescriptions/index.php        // Don't create feature-based domains
app/schedules/index.php
```

### 2. Feature Placement

**Ask:** "Who primarily uses this feature?"

- **Patients only** → `app/patients/`
- **Doctors only** → `app/doctors/`
- **Both, but different views** → Separate files in each domain
- **Truly shared (like user management)** → Consider creating `app/admin/`

### 3. Navigation Links

```php
// ✅ CORRECT - Domain-aware
app($domain . '/appointments')     // Adapts to current domain

// ❌ INCORRECT - Hardcoded
app('patients/appointments')       // Forces patient domain
```

---

## 🎯 Summary

**Domain Structure:**

- `app/landing/` - Public pages
- `app/auth/` - Authentication
- `app/patients/` - Complete patient domain
- `app/doctors/` - Complete doctor domain

**Key Principles:**

1. Complete domain isolation
2. Each domain is self-contained
3. No shared feature pages at root
4. Role-based automatic routing
5. Smart context-aware navigation

**Benefits:**

- ✅ Clear boundaries
- ✅ Easy to maintain
- ✅ Scalable architecture
- ✅ Independent evolution
- ✅ Reduced coupling

This architecture ensures professional, maintainable, and scalable code! 🚀
