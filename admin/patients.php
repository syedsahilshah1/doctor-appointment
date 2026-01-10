<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../config/db.php';
include 'includes/header.php';
?>

<h2>Patient Management</h2>
<div class="card shadow-sm border-0 mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Info</th>
                        <th>Registered On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("SELECT p.*, u.name, u.email, u.created_at FROM patients p JOIN users u ON p.user_id = u.id ORDER BY u.created_at DESC");
                    while($row = $stmt->fetch()){
                        echo "<tr>
                            <td>#{$row['id']}</td>
                            <td>
                                <div class='d-flex align-items-center'>
                                    <div class='bg-light rounded-circle p-2 me-2'><i class='fas fa-user text-success'></i></div>
                                    <div>
                                        <span class='fw-bold d-block'>{$row['name']}</span>
                                        <small class='text-muted'>{$row['email']}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class='badge bg-danger'>{$row['blood_group']}</span>
                                <small class='text-muted d-block mt-1'><i class='fas fa-map-marker-alt'></i> " . ($row['city'] ?? 'Unknown') . "</small>
                            </td>
                            <td>" . date('M d, Y', strtotime($row['created_at'])) . "</td>
                            <td>
                                <button class='btn btn-sm btn-outline-danger' disabled title='Delete not implemented to preserve history'><i class='fas fa-trash'></i></button>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
