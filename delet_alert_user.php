<?php
// Include database connection
include 'config.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch the alert ID from the URL
$id = isset($_GET['delete']) ? intval($_GET['delete']) : 0;

// Check if the ID is valid
if ($id > 0) {
    // Prepare the delete statement
    if ($stmt = $conn->prepare("DELETE FROM alerts WHERE id = ?")) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Redirect to alerts.php after successful deletion
            header("Location: alerts.php");
            exit();
        } else {
            echo "Error executing the query: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing the SQL statement: " . $conn->error;
    }
} else {
    echo "No valid ID specified for deletion.";
    exit;
}

// Close the connection
$conn->close();
?>
