<?php
require_once '../includes/config.php';
include '../includes/admin_header.php';

$doctors = $pdo->query("SELECT * FROM doctors WHERE status = 'active' ORDER BY doctor_name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $schedule_date = $_POST['schedule_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $max_patients = $_POST['max_patients'];
    
    $sql = "INSERT INTO schedules (doctor_id, schedule_date, start_time, end_time, max_patients) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    try {
        $stmt->execute([$doctor_id, $schedule_date, $start_time, $end_time, $max_patients]);
        $success = "Schedule added successfully!";
    } catch(PDOException $e) {
        $error = "Error adding schedule!";
    }
}
?>

<h2>Add New Schedule</h2>
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
                    <div class="mb-3">
                        <label for="doctor_id" class="form-label">Select Doctor</label>
                        <select class="form-select" id="doctor_id" name="doctor_id" required>
                            <option value="">-- Select Doctor --</option>
                            <?php foreach($doctors as $doctor): ?>
                                <option value="<?php echo $doctor['doctor_id']; ?>">
                                    <?php echo $doctor['doctor_name']; ?> - <?php echo $doctor['specialization']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="schedule_date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="schedule_date" name="schedule_date" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" class="form-control" id="end_time" name="end_time" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="max_patients" class="form-label">Maximum Patients</label>
                        <input type="number" class="form-control" id="max_patients" name="max_patients" value="10" min="1" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Add Schedule</button>
                    <a href="schedules.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>