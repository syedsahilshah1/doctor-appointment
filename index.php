<?php
session_start();
include 'config/db.php';
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

<!-- About Us Section -->
<section class="py-5 bg-light" id="about">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0 pe-lg-5">
                <img src="https://img.freepik.com/free-photo/modern-hospital-building_1127-2851.jpg?w=900" alt="Hospital Building" class="img-fluid rounded-4 shadow-lg">
            </div>
            <div class="col-lg-6">
                <span class="text-primary fw-bold text-uppercase tracking-wide">About DocCare</span>
                <h2 class="fw-bold display-6 mb-4 mt-2">World-Class Healthcare, Close to Home</h2>
                <p class="text-muted mb-4 lead">We are committed to providing the highest quality medical care to our community. With state-of-the-art facilities and a team of internationally recognized specialists, your health is always in safe hands.</p>
                <div class="row g-4 mb-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 50px; height: 50px;">
                                <i class="fas fa-award fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Award Winning</h6>
                                <small class="text-muted">Top hospital 2023</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 50px; height: 50px;">
                                <i class="fas fa-microscope fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">Modern Labs</h6>
                                <small class="text-muted">Advanced tech</small>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#featured-doctors" class="btn btn-outline-primary rounded-pill px-4">Meet Our Team</a>
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

<!-- How It Works Section -->
<section class="py-5 bg-white" id="how-it-works">
    <div class="container py-5">
        <div class="text-center w-75 mx-auto mb-5">
            <h2 class="fw-bold display-6 mb-3">How It Works</h2>
            <p class="text-muted">Get your appointment booked in 3 simple steps.</p>
        </div>
        <div class="row text-center g-4">
            <div class="col-md-4">
                <div class="p-4">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 80px; height: 80px; font-size: 32px;">
                        1
                    </div>
                    <h4 class="fw-bold">Find a Doctor</h4>
                    <p class="text-muted">Search for a doctor by name or specialization and view their profile.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 80px; height: 80px; font-size: 32px;">
                        2
                    </div>
                    <h4 class="fw-bold">Choose a Time</h4>
                    <p class="text-muted">Select an available date and time slot from the doctor's schedule.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 80px; height: 80px; font-size: 32px;">
                        3
                    </div>
                    <h4 class="fw-bold">Book Appointment</h4>
                    <p class="text-muted">Confirm your booking and receive a digital appointment receipt instantly.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Specialties Section -->
<style>
.specialty-card-3d {
    perspective: 1000px;
    background: transparent;
}
.specialty-card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    transform-style: preserve-3d;
    background: white;
    border-radius: 1rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}
