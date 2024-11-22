<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $stmt = $conn->prepare("INSERT INTO caregivers (name, email, phone) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $name, $email, $phone);
        $stmt->execute();
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM caregivers WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }
}

$caregivers = $conn->query("SELECT * FROM caregivers");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Caregivers - JKL Healthcare</title>
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

        /* Add Caregiver Form */
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

        input[type="text"],
        input[type="email"] {
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

        /* Caregiver List Table */
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

        /* Action Button */
        button[type="submit"].delete {
            background-color: red;
            color: white;
            width: 100px;
            margin-top: 5px;
        }

        button[type="submit"].delete:hover {
            background-color: #c82333;
        }

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
    <h1>Caregiver Management</h1>
</header>
<div class="container">
    <!-- Add Caregiver Form -->
    <form method="post">
        <h2>Add Caregiver</h2>
        <input type="text" name="name" placeholder="Caregiver Name" required>
        <input type="email" name="email" placeholder="Caregiver Email" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
        <button type="submit" name="add">Add Caregiver</button>
    </form>

    <!-- Caregiver List -->
    <h3>Caregiver List</h3>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $caregivers->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td>
                        <!-- Delete Button -->
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete" class="delete">Delete</button>
                        </form>
                    </td>
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
