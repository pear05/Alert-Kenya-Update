<?php
// Include database connection
include 'config.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Initialize variables
$title = $description = $location = "";
$title_err = $description_err = $location_err = "";

// Fetch user ID from session
session_start();
$user_id = $_SESSION['user_id'];

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate title
    if (empty(trim($_POST["title"]))) {
        $title_err = "Please enter a title.";
    } else {
        $title = trim($_POST["title"]);
    }

    // Validate description
    if (empty(trim($_POST["description"]))) {
        $description_err = "Please enter a description.";
    } else {
        $description = trim($_POST["description"]);
    }

    // Validate location
    if (empty(trim($_POST["location"]))) {
        $location_err = "Please enter a location.";
    } else {
        $location = trim($_POST["location"]);
    }

    // Check input errors before inserting into database
    if (empty($title_err) && empty($description_err) && empty($location_err)) {
        // Prepare an insert statement
        if ($stmt = $conn->prepare("INSERT INTO alerts (title, description, location, user_id) VALUES (?, ?, ?, ?)")) {
            $stmt->bind_param("sssi", $title, $description, $location, $user_id);

            if ($stmt->execute()) {
                // Redirect to view alerts page after successful insertion
                header("Location: add_alert.php");
                exit();
            } else {
                echo "Error executing the query: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing the SQL statement: " . $conn->error;
        }
    }

    // Close the connection
    $conn->close();
}

// Fetch user alerts from database
if ($stmt = $conn->prepare("SELECT id, title, description, location, created_at FROM alerts WHERE user_id = ? ORDER BY created_at DESC")) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $alerts_result = $stmt->get_result();
} else {
    echo "Error preparing the SQL statement: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Alert</title>
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
        .form-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-group .error {
            color: red;
            font-size: 0.875em;
        }
        .form-group input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            text-decoration: none;
            font-size: 16px;
        }
        .button.back {
            background-color: #007bff;
        }
        .button.back:hover {
            background-color: #0056b3;
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
        .button.edit {
            background-color: #ffc107;
        }
        .button.delete {
            background-color: #dc3545;
        }
        .button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <h1>Add New Alert</h1>
    <a href="alerts.php" class="button back">Go Back to Alerts</a>

    <div class="form-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>">
                <span class="error"><?php echo $title_err; ?></span>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($description); ?></textarea>
                <span class="error"><?php echo $description_err; ?></span>
            </div>
            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($location); ?>">
                <span class="error"><?php echo $location_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Add Alert">
            </div>
        </form>
    </div>

    <h2>Your Alerts</h2>
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
            <?php while ($row = $alerts_result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo htmlspecialchars($row['description']); ?></td>
                <td><?php echo htmlspecialchars($row['location']); ?></td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                <td>
                    <a href="edit_alerts_user.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="button edit">Edit</a>
                    <a href="delet_alert_user.php?delete=<?php echo htmlspecialchars($row['id']); ?>" class="button delete">Delete</a>
                    </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
