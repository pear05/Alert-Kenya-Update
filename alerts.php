<?php
// Include database connection
include 'config.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch user ID from session
session_start();
$user_id = $_SESSION['user_id'];

// Handle delete request
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // Prepare statement to check if the alert belongs to the current user
    $stmt = $conn->prepare("SELECT user_id FROM alerts WHERE id = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($alert_user_id);
    $stmt->fetch();
    $stmt->close();
    
    if ($alert_user_id == $user_id) {
        // Prepare statement to delete the alert
        $stmt = $conn->prepare("DELETE FROM alerts WHERE id = ?");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: view_alerts.php"); // Redirect to avoid resubmission
            exit;
        } else {
            die("Execute failed: " . $stmt->error);
        }
        $stmt->close();
    } else {
        echo "You are not authorized to delete this alert.";
    }
}

// Fetch alerts from database for the current user
$stmt = $conn->prepare("SELECT id, title, description, location, created_at FROM alerts WHERE user_id = ? ORDER BY created_at DESC");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Alerts</title>
    <link rel="stylesheet" href="alerts.css">
    <style>
        /* Your CSS styles here */
    </style>
</head>
<body>
    <h1>Alerts</h1>
    

    <!-- Buttons -->
    <div style="text-align: center;">
        <a href="user_dash.php" class="button dashboard">Go Back to Dashboard</a>
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
                    <a href="edit_alert.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="button edit">Edit</a>
                    <a href="?delet_alert_user.php=<?php echo htmlspecialchars($row['id']); ?>" class="button delete">Delete</a>

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
