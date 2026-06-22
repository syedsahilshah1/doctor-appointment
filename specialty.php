<?php
session_start();
include 'config/db.php';
include 'includes/header.php';

$specialty = $_GET['type'] ?? 'General';
$safe_specialty = htmlspecialchars($specialty);

// Huge Data Structure for the "Separate Website" feel per specialty
$specialtyData = [
    'Dentistry' => [
        'hero_title' => 'Advanced Dental & Oral Care',
        'hero_desc' => 'Experience world-class dentistry with state-of-the-art 3D technology and painless procedures.',
        'hero_img' => 'https://img.freepik.com/free-photo/dentist-working-with-patient-clinic_1303-26462.jpg?w=1200',
        'about_title' => 'Revolutionizing Dental Care',
        'about' => 'Our Dentistry center operates like a specialized hospital within a hospital. We use advanced 3D scanning, CAD/CAM technology, and robotic assistance to ensure precision in every procedure. From a simple cleaning to full-mouth reconstruction, your smile is in the hands of global experts.',
        'services' => [
            ['title' => '3D Dental Implants', 'desc' => 'Permanent, natural-looking tooth replacement using guided 3D surgery.', 'img' => 'assets/images/dental_implant.png'],
            ['title' => 'Root Canal Therapy', 'desc' => 'Microscope-assisted, painless endodontic treatments.', 'img' => 'assets/images/root_canal.png'],
            ['title' => 'Cosmetic Dentistry', 'desc' => 'Laser whitening, veneers, and smile makeovers.', 'img' => 'assets/images/cosmetic_teeth.png'],
            ['title' => 'Orthodontics', 'desc' => 'Invisible aligners and advanced braces for all ages.', 'img' => 'assets/images/orthodontics.png'],
            ['title' => 'Pediatric Dentistry', 'desc' => 'Child-friendly care to build lifelong healthy habits.', 'img' => 'assets/images/pediatric_tooth.png']
        ]
    ],
    'Cardiology' => [
        'hero_title' => 'Heart Institute & Cardiovascular Care',
        'hero_desc' => 'Pioneering cardiac treatments with unmatched precision and dedicated 24/7 emergency heart care.',
        'hero_img' => 'https://img.freepik.com/free-photo/doctors-surgeons-performing-surgery-operating-room_1303-20092.jpg?w=1200',
        'about_title' => 'Your Heart in the Best Hands',
        'about' => 'The Cardiology department is a fully equipped center offering everything from preventative screenings to complex bypass surgeries. We utilize 3D heart mapping and minimally invasive techniques to ensure rapid recovery and exceptional outcomes.',
        'services' => [
            ['title' => '3D Echocardiography', 'desc' => 'Advanced 3D imaging of the heart to detect anomalies.', 'img' => 'https://img.freepik.com/free-photo/3d-heart-model-medical-concept_23-2150424591.jpg?w=600'],
            ['title' => 'Interventional Cardiology', 'desc' => 'Angioplasty and stenting using cutting-edge tech.', 'img' => 'https://img.freepik.com/free-photo/surgeon-operating-room_1303-20094.jpg?w=600'],
            ['title' => 'Heart Bypass Surgery', 'desc' => 'CABG procedures performed by world-renowned surgeons.', 'img' => 'https://img.freepik.com/free-photo/medical-team-performing-surgical-operation_1303-26159.jpg?w=600'],
            ['title' => 'Electrophysiology', 'desc' => 'Treatment for arrhythmias and pacemaker implantation.', 'img' => 'https://img.freepik.com/free-photo/heart-rate-monitor-hospital_1303-19967.jpg?w=600']
        ]
    ],
    'Neurology' => [
        'hero_title' => 'Advanced Brain & Spine Center',
        'hero_desc' => 'Comprehensive neurological care leveraging 3D brain mapping and innovative therapies.',
        'hero_img' => 'https://img.freepik.com/free-photo/doctor-looking-mri-scan_1303-24151.jpg?w=1200',
        'about_title' => 'Unlocking the Mysteries of the Brain',
        'about' => 'Our Neurology center provides world-class care for brain, spinal cord, and nerve disorders. We use advanced neuroimaging, 3D functional brain mapping, and dedicated stroke units to provide life-saving treatments.',
        'services' => [
            ['title' => '3D Brain Mapping', 'desc' => 'Precise 3D visualization of brain activity and structures.', 'img' => 'https://img.freepik.com/free-photo/3d-glowing-brain-medical-concept_23-2150424602.jpg?w=600'],
            ['title' => 'Stroke Management', 'desc' => 'Rapid response units dedicated to stroke reversal.', 'img' => 'https://img.freepik.com/free-photo/doctor-holding-brain-scan_1303-24150.jpg?w=600'],
            ['title' => 'Neurosurgery', 'desc' => 'Minimally invasive spine and brain surgeries.', 'img' => 'https://img.freepik.com/free-photo/surgeons-operating-patient-hospital_1303-20093.jpg?w=600'],
            ['title' => 'Epilepsy Center', 'desc' => 'Advanced diagnostics and treatment plans for seizures.', 'img' => 'https://img.freepik.com/free-photo/neurologist-examining-patient_1303-24152.jpg?w=600']
        ]
    ],
    'Orthopedics' => [
        'hero_title' => 'Institute of Orthopedics & Joint Replacement',
        'hero_desc' => 'Regain your mobility with advanced 3D joint replacements and sports medicine.',
        'hero_img' => 'https://img.freepik.com/free-photo/male-doctor-examining-patient-s-knee_1303-23118.jpg?w=1200',
        'about_title' => 'Moving Forward Without Pain',
        'about' => 'Our Orthopedics division is a standalone powerhouse for musculoskeletal care. From 3D-printed custom joint replacements to elite sports injury rehabilitation, we ensure you get back to your active lifestyle quickly and safely.',
        'services' => [
            ['title' => '3D Joint Replacement', 'desc' => 'Custom-fit 3D printed knees and hips for perfect alignment.', 'img' => 'https://img.freepik.com/free-photo/3d-bone-joint-medical-illustration_23-2150424610.jpg?w=600'],
            ['title' => 'Sports Medicine', 'desc' => 'Advanced arthroscopy and ligament repairs.', 'img' => 'https://img.freepik.com/free-photo/physiotherapist-doing-leg-exercises-with-patient_1170-2051.jpg?w=600'],
            ['title' => 'Spine Surgery', 'desc' => 'Correction of scoliosis and herniated discs.', 'img' => 'https://img.freepik.com/free-photo/doctor-examining-spine-xray_1303-23119.jpg?w=600'],
            ['title' => 'Trauma Care', 'desc' => '24/7 dedicated orthopedic trauma surgery team.', 'img' => 'https://img.freepik.com/free-photo/patient-with-broken-leg-hospital_1303-23120.jpg?w=600']
        ]
    ]
];

