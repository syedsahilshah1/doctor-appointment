<?php
session_start();
include 'config/db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login with return URL
    header("Location: login.php");
    exit;
}

// Ensure doctor_id is present
if (!isset($_GET['doctor_id'])) {
    header("Location: doctors.php");
    exit;
}

$doctor_id = $_GET['doctor_id'];
$error = "";
$success = "";

// Fetch Doctor Details
$stmt = $pdo->prepare("SELECT d.*, u.name FROM doctors d JOIN users u ON d.user_id = u.id WHERE d.id = ?");
$stmt->execute([$doctor_id]);
$doctor = $stmt->fetch();

if (!$doctor) {
    die("Doctor not found.");
}

// Handle Booking Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $patient_user_id = $_SESSION['user_id'];
    
    // Get Patient ID
    $stmt = $pdo->prepare("SELECT id FROM patients WHERE user_id = ?");
    $stmt->execute([$patient_user_id]);
    $patient_id = $stmt->fetchColumn();

    if (!$patient_id) {
         // Create patient profile if checks moved too fast (rare case usually handled at registration, but safety net)
         $stmt = $pdo->prepare("INSERT INTO patients (user_id) VALUES (?)");
         $stmt->execute([$patient_user_id]);
         $patient_id = $pdo->lastInsertId();
    }

    // 1. Check if Doctor is available on this day of week
    $day_of_week = date('l', strtotime($date)); // e.g., "Monday"
    $stmt = $pdo->prepare("SELECT * FROM schedules WHERE doctor_id = ? AND day_of_week = ?");
    $stmt->execute([$doctor_id, $day_of_week]);
    $schedule = $stmt->fetch();

    if (!$schedule) {
        $error = "Dr. {$doctor['name']} is not available on {$day_of_week}s.";
    } else {
        // 2. Check if time is within range
        $appointment_time = strtotime($time);
        $start_time = strtotime($schedule['start_time']);
        $end_time = strtotime($schedule['end_time']);

        if ($appointment_time < $start_time || $appointment_time > $end_time) {
            $error = "Please select a time between " . date('h:i A', $start_time) . " and " . date('h:i A', $end_time);
        } else {
             // 3. Check for double booking
             $stmt = $pdo->prepare("SELECT id FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND appointment_time = ? AND status != 'cancelled'");
             $stmt->execute([$doctor_id, $date, $time]);
             
             if ($stmt->rowCount() > 0) {
                 $error = "This time slot is already booked. Please choose another time.";
             } else {
                 // Book it!
                 $symptoms = $_POST['symptoms'] ?? '';
                 $notes = $_POST['notes'] ?? '';
                 $stmt = $pdo->prepare("INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, status, symptoms, notes) VALUES (?, ?, ?, ?, 'pending', ?, ?)");
                 if ($stmt->execute([$patient_id, $doctor_id, $date, $time, $symptoms, $notes])) {
                     $success = "Appointment booked successfully! Status: Pending Approval.";
                 } else {
                     $error = "Booking failed. Please try again.";
                 }
             }
        }
    }
}

include 'includes/header.php';
?>

<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white p-4">
                    <h4 class="mb-0 fw-bold">Book Appointment</h4>
                </div>
                <div class="card-body p-4">
                    
                    <div class="d-flex align-items-center mb-4 p-3 bg-light rounded">
                        <img src="<?php echo getDoctorImage($doctor['id'], $doctor['name']); ?>" class="rounded-circle me-3" width="60" height="60" style="object-fit: cover;">
                        <div>
                            <h5 class="mb-0 fw-bold">Dr. <?php echo htmlspecialchars($doctor['name']); ?></h5>
                            <small class="text-muted"><?php echo htmlspecialchars($doctor['qualification'] ?? 'Specialist'); ?></small>
                            <p class="mb-0 text-primary small fw-bold"><?php echo htmlspecialchars($doctor['specialization']); ?></p>
                        </div>
                        <div class="ms-auto text-end">
                            <span class="badge bg-success bg-opacity-10 text-success border border-success px-3">Fee: $<?php echo $doctor['consultation_fee']; ?></span>
                        </div>
                    </div>

                    <!-- Dynamic Schedule Info -->
                    <div id="doctorScheduleInfo"></div>

                    <?php if($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <?php if($success): ?>
                        <div class="alert alert-success">
                            <?php echo $success; ?>
                            <br><a href="patient/index.php" class="fw-bold">View My Appointments</a>
                        </div>
                    <?php else: ?>

                        <div class="alert alert-info py-2 small">
                            <i class="fas fa-info-circle me-1"></i>
                            Please check availability before booking to avoid rejection.
                        </div>

                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Date</label>
                                    <input type="date" name="date" id="dateInput" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Time Slot</label>
                                    <div id="slotContainer" class="p-3 border rounded bg-light text-center text-muted small d-flex flex-wrap gap-2 justify-content-center">
                                        Select a date first to see availability.
                                    </div>
                                    <input type="hidden" name="time" id="selectedTime" required>
                                    <div id="timeError" class="text-danger small mt-1" style="display:none;">Please select a time slot</div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Symptoms (Main Complaint)</label>
                                <textarea name="symptoms" class="form-control" rows="2" placeholder="E.g. High fever, headache..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Reason / Extra Notes (Optional)</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary-custom btn-lg">Confirm Booking</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Load Doctor Info Immediately
document.addEventListener('DOMContentLoaded', function() {
    let doctorId = "<?php echo $doctor_id; ?>";
    fetch(`ajax_doctor_info.php?id=${doctorId}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('doctorScheduleInfo').innerHTML = data;
        });
});

document.getElementById('dateInput').addEventListener('change', function() {
    let date = this.value;
    let doctorId = "<?php echo $doctor_id; ?>";
    
    if(date) {
        document.getElementById('slotContainer').innerHTML = "<div class='spinner-border text-primary spinner-border-sm'></div> Loading slots...";
        
        fetch(`ajax_get_slots.php?doctor_id=${doctorId}&date=${date}`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('slotContainer').innerHTML = data;
        });
    }
});

function selectSlot(btn, time) {
    // Remove active class from all
    document.querySelectorAll('.slot-btn').forEach(b => {
        b.classList.remove('btn-success', 'text-white');
        b.classList.add('btn-outline-success');
    });
    
    // Add active to clicked
    btn.classList.remove('btn-outline-success');
    btn.classList.add('btn-success', 'text-white');
    
    // Set hidden input
    document.getElementById('selectedTime').value = time;
}
</script>

<?php include 'includes/footer.php'; ?>
