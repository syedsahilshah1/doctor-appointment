<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'doctor') {
    header("Location: ../login.php");
    exit;
}
include '../config/db.php';

// Get Doctor ID
$stmt = $pdo->prepare("SELECT id FROM doctors WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$doctor_id = $stmt->fetchColumn();

// Handle Status Change
if(isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action']; // confirm, cancel
    $app_id = $_GET['id'];
    
    $status = 'pending';
    if ($action == 'confirm') $status = 'confirmed';
    if ($action == 'cancel') $status = 'cancelled';
    
    $stmt = $pdo->prepare("UPDATE appointments SET status = ? WHERE id = ? AND doctor_id = ?");
    $stmt->execute([$status, $app_id, $doctor_id]);
    header("Location: appointments.php");
    exit;
}

// Handle Prescription Update
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['write_prescription'])) {
    $pres_id = $_POST['appointment_id'];
    $prescription = $_POST['prescription'];
    
    $stmt = $pdo->prepare("UPDATE appointments SET status = 'completed', prescription = ? WHERE id = ? AND doctor_id = ?");
    $stmt->execute([$prescription, $pres_id, $doctor_id]);
    header("Location: appointments.php?success=1");
    exit;
}

include 'includes/header.php';
?>

<h3 class="mb-4">My Appointments</h3>

<?php if(isset($_GET['success'])): ?>
<div class="alert alert-success">Prescription saved and appointment completed!</div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>Patient</th>
                        <th>Symptoms (Issue)</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->prepare("SELECT a.*, u.name as patient_name, p.blood_group 
                                           FROM appointments a 
                                           JOIN patients p ON a.patient_id = p.id 
                                           JOIN users u ON p.user_id = u.id 
                                           WHERE a.doctor_id = ? 
                                           ORDER BY a.appointment_date DESC");
                    $stmt->execute([$doctor_id]);
                    while ($row = $stmt->fetch()) {
                        $status_badge = match($row['status']) {
                            'pending' => 'bg-warning',
                            'confirmed' => 'bg-primary',
                            'completed' => 'bg-success',
                            'cancelled' => 'bg-danger',
                            default => 'bg-secondary'
                        };
                        
                        echo "<tr>
                            <td>
                                <div class='fw-bold'>" . date('M d, Y', strtotime($row['appointment_date'])) . "</div>
                                <small class='text-muted'>" . date('h:i A', strtotime($row['appointment_time'])) . "</small>
                            </td>
                            <td>
                                {$row['patient_name']}
                                <div class='small text-muted'>BG: ".($row['blood_group'] ?? 'N/A')."</div>
                            </td>
                            <td><span class='text-danger small'>" . htmlspecialchars($row['symptoms'] ?? 'Not specified') . "</span></td>
                            <td><span class='badge {$status_badge}'>{$row['status']}</span></td>
                            <td>";
                            
                        if($row['status'] == 'pending') {
                            echo "<a href='?action=confirm&id={$row['id']}' class='btn btn-sm btn-success me-1' title='Confirm'><i class='fas fa-check'></i></a>
                                  <a href='?action=cancel&id={$row['id']}' class='btn btn-sm btn-danger' title='Reject'><i class='fas fa-times'></i></a>";
                        } elseif($row['status'] == 'confirmed') {
                             echo "<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#prescribeModal{$row['id']}'>
                                    <i class='fas fa-notes-medical'></i> Treat & Prescribe
                                   </button>";
                        } elseif($row['status'] == 'completed') {
                             echo "<span class='text-success small'><i class='fas fa-check-circle'></i> Completed</span>";
                        }
                        
                        echo "</td></tr>";
                        
                        // Modal for Prescription
                        if($row['status'] == 'confirmed') {
                            echo "
                            <div class='modal fade' id='prescribeModal{$row['id']}' tabindex='-1'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>
                                        <form method='POST'>
                                            <div class='modal-header'>
                                                <h5 class='modal-title'>Write Prescription for {$row['patient_name']}</h5>
                                                <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                                            </div>
                                            <div class='modal-body'>
                                                <input type='hidden' name='appointment_id' value='{$row['id']}'>
                                                <div class='mb-3'>
                                                    <label class='fw-bold'>Symptoms:</label>
                                                    <p class='text-danger'>".htmlspecialchars($row['symptoms'] ?? 'No symptoms provided.')."</p>
                                                </div>
                                                <div class='mb-3'>
                                                    <label class='fw-bold'>Prescription / Medicine / Advice:</label>
                                                    <textarea name='prescription' class='form-control' rows='5' required placeholder='Rx: Tab Paracetamol 500mg (1+1+1)...'></textarea>
                                                </div>
                                            </div>
                                            <div class='modal-footer'>
                                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                                <button type='submit' name='write_prescription' class='btn btn-success'>Complete Appointment</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            ";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
