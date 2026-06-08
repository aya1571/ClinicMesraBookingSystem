<?php
require_once '../includes/config.php';


include '../includes/admin_header.php';

$stats = [];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM users WHERE role = 'patient'");
$stats['patients'] = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM doctors");
$stats['doctors'] = $stmt->fetch()['total'];

$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM appointments WHERE appointment_date = CURDATE()");
$stmt->execute();
$stats['today_appointments'] = $stmt->fetch()['total'];

$stmt = $pdo->prepare("SELECT COUNT(*) as total FROM appointments WHERE status = 'pending'");
$stmt->execute();
$stats['pending'] = $stmt->fetch()['total'];

$sql = "SELECT a.*, u.full_name as patient_name, d.doctor_name 
        FROM appointments a 
        JOIN users u ON a.user_id = u.user_id 
        JOIN doctors d ON a.doctor_id = d.doctor_id 
        ORDER BY a.booking_date DESC LIMIT 5";
$recent = $pdo->query($sql)->fetchAll();
?>

<div class="row">
    <div class="col-md-12">
        <h2>Dashboard</h2>
        <p>Welcome back, <?php echo $_SESSION['full_name']; ?>!</p>
        <hr>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5 class="card-title">Total Patients</h5>
                <h2><?php echo $stats['patients']; ?></h2>
                <i class="fas fa-users fa-2x position-absolute end-0 bottom-0 me-3 mb-3 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5 class="card-title">Total Doctors</h5>
                <h2><?php echo $stats['doctors']; ?></h2>
                <i class="fas fa-user-md fa-2x position-absolute end-0 bottom-0 me-3 mb-3 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h5 class="card-title">Today's Appointments</h5>
                <h2><?php echo $stats['today_appointments']; ?></h2>
                <i class="fas fa-calendar-day fa-2x position-absolute end-0 bottom-0 me-3 mb-3 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h5 class="card-title">Pending</h5>
                <h2><?php echo $stats['pending']; ?></h2>
                <i class="fas fa-clock fa-2x position-absolute end-0 bottom-0 me-3 mb-3 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="patients.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Manage Patients
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="doctors.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Manage Doctors
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="schedules.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Manage Schedules
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="appointments.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Manage Appointments
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Appointments</h5>
            </div>
            <div class="card-body">
                <?php if(count($recent) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Doctor</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($recent as $r): ?>
                                <tr>
                                    <td><?php echo $r['patient_name']; ?></td>
                                    <td><?php echo $r['doctor_name']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($r['appointment_date'])); ?></td>
                                    <td>
                                        <span class="badge bg-<?php 
                                            echo $r['status'] == 'confirmed' ? 'success' : 
                                                ($r['status'] == 'pending' ? 'warning' : 
                                                ($r['status'] == 'completed' ? 'info' : 'danger')); ?>">
                                            <?php echo $r['status']; ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-center text-muted">No recent appointments.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>