<?php
include 'config/db.php';

try {
    echo "Seeding Database...<br>";

    // Sample Doctors Data
    $doctors_data = [
        [
            'name' => 'Dr. Smith Johnson',
            'email' => 'smith@hospital.com',
            'specialization' => 'Cardiologist',
            'fee' => 150.00,
            'bio' => 'Expert in heart surgeries with 15 years of experience.'
        ],
        [
            'name' => 'Dr. Sarah Wilson',
            'email' => 'sarah@hospital.com',
            'specialization' => 'Dermatologist',
            'fee' => 100.00,
            'bio' => 'Specialist in skin care and cosmetic treatments.'
        ],
        [
            'name' => 'Dr. Michael Chen',
            'email' => 'michael@hospital.com',
            'specialization' => 'Neurologist',
            'fee' => 200.00,
            'bio' => 'Focuses on disorders of the nervous system.'
        ],
        [
            'name' => 'Dr. Emily Davis',
            'email' => 'emily@hospital.com',
            'specialization' => 'Pediatrician',
            'fee' => 80.00,
            'bio' => 'Dedicated to the health and well-being of children.'
        ],
        [
            'name' => 'Dr. James Wilson',
            'email' => 'james@hospital.com',
            'specialization' => 'Dentist',
            'fee' => 120.00,
            'bio' => 'Experienced dentist specializing in oral surgery.'
        ]
    ];

    $password = password_hash('password123', PASSWORD_DEFAULT);

    foreach ($doctors_data as $doc) {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$doc['email']]);
        
        if ($stmt->rowCount() == 0) {
            // Create User
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'doctor')");
            $stmt->execute([$doc['name'], $doc['email'], $password]);
            $user_id = $pdo->lastInsertId();

            // Create Doctor Profile
            $stmt = $pdo->prepare("INSERT INTO doctors (user_id, specialization, consultation_fee, bio) VALUES (?, ?, ?, ?)");
            $stmt->execute([$user_id, $doc['specialization'], $doc['fee'], $doc['bio']]);
            $doctor_id = $pdo->lastInsertId();

            // Create Schedule (Mon-Fri, 9AM - 5PM)
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
            $schedule_stmt = $pdo->prepare("INSERT INTO schedules (doctor_id, day_of_week, start_time, end_time) VALUES (?, ?, '09:00:00', '17:00:00')");
            
            foreach ($days as $day) {
                $schedule_stmt->execute([$doctor_id, $day]);
            }
            
            echo "Added {$doc['name']} ({$doc['specialization']})<br>";
        } else {
            echo "Skipped {$doc['name']} (Already exists)<br>";
        }
    }

    echo "<hr><strong style='color:green'>Seeding Completed! Default Password: password123</strong> <a href='index.php'>Go Home</a>";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