// Fallback for specialties not explicitly defined above
if (!isset($specialtyData[$specialty])) {
    $specialtyData[$specialty] = [
        'hero_title' => $safe_specialty . ' Center of Excellence',
        'hero_desc' => 'Providing top-tier medical care, research, and specialized treatments in ' . $safe_specialty . '.',
        'hero_img' => 'https://img.freepik.com/free-photo/modern-hospital-building_1127-2851.jpg?w=1200',
        'about_title' => 'Dedicated to Your Health',
        'about' => 'Welcome to our dedicated ' . $safe_specialty . ' facility. We operate as a comprehensive center providing end-to-end care, diagnostics, and advanced treatments specifically tailored to this medical field.',
        'services' => [
            ['title' => 'Advanced Diagnostics', 'desc' => 'State-of-the-art testing and 3D imaging for accurate diagnosis.', 'img' => 'https://img.freepik.com/free-photo/medical-technology-concept-with-3d-elements_23-2150424600.jpg?w=600'],
            ['title' => 'Specialized Treatment', 'desc' => 'Customized care plans designed by global experts.', 'img' => 'https://img.freepik.com/free-photo/doctor-consulting-patient_1303-23965.jpg?w=600'],
            ['title' => 'Surgical Procedures', 'desc' => 'Minimally invasive and highly precise surgical interventions.', 'img' => 'https://img.freepik.com/free-photo/surgeons-operating-room_1303-20092.jpg?w=600'],
            ['title' => 'Rehabilitation', 'desc' => 'Post-treatment care to ensure full and rapid recovery.', 'img' => 'https://img.freepik.com/free-photo/physiotherapist-helping-patient_1170-2051.jpg?w=600']
        ]
    ];
}

