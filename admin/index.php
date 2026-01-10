<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../config/db.php';
include 'includes/header.php';

// Fetch stats
$stmt = $pdo->query("SELECT COUNT(*) FROM doctors");
$total_doctors = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM patients");
$total_patients = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM appointments");
$total_appointments = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'pending'");
$pending_appointments = $stmt->fetchColumn();
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<div class="row g-4">
    <div class="col-md-6 col-lg-3">
        <div class="card card-stat p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Total Doctors</h6>
                    <h3 class="fw-bold mb-0"><?php echo $total_doctors; ?></h3>
                </div>
                <div class="icon-box bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-user-md"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="card card-stat p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Total Patients</h6>
                    <h3 class="fw-bold mb-0"><?php echo $total_patients; ?></h3>
                </div>
                <div class="icon-box bg-success bg-opacity-10 text-success">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="card card-stat p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Appointments</h6>
                    <h3 class="fw-bold mb-0"><?php echo $total_appointments; ?></h3>
                </div>
                <div class="icon-box bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6 col-lg-3">
        <div class="card card-stat p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted mb-2">Pending</h6>
                    <h3 class="fw-bold mb-0"><?php echo $pending_appointments; ?></h3>
                </div>
                <div class="icon-box bg-danger bg-opacity-10 text-danger">
                    <i class="fas fa-hourglass-half"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="card-title mb-0">Recent Appointments</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $pdo->query("SELECT a.*, u_p.name as patient_name, u_d.name as doctor_name 
                                                 FROM appointments a 
                                                 JOIN patients p ON a.patient_id = p.id 
                                                 JOIN users u_p ON p.user_id = u_p.id
                                                 JOIN doctors d ON a.doctor_id = d.id 
                                                 JOIN users u_d ON d.user_id = u_d.id
                                                 ORDER BY a.created_at DESC LIMIT 5");
                            while ($row = $stmt->fetch()) {
                                $status_badge = match($row['status']) {
                                    'pending' => 'bg-warning',
                                    'confirmed' => 'bg-primary',
                                    'completed' => 'bg-success',
                                    'cancelled' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                                echo "<tr>
                                    <td>#{$row['id']}</td>
                                    <td>{$row['patient_name']}</td>
                                    <td>Dr. {$row['doctor_name']}</td>
                                    <td>{$row['appointment_date']}</td>
                                    <td><span class='badge {$status_badge}'>{$row['status']}</span></td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
