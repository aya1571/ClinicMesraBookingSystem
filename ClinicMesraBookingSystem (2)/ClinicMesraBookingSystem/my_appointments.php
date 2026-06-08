<?php
require_once 'includes/config.php';

if (!isLoggedIn()) {
    redirect('login.php');
}


if (isset($_GET['cancel'])) {
    $appointment_id = $_GET['cancel'];
    $sql = "UPDATE appointments SET status = 'cancelled' WHERE appointment_id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$appointment_id, $_SESSION['user_id']]);
    $success = "Appointment cancelled successfully!";
}


$sql = "SELECT a.*, d.doctor_name, d.specialization 
        FROM appointments a 
        JOIN doctors d ON a.doctor_id = d.doctor_id 
        WHERE a.user_id = ? 
        ORDER BY a.appointment_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$appointments = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <h2>My Appointments</h2>
        <hr>
    </div>
</div>

<?php if(isset($success)): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?php if(count($appointments) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Appointment ID</th>
                                    <th>Doctor</th>
                                    <th>Specialization</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($appointments as $appt): ?>
                                <tr>
                                    <td>AP<?php echo str_pad($appt['appointment_id'], 6, '0', STR_PAD_LEFT); ?></td>
                                    <td><?php echo $appt['doctor_name']; ?></td>
                                    <td><?php echo $appt['specialization']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($appt['appointment_date'])); ?></td>
                                    <td><?php echo $appt['appointment_time']; ?></td>
                                    <td>
                                        <?php
                                        $badge_color = 'secondary';
                                        if($appt['status'] == 'confirmed') $badge_color = 'success';
                                        if($appt['status'] == 'pending') $badge_color = 'warning';
                                        if($appt['status'] == 'completed') $badge_color = 'info';
                                        if($appt['status'] == 'cancelled') $badge_color = 'danger';
                                        ?>
                                        <span class="badge bg-<?php echo $badge_color; ?>">
                                            <?php echo $appt['status']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $appt['remarks'] ?: '-'; ?></td>
                                    <td>
                                        <?php if($appt['status'] != 'cancelled' && $appt['status'] != 'completed'): ?>
                                            <a href="?cancel=<?php echo $appt['appointment_id']; ?>" 
                                               class="btn btn-danger btn-sm" 
                                               onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                                <i class="fas fa-times-circle me-1"></i>Cancel
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center">
                        <i class="fas fa-calendar-times fa-3x mb-3"></i>
                        <p>No appointments found.</p>
                        <a href="book_appointment.php" class="btn btn-primary">Book your first appointment now!</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>