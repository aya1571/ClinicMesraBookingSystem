<?php
require_once 'includes/config.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$selected_doctor = isset($_GET['doctor_id']) ? $_GET['doctor_id'] : '';

$sql = "SELECT * FROM doctors WHERE status = 'active' ORDER BY doctor_name";
$stmt = $pdo->query($sql);
$doctors = $stmt->fetchAll();


$available_dates = [];
$time_slots = [];
$selected_date = '';
$doctor_id = '';
$show_date_step = false;
$show_time_step = false;


if (isset($_POST['check_schedule']) || isset($_POST['doctor_id'])) {
    $doctor_id = $_POST['doctor_id'];
    $selected_doctor = $doctor_id;
    $show_date_step = true;
    
 
    $sql = "SELECT s.*, d.doctor_name, 
            (SELECT COUNT(*) FROM appointments a WHERE a.schedule_id = s.schedule_id AND a.status != 'cancelled') as booked_count
            FROM schedules s 
            JOIN doctors d ON s.doctor_id = d.doctor_id 
            WHERE s.doctor_id = ? AND s.schedule_date >= CURDATE() AND s.status = 'available'
            ORDER BY s.schedule_date, s.start_time";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$doctor_id]);
    $all_schedules = $stmt->fetchAll();
    

    $dates_array = [];
    foreach($all_schedules as $schedule) {
        $available_slots = $schedule['max_patients'] - $schedule['booked_count'];
        if ($available_slots > 0) {
            $dates_array[$schedule['schedule_date']] = true;
        }
    }
    

    $available_dates = array_keys($dates_array);
    sort($available_dates);
}


if (isset($_POST['show_times']) || isset($_POST['selected_date'])) {
    $doctor_id = $_POST['doctor_id'];
    $selected_date = $_POST['selected_date'];
    $selected_doctor = $doctor_id;
    $show_time_step = true;
    
    $sql = "SELECT s.*, d.doctor_name,
            (SELECT COUNT(*) FROM appointments a WHERE a.schedule_id = s.schedule_id AND a.status != 'cancelled') as booked_count
            FROM schedules s 
            JOIN doctors d ON s.doctor_id = d.doctor_id 
            WHERE s.doctor_id = ? AND s.schedule_date = ? AND s.status = 'available'
            ORDER BY s.start_time";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$doctor_id, $selected_date]);
    $all_time_slots = $stmt->fetchAll();
    

    $time_slots = [];
    foreach($all_time_slots as $slot) {
        $available_slots = $slot['max_patients'] - $slot['booked_count'];
        if ($available_slots > 0) {
            $slot['available_slots'] = $available_slots;
            $time_slots[] = $slot;
        }
    }
}


if (isset($_POST['book_appointment'])) {

    if (!isset($_POST['confirm_terms'])) {
        $error = "You must confirm the Terms & Conditions to proceed with booking!";
    } else {
        $doctor_id = $_POST['doctor_id'];
        $schedule_id = $_POST['schedule_id'];
        $appointment_date = $_POST['appointment_date'];
        $appointment_time = $_POST['appointment_time'];
        $remarks = $_POST['remarks'];
        $user_id = $_SESSION['user_id'];
        
     
        $sql = "SELECT s.*, 
                (SELECT COUNT(*) FROM appointments a WHERE a.schedule_id = s.schedule_id AND a.status != 'cancelled') as booked_count
                FROM schedules s WHERE s.schedule_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$schedule_id]);
        $schedule = $stmt->fetch();
        
        if ($schedule && $schedule['booked_count'] < $schedule['max_patients']) {
        
            $sql = "SELECT * FROM appointments WHERE user_id = ? AND appointment_date = ? AND appointment_time = ? AND status != 'cancelled'";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id, $appointment_date, $appointment_time]);
            
            if ($stmt->rowCount() == 0) {
           
                $sql = "INSERT INTO appointments (user_id, doctor_id, schedule_id, appointment_date, appointment_time, remarks) 
                        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                
                try {
                    $stmt->execute([$user_id, $doctor_id, $schedule_id, $appointment_date, $appointment_time, $remarks]);
                    
            
                    $new_booked_count = $schedule['booked_count'] + 1;
                    if ($new_booked_count >= $schedule['max_patients']) {
                        $update_sql = "UPDATE schedules SET status = 'full' WHERE schedule_id = ?";
                        $update_stmt = $pdo->prepare($update_sql);
                        $update_stmt->execute([$schedule_id]);
                    }
                    
                    $_SESSION['success'] = "Appointment booked successfully!";
                    redirect('my_appointments.php');
                } catch(PDOException $e) {
                    $error = "Error booking appointment: " . $e->getMessage();
                }
            } else {
                $error = "You already have an appointment at this time!";
            }
        } else {
            $error = "Sorry, this time slot is already full. Please select another time.";
        }
    }
}

include 'includes/header.php';
?>

<div class="row">
    <div class="col-md-12">
        <h2>Book Appointment</h2>
        <p class="lead">Follow the steps below to book your appointment</p>
        <hr>
    </div>
</div>

