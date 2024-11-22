<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $caregiver_id = $_POST['caregiver_id'];
    $appointment_time = $_POST['appointment_time'];

    $stmt = $conn->prepare("INSERT INTO appointments (patient_id, caregiver_id, appointment_time) VALUES (?, ?, ?)");
    $stmt->bind_param('iis', $patient_id, $caregiver_id, $appointment_time);
    $stmt->execute();
}

$patients = $conn->query("SELECT id, name FROM patients");
$caregivers = $conn->query("SELECT id, name FROM caregivers");
$appointments = $conn->query("
    SELECT a.*, p.name AS patient_name, c.name AS caregiver_name 
    FROM appointments a 
    JOIN patients p ON a.patient_id = p.id 
    JOIN caregivers c ON a.caregiver_id = c.id
");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Appointments - JKL Healthcare</title>
    <style>
        /* General Reset */
        body, html {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #333;
        }

        /* Header */
        header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        /* Container */
        .container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Appointment Form */
        form {
            background: white;
            padding: 20px 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-bottom: 30px;
        }

        form h2 {
            color: #007bff;
            margin-bottom: 20px;
            text-align: center;
        }

        select,
        input[type="datetime-local"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Appointments List Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Link */
        a {
            text-decoration: none;
            color: #007bff;
            display: inline-block;
            margin-top: 20px;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
<header>
    <h1>Appointment Management</h1>
</header>
<div class="container">
    <!-- Schedule Appointment Form -->
    <form method="post">
        <h2>Schedule Appointment</h2>
        <select name="patient_id" required>
            <option value="">Select Patient</option>
            <?php while ($row = $patients->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <select name="caregiver_id" required>
            <option value="">Select Caregiver</option>
            <?php while ($row = $caregivers->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <input type="datetime-local" name="appointment_time" required>
        <button type="submit">Schedule Appointment</button>
    </form>

    <!-- Appointments List -->
    <h3>Appointments List</h3>
    <table>
        <thead>
            <tr>
                <th>Patient</th>
                <th>Caregiver</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $appointments->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['patient_name']; ?></td>
                    <td><?php echo $row['caregiver_name']; ?></td>
                    <td><?php echo $row['appointment_time']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="dashboard.php">Back to Dashboard</a>
</div>
<footer>
    <p>JKL Healthcare Services &copy; <?php echo date("Y"); ?></p>
</footer>
</body>
</html>
