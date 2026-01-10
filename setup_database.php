<?php
$host = 'localhost';
$username = 'root';
$password = ''; // Default XAMPP password

try {
    // 1. Connect without Database to create it
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to MySQL server successfully.<br>";

    // 2. Create Database
    $dbname = "`doctor_appointment_db`";
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    echo "Database '$dbname' created or already exists.<br>";

    // 3. Select Database
    $pdo->exec("USE $dbname");

    // 4. Read SQL file
    $sql_file = __DIR__ . '/database.sql';
    if (file_exists($sql_file)) {
        $sql = file_get_contents($sql_file);
        
        // Execute SQL commands
        $pdo->exec($sql);
        echo "Tables created successfully from database.sql.<br>";
        
        // 5. Create Default Admin if it doesn't exist
        $admin_email = 'admin@admin.com';
        $stmt = $pdo->query("SELECT id FROM users WHERE email = '$admin_email'");
        if ($stmt->rowCount() == 0) {
            $admin_pass = password_hash('admin123', PASSWORD_DEFAULT);
            $pdo->exec("INSERT INTO users (name, email, password, role) VALUES ('Admin', '$admin_email', '$admin_pass', 'admin')");
            echo "Default Admin User Created: admin@admin.com / admin123<br>";
        }
        
    } else {
        echo "Error: database.sql file not found at $sql_file<br>";
    }

    echo "<hr><strong style='color:green'>Setup Completed Successfully!</strong> <a href='index.php'>Go to Home</a>";

} catch(PDOException $e) {
    die("DB CONNECTION FAILED: " . $e->getMessage());
}
?>
