# 🏥 MindTrack

MindTrack is a web-based **Patient Management and Online Appointment System** designed to digitize clinic operations for the **Wayside Psyche Resource Center**. It automates appointment scheduling, patient record management, and administrative reporting.

---

## 📋 Table of Contents

- [Overview](#overview)
- [Tech Stack](#tech-stack)
- [Features](#features)
- [System Architecture](#system-architecture)
- [Installation & Setup](#installation--setup)
- [Database Schema](#database-schema)
- [Constraints](#constraints)

---

## 🔍 Overview

MindTrack addresses the limitations of manual scheduling by providing a centralized platform for:

- **👤 Patient Portal**: Online booking and status tracking.
- **🛡 Admin Console**: Management of patient records, provider schedules, and appointment requests.
- **⚡ Automation**: Email notifications for appointment approvals and reminders.

---

## 🛠 Tech Stack

The project is built using a standard LAMP/WAMP stack environment.

| Component           | Technology              |
| ------------------- | ----------------------- |
| **Frontend**        | HTML5, CSS3, JavaScript |
| **Backend**         | PHP                     |
| **Database**        | MySQL                   |
| **Server**          | Apache (via XAMPP)      |
| **Design/Proto**    | Figma                   |
| **Version Control** | GitHub                  |

---

## 🚀 Features

### 👤 User Module (Patient)

- **📅 Appointment Booking**: Interface to select service type, date, and time slots.
- **📋 Service Catalog**: View available services (e.g., Individual Therapy, Addiction Counseling).
- **🛤 Status Tracking**: View approval status of requested appointments.

### 🛡 Admin Module (Staff)

- **📊 Dashboard**: High-level metrics for patient count, provider activity, and monthly appointment volume.
- **📥 Request Management**: Workflow to accept/decline bookings and assign specific doctors.
- **🗓 Calendar System**: Consolidated view of daily and monthly schedules.
- **📁 Patient Records**: CRUD operations for patient profiles and medical history.
- **👨‍⚕️ Doctor Management**: Manage provider profiles and specialties.
- **⚙ System Settings**: Admin profile management and system logs.

---

## 🏗 System Architecture

The system follows an **Input-Process-Output (IPO)** model.

### 🔄 Data Flow

1. **User Interaction**: Patients submit booking requests via the web interface.
2. **Processing**: Admin reviews requests; the system checks availability and assigns doctors.
3. **Notification**: The system triggers email notifications upon status changes.
4. **Storage**: Data is normalized and stored in a relational MySQL database.

---

## ⚙ Installation & Setup

### Prerequisites

- **XAMPP** (PHP >= 7.x, MariaDB/MySQL).
- **Web Browser** (Chrome/Edge/Firefox).

### Local Deployment Steps

1. **Clone the Repository**

    ```bash
    git clone https://github.com/your-username/mindtrack.git
    ```

2. **Server Configuration**
    - Move the project folder to your XAMPP `htdocs` directory (e.g., `C:\xampp\htdocs\mindtrack`).
    - Start **Apache** and **MySQL** modules in the XAMPP Control Panel.

3. **Database Setup**
    - Navigate to [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
    - Create a new database named `mindtrack`.
    - Import the SQL file located in the `/database` folder of this repo (e.g., `mindtrack.sql`).
    - _Note: Ensure `db_connection.php` (or equivalent config file) matches your local DB credentials._

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

- **📹 Video Conferencing**: Not natively integrated; requires external tools (Zoom/Google Meet).
- **💸 Payments**: No integrated payment gateway; financial transactions are handled externally.
- **🌐 Connectivity**: Requires active internet connection; no offline support.
