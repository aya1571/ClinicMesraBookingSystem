<?php
require_once '../includes/config.php';
include '../includes/admin_header.php';

$id = $_GET['id'] ?? 0;


$sql = "SELECT * FROM doctors WHERE doctor_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$doctor = $stmt->fetch();

if (!$doctor) {
    header("Location: doctors.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_name = $_POST['doctor_name'];
    $specialization = $_POST['specialization'];
    $qualification = $_POST['qualification'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    
    $sql = "UPDATE doctors SET doctor_name = ?, specialization = ?, qualification = ?, contact = ?, email = ?, status = ? WHERE doctor_id = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$doctor_name, $specialization, $qualification, $contact, $email, $status, $id])) {
        $success = "Doctor updated successfully!";
        

        $stmt = $pdo->prepare("SELECT * FROM doctors WHERE doctor_id = ?");
        $stmt->execute([$id]);
        $doctor = $stmt->fetch();
    } else {
        $error = "Error updating doctor!";
    }
}
?>

<h2>Edit Doctor</h2>
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
                            <input type="text" class="form-control" id="doctor_name" name="doctor_name" 
                                   value="<?php echo $doctor['doctor_name']; ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="specialization" class="form-label">Specialization</label>
                            <input type="text" class="form-control" id="specialization" name="specialization" 
                                   value="<?php echo $doctor['specialization']; ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="qualification" class="form-label">Qualification</label>
                        <input type="text" class="form-control" id="qualification" name="qualification" 
                               value="<?php echo $doctor['qualification']; ?>" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="contact" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contact" name="contact" 
                                   value="<?php echo $doctor['contact']; ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo $doctor['email']; ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active" <?php echo $doctor['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo $doctor['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Doctor</button>
                    <a href="doctors.php" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>