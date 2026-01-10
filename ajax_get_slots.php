<?php
include 'config/db.php';

if (!isset($_GET['doctor_id']) || !isset($_GET['date'])) {
    exit;
}

$doctor_id = $_GET['doctor_id'];
$date = $_GET['date'];
$day_of_week = date('l', strtotime($date));

// 1. Get Doctor's Schedule
$stmt = $pdo->prepare("SELECT * FROM schedules WHERE doctor_id = ? AND day_of_week = ?");
$stmt->execute([$doctor_id, $day_of_week]);
$schedule = $stmt->fetch();

// 2. Get Appointment Duration
$stmt = $pdo->prepare("SELECT appointment_duration FROM doctors WHERE id = ?");
$stmt->execute([$doctor_id]);
$duration = $stmt->fetchColumn() ?: 30; // Default 30 mins

if (!$schedule) {
    echo "<div class='text-danger fw-bold text-center mt-3'><i class='fas fa-calendar-times me-2'></i>Doctor is not available on {$day_of_week}s.</div>";
    exit;
}

// 3. Get Booked Slots
$stmt = $pdo->prepare("SELECT appointment_time FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND status != 'cancelled'");
$stmt->execute([$doctor_id, $date]);
$booked_times = $stmt->fetchAll(PDO::FETCH_COLUMN);

// 4. Generate Times
$start = strtotime($schedule['start_time']);
$end = strtotime($schedule['end_time']);

echo "<div class='row g-2 mt-3'>";
$count = 0;

for ($time = $start; $time < $end; $time += ($duration * 60)) {
    $current_slot = date('H:i:00', $time);
    $display_time = date('h:i A', $time);
    
    // Check if booked
    if (in_array($current_slot, $booked_times)) {
        echo "<div class='col-4 col-md-3'>
                <button type='button' class='btn btn-outline-secondary w-100 disabled' style='opacity:0.6; text-decoration:line-through'>$display_time</button>
              </div>";
    } else {
        // Active Slot
        echo "<div class='col-4 col-md-3'>
                <button type='button' class='btn btn-outline-success w-100 slot-btn' onclick='selectSlot(this, \"$current_slot\")'>$display_time</button>
              </div>";
        $count++;
    }
}
echo "</div>";

if($count == 0) {
    echo "<div class='text-warning fw-bold text-center mt-3'>All slots fully booked for this day!</div>";
}
?>