$data = $specialtyData[$specialty];

?>
<style>
/* Custom Styles for the "Standalone Website" Feel */
.specialty-hero {
    position: relative;
    background: url('<?php echo $data['hero_img']; ?>') no-repeat center center/cover;
    height: 60vh;
    min-height: 400px;
    display: flex;
    align-items: center;
    color: white;
}
.specialty-hero::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: linear-gradient(90deg, rgba(13,110,253,0.9) 0%, rgba(0,0,0,0.6) 100%);
}
.hero-content {
    position: relative;
    z-index: 1;
}

/* Horizontal Scrolling 3D Cards */
.services-scroll-container {
    padding: 40px 0;
    overflow: hidden;
}
.scrolling-wrapper {
    display: flex;
    flex-wrap: nowrap;
    overflow-x: auto;
    padding: 20px;
    gap: 30px;
    -webkit-overflow-scrolling: touch;
    scroll-snap-type: x mandatory;
    scroll-behavior: smooth;
}
/* Hide scrollbar for clean look, or style it */
.scrolling-wrapper::-webkit-scrollbar {
    display: none;
}
.scrolling-wrapper {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}

.card-3d {
    flex: 0 0 auto;
    width: 320px;
    perspective: 1500px;
    scroll-snap-align: center;
}
.card-3d-inner {
    position: relative;
    width: 100%;
    height: 420px;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    transform-style: preserve-3d;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border-radius: 20px;
    background: #fff;
    cursor: pointer;
}
.card-3d-img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    transition: all 0.5s ease;
}
.card-3d:hover .card-3d-img {
    filter: brightness(1.1);
}
.card-3d-body {
    padding: 25px;
    transform: translateZ(30px); /* Pushes text out in 3D space */
}
</style>

<!-- Specialty Hero Section -->
<section class="specialty-hero">
    <div class="container hero-content animate-fade-in">
        <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill fs-6"><?php echo $safe_specialty; ?></span>
        <h1 class="display-3 fw-bold mb-3 text-white"><?php echo $data['hero_title']; ?></h1>
        <p class="lead text-white-50 mb-4" style="max-width: 700px; font-size: 1.25rem;">
            <?php echo $data['hero_desc']; ?>
        </p>
        <div class="d-flex gap-3">
            <a href="#specialists" class="btn btn-light btn-lg rounded-pill fw-bold text-primary px-4">View Doctors</a>
            <a href="booking.php" class="btn btn-outline-light btn-lg rounded-pill px-4">Book Now</a>
        </div>
    </div>
</section>

