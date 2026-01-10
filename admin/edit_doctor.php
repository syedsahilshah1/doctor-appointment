<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../config/db.php';

$success = "";
$error = "";
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: doctors.php");
    exit;
}

// Fetch existing data
$stmt = $pdo->prepare("SELECT d.*, u.name, u.email FROM doctors d JOIN users u ON d.user_id = u.id WHERE d.id = ?");
$stmt->execute([$id]);
$doctor = $stmt->fetch();

if (!$doctor) {
    die("Doctor not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $specialization = trim($_POST['specialization']);
    $qualification = trim($_POST['qualification']);
    $experience = $_POST['experience'];
    $room_no = $_POST['room_no'];
    $fee = $_POST['fee'];
    $duration = $_POST['duration'];
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Update User
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    if($stmt->execute([$name, $email, $doctor['user_id']])) {
        // Update Doctor
        $stmt = $pdo->prepare("UPDATE doctors SET specialization = ?, qualification = ?, experience = ?, room_no = ?, consultation_fee = ?, appointment_duration = ?, is_active = ? WHERE id = ?");
        $stmt->execute([$specialization, $qualification, $experience, $room_no, $fee, $duration, $is_active, $id]);
        $success = "Doctor updated successfully.";
        
        // Refresh
        $stmt = $pdo->prepare("SELECT d.*, u.name, u.email FROM doctors d JOIN users u ON d.user_id = u.id WHERE d.id = ?");
        $stmt->execute([$id]);
        $doctor = $stmt->fetch();
    } else {
        $error = "Failed to update doctor.";
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                 <h4 class="mb-0">Edit Doctor</h4>
            </div>
            <div class="card-body">
                <?php if($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($doctor['name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($doctor['email']); ?>" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Specialization</label>
                             <select name="specialization" class="form-select" required>
                                <option value="<?php echo $doctor['specialization']; ?>" selected><?php echo $doctor['specialization']; ?> (Current)</option>
                                <option value="General Physician">General Physician</option>
                                <option value="Cardiologist">Cardiologist</option>
                                <option value="Dermatologist">Dermatologist</option>
                                <option value="Dentist">Dentist</option>
                                <option value="Neurologist">Neurologist</option>
                                <option value="Pediatrician">Pediatrician</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Qualification</label>
                            <input type="text" name="qualification" class="form-control" value="<?php echo htmlspecialchars($doctor['qualification'] ?? ''); ?>" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Experience</label>
                            <input type="number" name="experience" class="form-control" value="<?php echo $doctor['experience']; ?>">
                        </div>
                         <div class="col-md-4 mb-3">
                            <label>Room No</label>
                            <input type="text" name="room_no" class="form-control" value="<?php echo htmlspecialchars($doctor['room_no'] ?? ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Fee ($)</label>
                            <input type="number" name="fee" class="form-control" value="<?php echo $doctor['consultation_fee']; ?>" required step="0.01">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Slot Duration (Mins)</label>
                            <select name="duration" class="form-select">
                                <option value="15" <?php echo ($doctor['appointment_duration'] == 15) ? 'selected' : ''; ?>>15 Mins</option>
                                <option value="20" <?php echo ($doctor['appointment_duration'] == 20) ? 'selected' : ''; ?>>20 Mins</option>
                                <option value="30" <?php echo ($doctor['appointment_duration'] == 30) ? 'selected' : ''; ?>>30 Mins (Default)</option>
                                <option value="45" <?php echo ($doctor['appointment_duration'] == 45) ? 'selected' : ''; ?>>45 Mins</option>
                                <option value="60" <?php echo ($doctor['appointment_duration'] == 60) ? 'selected' : ''; ?>>1 Hour</option>
                            </select>
                        </div>
                    </div>

                     <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive" <?php echo $doctor['is_active'] ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="isActive">Active Status</label>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                         <a href="doctors.php" class="btn btn-secondary">Back</a>
                         <button type="submit" class="btn btn-primary">Update Doctor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
