<?php
require_once '../includes/config.php';
include '../includes/admin_header.php';

if (isset($_GET['update_status']) && isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'];
    
    $sql = "UPDATE appointments SET status = ? WHERE appointment_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$status, $id]);
    $success = "Appointment status updated to $status!";
}


$search = isset($_GET['search']) ? $_GET['search'] : '';
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

$sql = "SELECT a.*, u.full_name as patient_name, u.ic_number, u.phone, d.doctor_name, d.specialization 
        FROM appointments a 
        JOIN users u ON a.user_id = u.user_id 
        JOIN doctors d ON a.doctor_id = d.doctor_id 
        WHERE 1=1";

$params = [];

if ($search) {
    $sql .= " AND (u.full_name LIKE ? OR u.ic_number LIKE ? OR d.doctor_name LIKE ?)";
    $searchTerm = "%$search%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
}

if ($status_filter) {
    $sql .= " AND a.status = ?";
    $params[] = $status_filter;
}

$sql .= " ORDER BY a.appointment_date DESC, a.appointment_time";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$appointments = $stmt->fetchAll();
?>

<h2>Manage Appointments</h2>
<hr>

<?php if(isset($success)): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<div class="row mb-3">
    <div class="col-md-12">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by patient name, IC, or doctor..." value="<?php echo $search; ?>">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" <?php echo $status_filter == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="confirmed" <?php echo $status_filter == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                    <option value="completed" <?php echo $status_filter == 'completed' ? 'selected' : ''; ?>>Completed</option>
                    <option value="cancelled" <?php echo $status_filter == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-3">
                <?php if($search || $status_filter): ?>
                    <a href="appointments.php" class="btn btn-outline-secondary w-100">Clear</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if(count($appointments) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Patient</th>
                            <th>IC Number</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($appointments as $apt): ?>
                        <tr>
                            <td>AP<?php echo str_pad($apt['appointment_id'], 6, '0', STR_PAD_LEFT); ?></td>
                            <td><?php echo $apt['patient_name']; ?></td>
                            <td><?php echo $apt['ic_number']; ?></td>
                            <td><?php echo $apt['doctor_name']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($apt['appointment_date'])); ?></td>
                            <td><?php echo $apt['appointment_time']; ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo $apt['status'] == 'confirmed' ? 'success' : 
                                        ($apt['status'] == 'pending' ? 'warning' : 
                                        ($apt['status'] == 'completed' ? 'info' : 'danger')); ?>">
                                    <?php echo $apt['status']; ?>
                                </span>
                            </td>
                            <td><?php echo $apt['remarks'] ?: '-'; ?></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-bs-toggle="dropdown">
                                        Update Status
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="?update_status=1&id=<?php echo $apt['appointment_id']; ?>&status=pending">Pending</a></li>
                                        <li><a class="dropdown-item" href="?update_status=1&id=<?php echo $apt['appointment_id']; ?>&status=confirmed">Confirmed</a></li>
                                        <li><a class="dropdown-item" href="?update_status=1&id=<?php echo $apt['appointment_id']; ?>&status=completed">Completed</a></li>
                                        <li><a class="dropdown-item" href="?update_status=1&id=<?php echo $apt['appointment_id']; ?>&status=cancelled">Cancelled</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center">No appointments found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>