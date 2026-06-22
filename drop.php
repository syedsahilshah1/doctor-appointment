<?php
$pdo = new PDO("mysql:host=localhost", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("DROP DATABASE IF EXISTS doctor_appointment_db");
echo "Dropped.";