<?php if(isset($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> <?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if(isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">

    <div class="col-md-4">
        <div class="card mb-4 <?php echo $selected_doctor ? 'border-success' : 'border-primary'; ?>">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <span class="badge bg-light text-primary me-2">1</span>
                    Select Doctor
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="" id="doctorForm">
                    <div class="mb-3">
                        <label for="doctor_id" class="form-label">Choose Doctor</label>
                        <select class="form-select" id="doctor_id" name="doctor_id" required>
                            <option value="">-- Select Doctor --</option>
                            <?php foreach($doctors as $doctor): ?>
                                <option value="<?php echo $doctor['doctor_id']; ?>" 
                                    <?php echo $selected_doctor == $doctor['doctor_id'] ? 'selected' : ''; ?>>
                                    <?php echo $doctor['doctor_name']; ?> - <?php echo $doctor['specialization']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="check_schedule" class="btn btn-primary w-100">
                        <i class="fas fa-calendar-alt me-2"></i> Check Available Dates
                    </button>
                </form>
            </div>
        </div>
    </div>
    

    <div class="col-md-4">
        <?php if($show_date_step): ?>
            <?php if(!empty($available_dates)): ?>
                <div class="card mb-4 border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <span class="badge bg-light text-success me-2">2</span>
                            Select Date
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" id="dateForm">
                            <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
                            
                            <div class="mb-3">
                                <label class="form-label">Available Dates</label>
                                <select class="form-select" name="selected_date" id="selected_date" required>
                                    <option value="">-- Select Date --</option>
                                    <?php foreach($available_dates as $date): ?>
                                        <option value="<?php echo $date; ?>" 
                                            <?php echo ($selected_date == $date) ? 'selected' : ''; ?>>
                                            <?php echo date('d/m/Y', strtotime($date)); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <button type="submit" name="show_times" class="btn btn-success w-100">
                                <i class="fas fa-clock me-2"></i> Show Available Times
                            </button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <span class="badge bg-light text-secondary me-2">2</span>
                            Select Date
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            No available dates for this doctor. Please try another doctor.
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <span class="badge bg-light text-secondary me-2">2</span>
                        Select Date
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-light mb-0 text-center">
                        <i class="fas fa-arrow-left me-2"></i> Select a doctor first
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
 
    <div class="col-md-4">
        <?php if($show_time_step): ?>
            <?php if(!empty($time_slots)): ?>
                <div class="card mb-4 border-info">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <span class="badge bg-light text-info me-2">3</span>
                            Select Time
                        </h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">
                            <input type="hidden" name="selected_date" value="<?php echo $selected_date; ?>">
                            <input type="hidden" name="appointment_date" value="<?php echo $selected_date; ?>">
                            <input type="hidden" name="appointment_time" id="appointment_time">
                            
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="fas fa-calendar-day me-1"></i>
                                    <?php echo date('d/m/Y', strtotime($selected_date)); ?>
                                </label>
                                <div class="list-group">
                                    <?php foreach($time_slots as $slot): 
                                        $available_slots = $slot['available_slots'];
                                        $time_display = date('h:i A', strtotime($slot['start_time'])) . ' - ' . 
                                                       date('h:i A', strtotime($slot['end_time']));
                                    ?>
                                    <label class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <input class="form-check-input me-2" type="radio" name="schedule_id" 
                                                   value="<?php echo $slot['schedule_id']; ?>" 
                                                   data-time="<?php echo $slot['start_time']; ?>"
                                                   required>
                                            <?php echo $time_display; ?>
                                        </div>
                                        <span class="badge bg-<?php echo $available_slots > 1 ? 'success' : 'warning'; ?> rounded-pill">
                                            <?php echo $available_slots; ?> / <?php echo $slot['max_patients']; ?> left
                                        </span>
                                    </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="remarks" class="form-label">Remarks (Optional)</label>
                                <textarea class="form-control" id="remarks" name="remarks" rows="2" 
                                          placeholder="e.g., First visit, Follow-up, etc."></textarea>
                            </div>
                            
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="confirm_terms" name="confirm_terms" required>
                                <label class="form-check-label" for="confirm_terms">
                                    I confirm that I have read and agree to the clinic's 
                                    <a href="javascript:void(0)" onclick="openTerms('terms.php')">Terms & Conditions</a> and 
                                    <a href="javascript:void(0)" onclick="openTerms('privacy.php')">Privacy Policy</a>
                                </label>
                            </div>
                            
                            <button type="submit" name="book_appointment" class="btn btn-info text-white w-100">
                                <i class="fas fa-check-circle me-2"></i> Confirm Booking
                            </button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="card mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">
                            <span class="badge bg-light text-secondary me-2">3</span>
                            Select Time
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            No available time slots for this date. Please select another date.
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">
                        <span class="badge bg-light text-secondary me-2">3</span>
                        Select Time
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-light mb-0 text-center">
                        <i class="fas fa-arrow-left me-2"></i> Select a date first
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-12">
        <div class="card bg-light">
            <div class="card-body">
                <h6><i class="fas fa-info-circle me-2 text-primary"></i> How it works:</h6>
                <ol class="mb-0">
                    <li>Select your preferred doctor</li>
                    <li>Choose an available date</li>
                    <li>Pick a time slot that suits you</li>
                    <li>Read and agree to Terms & Conditions (opens in popup)</li>
                    <li>Add any remarks if needed</li>
                    <li>Confirm your booking</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<script>
function openTerms(url) {
    window.open(url, 'TermsWindow', 'width=800,height=600,scrollbars=yes,resizable=yes');
}

document.getElementById('doctor_id')?.addEventListener('change', function() {
    if(this.value) {
        document.getElementById('doctorForm').submit();
    }
});


document.getElementById('selected_date')?.addEventListener('change', function() {
    if(this.value) {
        document.getElementById('dateForm').submit();
    }
});

document.querySelectorAll('input[name="schedule_id"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('appointment_time').value = this.dataset.time;
    });
});
</script>

<?php include 'includes/footer.php'; ?>