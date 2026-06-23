<?php
include 'config/db.php';
$doc_id = $_GET['id'];

// Get Schedules (Days)
$stmt = $pdo->prepare("SELECT day_of_week, start_time, end_time FROM schedules WHERE doctor_id = ? ORDER BY FIELD(day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')");
$stmt->execute([$doc_id]);
$schedules = $stmt->fetchAll();


// Get Total Slots (Estimate per day) & Booked today
$today = date('Y-m-d');
$stmt = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND status != 'cancelled'");
$stmt->execute([$doc_id, $today]);
$booked_today = $stmt->fetchColumn();

// Get Duration
$stmt = $pdo->prepare("SELECT appointment_duration FROM doctors WHERE id = ?");
$stmt->execute([$doc_id]);
$duration = $stmt->fetchColumn() ?: 30;

echo "
<div class='card border-0 bg-light mb-4'>
    <div class='card-body p-3'>
        <h6 class='fw-bold text-primary mb-2'><i class='fas fa-calendar-alt me-2'></i>Weekly Schedule</h6>
        <div class='d-flex flex-wrap gap-2 mb-3'>";
        
        if($schedules) {
            foreach($schedules as $sch) {
                echo "<span class='badge bg-white text-dark border px-3 py-2'>
                        <span class='fw-bold text-primary'>{$sch['day_of_week']}</span><br>
                        <small>" . date('h:i A', strtotime($sch['start_time'])) . " - " . date('h:i A', strtotime($sch['end_time'])) . "</small>
                      </span>";
            }
        } else {
            echo "<span class='text-muted small'>No schedule set.</span>";
        }

echo "  </div>

        <div class='d-flex justify-content-between align-items-center border-top pt-2'>
             <small class='text-muted'><i class='fas fa-clock me-1'></i> Avg Duration: <strong>{$duration} mins</strong></small>
             <small class='text-muted'><i class='fas fa-user-check me-1'></i> Booked Today: <strong>{$booked_today}</strong></small>
        </div>
    </div>
</div>";
?>
