<?php
require_once '../includes/config.php';
include '../includes/admin_header.php';

$id = $_GET['id'] ?? 0;


$sql = "SELECT s.*, d.doctor_name FROM schedules s JOIN doctors d ON s.doctor_id = d.doctor_id WHERE s.schedule_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$schedule = $stmt->fetch();

if (!$schedule) {
    header("Location: schedules.php");
    exit();
}


$doctors = $pdo->query("SELECT * FROM doctors WHERE status = 'active' ORDER BY doctor_name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $schedule_date = $_POST['schedule_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $max_patients = $_POST['max_patients'];
    $status = $_POST['status'];
    
    $sql = "UPDATE schedules SET doctor_id = ?, schedule_date = ?, start_time = ?, end_time = ?, max_patients = ?, status = ? WHERE schedule_id = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$doctor_id, $schedule_date, $start_time, $end_time, $max_patients, $status, $id])) {
        $success = "Schedule updated successfully!";
        

        $stmt = $pdo->prepare("SELECT s.*, d.doctor_name FROM schedules s JOIN doctors d ON s.doctor_id = d.doctor_id WHERE s.schedule_id = ?");
        $stmt->execute([$id]);
        $schedule = $stmt->fetch();
    } else {
        $error = "Error updating schedule!";
    }
}
?>

<h2>Edit Schedule</h2>
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
                                <option value="<?php echo $doctor['doctor_id']; ?>" <?php echo $schedule['doctor_id'] == $doctor['doctor_id'] ? 'selected' : ''; ?>>
                                    <?php echo $doctor['doctor_name']; ?> - <?php echo $doctor['specialization']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="schedule_date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="schedule_date" name="schedule_date" 
                               value="<?php echo $schedule['schedule_date']; ?>" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" class="form-control" id="start_time" name="start_time" 
                                   value="<?php echo $schedule['start_time']; ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" class="form-control" id="end_time" name="end_time" 
                                   value="<?php echo $schedule['end_time']; ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="max_patients" class="form-label">Maximum Patients</label>
                        <input type="number" class="form-control" id="max_patients" name="max_patients" 
                               value="<?php echo $schedule['max_patients']; ?>" min="1" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="available" <?php echo $schedule['status'] == 'available' ? 'selected' : ''; ?>>Available</option>
                            <option value="full" <?php echo $schedule['status'] == 'full' ? 'selected' : ''; ?>>Full</option>
                            <option value="cancelled" <?php echo $schedule['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Schedule</button>
                    <a href="schedules.php" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>