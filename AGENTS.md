# MindTrack Agent Guide

This document provides essential instructions and guidelines for agentic coding agents operating in the `mindtrack` directory.

## Project Overview

MindTrack is a web-based **Patient Management and Online Appointment System** built on a custom LAMP/WAMP stack. It digitizes clinic operations for the **Wayside Psyche Resources Center**, handling appointments, patient records, and reporting.

---

## 🛠 Technology Stack

| Category         | Technology                           |
| :--------------- | :----------------------------------- |
| **Framework**    | Custom PHP (LAMP/WAMP Stack)         |
| **Core**         | PHP 8.1+, MySQL 8.0+                 |
| **Frontend**     | HTML5, JavaScript, jQuery, DaisyUI   |
| **Styling**      | TailwindCSS 4, PostCSS, Autoprefixer |
| **Backend Libs** | PHPMailer, Dompdf, Ramsey UUID       |
| **Database**     | MySQL / MariaDB                      |
| **Server**       | Apache (via XAMPP)                   |

---

## 🔧 Commands

### PHP & Backend

Dependencies are managed via Composer.

| Action       | Command                  | Description              |
| :----------- | :----------------------- | :----------------------- |
| **Install**  | `composer install`       | Install PHP dependencies |
| **Update**   | `composer update`        | Update PHP dependencies  |
| **Autoload** | `composer dump-autoload` | Regenerate autoloader    |

### Frontend & Assets

Styles are built using TailwindCSS via npm/pnpm.

| Action      | Command        | Description                 |
| :---------- | :------------- | :-------------------------- |
| **Install** | `pnpm install` | Install JS/CSS dependencies |
| **Dev**     | `pnpm dev`     | Watch TailwindCSS changes   |
| **Build**   | `pnpm build`   | Build production CSS        |

### Server

This project runs on XAMPP.

- **Start**: Open XAMPP Control Panel and start **Apache** and **MySQL**.
- **Access**: Visit `http://localhost/mindtrack`.

---

## 📂 Directory Structure

```text
src/
├── app/                    # Application Entry Points / Pages
│   ├── admin/              # Admin dashboard pages (layout.php, index.php, etc.)
│   ├── auth/               # Authentication pages (signin, signup)
│   ├── doctor/             # Doctor/Clinician portal pages (layout.php, index.php)
│   ├── landing/            # Public landing pages (homepage, about, etc.)
│   ├── patient/            # Patient dashboard pages (layout.php, index.php)
│   ├── global.css          # Global Tailwind directives
│   ├── layout.php          # Root layout (like Next.js RootLayout)
│   └── index.php           # Redirects to landing/
├── components/             # Shared UI Components (PHP Partials)
│   ├── layout/             # Header, footer, sidebar
│   ├── theme/              # Theme configurations
│   └── ui/                 # Reusable UI elements
├── core/                   # Core Logic & Configuration
│   ├── db/                 # SQL dumps (e.g. mindtrack.sql)
│   ├── migrations/         # SQL migrations
│   └── ...                 # Core system logic
├── data/                   # Static data, mock data
├── features/               # Feature-Based Modules
├── lib/                    # Shared PHP Libraries / Helpers
│   ├── data-tables.php     # Data handling utilities
│   ├── email.php           # Email sending logic
│   └── session-manager.php # Session handling
├── schemas/                # Validation Schemas (Respect Validation)
├── server/                 # Backend API Endpoints / Logic
│   ├── db/                 # Database SQL Interaction
│   └── actions             # API Endpoints / Layer
├── utils/                  # Utility Functions
└── vendor/                 # Composer Dependencies
```

---

## 🏗️ Feature Sliced Design (`src/features/`)

Each feature is a **self-contained module**.

### Feature Internal Structure

