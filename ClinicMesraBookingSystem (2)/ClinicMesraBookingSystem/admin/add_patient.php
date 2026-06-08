<?php
require_once '../includes/config.php';
include '../includes/admin_header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ic_number = $_POST['ic_number'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (ic_number, full_name, email, phone, address, password, role) VALUES (?, ?, ?, ?, ?, ?, 'patient')";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$ic_number, $full_name, $email, $phone, $address, $password]);
        $success = "Patient added successfully!";
    } catch(PDOException $e) {
        $error = "Email or IC number already exists!";
    }
}
?>

<div class="row">
    <div class="col-md-12">
        <h2>Add New Patient</h2>
        <hr>
    </div>
</div>

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
                            <label for="ic_number" class="form-label">IC Number</label>
                            <input type="text" class="form-control" id="ic_number" name="ic_number" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Add Patient</button>
                    <a href="patients.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelector('form').addEventListener('submit', function(e) {
    var password = document.getElementById('password').value;
    var confirm = document.getElementById('confirm_password').value;
    if (password != confirm) {
        e.preventDefault();
        alert('Password and confirm password do not match!');
    }
});
</script>

<?php include '../includes/admin_footer.php'; ?>