.specialty-card-content {
    transform: translateZ(30px);
}
.img-3d-icon {
    object-fit: cover;
    filter: drop-shadow(0 10px 15px rgba(13,110,253,0.3));
    transition: transform 0.3s ease;
    border-radius: 50%; /* Removes the square 'extra border' look */
}
.specialty-card-3d:hover .img-3d-icon {
    transform: scale(1.1) translateY(-5px);
}
</style>
<section class="py-5 bg-light" id="specialties">
    <div class="container py-5">
        <div class="text-center w-75 mx-auto mb-5">
            <h2 class="fw-bold display-6 mb-3">Our Medical Specialties</h2>
            <p class="text-muted">We offer a wide range of medical services to cover all your healthcare needs under one roof.</p>
        </div>
        <div class="row g-4 text-center">
            <div class="col-6 col-md-4 col-lg-2">
                <a href="specialty.php?type=Cardiology" class="text-decoration-none text-dark">
                    <div class="specialty-card-3d h-100">
                        <div class="specialty-card-inner py-4">
                            <div class="specialty-card-content">
                                <div class="mb-3">
                                    <img src="assets/images/3d_heart.png" alt="Cardiology" width="90" height="90" class="img-3d-icon">
                                </div>
                                <h6 class="fw-bold mb-0">Cardiology</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="specialty.php?type=Neurology" class="text-decoration-none text-dark">
                    <div class="specialty-card-3d h-100">
                        <div class="specialty-card-inner py-4">
                            <div class="specialty-card-content">
                                <div class="mb-3">
                                    <img src="assets/images/3d_brain.png" alt="Neurology" width="90" height="90" class="img-3d-icon">
                                </div>
                                <h6 class="fw-bold mb-0">Neurology</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="specialty.php?type=Pediatrics" class="text-decoration-none text-dark">
                    <div class="specialty-card-3d h-100">
                        <div class="specialty-card-inner py-4">
                            <div class="specialty-card-content">
                                <div class="mb-3">
                                    <img src="assets/images/3d_baby.png" alt="Pediatrics" width="90" height="90" class="img-3d-icon">
                                </div>
                                <h6 class="fw-bold mb-0">Pediatrics</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="specialty.php?type=Dentistry" class="text-decoration-none text-dark">
                    <div class="specialty-card-3d h-100">
                        <div class="specialty-card-inner py-4">
                            <div class="specialty-card-content">
                                <div class="mb-3">
                                    <img src="assets/images/3d_tooth.png" alt="Dentistry" width="90" height="90" class="img-3d-icon">
                                </div>
                                <h6 class="fw-bold mb-0">Dentistry</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="specialty.php?type=Orthopedics" class="text-decoration-none text-dark">
                    <div class="specialty-card-3d h-100">
                        <div class="specialty-card-inner py-4">
                            <div class="specialty-card-content">
                                <div class="mb-3">
                                    <img src="assets/images/3d_bone.png" alt="Orthopedics" width="90" height="90" class="img-3d-icon">
                                </div>
                                <h6 class="fw-bold mb-0">Orthopedics</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <a href="specialty.php?type=Optometry" class="text-decoration-none text-dark">
                    <div class="specialty-card-3d h-100">
                        <div class="specialty-card-inner py-4">
                            <div class="specialty-card-content">
                                <div class="mb-3">
                                    <img src="assets/images/3d_eye.png" alt="Optometry" width="90" height="90" class="img-3d-icon">
                                </div>
                                <h6 class="fw-bold mb-0">Optometry</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll('.specialty-card-3d');
    
    cards.forEach(card => {
        const inner = card.querySelector('.specialty-card-inner');
        
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            // Calculate rotation based on mouse position (max 15 degrees)
            const rotateX = ((y - centerY) / centerY) * -15; 
            const rotateY = ((x - centerX) / centerX) * 15;
            
            inner.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.05) translateZ(10px)`;
            inner.style.transition = 'none'; // remove transition for snappy tracking
            
            // Dynamic shadow direction
            inner.style.boxShadow = `${-rotateY}px ${rotateX}px 30px rgba(13,110,253,0.2)`;
        });
        
        card.addEventListener('mouseleave', () => {
            inner.style.transform = 'rotateX(0) rotateY(0) scale(1) translateZ(0)';
            inner.style.transition = 'transform 0.6s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.6s';
            inner.style.boxShadow = '0 5px 15px rgba(0,0,0,0.05)';
        });
        
        card.addEventListener('mouseenter', () => {
            inner.style.transition = 'transform 0.1s, box-shadow 0.1s';
        });
    });
});
</script>

<!-- Featured Doctors Section -->
<section class="py-5 bg-light" id="featured-doctors">
    <div class="container py-5">
        <div class="text-center w-75 mx-auto mb-5">
            <h2 class="fw-bold display-6 mb-3">Our Top Doctors</h2>
            <p class="text-muted">Book an appointment with some of our most experienced specialists.</p>
        </div>
        <div class="row g-4">
            <?php
            $sql = "SELECT d.*, u.name 
                    FROM doctors d 
                    JOIN users u ON d.user_id = u.id 
                    WHERE d.is_active = 1 LIMIT 4";
            $stmt = $pdo->query($sql);
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch()) {
                    echo '
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm text-center p-3 animate-fade-in">
                            <div class="card-body">
                                <img src="'.getDoctorImage($row['id'], $row['name']).'" class="rounded-circle mb-3 shadow-sm" width="100" height="100" style="object-fit: cover;">
                                <h5 class="fw-bold mb-0">Dr. '.htmlspecialchars($row['name']).'</h5>
                                <small class="text-muted">'.htmlspecialchars($row['qualification'] ?? 'Specialist').'</small>
                                <p class="text-primary small fw-bold mt-2 mb-1">'.htmlspecialchars($row['specialization']).'</p>
                                
                                <div class="d-flex justify-content-center gap-3 mb-3 text-muted small">
                                    <span><i class="fas fa-briefcase me-1"></i>'.($row['experience'] ?? '5').' Yrs</span>
                                    <span><i class="fas fa-door-open me-1"></i>Room '.($row['room_no'] ?? '101').'</span>
                                </div>

                                <p class="fw-bold mb-3">$'.number_format($row['consultation_fee'], 2).' <span class="text-muted fw-normal small">/ Visit</span></p>
                                <a href="booking.php?doctor_id='.$row['id'].'" class="btn btn-outline-primary w-100 rounded-pill">Book Appointment</a>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="col-12 text-center"><p class="text-muted">No featured doctors available at the moment.</p></div>';
            }
            ?>
        </div>
        <div class="text-center mt-5">
            <a href="doctors.php" class="btn btn-primary-custom px-4 rounded-pill">View All Doctors</a>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 bg-white" id="testimonials">
    <div class="container py-5">
        <div class="text-center w-75 mx-auto mb-5">
            <h2 class="fw-bold display-6 mb-3">What Our Patients Say</h2>
            <p class="text-muted">Read stories from patients who have experienced our seamless healthcare service.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4">
                    <div class="d-flex text-warning mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="fst-italic text-muted mb-4">"DocCare made it incredibly easy for me to find a cardiologist and book an appointment the very next day. Highly recommended!"</p>
                    <div class="d-flex align-items-center mt-auto">
                        <img src="https://randomuser.me/api/portraits/women/12.jpg" class="rounded-circle me-3" width="50" height="50">
                        <div>
                            <h6 class="mb-0 fw-bold">Sarah Jenkins</h6>
                            <small class="text-muted">Patient</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4">
                    <div class="d-flex text-warning mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="fst-italic text-muted mb-4">"The digital prescription feature is a lifesaver. I never have to worry about losing my paper prescriptions again."</p>
                    <div class="d-flex align-items-center mt-auto">
                        <img src="https://randomuser.me/api/portraits/men/22.jpg" class="rounded-circle me-3" width="50" height="50">
                        <div>
                            <h6 class="mb-0 fw-bold">Mark Thompson</h6>
                            <small class="text-muted">Patient</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm p-4">
                    <div class="d-flex text-warning mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="fst-italic text-muted mb-4">"Great platform! The doctors are very professional and the appointment process is smooth and completely transparent."</p>
                    <div class="d-flex align-items-center mt-auto">
                        <img src="https://randomuser.me/api/portraits/women/33.jpg" class="rounded-circle me-3" width="50" height="50">
                        <div>
                            <h6 class="mb-0 fw-bold">Emily Roberts</h6>
                            <small class="text-muted">Patient</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5 bg-light" id="faq">
    <div class="container py-5">
        <div class="text-center w-75 mx-auto mb-5">
            <h2 class="fw-bold display-6 mb-3">Frequently Asked Questions</h2>
            <p class="text-muted">Have questions? We have answers.</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="accordion border-0 shadow-sm" id="faqAccordion">
                    <div class="accordion-item border-0 mb-3 rounded">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                How do I book an appointment?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Simply sign up for a patient account, search for a doctor in your desired specialty, select an available date and time, and confirm your booking.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 mb-3 rounded">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                Is there a fee for booking?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Our platform is free to use. You only pay the consultation fee charged by the doctor during your visit.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item border-0 mb-3 rounded">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                Can I cancel my appointment?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Yes, you can cancel your pending appointments from your patient dashboard at any time before the doctor confirms them.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Emergency Banner -->
<section class="py-4 bg-danger text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 text-center text-md-start mb-3 mb-md-0">
                <h3 class="fw-bold mb-1"><i class="fas fa-ambulance me-2"></i> Need Emergency Help?</h3>
                <p class="mb-0 text-white-50">Our emergency room and ambulance service is available 24/7.</p>
            </div>
            <div class="col-md-4 text-center text-md-end">
                <a href="tel:+1234567890" class="btn btn-light btn-lg rounded-pill fw-bold text-danger px-4 shadow-sm">
                    <i class="fas fa-phone-alt me-2"></i> Call 911
                </a>
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
