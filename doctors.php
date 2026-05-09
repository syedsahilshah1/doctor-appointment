<?php
session_start();
include 'config/db.php';
include 'includes/header.php';
?>



<div class="container py-5 mt-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Find a Specialist</h2>
        <p class="text-muted">Browse our list of qualified doctors and book an appointment.</p>
    </div>

    <!-- Search/Filter -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <form action="" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control form-control-lg" placeholder="Search by doctor name or specialization..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit" class="btn btn-primary-custom px-4">Search</button>
            </form>
        </div>
    </div>

    <div class="row g-4">
        <?php
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $sql = "SELECT d.*, u.name 
                FROM doctors d 
                JOIN users u ON d.user_id = u.id 
                WHERE d.is_active = 1";
        
        $params = [];
        if ($search) {
            $sql .= " AND (u.name LIKE ? OR d.specialization LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch()) {
                echo '
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm text-center p-3 animate-fade-in">
                        <div class="card-body">
                            <img src="https://ui-avatars.com/api/?name='.urlencode($row['name']).'&background=0D8ABC&color=fff" class="rounded-circle mb-3 shadow-sm" width="100" height="100">
                            <h5 class="fw-bold mb-0">Dr. '.htmlspecialchars($row['name']).'</h5>
                            <small class="text-muted">'.htmlspecialchars($row['qualification']).'</small>
                            <p class="text-primary small fw-bold mt-2 mb-1">'.htmlspecialchars($row['specialization']).'</p>
                            
                            <div class="d-flex justify-content-center gap-3 mb-3 text-muted small">
                                <span><i class="fas fa-briefcase me-1"></i>'.$row['experience'].' Yrs</span>
                                <span><i class="fas fa-door-open me-1"></i>Room '.$row['room_no'].'</span>
                            </div>

                            <p class="fw-bold mb-3">$'.number_format($row['consultation_fee'], 2).' <span class="text-muted fw-normal small">/ Visit</span></p>
                            <a href="booking.php?doctor_id='.$row['id'].'" class="btn btn-outline-primary w-100 rounded-pill">Book Appointment</a>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<div class="col-12 text-center"><p class="text-muted">No doctors found matching your criteria.</p></div>';
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
