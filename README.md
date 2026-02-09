# 🏥 MindTrack

MindTrack is a web-based **Patient Management and Online Appointment System** designed to digitize clinic operations for the **Wayside Psyche Resources Center**.

**About the Clinic:**
Wayside Psyche Resources Center is dedicated to promoting mental health and emotional wellness through compassionate, professional, and evidence-based care. The clinic primarily provides face-to-face consultations, ensuring accessible support for all patients. MindTrack automates the administrative side of these operations, handling appointment scheduling, patient record management, and reporting.

---

## 📋 Table of Contents

- [Overview](#overview)
- [Tech Stack](#tech-stack)
- [Features & Services](#features--services)
- [System Architecture](#system-architecture)
- [Installation & Setup](#installation--setup)
- [Database Schema](#database-schema)
- [Constraints](#constraints)

---

## 🔍 Overview

MindTrack addresses the limitations of manual scheduling by providing a centralized platform for:

- **👤 Patient Portal**: Online booking for face-to-face consultations and status tracking.
- **🩺 Doctor Portal**: Clinical dashboard for managing schedules, patients, and session notes.
- **🛡 Admin Console**: Management of patient records, provider schedules, and appointment requests.
- **⚡ Automation**: Email notifications for appointment approvals and reminders.

---

## 🛠 Tech Stack

The project is built using a standard LAMP/WAMP stack environment.

| Component           | Technology                                   |
| ------------------- | -------------------------------------------- |
| **Frontend**        | HTML5, TailwindCSS, CSS3, jQuery, JavaScript |
| **Backend**         | PHP                                          |
| **Database**        | MySQL                                        |
| **Server**          | Apache (via XAMPP)                           |
| **Design/Proto**    | Figma                                        |
| **Version Control** | GitHub                                       |

---

## 🚀 Features & Services

### 👤 User Module (Patient)

- **📅 Appointment Booking**: Interface to select service type, date, and time slots.
- **📋 Service Catalog**: Users can book the following specific services:
    - Consultation
    - Psychotherapy
    - Cognitive / Behavior Therapy (CBT)
    - Family / Couple Therapy
    - Individual Therapy
    - Addiction Counseling
    - Psychological Testing
    - Occupational Therapy
    - Applied Behavioral Analysis (ABA)
    - Training & Development Programs
    - Others
- **🛤 Status Tracking**: View approval status of requested appointments.

### 🛡 Admin Module (Staff)

- **📊 Dashboard**: High-level metrics for patient count, provider activity, and monthly appointment volume.
- **📥 Request Management**: Workflow to accept/decline bookings and assign specific doctors.
- **🗓 Calendar System**: Consolidated view of daily and monthly schedules.
- **📁 Patient Records**: CRUD operations for patient profiles and medical history.
- **👨‍⚕️ Doctor Management**: Manage provider profiles and specialties.
- **⚙ System Settings**: Admin profile management and system logs.

### 🩺 Doctor Module (Clinician)

- **📊 Clinical Dashboard**: Overview of today's schedule, pending notes, and weekly hours.
- **👥 Patient List**: Quick access to assigned patient profiles.
- **📝 Clinical Notes**: Interface for documenting session notes and diagnoses.
- **🔧 Clinical Tools**: Quick-access buttons for prescriptions, referrals, and lab portal.

---

## 🏗 System Architecture

The system follows an **Input-Process-Output (IPO)** model.

### 🔄 Data Flow

1. **User Interaction**: Patients navigate a seamless 3-step booking flow (Service Selection → Schedule & Provider → Review & Confirm).
2. **State Management**: Choices are preserved bidirectionally using URL parameter persistence, allowing users to move back and forth without losing data.
3. **Processing**: AJAX-driven interface fetches real-time provider availability and service details from backend API actions. Shared actions (e.g., registration) are centralized in `src/server/actions`, while feature-specific actions remain modular. Database logic is abstracted into models (`src/server/db`) to keep actions lightweight.
4. **Storage**: Data is normalized and stored in a relational MySQL database upon final confirmation.

---

## ⚙ Installation & Setup

### Prerequisites

- **XAMPP** (PHP >= 8.1, MariaDB/MySQL).
- **Web Browser** (Chrome/Edge/Firefox).

### Local Deployment Steps

1. **Clone the Repository**

    ```bash
    git clone [https://github.com/your-username/mindtrack.git](https://github.com/your-username/mindtrack.git)
    ```

2. **Server Configuration**
    - Move the project folder to your XAMPP `htdocs` directory (e.g., `C:\xampp\htdocs\mindtrack`).
    - Start **Apache** and **MySQL** modules in the XAMPP Control Panel.

3. **Database Setup**
    - Navigate to [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
    - Create a new database named `mindtrack`.
    - Import the SQL file located in the `core/db` folder of this repo (e.g., `mindtrack.sql`).
    - _Note: Expected environment variables (`DB_HOST`, etc.) are handled via `.env`._

4. **Run Application**
    - Access the application via: [http://localhost/mindtrack](http://localhost/mindtrack)
    - **Default Admin Credentials:** (Refer to the `admin` table in the database or the config file).

---

## 🗄 Database Schema

The system utilizes a relational database with the following core entities:

| Entity           | Description                                                 |
| ---------------- | ----------------------------------------------------------- |
| **Patient**      | Stores personal details, contact info, and medical history. |
| **Doctor**       | Stores provider profiles and specialties.                   |
| **Appointment**  | Links Patients and Doctors with time/date and status.       |
| **Notification** | Logs alerts sent to users.                                  |
| **Result**       | Stores diagnosis and session notes linked to appointments.  |
| **Admin**        | Stores administrative access credentials.                   |

---

## ⚠ Constraints

- **📹 Video Conferencing**: Not natively integrated; the system focuses on booking face-to-face consultations.
- **💸 Payments**: No integrated payment gateway; financial transactions are handled externally.
- **🌐 Connectivity**: Requires active internet connection; no offline support.
