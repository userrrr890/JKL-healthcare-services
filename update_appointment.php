<?php
session_start();
include 'db.php';

// Check if the logged-in user is a caregiver
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'caregiver') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_id = $_POST['appointment_id'];
    $new_appointment_time = $_POST['appointment_time'];

    // Update the appointment in the database
    $stmt = $conn->prepare("UPDATE appointments SET appointment_time = ? WHERE id = ?");
    $stmt->bind_param("si", $new_appointment_time, $appointment_id);
    
    if ($stmt->execute()) {
        header("Location: caregiver_appointments.php");
        exit();
    } else {
        $error_message = "Failed to update appointment.";
    }

    $stmt->close();
} else {
    // Fetch the appointment details to pre-fill the form
    $appointment_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT appointment_time FROM appointments WHERE id = ?");
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $appointment = $result->fetch_assoc();
    } else {
        header("Location: caregiver_appointments.php");
        exit();
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Appointment - JKL Healthcare</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        header, footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="datetime-local"] {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<header>
    <h1>Update Appointment - JKL Healthcare</h1>
</header>
<div class="container">
    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form action="" method="post">
        <input type="hidden" name="appointment_id" value="<?php echo $appointment_id; ?>">
        <label for="appointment_time">New Appointment Time:</label>
        <input type="datetime-local" id="appointment_time" name="appointment_time" value="<?php echo date('Y-m-d\TH:i', strtotime($appointment['appointment_time'])); ?>" required>
        <button type="submit">Update Appointment</button>
    </form>
</div>
<footer>
    <p>JKL Healthcare Services &copy; <?php echo date("Y"); ?></p>
</footer>
</body>
</html>
