<?php
session_start();
include 'config/db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Login Success
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];

            // Redirect based on role
            switch ($user['role']) {
                case 'admin':
                    header("Location: admin/index.php");
                    break;
                case 'doctor':
                    header("Location: doctor/index.php");
                    break;
                case 'patient':
                    header("Location: patient/index.php");
                    break;
                default:
                    header("Location: index.php"); // Fallback
            }
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DocCare</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #e0f7fa 0%, #ffffff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-card {
            max-width: 450px;
            width: 100%;
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card auth-card glass-card p-4 p-md-5">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary">Welcome Back</h2>
                    <p class="text-muted">Login to access your dashboard.</p>
                </div>
                
                <?php if($error): ?>
                    <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" required placeholder="john@example.com">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control" required placeholder="******">
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe">
                            <label class="form-check-label text-muted small" for="rememberMe">Remember me</label>
                        </div>
                        <a href="#" class="text-decoration-none text-primary small fw-bold">Forgot Password?</a>
                    </div>
                    
                    <button type="submit" class="btn btn-primary-custom w-100 py-2 mb-3">Login</button>
                    
                    <!-- Demo Quick Login Buttons -->
                    <div class="border-top pt-3 mt-3">
                        <p class="text-center text-muted small mb-2">Demo Quick Login</p>
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="fillLogin('admin@admin.com', 'admin123')">
                                <i class="fas fa-user-shield me-1"></i>Admin
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-info" onclick="fillLogin('smith@hospital.com', 'password123')">
                                <i class="fas fa-user-md me-1"></i>Doctor
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-success" onclick="fillLogin('patient@example.com', 'patient123')">
                                <i class="fas fa-user-injured me-1"></i>Patient
                            </button>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <small>Don't have an account? <a href="register.php" class="text-primary fw-bold text-decoration-none">Sign Up</a></small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function fillLogin(email, password) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = password;
}
</script>
</body>
</html>
