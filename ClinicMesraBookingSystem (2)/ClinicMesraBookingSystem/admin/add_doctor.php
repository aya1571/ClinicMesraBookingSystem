<?php
require_once '../includes/config.php';
include '../includes/admin_header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_name = $_POST['doctor_name'];
    $specialization = $_POST['specialization'];
    $qualification = $_POST['qualification'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    
    $sql = "INSERT INTO doctors (doctor_name, specialization, qualification, contact, email) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$doctor_name, $specialization, $qualification, $contact, $email]);
        $success = "Doctor added successfully!";
    } catch(PDOException $e) {
        $error = "Error adding doctor!";
    }
}
?>

<h2>Add New Doctor</h2>
<hr>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <?php if(isset($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="doctor_name" class="form-label">Doctor Name</label>
                            <input type="text" class="form-control" id="doctor_name" name="doctor_name" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="specialization" class="form-label">Specialization</label>
                            <input type="text" class="form-control" id="specialization" name="specialization" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="qualification" class="form-label">Qualification</label>
                        <input type="text" class="form-control" id="qualification" name="qualification" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="contact" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contact" name="contact" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Add Doctor</button>
                    <a href="doctors.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>