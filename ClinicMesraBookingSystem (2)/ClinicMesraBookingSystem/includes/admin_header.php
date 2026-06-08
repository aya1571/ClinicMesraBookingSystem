<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Clinic Mesra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.0;
            background-color: #f4f6f9;
        }
        .wrapper {
            display: flex;
            width: 100%;
        }
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #2c3e50;
            color: #fff;
            transition: all 0.3s;
        }
        .sidebar .sidebar-header {
            padding: 20px;
            background: #1a2632;
        }
        .sidebar ul li a {
            padding: 10px 20px;
            display: block;
            color: #fff;
            text-decoration: none;
        }
        .sidebar ul li a:hover {
            background: #3498db;
        }
        .sidebar ul li.active a {
            background: #3498db;
        }
        .content {
            width: 100%;
            padding: 20px;
        }
        .navbar-top {
            background: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="wrapper">
   
        <nav class="sidebar">
            <div class="sidebar-header">
                <h4>Clinic Mesra</h4>
                <p class="mb-0">Admin Panel</p>
            </div>
            <ul class="list-unstyled components">
                <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                    <a href="dashboard.php"><i class="fas fa-dashboard me-2"></i> Dashboard</a>
                </li>
                <li class="<?php echo in_array(basename($_SERVER['PHP_SELF']), ['patients.php', 'add_patient.php', 'edit_patient.php']) ? 'active' : ''; ?>">
                    <a href="patients.php"><i class="fas fa-users me-2"></i> Patients</a>
                </li>
                <li class="<?php echo in_array(basename($_SERVER['PHP_SELF']), ['doctors.php', 'add_doctor.php', 'edit_doctor.php']) ? 'active' : ''; ?>">
                    <a href="doctors.php"><i class="fas fa-user-md me-2"></i> Doctors</a>
                </li>
                <li class="<?php echo in_array(basename($_SERVER['PHP_SELF']), ['schedules.php', 'add_schedule.php', 'edit_schedule.php']) ? 'active' : ''; ?>">
                    <a href="schedules.php"><i class="fas fa-calendar me-2"></i> Schedules</a>
                </li>
                <li class="<?php echo basename($_SERVER['PHP_SELF']) == 'appointments.php' ? 'active' : ''; ?>">
                    <a href="appointments.php"><i class="fas fa-clock me-2"></i> Appointments</a>
                </li>
                <li>
                    <a href="logout.php"><i class="fas fa-sign-out me-2"></i> Logout</a>
                </li>
            </ul>
        </nav>

 
        <div class="content">
            <div class="navbar-top">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Welcome, <?php echo $_SESSION['full_name']; ?></h5>
                    <a href="../index.php" class="btn btn-sm btn-outline-primary" target="_blank">View Website</a>
                </div>
            </div>