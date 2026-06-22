<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'doctor') {
    header("Location: ../login.php");
    exit;
}
include '../config/db.php';

$user_id = $_SESSION['user_id'];
$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $specialization = trim($_POST['specialization']);
    $qualification = trim($_POST['qualification']);
    $experience = $_POST['experience'];
    $room_no = trim($_POST['room_no']);
    $appointment_duration = $_POST['appointment_duration'];
    $consultation_fee = $_POST['consultation_fee'];
    $bio = trim($_POST['bio']);
    $password = $_POST['password'];

    try {
        $pdo->beginTransaction();
        
        // Update users table
        if (!empty($password)) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
            $stmt->execute([$name, $email, $hashed, $user_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
            $stmt->execute([$name, $email, $user_id]);
        }
        
        // Update doctors table
        $stmt = $pdo->prepare("UPDATE doctors SET specialization = ?, qualification = ?, experience = ?, room_no = ?, appointment_duration = ?, consultation_fee = ?, bio = ? WHERE user_id = ?");
        $stmt->execute([$specialization, $qualification, $experience, $room_no, $appointment_duration, $consultation_fee, $bio, $user_id]);
        
        $_SESSION['user_name'] = $name; // Update session
        $pdo->commit();
        $success = "Profile updated successfully!";
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Error updating profile: " . $e->getMessage();
    }
}

// Fetch current details
$stmt = $pdo->prepare("SELECT u.name, u.email, d.* FROM users u JOIN doctors d ON u.id = d.user_id WHERE u.id = ?");
$stmt->execute([$user_id]);
$doctor = $stmt->fetch();

include 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>My Profile</h2>
</div>

<?php if($success): ?>
    <div class="alert alert-success alert-dismissible fade show"><?php echo $success; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>
<?php if($error): ?>
    <div class="alert alert-danger alert-dismissible fade show"><?php echo $error; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="POST" action="">
            <h5 class="text-primary mb-3"><i class="fas fa-user-circle me-2"></i>Basic Information</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($doctor['name']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($doctor['email']); ?>" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label>New Password <small class="text-muted">(Leave blank to keep current password)</small></label>
                    <input type="password" name="password" class="form-control">
                </div>
            </div>

            <hr class="my-4">
            <h5 class="text-primary mb-3"><i class="fas fa-stethoscope me-2"></i>Professional Details</h5>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Specialization</label>
                    <select name="specialization" class="form-select" required>
                        <option value="General Physician" <?php echo $doctor['specialization'] == 'General Physician' ? 'selected' : ''; ?>>General Physician</option>
                        <option value="Cardiologist" <?php echo $doctor['specialization'] == 'Cardiologist' ? 'selected' : ''; ?>>Cardiologist</option>
                        <option value="Dermatologist" <?php echo $doctor['specialization'] == 'Dermatologist' ? 'selected' : ''; ?>>Dermatologist</option>
                        <option value="Pediatrician" <?php echo $doctor['specialization'] == 'Pediatrician' ? 'selected' : ''; ?>>Pediatrician</option>
                        <option value="Neurologist" <?php echo $doctor['specialization'] == 'Neurologist' ? 'selected' : ''; ?>>Neurologist</option>
                        <option value="Dentist" <?php echo $doctor['specialization'] == 'Dentist' ? 'selected' : ''; ?>>Dentist</option>
                        <option value="Orthopedics" <?php echo $doctor['specialization'] == 'Orthopedics' ? 'selected' : ''; ?>>Orthopedics</option>
                        <option value="Optometry" <?php echo $doctor['specialization'] == 'Optometry' ? 'selected' : ''; ?>>Optometry</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Qualification</label>
                    <input type="text" name="qualification" class="form-control" value="<?php echo htmlspecialchars($doctor['qualification'] ?? ''); ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Experience (Years)</label>
                    <input type="number" name="experience" class="form-control" value="<?php echo htmlspecialchars($doctor['experience'] ?? 0); ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Room Number</label>
                    <input type="text" name="room_no" class="form-control" value="<?php echo htmlspecialchars($doctor['room_no'] ?? ''); ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Consultation Fee ($)</label>
                    <input type="number" name="consultation_fee" class="form-control" value="<?php echo htmlspecialchars($doctor['consultation_fee']); ?>" required step="0.01">
                </div>
                <div class="col-md-12 mb-3">
                    <label>Appointment Duration (Minutes)</label>
                    <input type="number" name="appointment_duration" class="form-control" value="<?php echo htmlspecialchars($doctor['appointment_duration'] ?? 30); ?>" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Bio / About Me</label>
                    <textarea name="bio" class="form-control" rows="4"><?php echo htmlspecialchars($doctor['bio'] ?? ''); ?></textarea>
                </div>
            </div>
            
            <button type="submit" name="update_profile" class="btn btn-primary mt-3"><i class="fas fa-save me-2"></i>Save Changes</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
