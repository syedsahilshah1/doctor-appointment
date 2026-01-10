<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../config/db.php';
include 'includes/header.php';
?>

<h2>Doctor Schedules</h2>
<div class="card shadow-sm border-0 mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Doctor</th>
                        <th>Day</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("SELECT s.*, u.name as doctor_name 
                                         FROM schedules s 
                                         JOIN doctors d ON s.doctor_id = d.id 
                                         JOIN users u ON d.user_id = u.id 
                                         ORDER BY u.name, FIELD(s.day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')");
                    while($row = $stmt->fetch()){
                        echo "<tr>
                            <td>Dr. {$row['doctor_name']}</td>
                            <td><span class='badge bg-info text-dark'>{$row['day_of_week']}</span></td>
                            <td>" . date('h:i A', strtotime($row['start_time'])) . "</td>
                            <td>" . date('h:i A', strtotime($row['end_time'])) . "</td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
