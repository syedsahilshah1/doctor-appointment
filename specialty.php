<?php
session_start();
include 'config/db.php';
include 'includes/header.php';

$specialty = $_GET['type'] ?? 'General';
$safe_specialty = htmlspecialchars($specialty);

// Extended Specialty Data
$aboutData = [
    'Cardiology' => [
        'desc' => 'Expert care for your heart and cardiovascular system. Our cardiologists are equipped with the latest technology.',
        'about' => 'Cardiology is a medical specialty dealing with disorders of the heart as well as some parts of the circulatory system. Our cardiology department is dedicated to providing state-of-the-art cardiovascular care, from diagnosis and prevention to treatment and rehabilitation.',
        'conditions' => ['Coronary Artery Disease', 'Heart Arrhythmias', 'Heart Failure', 'Congenital Heart Defects', 'Valvular Heart Disease', 'Hypertension'],
        'image' => 'https://img.freepik.com/free-photo/doctor-checking-patient-s-heart-rate_23-2148939497.jpg?w=900'
    ],
    'Neurology' => [
        'desc' => 'Comprehensive diagnosis and treatment of nervous system disorders by leading neurologists.',
        'about' => 'The Neurology department provides comprehensive care for disorders of the nervous system. Our expert neurologists specialize in diagnosing and treating complex neurological conditions using advanced imaging and therapeutic techniques.',
        'conditions' => ['Stroke', 'Epilepsy', 'Multiple Sclerosis', 'Parkinson\'s Disease', 'Alzheimer\'s Disease', 'Migraines'],
        'image' => 'https://img.freepik.com/free-photo/neurologist-examining-brain-mri-scan_23-2149352345.jpg?w=900'
    ],
    'Pediatrics' => [
        'desc' => 'Compassionate and expert healthcare for infants, children, and adolescents.',
        'about' => 'Our Pediatrics department offers specialized, compassionate care for children from infancy through adolescence. We provide a child-friendly environment and comprehensive healthcare services tailored to the unique needs of young patients.',
        'conditions' => ['Childhood Asthma', 'Infectious Diseases', 'Growth Disorders', 'Nutritional Issues', 'Immunizations', 'Behavioral Development'],
        'image' => 'https://img.freepik.com/free-photo/pediatrician-doctor-examining-baby-boy_1303-23961.jpg?w=900'
    ],
    'Dentistry' => [
        'desc' => 'Complete oral health care from routine cleanings to advanced dental surgeries.',
        'about' => 'The Dentistry department provides a full spectrum of oral healthcare services. From routine check-ups and preventative care to complex restorative and cosmetic procedures, our dental professionals ensure your smile stays healthy and bright.',
        'conditions' => ['Tooth Decay', 'Gum Disease', 'Tooth Impaction', 'Oral Infections', 'Malocclusion', 'Tooth Loss'],
        'image' => 'https://img.freepik.com/free-photo/dentist-examining-patient-s-teeth-clinic_1303-19965.jpg?w=900'
    ],
    'Orthopedics' => [
        'desc' => 'Specialized care for your bones, joints, ligaments, tendons, and muscles.',
        'about' => 'Our Orthopedics department specializes in the care of the musculoskeletal system. We offer advanced treatments for bone and joint conditions, sports injuries, and complex orthopedic trauma to help you regain mobility and live pain-free.',
        'conditions' => ['Osteoarthritis', 'Bone Fractures', 'Tendonitis', 'Ligament Tears', 'Spinal Disorders', 'Sports Injuries'],
        'image' => 'https://img.freepik.com/free-photo/physiotherapist-doing-leg-exercises-with-patient_1170-2051.jpg?w=900'
    ],
    'Optometry' => [
        'desc' => 'Advanced eye care services to protect and improve your vision.',
        'about' => 'The Optometry department is committed to preserving and enhancing your vision. We offer comprehensive eye exams, specialized contact lens fittings, and advanced diagnostic services to treat and manage a wide range of eye conditions.',
        'conditions' => ['Myopia', 'Cataracts', 'Glaucoma', 'Macular Degeneration', 'Dry Eye Syndrome', 'Diabetic Retinopathy'],
        'image' => 'https://img.freepik.com/free-photo/optometrist-examining-patient-s-eyes-with-slit-lamp_1303-24103.jpg?w=900'
    ]
];

$data = $aboutData[$specialty] ?? [
    'desc' => 'Dedicated to providing the best medical care and treatment in ' . $safe_specialty . '.',
    'about' => 'Welcome to the ' . $safe_specialty . ' department. We provide expert medical care and advanced treatments to ensure your health and well-being.',
    'conditions' => ['General Checkups', 'Diagnostic Services', 'Preventative Care', 'Specialized Treatments'],
    'image' => 'https://img.freepik.com/free-photo/modern-hospital-building_1127-2851.jpg?w=900'
];
$desc = $data['desc'];

?>

<!-- Specialty Hero Section -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container py-4">
        <h1 class="display-4 fw-bold mb-3"><?php echo $safe_specialty; ?> Department</h1>
        <p class="lead opacity-75 mx-auto" style="max-width: 600px;">
            <?php echo $desc; ?>
        </p>
    </div>
</section>

<!-- About the Department Section -->
<section class="py-5 bg-white">
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0 pe-lg-5">
                <img src="<?php echo $data['image']; ?>" alt="<?php echo $safe_specialty; ?>" class="img-fluid rounded-4 shadow-lg" style="object-fit: cover; height: 400px; width: 100%;">
            </div>
            <div class="col-lg-6">
                <span class="text-primary fw-bold text-uppercase tracking-wide">About the Department</span>
                <h2 class="fw-bold display-6 mb-4 mt-2">What is <?php echo $safe_specialty; ?>?</h2>
                <p class="text-muted mb-4 lead"><?php echo $data['about']; ?></p>
                
                <h5 class="fw-bold mb-3">Conditions We Treat</h5>
                <div class="row g-3">
                    <?php foreach($data['conditions'] as $condition): ?>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center text-muted">
                            <i class="fas fa-check-circle text-primary me-2"></i>
                            <span><?php echo $condition; ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Doctors List Section -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center w-75 mx-auto mb-5">
            <h2 class="fw-bold display-6 mb-3">Our <?php echo $safe_specialty; ?> Specialists</h2>
            <p class="text-muted">Book an appointment with our experienced doctors.</p>
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
                echo '<div class="col-12 text-center py-5">
                        <div class="text-muted mb-3"><i class="fas fa-user-md fa-4x opacity-50"></i></div>
                        <h4 class="text-muted">No specialists found</h4>
                        <p class="text-muted">We currently do not have any active doctors available in the '.$safe_specialty.' department.</p>
                        <a href="doctors.php" class="btn btn-primary mt-3">View All Doctors</a>
                      </div>';
            }
            ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
