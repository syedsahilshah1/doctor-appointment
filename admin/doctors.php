<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../config/db.php';

$success = "";
$error = "";

// Handle Add Doctor
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_doctor'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $specialization = trim($_POST['specialization']);
    $qualification = trim($_POST['qualification']);
    $experience = $_POST['experience'];
    $room_no = $_POST['room_no'];
    $fee = $_POST['fee'];

    // Basic Validation
    if(empty($name) || empty($email) || empty($password)){
         $error = "All fields are required";
    } else {
         // Check email
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $error = "Email already exists.";
        } else {
             try {
                $pdo->beginTransaction();
                // 1. Create User
                $hashed = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'doctor')");
                $stmt->execute([$name, $email, $hashed]);
                $user_id = $pdo->lastInsertId();

                // 2. Create Doctor Profile (Updated with new fields)
                $stmt = $pdo->prepare("INSERT INTO doctors (user_id, specialization, qualification, experience, room_no, consultation_fee) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$user_id, $specialization, $qualification, $experience, $room_no, $fee]);
                
                $pdo->commit();
                $success = "Doctor added successfully!";
             } catch (Exception $e) {
                 $pdo->rollBack();
                 $error = "Error adding doctor: " . $e->getMessage();
             }
        }
    }
}

// Handle Delete Doctor
if(isset($_GET['delete'])) {
    $doc_id = $_GET['delete'];
    try {
        $stmt = $pdo->prepare("SELECT user_id FROM doctors WHERE id = ?");
        $stmt->execute([$doc_id]);
        $u_id = $stmt->fetchColumn();
        
        if($u_id) {
            $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?"); 
            $stmt->execute([$u_id]);
            $success = "Doctor deleted.";
        }
    } catch (Exception $e) {
        $error = "Error deleting doctor.";
    }
}

include 'includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Manage Doctors</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDoctorModal">
        <i class="fas fa-plus me-2"></i>Add New Doctor
    </button>
</div>

<?php if($success): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $success; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if($error): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name (Qual.)</th>
                        <th>Specialization</th>
                        <th>Room</th>
                        <th>Fee</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("SELECT d.*, u.name, u.email FROM doctors d JOIN users u ON d.user_id = u.id ORDER BY d.id DESC");
                    while($row = $stmt->fetch()){
                        $status = $row['is_active'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
                        echo "<tr>
                            <td>#{$row['id']}</td>
                            <td>
                                <div class='fw-bold'>{$row['name']}</div>
                                <small class='text-muted'>{$row['qualification']} | {$row['experience']} Yrs Exp</small>
                            </td>
                            <td>{$row['specialization']}</td>
                            <td>{$row['room_no']}</td>
                            <td>\${$row['consultation_fee']}</td>
                            <td>
                                <a href='edit_doctor.php?id={$row['id']}' class='btn btn-sm btn-outline-primary me-1'><i class='fas fa-edit'></i></a>
                                <a href='?delete={$row['id']}' class='btn btn-sm btn-outline-danger' onclick='return confirm(\"Are you sure?\")'><i class='fas fa-trash'></i></a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Doctor Modal (Updated) -->
<div class="modal fade" id="addDoctorModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Doctor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" required placeholder="Dr. John Doe">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Specialization</label>
                            <select name="specialization" class="form-select" required>
                                <option value="">Select...</option>
                                <option value="General Physician">General Physician</option>
                                <option value="Cardiologist">Cardiologist</option>
                                <option value="Dermatologist">Dermatologist</option>
                                <option value="Pediatrician">Pediatrician</option>
                                <option value="Neurologist">Neurologist</option>
                                <option value="Dentist">Dentist</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Qualification</label>
                            <input type="text" name="qualification" class="form-control" placeholder="MBBS, FCPS" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Experience (Years)</label>
                            <input type="number" name="experience" class="form-control" value="0" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Room Number</label>
                            <input type="text" name="room_no" class="form-control" placeholder="101" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Consultation Fee ($)</label>
                            <input type="number" name="fee" class="form-control" required step="0.01">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="add_doctor" class="btn btn-primary">Save Doctor</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
