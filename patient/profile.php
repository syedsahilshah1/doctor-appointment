<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'patient') {
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
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $gender = trim($_POST['gender']);
    $dob = trim($_POST['dob']);
    $blood_group = trim($_POST['blood_group']);
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
        
        // Update patients table
        $stmt = $pdo->prepare("UPDATE patients SET phone = ?, address = ?, city = ?, gender = ?, dob = ?, blood_group = ? WHERE user_id = ?");
        $stmt->execute([$phone, $address, $city, $gender, $dob, $blood_group, $user_id]);
        
        $_SESSION['user_name'] = $name; // Update session
        $pdo->commit();
        $success = "Profile updated successfully!";
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Error updating profile: " . $e->getMessage();
    }
}

// Fetch current details
$stmt = $pdo->prepare("SELECT u.name, u.email, p.* FROM users u JOIN patients p ON u.id = p.user_id WHERE u.id = ?");
$stmt->execute([$user_id]);
$patient = $stmt->fetch();

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <h3 class="mb-4 text-primary fw-bold"><i class="fas fa-user-circle me-2"></i>My Profile</h3>

        <?php if($success): ?>
            <div class="alert alert-success alert-dismissible fade show"><?php echo $success; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php endif; ?>
        <?php if($error): ?>
            <div class="alert alert-danger alert-dismissible fade show"><?php echo $error; ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        <?php endif; ?>

        <div class="card card-dash mb-4">
            <div class="card-body p-4">
                <form method="POST" action="">
                    <h5 class="text-secondary border-bottom pb-2 mb-4">Account Information</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($patient['name']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($patient['email']); ?>" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">New Password <small class="text-muted">(Leave blank to keep current password)</small></label>
                            <input type="password" name="password" class="form-control">
                        </div>
                    </div>

                    <h5 class="text-secondary border-bottom pb-2 mb-4 mt-4">Personal Details</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($patient['phone'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" value="<?php echo htmlspecialchars($patient['dob'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">Select...</option>
                                <option value="Male" <?php echo ($patient['gender'] ?? '') == 'Male' ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo ($patient['gender'] ?? '') == 'Female' ? 'selected' : ''; ?>>Female</option>
                                <option value="Other" <?php echo ($patient['gender'] ?? '') == 'Other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Blood Group</label>
                            <select name="blood_group" class="form-select">
                                <option value="">Select...</option>
                                <?php
                                $bgs = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
                                foreach($bgs as $bg) {
                                    $sel = ($patient['blood_group'] ?? '') == $bg ? 'selected' : '';
                                    echo "<option value='$bg' $sel>$bg</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" class="form-control" value="<?php echo htmlspecialchars($patient['city'] ?? ''); ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Full Address</label>
                            <textarea name="address" class="form-control" rows="3"><?php echo htmlspecialchars($patient['address'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    
                    <button type="submit" name="update_profile" class="btn btn-primary w-100 py-2 mt-2"><i class="fas fa-save me-2"></i>Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
