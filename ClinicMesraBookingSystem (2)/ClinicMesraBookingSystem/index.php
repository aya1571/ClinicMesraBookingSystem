<?php
require_once 'includes/config.php';
include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-12 text-center mb-4">
        <h1 class="display-4">Welcome to Clinic Mesra</h1>
        <p class="lead">Your trusted healthcare partner for convenient online appointment booking</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="fas fa-calendar-check fa-4x mb-3" style="color: #3498db;"></i>
                <h5 class="card-title">Easy Booking</h5>
                <p class="card-text">Book your appointments online anytime, anywhere without waiting in long queues.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="fas fa-user-md fa-4x mb-3" style="color: #3498db;"></i>
                <h5 class="card-title">Qualified Doctors</h5>
                <p class="card-text">View our experienced doctors and choose the specialist that suits your needs.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center h-100">
            <div class="card-body">
                <i class="fas fa-clock fa-4x mb-3" style="color: #3498db;"></i>
                <h5 class="card-title">Save Time</h5>
                <p class="card-text">Reduce waiting time with our efficient scheduling system.</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user me-2"></i>For Patients</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i>Register online account</li>
                    <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i>View doctor schedules</li>
                    <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i>Book appointments 24/7</li>
                    <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i>Check appointment status</li>
                    <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i>Update personal information</li>
                </ul>
                <?php if(!isset($_SESSION['user_id'])): ?>
                    <div class="mt-3">
                        <a href="register.php" class="btn btn-primary">Register Now</a>
                        <a href="login.php" class="btn btn-outline-primary ms-2">Login</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-hospital-user me-2"></i>For Clinic Staff</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i>Manage patient records</li>
                    <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i>Manage doctor information</li>
                    <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i>Schedule management</li>
                    <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i>Appointment tracking</li>
                    <li class="list-group-item"><i class="fas fa-check-circle text-success me-2"></i>Search and filter records</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>