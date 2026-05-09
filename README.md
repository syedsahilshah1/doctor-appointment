# 🏥 DocCare - Doctor Appointment System

A premium, fully functional **Doctor Appointment Web Application** built with **Core PHP** (No Frameworks). This project is designed for university projects, portfolios, and final year projects (FYP).

![DocCare Preview](assets/images/preview.png)
*(Note: Add a screenshot of your landing page here)*


---

## ✨ Features


### 👤 Public Area
*   **Modern Landing Page**: Glassmorphism UI with animations.
*   **Find Doctors**: Search by name or specialization.
*   **View Doctor Profile**: See qualification, experience, fee, and room number.
*   **Register/Login**: Secure authentication system.

### 🩺 Patient Panel
*   **Book Appointment**:
    *   View Doctor's **Weekly Schedule** and **Available Time Slots**.
    *   Prevents checking out outside working hours or double-booking.
    *   Add **Symptoms** and Notes.
*   **Dashboard**: View appointment history and status.
*   **Digital Prescription**: View and print prescriptions/reports after the visit.
*   **Cancel Appointment**: Option to cancel pending requests.

### 👨‍⚕️ Doctor Panel
*   **Dashboard**: Daily stats (Total bookings, Pending, Completed).
*   **Manage Schedule**: Add/Remove available days and time slots.
*   **Appointment Actions**:
    *   **Confirm** or **Reject** appointments.
    *   **Treat Patient**: View symptoms and write a **Digital Prescription**.

### ⚡ Admin Panel
*   **Manage Doctors**: Add, Edit, Delete doctors (including setting Slot Duration & Fees).
*   **View Patients**: See patient details (Blood Group, City).
*   **Analytics**: View total appointments, revenue stats (simulated).

---

## 🔐 Login Credentials (Default)

Use these accounts to test the system:

### 🔴 Admin Account
*   **Email:** `admin@admin.com`
*   **Password:** `admin123`

### 🔵 Doctor Account (Sample)
*   **Email:** `smith@hospital.com`
*   **Password:** `password123`
*   *(Other doctors available in database with same password)*

### 🟢 Patient Account
*   You can **Register** a new account from the "Sign Up" page.

---

## 🛠️ Installation Guide

1.  **Download/Clone** this repository.
2.  **Move the folder** to your server directory (e.g., `C:\xampp\htdocs\Docter-appointment`).
3.  **Database Setup**:
    *   Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
    *   Create a database named **`doctor_appointment_db`**.
    *   Import the `database.sql` file provided in the root folder.
    *   *(Alternatively, run `http://localhost/Docter-appointment/setup_database.php` and `seeder.php` to auto-setup).*
4.  **Configure DB**:
    *   Open `config/db.php` and ensure credentials match (Default: `root`, no password).
5.  **Run**:
    *   Open browser and visit: `http://localhost/Docter-appointment/`

---

## 💻 Tech Stack

*   **Frontend**: HTML5, CSS3 (Custom + Glassmorphism), Bootstrap 5, JavaScript.
*   **Backend**: Core PHP (Object Oriented / PDO).
*   **Database**: MySQL.

---

## 📂 Project Structure
```
/Docter-appointment
├── admin/              # Admin Dashboard
├── doctor/             # Doctor Dashboard
├── patient/            # Patient Dashboard & Booking History
├── assets/             # CSS, JS, Images
├── config/             # Database Connection
├── includes/           # Reusable Header/Footer
├── database.sql        # Database Import File
├── index.php           # Landing Page
├── login.php           # Universal Login
├── register.php        # Patient Registration
├── doctors.php         # Doctor Listing & Search
└── booking.php         # Smart Booking System
```

---

Developed with ❤️ by **[Your Name]**