<!-- About the Department Section -->
<section class="py-5 bg-white">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div class="position-relative">
                    <img src="<?php echo $data['hero_img']; ?>" alt="About" class="img-fluid rounded-4 shadow-lg" style="object-fit: cover; height: 500px; width: 100%;">
                    <div class="position-absolute bottom-0 end-0 bg-primary text-white p-4 rounded-4 shadow-lg m-n4 d-none d-lg-block">
                        <h3 class="fw-bold mb-0">24/7</h3>
                        <p class="mb-0">Emergency Care</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 offset-lg-1">
                <span class="text-primary fw-bold text-uppercase tracking-wide border-bottom border-primary border-2 pb-1">About The Department</span>
                <h2 class="fw-bold display-5 mb-4 mt-4"><?php echo $data['about_title']; ?></h2>
                <p class="text-muted mb-4 lead" style="line-height: 1.8;"><?php echo $data['about']; ?></p>
                <div class="row g-4 mt-2">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-microscope fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">3D Tech</h5>
                                <small class="text-muted">Advanced Imaging</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-user-md fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Expert Team</h5>
                                <small class="text-muted">Global Specialists</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 3D Services Scrolling Section -->
<section class="bg-light services-scroll-container">
    <div class="container mb-2 pt-4">
        <h2 class="fw-bold display-6 mb-2">Our Specialized Procedures</h2>
        <p class="text-muted">Scroll to explore the advanced treatments offered in our <?php echo $safe_specialty; ?> center.</p>
    </div>
    
    <div class="scrolling-wrapper">
        <?php foreach($data['services'] as $service): ?>
        <div class="card-3d">
            <div class="card-3d-inner">
                <img src="<?php echo $service['img']; ?>" class="card-3d-img" alt="<?php echo $service['title']; ?>">
                <div class="card-3d-body">
                    <h5 class="fw-bold text-primary mb-3"><?php echo $service['title']; ?></h5>
                    <p class="text-muted"><?php echo $service['desc']; ?></p>
                    <a href="#" class="text-decoration-none fw-bold text-dark mt-auto d-inline-block">Learn more <i class="fas fa-arrow-right ms-1 text-primary"></i></a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        
        <!-- Add a final card to prompt booking -->
        <div class="card-3d">
            <div class="card-3d-inner bg-primary text-white d-flex align-items-center justify-content-center text-center p-4">
                <div style="transform: translateZ(40px);">
                    <i class="fas fa-calendar-alt fa-4x mb-4 text-white-50"></i>
                    <h4 class="fw-bold mb-3">Ready to start?</h4>
                    <p class="mb-4 text-white-50">Schedule a consultation with our specialists today.</p>
                    <a href="booking.php" class="btn btn-light rounded-pill px-4 text-primary fw-bold">Book Appointment</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-5 bg-white">
    <div class="container py-5 border-top pt-5">
        <div class="row text-center g-4">
            <div class="col-md-3 col-6">
                <div class="p-3">
                    <h2 class="display-5 fw-bold text-primary">98%</h2>
                    <p class="text-muted fw-bold">Success Rate</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-3">
                    <h2 class="display-5 fw-bold text-primary">5k+</h2>
                    <p class="text-muted fw-bold">Happy Patients</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-3">
                    <h2 class="display-5 fw-bold text-primary">24/7</h2>
                    <p class="text-muted fw-bold">Emergency Care</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-3">
                    <h2 class="display-5 fw-bold text-primary">15+</h2>
                    <p class="text-muted fw-bold">Top Specialists</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Patient Success Stories -->
<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center w-75 mx-auto mb-5">
            <h2 class="fw-bold display-6 mb-3">Patient Success Stories</h2>
            <p class="text-muted">Hear from those who have experienced our world-class <?php echo $safe_specialty; ?> care firsthand.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-4 h-100 rounded-4 hover-lift">
                    <div class="d-flex text-warning mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="fst-italic text-muted mb-4 lead">"The level of care and advanced technology used here is unmatched. My recovery was incredibly fast, and the doctors explained every step in detail."</p>
                    <div class="d-flex align-items-center mt-auto">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-weight: bold;">
                            JS
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">James Smith</h6>
                            <small class="text-primary fw-bold">Verified Patient</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-4 h-100 rounded-4 hover-lift">
                    <div class="d-flex text-warning mb-3">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="fst-italic text-muted mb-4 lead">"From the moment I walked in, I knew I was in good hands. The 3D imaging completely changed how they approached my treatment. Absolutely life-changing."</p>
                    <div class="d-flex align-items-center mt-auto">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px; font-weight: bold;">
                            MR
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold text-dark">Maria Rodriguez</h6>
                            <small class="text-primary fw-bold">Verified Patient</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Doctors List Section -->
