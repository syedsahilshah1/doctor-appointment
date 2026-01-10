<?php
session_start();
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content animate-fade-in">
                <span class="badge bg-primary-subtle text-primary mb-3 px-3 py-2 rounded-pill">For Your Better Health</span>
                <h1>Your Health, Our <br>Priority.</h1>
                <p class="lead text-muted mb-4">Book appointments with efficient doctors. Skip the waiting room and get the care you need, when you need it.</p>
                <div class="d-flex gap-3">
                    <a href="register.php" class="btn btn-primary-custom btn-lg">Get Started</a>
                    <a href="doctors.php" class="btn btn-outline-custom btn-lg">Find Doctors</a>
                </div>
                
                <div class="mt-5 d-flex gap-5">
                    <div>
                        <h3 class="fw-bold mb-0">50+</h3>
                        <p class="text-muted">Specialists</p>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">10k+</h3>
                        <p class="text-muted">Happy Patients</p>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0">24/7</h3>
                        <p class="text-muted">Support</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 hero-image mt-5 mt-lg-0 animate-fade-in" style="animation-delay: 0.2s;">
                <!-- Placeholder for a nice doctor image. -->
                <img src="https://img.freepik.com/free-photo/team-young-specialist-doctors-standing-corridor-hospital_1303-21199.jpg?w=900" alt="Doctors Team" class="img-fluid w-100">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5" id="services">
    <div class="container py-5">
        <div class="text-center w-75 mx-auto mb-5">
            <h2 class="fw-bold display-6 mb-3">Why Choose DocCare?</h2>
            <p class="text-muted">Experience the future of healthcare with our seamless appointment booking and management features.</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card text-center p-4">
                    <div class="feature-icon">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <h4>Expert Doctors</h4>
                    <p class="text-muted">Access to highly qualified doctors across various specializations.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center p-4">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h4>Easy Booking</h4>
                    <p class="text-muted">Book your appointment in just a few clicks. No more waiting in lines.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-card text-center p-4">
                    <div class="feature-icon">
                        <i class="fas fa-notes-medical"></i>
                    </div>
                    <h4>Digital Reports</h4>
                    <p class="text-muted">Access all your medical history and reports securely from anywhere.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container">
        <h2 class="fw-bold mb-3">Ready to Consult a Doctor?</h2>
        <p class="mb-4 opacity-75">Join thousands of patients who trust DocCare for their healthcare needs.</p>
        <a href="register.php" class="btn btn-light btn-lg rounded-pill px-5 text-primary fw-bold">Book Now</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
