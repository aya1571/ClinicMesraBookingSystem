<?php
require_once '../includes/config.php';
include '../includes/admin_header.php';


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM schedules WHERE schedule_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $success = "Schedule deleted successfully!";
}


$doctor_filter = isset($_GET['doctor_id']) ? $_GET['doctor_id'] : '';

if ($doctor_filter) {
    $sql = "SELECT s.*, d.doctor_name FROM schedules s JOIN doctors d ON s.doctor_id = d.doctor_id WHERE s.doctor_id = ? ORDER BY s.schedule_date, s.start_time";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$doctor_filter]);
} else {
    $sql = "SELECT s.*, d.doctor_name FROM schedules s JOIN doctors d ON s.doctor_id = d.doctor_id ORDER BY s.schedule_date, s.start_time";
    $stmt = $pdo->query($sql);
}
$schedules = $stmt->fetchAll();

$doctors = $pdo->query("SELECT * FROM doctors ORDER BY doctor_name")->fetchAll();
?>

<h2>Manage Schedules</h2>
<hr>

<?php if(isset($success)): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<div class="row mb-3">
    <div class="col-md-6">
        <a href="add_schedule.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Schedule
        </a>
    </div>
    <div class="col-md-6">
        <form method="GET" class="d-flex">
            <select name="doctor_id" class="form-select me-2">
                <option value="">All Doctors</option>
                <?php foreach($doctors as $doctor): ?>
                    <option value="<?php echo $doctor['doctor_id']; ?>" <?php echo $doctor_filter == $doctor['doctor_id'] ? 'selected' : ''; ?>>
                        <?php echo $doctor['doctor_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-outline-primary">Filter</button>
            <?php if($doctor_filter): ?>
                <a href="schedules.php" class="btn btn-outline-secondary ms-2">Clear</a>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if(count($schedules) > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Max Patients</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($schedules as $schedule): ?>
                        <tr>
                            <td><?php echo $schedule['schedule_id']; ?></td>
                            <td><?php echo $schedule['doctor_name']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($schedule['schedule_date'])); ?></td>
                            <td><?php echo date('h:i A', strtotime($schedule['start_time'])); ?></td>
                            <td><?php echo date('h:i A', strtotime($schedule['end_time'])); ?></td>
                            <td><?php echo $schedule['max_patients']; ?></td>
                            <td>
                                <span class="badge bg-<?php echo $schedule['status'] == 'available' ? 'success' : ($schedule['status'] == 'full' ? 'warning' : 'secondary'); ?>">
                                    <?php echo $schedule['status']; ?>
                                </span>
                            </td>
                            <td>
                                <a href="edit_schedule.php?id=<?php echo $schedule['schedule_id']; ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="?delete=<?php echo $schedule['schedule_id']; ?>" class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this schedule?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center">No schedules found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>
<div class="row mb-3">
    <div class="col-md-12">
        <button class="btn btn-success" onclick="generateWeekly()">
            <i class="fas fa-calendar-week"></i> Generate Weekly Schedule
        </button>
    </div>
</div>

<script>
function generateWeekly() {
    if(confirm('Generate schedule untuk minggu depan?')) {
        window.location.href = 'generate_schedule.php';
    }
}
</script>