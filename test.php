<?php
require 'config/db.php';
$stmt = $pdo->query('SELECT DISTINCT specialization FROM doctors');
print_r($stmt->fetchAll(PDO::FETCH_COLUMN));
