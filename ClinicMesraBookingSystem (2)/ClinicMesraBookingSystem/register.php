<?php
require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    if (!isset($_POST['terms'])) {
        $error = "You must agree to the Terms & Conditions to register!";
    } else {
        $ic_number = $_POST['ic_number'];
        $full_name = $_POST['full_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $agreed_terms = 1;
        
        $sql = "INSERT INTO users (ic_number, full_name, email, phone, address, password, role, agreed_terms) 
                VALUES (?, ?, ?, ?, ?, ?, 'patient', ?)";
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([$ic_number, $full_name, $email, $phone, $address, $password, $agreed_terms]);
            $success = "Registration successful! Please login.";
        } catch(PDOException $e) {
            $error = "Email or IC number already exists!";
        }
    }
}

include 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i>Patient Registration</h4>
            </div>
            <div class="card-body">
                <?php if(isset($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="" id="registerForm">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ic_number" class="form-label">IC Number</label>
                            <input type="text" class="form-control" id="ic_number" name="ic_number" placeholder="e.g., 950101-10-1234" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="e.g., Siti Aisyah Binti Abdullah" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="e.g., siti.aisyah@email.com" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="e.g., 012-3456789" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" placeholder="e.g., No 123, Jalan Clinic, Taman Kesihatan" required></textarea>
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
                    
            
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            I have read and agree to the 
                            <a href="javascript:void(0)" onclick="openTerms('terms.php')">Terms & Conditions</a> and 
                            <a href="javascript:void(0)" onclick="openTerms('privacy.php')">Privacy Policy</a>
                        </label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Register</button>
                    <a href="login.php" class="btn btn-link">Already have an account? Login here</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

function openTerms(url) {
    window.open(url, 'TermsWindow', 'width=800,height=600,scrollbars=yes,resizable=yes');
}


document.getElementById('registerForm').addEventListener('submit', function(e) {
    var password = document.getElementById('password').value;
    var confirm = document.getElementById('confirm_password').value;
    if (password != confirm) {
        e.preventDefault();
        alert('Password and confirm password do not match!');
    }
});


document.querySelectorAll('#registerForm input, #registerForm textarea').forEach(field => {
    field.addEventListener('change', function() {
        sessionStorage.setItem(field.id, field.value);
    });
});


window.addEventListener('load', function() {
    document.querySelectorAll('#registerForm input, #registerForm textarea').forEach(field => {
        let saved = sessionStorage.getItem(field.id);
        if (saved && !field.value) {
            field.value = saved;
        }
    });
});


<?php if(isset($success)): ?>
    sessionStorage.clear();
<?php endif; ?>
</script>

<?php include 'includes/footer.php'; ?>