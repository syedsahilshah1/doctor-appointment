<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'patient') {
    header("Location: ../login.php");
    exit;
}

if(isset($_GET['id'])) {
    $appoint_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Verify ownership
    $stmt = $pdo->prepare("SELECT a.id FROM appointments a JOIN patients p ON a.patient_id = p.id WHERE a.id = ? AND p.user_id = ?");
    $stmt->execute([$appoint_id, $user_id]);
    
    if($stmt->rowCount() > 0) {
        // Update status to cancelled
        $stmt = $pdo->prepare("UPDATE appointments SET status = 'cancelled' WHERE id = ?");
        $stmt->execute([$appoint_id]);
    }
}

header("Location: index.php");
exit;
?>
