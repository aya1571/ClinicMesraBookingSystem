<?php
require_once 'includes/config.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$sql = "SELECT COUNT(*) as total FROM appointments WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$total_appointments = $stmt->fetch()['total'];

$sql = "SELECT a.*, d.doctor_name, d.specialization 
        FROM appointments a 
        JOIN doctors d ON a.doctor_id = d.doctor_id 
        WHERE a.user_id = ? AND a.appointment_date >= CURDATE() AND a.status != 'cancelled'
        ORDER BY a.appointment_date ASC LIMIT 5";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$upcoming = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <h2>Welcome back, <?php echo $_SESSION['full_name']; ?>!</h2>
        <hr>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Appointments</h5>
                <h2><?php echo $total_appointments; ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Quick Actions</h5>
                <a href="book_appointment.php" class="btn btn-light btn-sm">Book New Appointment</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Profile</h5>
                <a href="profile.php" class="btn btn-light btn-sm">Update Profile</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Upcoming Appointments</h5>
            </div>
            <div class="card-body">
                <?php if(count($upcoming) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Doctor</th>
                                    <th>Specialization</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($upcoming as $appt): ?>
                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($appt['appointment_date'])); ?></td>
                                    <td><?php echo $appt['appointment_time']; ?></td>
                                    <td><?php echo $appt['doctor_name']; ?></td>
                                    <td><?php echo $appt['specialization']; ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo $appt['status'] == 'confirmed' ? 'success' : 'warning'; ?>">
                                            <?php echo $appt['status']; ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        No upcoming appointments. <a href="book_appointment.php">Book your first appointment now!</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>