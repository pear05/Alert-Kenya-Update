<?php
// Include database connection
include 'config.php';

// Handle delete request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM alerts WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: view_alerts.php"); // Redirect to avoid resubmission
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch alerts from database
$stmt = $conn->prepare("SELECT id, title, description, location, created_at FROM alerts ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Alerts</title>
    <!-- Add your CSS link here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            color: white;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }
        .button.dashboard {
            background-color: #007bff;
        }
        .button.add-alert {
            background-color: #28a745;
        }
        .button.edit {
            background-color: #ffc107;
        }
        .button.delete {
            background-color: #dc3545;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            max-width: 1200px;
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
            background-color: #f2f2f2;
        }
        td a {
            text-decoration: none;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
        }
        td a.edit {
            background-color: #ffc107;
        }
        td a.delete {
            background-color: #dc3545;
        }
        td a:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <h1>Alerts</h1>

    <!-- Buttons -->
    <div style="text-align: center;">
        <a href="adm_dash.php" class="button dashboard">Go Back to Dashboard</a>
        <a href="add_alert.php" class="button add-alert">Add Alert</a>
    </div>
    <br><br>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Location</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><?php echo htmlspecialchars($row['location']); ?></td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                <td>
                    <a href="edit_alerts.php?id=<?php echo $row['id']; ?>" class="button edit">Edit</a>
                    <a href="delete_alert.php?delete=<?php echo $row['id']; ?>" class="button delete" onclick="return confirm('Are you sure you want to delete this alert?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <?php
    // Close the connection
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
