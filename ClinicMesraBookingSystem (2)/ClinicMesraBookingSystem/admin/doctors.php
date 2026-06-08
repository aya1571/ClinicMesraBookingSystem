<?php
require_once '../includes/config.php';
include '../includes/admin_header.php';


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM doctors WHERE doctor_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $success = "Doctor deleted successfully!";
}


$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search) {
    $sql = "SELECT * FROM doctors WHERE doctor_name LIKE ? OR specialization LIKE ? ORDER BY doctor_name";
    $stmt = $pdo->prepare($sql);
    $searchTerm = "%$search%";
    $stmt->execute([$searchTerm, $searchTerm]);
} else {
    $sql = "SELECT * FROM doctors ORDER BY doctor_name";
    $stmt = $pdo->query($sql);
}
$doctors = $stmt->fetchAll();
?>

<h2>Manage Doctors</h2>
<hr>

<?php if(isset($success)): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<div class="row mb-3">
    <div class="col-md-6">
        <a href="add_doctor.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Doctor
        </a>
    </div>
    <div class="col-md-6">
        <form method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Search by name or specialization..." value="<?php echo $search; ?>">
            <button type="submit" class="btn btn-outline-primary">Search</button>
            <?php if($search): ?>
                <a href="doctors.php" class="btn btn-outline-secondary ms-2">Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if(count($doctors) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Doctor Name</th>
                            <th>Specialization</th>
                            <th>Qualification</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($doctors as $doctor): ?>
                        <tr>
                            <td><?php echo $doctor['doctor_id']; ?></td>
                            <td><?php echo $doctor['doctor_name']; ?></td>
                            <td><?php echo $doctor['specialization']; ?></td>
                            <td><?php echo $doctor['qualification']; ?></td>
                            <td><?php echo $doctor['contact']; ?></td>
                            <td><?php echo $doctor['email']; ?></td>
                            <td>
                                <span class="badge bg-<?php echo $doctor['status'] == 'active' ? 'success' : 'secondary'; ?>">
                                    <?php echo $doctor['status']; ?>
                                </span>
                            </td>
                            <td>
                                <a href="edit_doctor.php?id=<?php echo $doctor['doctor_id']; ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="?delete=<?php echo $doctor['doctor_id']; ?>" class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this doctor?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                                <a href="schedules.php?doctor_id=<?php echo $doctor['doctor_id']; ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-calendar"></i> Schedules
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center">No doctors found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>