<?php
require_once '../includes/config.php';
include '../includes/admin_header.php';

$id = $_GET['id'] ?? 0;


$sql = "SELECT * FROM users WHERE user_id = ? AND role = 'patient'";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$patient = $stmt->fetch();

if (!$patient) {
    header("Location: patients.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    $sql = "UPDATE users SET full_name = ?, phone = ?, address = ? WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$full_name, $phone, $address, $id])) {
        $success = "Patient updated successfully!";
        

        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
        $patient = $stmt->fetch();
    } else {
        $error = "Error updating patient!";
    }
}
?>

<h2>Edit Patient</h2>
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
                            <label class="form-label">IC Number</label>
                            <input type="text" class="form-control" value="<?php echo $patient['ic_number']; ?>" readonly disabled>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" 
                                   value="<?php echo $patient['full_name']; ?>" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" value="<?php echo $patient['email']; ?>" readonly disabled>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" 
                                   value="<?php echo $patient['phone']; ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required><?php echo $patient['address']; ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Patient</button>
                    <a href="patients.php" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>