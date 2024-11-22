<?php
session_start();
include 'db.php';

// Check if the logged-in user is a caregiver
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'caregiver') {
    header("Location: login.php");
    exit();
}

// Fetch all appointments
$stmt = $conn->prepare("
    SELECT 
        a.id AS appointment_id,
        a.appointment_time, 
        p.name AS patient_name, 
        p.address AS patient_address, 
        p.medical_records, 
        c.name AS caregiver_name
    FROM 
        appointments a
    JOIN 
        patients p ON a.patient_id = p.id
    JOIN
        caregivers c ON a.caregiver_id = c.id
    ORDER BY 
        a.appointment_time ASC
");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caregiver Dashboard - JKL Healthcare</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        header h1 {
            margin: 0;
        }
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007bff;
            margin-bottom: 20px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #f7f7f7;
            color: #555;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .actions a {
            display: inline-block;
            padding: 8px 12px;
            margin: 5px 0;
            text-decoration: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .actions a:hover {
            background-color: #0056b3;
        }
        .logout-link {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            text-decoration: none;
            background-color: #dc3545;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .logout-link:hover {
            background-color: #b02a37;
        }
        footer {
            text-align: center;
            padding: 15px;
            background-color: #007bff;
            color: white;
            position: relative;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<header>
    <h1>Welcome, <?php echo $_SESSION['user']['username']; ?> - Caregiver Dashboard</h1>
</header>
<div class="container">
    <h2>Appointments</h2>

    <!-- Appointments List -->
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Appointment Time</th>
                    <th>Patient Name</th>
                    <th>Patient Address</th>
                    <th>Medical Records</th>
                    <th>Caregiver Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo date("Y-m-d H:i", strtotime($row['appointment_time'])); ?></td>
                        <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['patient_address']); ?></td>
                        <td><?php echo htmlspecialchars($row['medical_records']); ?></td>
                        <td><?php echo htmlspecialchars($row['caregiver_name']); ?></td>
                        <td class="actions">
                            <a href="update_appointment.php?id=<?php echo $row['appointment_id']; ?>">Edit</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No appointments available.</p>
    <?php endif; ?>

    <a href="logout.php" class="logout-link">Logout</a>
</div>
<footer>
    <p>JKL Healthcare Services &copy; <?php echo date("Y"); ?></p>
</footer>
</body>
</html>
