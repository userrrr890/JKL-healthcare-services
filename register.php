<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $username, $password, $role);

    if ($stmt->execute()) {
        $message = "User registered successfully!";
        $message_color = "green";
    } else {
        $message = "Error: " . $stmt->error;
        $message_color = "red";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - JKL Healthcare</title>
    <style>
        /* General Reset */
        body, html {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            background: url('backgroundd.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }

        /* Header */
        header {
            text-align: center;
            background-color: rgba(40, 167, 69, 0.7); /* Slight transparency */
            color: white;
            padding: 20px 0;
        }

        header h1 {
            margin: 0;
            font-size: 24px;
        }

        /* Container */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }

        /* Form Styling */
        form {
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
            padding: 30px 40px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
        }

        form h2 {
            margin-bottom: 20px;
            color: #28a745;
            text-align: center;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px 0;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }

        a {
            display: block;
            text-align: center;
            color: #28a745;
            text-decoration: none;
            margin-top: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Message Styling */
        .message {
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .message.green {
            color: green;
        }

        .message.red {
            color: red;
        }
    </style>
</head>
<body>
<header>
    <h1>Register - JKL Healthcare</h1>
</header>
<div class="container">
    <form method="post">
        <h2>User Registration</h2>
        <?php if (isset($message)): ?>
            <p class="message <?php echo $message_color; ?>"><?php echo $message; ?></p>
        <?php endif; ?>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
            <option value="">Select Role</option>
            <option value="admin">Admin</option>
            <option value="caregiver">Caregiver</option>
        </select>
        <button type="submit">Register</button>
        <a href="login.php">Already registered? Login</a>
    </form>
</div>
</body>
</html>
