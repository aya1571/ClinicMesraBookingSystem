<?php
require_once '../includes/config.php';

if (!isLoggedIn() || !isAdmin()) {
    redirect('login.php');
}


$start_date = date('Y-m-d', strtotime('next monday'));
$dates = [];


for($i = 0; $i < 6; $i++) {
    $dates[] = date('Y-m-d', strtotime($start_date . ' + ' . $i . ' days'));
}


$doctors = [
    1 => ['days' => [0,1,2,3,4,5]], 
    2 => ['days' => [1,2,3,4,5,6]], 
    3 => ['days' => [0,2,4]],       
    4 => ['days' => [1,3,5]]       
];

$time_slots = [
    ['08:00:00', '09:00:00'],
    ['09:00:00', '10:00:00'],
    ['10:00:00', '11:00:00'],
    ['11:00:00', '12:00:00'],
    ['12:00:00', '13:00:00'],
    ['14:00:00', '15:00:00'],
    ['15:00:00', '16:00:00'],
    ['16:00:00', '17:00:00'],
    ['17:00:00', '18:00:00']
];

$count = 0;

foreach($doctors as $doctor_id => $schedule) {
    foreach($dates as $index => $date) {
        if(in_array($index, $schedule['days'])) {
            foreach($time_slots as $slot) {
                if(($doctor_id == 3 || $doctor_id == 4) && $slot[0] >= '14:00:00') {
                    continue;
                }
                
                $sql = "INSERT INTO schedules (doctor_id, schedule_date, start_time, end_time, max_patients, status) 
                        VALUES (?, ?, ?, ?, 3, 'available')";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$doctor_id, $date, $slot[0], $slot[1]]);
                $count++;
            }
        }
    }
}

$_SESSION['success'] = "$count schedule slots generated for next week!";
redirect('schedules.php');
?>