<section class="py-5 bg-white" id="specialists">
    <div class="container py-5">
        <div class="text-center w-75 mx-auto mb-5">
            <h2 class="fw-bold display-6 mb-3">Meet Our <?php echo $safe_specialty; ?> Experts</h2>
            <p class="text-muted">Our board-certified specialists are leaders in their respective fields.</p>
        </div>
        
        <div class="row g-4">
            <?php
            $sql = "SELECT d.*, u.name 
                    FROM doctors d 
                    JOIN users u ON d.user_id = u.id 
                    WHERE d.is_active = 1 AND d.specialization = :specialty";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['specialty' => $specialty]);
            
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch()) {
                    echo '
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 border-0 shadow-sm text-center p-3 hover-lift">
                            <div class="card-body">
                                <img src="'.getDoctorImage($row['id'], $row['name']).'" class="rounded-circle mb-3 shadow-sm border border-3 border-primary-subtle" width="120" height="120" style="object-fit: cover;">
                                <h5 class="fw-bold mb-0 text-dark">Dr. '.htmlspecialchars($row['name']).'</h5>
                                <small class="text-primary fw-bold">'.htmlspecialchars($row['qualification'] ?? 'Specialist').'</small>
                                
                                <hr class="my-3 opacity-25">
                                
                                <div class="d-flex justify-content-between mb-3 text-muted small px-2">
                                    <span><i class="fas fa-briefcase text-primary me-1"></i>'.($row['experience'] ?? '5').' Yrs Exp</span>
                                    <span><i class="fas fa-door-open text-primary me-1"></i>Rm '.($row['room_no'] ?? '101').'</span>
                                </div>

                                <p class="fw-bold mb-3 fs-5">$'.number_format($row['consultation_fee'], 2).' <span class="text-muted fw-normal small fs-6">/ Visit</span></p>
                                <a href="booking.php?doctor_id='.$row['id'].'" class="btn btn-primary w-100 rounded-pill shadow-sm">Book Consultation</a>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="col-12 text-center py-5 bg-light rounded-4">
                        <div class="text-muted mb-3"><i class="fas fa-user-md fa-4x opacity-25"></i></div>
                        <h4 class="text-dark fw-bold">No specialists found</h4>
                        <p class="text-muted">We currently do not have any active doctors available in the '.$safe_specialty.' department.</p>
                        <a href="doctors.php" class="btn btn-primary mt-3 rounded-pill px-4">View All Doctors</a>
                      </div>';
            }
            ?>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll('.card-3d');
    
    cards.forEach(card => {
        const inner = card.querySelector('.card-3d-inner');
        
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            
            // Calculate rotation based on mouse position (max 15 degrees)
            const rotateX = ((y - centerY) / centerY) * -15; 
            const rotateY = ((x - centerX) / centerX) * 15;
            
            inner.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale(1.05) translateZ(20px)`;
            inner.style.transition = 'none'; // remove transition for snappy tracking
            
            // Dynamic shadow direction
            inner.style.boxShadow = `${-rotateY}px ${rotateX}px 40px rgba(13,110,253,0.3)`;
        });
        
        card.addEventListener('mouseleave', () => {
            inner.style.transform = 'rotateX(0) rotateY(0) scale(1) translateZ(0)';
            inner.style.transition = 'transform 0.6s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.6s';
            inner.style.boxShadow = '0 10px 30px rgba(0,0,0,0.1)';
        });
        
        card.addEventListener('mouseenter', () => {
            inner.style.transition = 'transform 0.1s, box-shadow 0.1s';
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
