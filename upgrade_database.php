<?php
include 'config/db.php';

try {
    // Add columns to Doctors
    $pdo->exec("ALTER TABLE doctors ADD COLUMN qualification VARCHAR(100) DEFAULT 'MBBS' AFTER specialization");
    $pdo->exec("ALTER TABLE doctors ADD COLUMN experience INT DEFAULT 2 AFTER qualification");
    $pdo->exec("ALTER TABLE doctors ADD COLUMN room_no VARCHAR(20) DEFAULT '101' AFTER experience");

    // Add columns to Patients
    $pdo->exec("ALTER TABLE patients ADD COLUMN blood_group VARCHAR(5) DEFAULT NULL AFTER dob");
    $pdo->exec("ALTER TABLE patients ADD COLUMN city VARCHAR(100) DEFAULT NULL AFTER address");

    // Add columns to Appointments
    $pdo->exec("ALTER TABLE appointments ADD COLUMN symptoms TEXT DEFAULT NULL AFTER notes");
    $pdo->exec("ALTER TABLE appointments ADD COLUMN prescription TEXT DEFAULT NULL AFTER symptoms");
    $pdo->exec("ALTER TABLE appointments ADD COLUMN payment_status ENUM('paid', 'unpaid') DEFAULT 'unpaid' AFTER status");

    echo "<h3>Database Upgraded Successfully! ✅</h3> <p>Added features: Qualification, Experience, Room No, Blood Group, City, Symptoms, Prescription, Payment Status.</p> <a href='index.php'>Go Home</a>";

} catch (PDOException $e) {
    // 42S21 is 'Column already exists' error code
    if ($e->getCode() == '42S21') {
        echo "<h3>Database Already Upgraded! ✅</h3> <a href='index.php'>Go Home</a>";
    } else {
        echo "Error upgrading database (Might already be done or syntax error): " . $e->getMessage();
    }
}
?>
