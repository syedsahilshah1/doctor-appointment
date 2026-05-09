<?php
include 'config/db.php';


try {
    // Add appointment_duration to doctors table
    $pdo->exec("ALTER TABLE doctors ADD COLUMN appointment_duration INT DEFAULT 30 AFTER consultation_fee");
    
    echo "<h3>Database Upgraded: Time Slots Enabled! ⏰</h3> <p>Added 'appointment_duration' to doctors table.</p> <a href='index.php'>Go Home</a>";

} catch (PDOException $e) {
    if ($e->getCode() == '42S21') {
        echo "<h3>Database Already Ready! ✅</h3> <a href='index.php'>Go Home</a>";
    } else {
        echo "Error: " . $e->getMessage();
    }
}
?>