```text
src/features/[feature-name]/
├── components/    # Feature-specific UI components (PHP) (Include the js inside <script>)
├── schemas/       # Feature-specific schemas, validation (Respect Validation)
├── js/            # Feature-specific JavaScript logic (if needed beyond components included <script>)
└── server/        # Feature-specific backend logic
└── utils/         # Feature-specific Utility Functions
```

### Supported Features

- **Core**: `auth`, `dashboard`, `home`, `settings`, `users`
- **Domain**: `appointments`, `services`, `products`
- **Content**: `about`, `contact`

---

## 🎨 Code Style Guidelines

### Backend (PHP)

- Follow **PSR-4** for autoloading (`Mindtrack\` namespace maps to `src/`).
- Use strict typing where possible in PHP 8.1+.
- Use prepared statements (PDO/MySQLi) for all database interactions to prevent SQL injection.

### Frontend (JS/CSS)

- **Styling**: Always use **TailwindCSS** utility classes. Avoid inline styles.
- **DaisyUI Components**: Leverage DaisyUI component classes for common UI elements:
    - Use semantic component classes: `btn`, `card`, `input`, `modal`, `dropdown`, etc.
    - Combine with Tailwind utilities for customization
    - Refer to [DaisyUI documentation](https://daisyui.com/components/) for available components
    - DaisyUI themes are disabled; use custom CSS variables from `global.css` for theming
- **JavaScript**: Use modern ES6+ features where supported, or jQuery for DOM manipulation if legacy consistency is needed.

### File Naming

- **PHP Classes**: `PascalCase.php`
- **Partial/Views**: `kebab-case.php`
- **JS/CSS**: `kebab-case.js`, `kebab-case.css`

---

## 🔌 API & Database Communication

- **Database**: Use the core database wrapper in `src/core/db`.
- **AJAX**: Use jQuery `$.ajax` or Fetch API for client-server communication.
- **Responses**: Return JSON for API endpoints (e.g., in `server/` directories).

---

## 🔑 Authentication & Roles

- **Session Management**: Handled via `src/lib/session-manager.php`.
- **Roles**: The system supports three distinct user roles:
    - `admin`: Clinic staff with full management access.
    - `doctor`: Healthcare providers with clinical portal access.
    - `patient`: Registered patients with booking and records access.
- **Role Parameter**: The shared `sidebar` and `headbar` components use a `role` parameter to dynamically render navigation and identity elements.
- **Protection**: Ensure all protected pages check for an active session and validate the user's role at the top of the file.

---

## 🧱 Layout System

The application uses a hierarchical, role-aware layout system inspired by Next.js.

### Root Layout (`src/app/layout.php`)

The universal HTML shell. All other layouts include this file.

### Role-Specific Layouts

| Layout                       | Role      | Description                                 |
| :--------------------------- | :-------- | :------------------------------------------ |
| `src/app/admin/layout.php`   | `admin`   | Sidebar + headbar for management dashboard. |
| `src/app/doctor/layout.php`  | `doctor`  | Sidebar + headbar for clinical portal.      |
| `src/app/patient/layout.php` | `patient` | Sidebar + headbar for patient portal.       |

### Shared Components

| Component                       | Description                                             |
| :------------------------------ | :------------------------------------------------------ |
| `components/layout/sidebar.php` | Renders role-specific navigation based on `role` param. |
| `components/layout/headbar.php` | Renders page header and user identity based on `role`.  |

**Usage in Pages:**

```php
<?php
$pageTitle = "Dashboard";
$headerData = [
    'title' => 'Welcome Back!',
    'description' => 'Your overview for today.',
    'actionLabel' => 'New Appointment'
];
include_once __DIR__ . '/layout.php'; // Include the role-specific layout
?>
<!-- Page-specific content here -->
```

---

## 📚 Resources

- **Project README**: `README.md`
- **Database Schema**: `src/core/db/mindtrack.sql` (Check PHPMyAdmin)

---

_Note: This file is intended for AI agents. Adhere strictly to these patterns to maintain codebase consistency._
