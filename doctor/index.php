<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'doctor') {
    header("Location: ../login.php");
    exit;
}
include '../config/db.php';
include 'includes/header.php';

// Get Doctor ID
$stmt = $pdo->prepare("SELECT id FROM doctors WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$doctor_id = $stmt->fetchColumn();



// Fetch Stats
$total_app = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE doctor_id = ?");
$total_app->execute([$doctor_id]);
$total_app = $total_app->fetchColumn();

$pending_app = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE doctor_id = ? AND status = 'pending'");
$pending_app->execute([$doctor_id]);
$pending_app = $pending_app->fetchColumn();

$today_app = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE doctor_id = ? AND appointment_date = CURDATE()");
$today_app->execute([$doctor_id]);
$today_app = $today_app->fetchColumn();
?>

<h3>Dashboard Overview</h3>
<div class="row g-4 mt-2">
    <div class="col-md-4">
         <div class="card p-4 border-0 shadow-sm bg-primary text-white">
             <h5>Total Appointments</h5>
             <h2 class="fw-bold"><?php echo $total_app; ?></h2>
         </div>
    </div>
    <div class="col-md-4">
         <div class="card p-4 border-0 shadow-sm bg-warning text-dark">
             <h5>Pending Requests</h5>
             <h2 class="fw-bold"><?php echo $pending_app; ?></h2>
         </div>
    </div>
    <div class="col-md-4">
         <div class="card p-4 border-0 shadow-sm bg-success text-white">
             <h5>Today's Appointments</h5>
             <h2 class="fw-bold"><?php echo $today_app; ?></h2>
         </div>
    </div>
</div>

<div class="card mt-4 border-0 shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">Upcoming Appointments</h5>
    </div>
    <div class="card-body">
        <table class="table">
             <thead>
                 <tr>
                     <th>Patient</th>
                     <th>Date</th>
                     <th>Time</th>
                     <th>Status</th>
                 </tr>
             </thead>
             <tbody>
                 <?php
                 $stmt = $pdo->prepare("SELECT a.*, u.name as patient_name 
                                        FROM appointments a 
                                        JOIN patients p ON a.patient_id = p.id 
                                        JOIN users u ON p.user_id = u.id 
                                        WHERE a.doctor_id = ? AND a.status IN ('pending', 'confirmed') 
                                        ORDER BY a.appointment_date ASC LIMIT 5");
                 $stmt->execute([$doctor_id]);
                 while($row = $stmt->fetch()){
                     echo "<tr>
                         <td>{$row['patient_name']}</td>
                         <td>{$row['appointment_date']}</td>
                         <td>{$row['appointment_time']}</td>
                         <td>{$row['status']}</td>
                     </tr>";
                 }
                 ?>
             </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
