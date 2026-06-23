<?php
$host = 'localhost';
$db_name = 'doctor_appointment_db_2';
$username = 'root';
$password = ''; // Default XAMPP password is empty

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

function getDoctorImage($id, $name) {
    $doc_images = [
        1 => 'https://randomuser.me/api/portraits/men/32.jpg',
        2 => 'https://randomuser.me/api/portraits/women/44.jpg',
        3 => 'https://randomuser.me/api/portraits/men/67.jpg',
        4 => 'https://randomuser.me/api/portraits/women/68.jpg',
        5 => 'https://randomuser.me/api/portraits/men/90.jpg',
    ];
    if (isset($doc_images[$id])) {
        return $doc_images[$id];
    }
    return 'https://ui-avatars.com/api/?name='.urlencode($name).'&background=0D8ABC&color=fff';
}
?>
