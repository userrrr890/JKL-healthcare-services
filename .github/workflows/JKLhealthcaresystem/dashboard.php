<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - JKL Healthcare</title>
    <style>
        /* General Reset */
        body, html {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            background: url('dashboard.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }

        /* Header */
        header {
            background-color: rgba(0, 123, 255, 0.7);
            color: white;
            padding: 15px 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        header h1 span {
            font-size: 30px; /* Larger font size for system name */
            font-weight: bold; /* Bold text */
            display: block;
        }

        /* Container Layout */
        .dashboard-container {
            display: flex;
            height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: rgba(52, 58, 64, 0.8); /* Slightly transparent background */
            color: white;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar h2 {
            color: #ffc107;
            margin-top: 0;
            text-align: center;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: white;
            font-size: 16px;
            display: block;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: #ffc107;
            color: #343a40;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .main-content h2 {
            color: #007bff;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 10px 20px;
            background: rgba(0, 123, 255, 0.7);
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
<header>
    <h1>
        <span>JKL Healthcare Services</span>
        Welcome, <?php echo $_SESSION['user']['username']; ?>!
    </h1>
</header>
<div class="dashboard-container">
    <div class="sidebar">
        <h2>Navigation</h2>
        <ul>
            <li><a href="patients.php">Manage Patients</a></li>
            <li><a href="caregivers.php">Manage Caregivers</a></li>
            <li><a href="appointments.php">Manage Appointments</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h2>Dashboard</h2>
        <p>Welcome to the JKL Healthcare Services Dashboard. Use the navigation menu to manage different sections.</p>
    </div>
</div>
<footer>
    <p>JKL Healthcare Services &copy; <?php echo date("Y"); ?></p>
</footer>
</body>
</html>
