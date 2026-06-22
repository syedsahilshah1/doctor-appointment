-- Database: doctor_appointment_db



-- Users Table (Stores Admin, Doctor, Patient login info)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'doctor', 'patient') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Doctors Table (Extra info for doctors)
CREATE TABLE doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    specialization VARCHAR(100) NOT NULL,
    qualification VARCHAR(100) DEFAULT 'MBBS, FCPS',
    experience INT DEFAULT 5,
    room_no VARCHAR(20) DEFAULT '101',
    appointment_duration INT DEFAULT 30,
    consultation_fee DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    bio TEXT,
    is_active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Patients Table (Extra info for patients)
CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    city VARCHAR(100),
    gender ENUM('Male', 'Female', 'Other'),
    dob DATE,
    blood_group VARCHAR(10),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Schedules Table (Doctor availability)
CREATE TABLE schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_id INT NOT NULL,
    day_of_week ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE
);

-- Appointments Table
CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    doctor_id INT NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled', 'rejected') DEFAULT 'pending',
    symptoms TEXT,
    notes TEXT,
    prescription TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (patient_id) REFERENCES patients(id) ON DELETE CASCADE,
    FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE
);

-- Create a default admin user (Password: admin123)
-- Hash for 'admin123' (BCRYPT) - You might need to generate this via PHP for accuracy, 
-- but here is a placeholder. It is better to register via the app or use a known hash.
-- $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi is 'password' usually found in Laravel factories, 
-- let's just insert a raw one and users should hash it or I will provide a registration script mostly.
-- For now, let's leave data insertion for the setup script or manual entry.
