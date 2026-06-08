<?php
require_once 'includes/config.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$sql = "SELECT * FROM doctors WHERE status = 'active' ORDER BY doctor_name";
$stmt = $pdo->query($sql);
$doctors = $stmt->fetchAll();

include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <h2>Our Doctors</h2>
        <p class="lead">Meet our team of qualified and experienced medical professionals.</p>
        <hr>
    </div>
</div>

<div class="row">
    <?php foreach($doctors as $doctor): ?>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="fas fa-user-md fa-4x" style="color: #3498db;"></i>
                </div>
                <h5 class="card-title text-center"><?php echo $doctor['doctor_name']; ?></h5>
                <p class="card-text">
                    <ul class="list-unstyled">
                        <li><strong><i class="fas fa-stethoscope me-2"></i>Specialization:</strong> <?php echo $doctor['specialization']; ?></li>
                        <li><strong><i class="fas fa-graduation-cap me-2"></i>Qualification:</strong> <?php echo $doctor['qualification']; ?></li>
                        <li><strong><i class="fas fa-phone me-2"></i>Contact:</strong> <?php echo $doctor['contact']; ?></li>
                        <li><strong><i class="fas fa-envelope me-2"></i>Email:</strong> <?php echo $doctor['email']; ?></li>
                    </ul>
                </p>
                <div class="d-grid gap-2">
                    <a href="book_appointment.php?doctor_id=<?php echo $doctor['doctor_id']; ?>" class="btn btn-primary">
                        <i class="fas fa-calendar-check me-2"></i>Book Appointment
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php include 'includes/footer.php'; ?>