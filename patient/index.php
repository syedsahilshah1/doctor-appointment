<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'patient') {
    header("Location: ../login.php");
    exit;
}
include '../config/db.php';
include 'includes/header.php';

// Get Patient ID
$stmt = $pdo->prepare("SELECT id FROM patients WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$patient_id = $stmt->fetchColumn();
?>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card card-dash bg-primary text-white p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold">My Appointments</h2>
                    <p class="mb-0 opacity-75">View details and status of your bookings</p>
                </div>
                <div><i class="fas fa-notes-medical fa-3x opacity-50"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Doctor</th>
                                <th>Specialization</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $pdo->prepare("SELECT a.*, u.name as doctor_name, d.specialization 
                                                   FROM appointments a 
                                                   JOIN doctors d ON a.doctor_id = d.id 
                                                   JOIN users u ON d.user_id = u.id 
                                                   WHERE a.patient_id = ? 
                                                   ORDER BY a.appointment_date DESC");
                            $stmt->execute([$patient_id]);
                            
                            if ($stmt->rowCount() > 0) {
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
                                            <span class='fw-bold'>Dr. {$row['doctor_name']}</span>
                                        </td>
                                        <td>{$row['specialization']}</td>
                                        <td>" . date('M d, Y', strtotime($row['appointment_date'])) . "</td>
                                        <td>" . date('h:i A', strtotime($row['appointment_time'])) . "</td>
                                        <td><span class='badge {$status_badge}'>{$row['status']}</span></td>
                                        <td>";
                                        
                                    if ($row['status'] == 'pending' || $row['status'] == 'confirmed') {
                                        echo "<a href='cancel_appointment.php?id={$row['id']}' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Are you sure you want to cancel?\")'>Cancel</a>";
                                    } elseif ($row['status'] == 'completed' && !empty($row['prescription'])) {
                                        echo "<button class='btn btn-sm btn-primary' data-bs-toggle='modal' data-bs-target='#viewPrescription{$row['id']}'>
                                                <i class='fas fa-file-prescription'></i> View Rx
                                              </button>";
                                    } else {
                                        echo "<span class='text-muted'>-</span>";
                                    }
                                    
                                    echo "</td></tr>";

                                    // Valid Modal Location
                                    if ($row['status'] == 'completed') {
                                        echo "
                                        <div class='modal fade' id='viewPrescription{$row['id']}' tabindex='-1'>
                                            <div class='modal-dialog'>
                                                <div class='modal-content'>
                                                    <div class='modal-header bg-primary text-white'>
                                                        <h5 class='modal-title'><i class='fas fa-file-medical me-2'></i>Medical Prescription</h5>
                                                        <button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal'></button>
                                                    </div>
                                                    <div class='modal-body'>
                                                        <div class='mb-3 pb-3 border-bottom'>
                                                            <h6 class='fw-bold text-primary'>Dr. {$row['doctor_name']}</h6>
                                                            <small class='text-muted'>{$row['specialization']}</small>
                                                        </div>
                                                        <p class='mb-1 fw-bold'>Date: <span class='fw-normal'>" . date('M d, Y', strtotime($row['appointment_date'])) . "</span></p>
                                                        <p class='mb-3 fw-bold'>Diagnosis / Symptoms:</p>
                                                        <p class='text-muted ps-3 border-start border-3'>" . htmlspecialchars($row['symptoms'] ?? 'N/A') . "</p>
                                                        
                                                        <h6 class='fw-bold mt-4 mb-2 text-success'>Rx / Advise:</h6>
                                                        <div class='p-3 bg-light rounded text-dark' style='white-space: pre-line;'>
                                                            " . htmlspecialchars($row['prescription']) . "
                                                        </div>
                                                    </div>
                                                    <div class='modal-footer'>
                                                        <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                                        <button class='btn btn-outline-primary' onclick='window.print()'>Print</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>";
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center py-4'>No appointments found. <a href='../doctors.php'>Book one now!</a></td></tr>";
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
