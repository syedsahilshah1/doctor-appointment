<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

include '../config/db.php';
include 'includes/header.php';

// Handle Filter
$filter_date = isset($_GET['date']) ? $_GET['date'] : '';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>All Appointments</h2>
    <form class="d-flex gap-2">
        <input type="date" name="date" class="form-control" value="<?php echo $filter_date; ?>">
        <button type="submit" class="btn btn-primary">Filter</button>
        <?php if($filter_date): ?><a href="appointments.php" class="btn btn-secondary">Reset</a><?php endif; ?>
    </form>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT a.*, p_u.name as patient_name, d_u.name as doctor_name 
                            FROM appointments a 
                            JOIN patients p ON a.patient_id = p.id 
                            JOIN users p_u ON p.user_id = p_u.id 
                            JOIN doctors d ON a.doctor_id = d.id 
                            JOIN users d_u ON d.user_id = d_u.id";
                    
                    if ($filter_date) {
                        $sql .= " WHERE a.appointment_date = :date";
                    }
                    
                    $sql .= " ORDER BY a.appointment_date DESC";
                    
                    $stmt = $pdo->prepare($sql);
                    if ($filter_date) {
                        $stmt->execute(['date' => $filter_date]);
                    } else {
                        $stmt->execute();
                    }

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
                            <td>
                                <div>" . date('M d, Y', strtotime($row['appointment_date'])) . "</div>
                                <small class='text-muted'>" . date('h:i A', strtotime($row['appointment_time'])) . "</small>
                            </td>
                            <td><span class='badge {$status_badge}'>{$row['status']}</span></td>
                             <td><small>" . htmlspecialchars($row['notes'] ?? '') . "</small></td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
