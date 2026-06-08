<?php
require_once '../includes/config.php';
include '../includes/admin_header.php';


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE user_id = ? AND role = 'patient'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $success = "Patient deleted successfully!";
}


$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search) {
    $sql = "SELECT * FROM users WHERE role = 'patient' AND (full_name LIKE ? OR ic_number LIKE ? OR email LIKE ? OR phone LIKE ?) ORDER BY full_name";
    $stmt = $pdo->prepare($sql);
    $searchTerm = "%$search%";
    $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
} else {
    $sql = "SELECT * FROM users WHERE role = 'patient' ORDER BY full_name";
    $stmt = $pdo->query($sql);
}
$patients = $stmt->fetchAll();
?>

<h2>Manage Patients</h2>
<hr>

<?php if(isset($success)): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<div class="row mb-3">
    <div class="col-md-6">
        <a href="add_patient.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Patient
        </a>
    </div>
    <div class="col-md-6">
        <form method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search by name, IC, email, phone..." value="<?php echo $search; ?>">
            <button type="submit" class="btn btn-outline-primary">Search</button>
            <?php if($search): ?>
                <a href="patients.php" class="btn btn-outline-secondary ms-2">Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if(count($patients) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>IC Number</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Registration Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($patients as $patient): ?>
                        <tr>
                            <td><?php echo $patient['user_id']; ?></td>
                            <td><?php echo $patient['ic_number']; ?></td>
                            <td><?php echo $patient['full_name']; ?></td>
                            <td><?php echo $patient['email']; ?></td>
                            <td><?php echo $patient['phone']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($patient['registration_date'])); ?></td>
                            <td>
                                <a href="edit_patient.php?id=<?php echo $patient['user_id']; ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="?delete=<?php echo $patient['user_id']; ?>" class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this patient?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center">No patients found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>