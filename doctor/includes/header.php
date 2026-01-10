<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard - DocCare</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            background: #fff;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            padding-top: 20px;
            z-index: 1000;
        }
        .main-content { margin-left: 260px; padding: 30px; }
        .nav-link {
            color: #555;
            padding: 15px 25px;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }
        .nav-link:hover, .nav-link.active {
            background-color: #f8f9fa;
            color: #0d6efd;
            border-right: 4px solid #0d6efd;
        }
        .nav-link i { width: 30px; }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column">
    <a href="index.php" class="d-flex align-items-center mb-4 px-4 text-decoration-none">
        <span class="fs-4 fw-bold text-primary"><i class="fas fa-user-md me-2"></i>DocPortal</span>
    </a>
    
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                <i class="fas fa-th-large"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="appointments.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'appointments.php' ? 'active' : ''; ?>">
                <i class="fas fa-calendar-check"></i> Appointments
            </a>
        </li>
        <li>
            <a href="schedule.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'schedule.php' ? 'active' : ''; ?>">
                <i class="fas fa-clock"></i> My Schedule
            </a>
        </li>
    </ul>
    
    <div class="mt-auto p-4 border-top">
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
                <img src="https://ui-avatars.com/api/?name=<?php echo $_SESSION['user_name']; ?>" class="rounded-circle" width="40" height="40">
            </div>
            <div class="flex-grow-1 ms-3">
                <h6 class="mb-0"><?php echo htmlspecialchars($_SESSION['user_name']); ?></h6>
                <small class="text-muted">Doctor</small>
            </div>
            <a href="../logout.php" class="text-danger ms-2"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </div>
</div>

<div class="main-content">
