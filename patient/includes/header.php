<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard - DocCare</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .card-dash { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: transform 0.2s; }
        .card-dash:hover { transform: translateY(-5px); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand text-primary fw-bold" href="../index.php"><i class="fas fa-heartbeat me-2"></i>DocCare</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="../doctors.php">Find Doctor</a></li>
            </ul>
            <div class="d-flex align-items-center">
                 <span class="me-3 fw-bold">Hello, <?php echo $_SESSION['user_name']; ?></span>
                 <a href="../logout.php" class="btn btn-sm btn-outline-danger rounded-pill">Logout</a>
            </div>
        </div>
    </div>
</nav>

<div class="container py-5">
