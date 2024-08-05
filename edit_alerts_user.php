<?php
// Include database connection
include 'config.php';

// Initialize variables
$id = $title = $description = $location = "";
$title_err = $description_err = $location_err = "";

// Fetch alert details if ID is provided
if (isset($_GET['id']) && !empty(trim($_GET['id']))) {
    $id = trim($_GET['id']);
    
    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT title, description, location FROM alerts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($title, $description, $location);
    $stmt->fetch();
    $stmt->close();
}

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = trim($_POST["id"]);
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $location = trim($_POST["location"]);

    // Validate title
    if (empty($title)) {
        $title_err = "Please enter a title.";
    }

    // Validate description
    if (empty($description)) {
        $description_err = "Please enter a description.";
    }

    // Validate location
    if (empty($location)) {
        $location_err = "Please enter a location.";
    }

    // Check input errors before updating database
    if (empty($title_err) && empty($description_err) && empty($location_err)) {
        // Prepare an update statement
        $stmt = $conn->prepare("UPDATE alerts SET title = ?, description = ?, location = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $description, $location, $id);

        if ($stmt->execute()) {
            // Redirect to view alerts page after successful update
            header("Location: alerts.php");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }
        $stmt->close();
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Alert</title>
    <!-- Add your CSS link here -->
    <style>
        /* Basic styling for form */
        form {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
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
        }
        .button.back {
            background-color: #007bff;
        }
        .button.back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Edit Alert</h1>
    <a href="view_alerts.php" class="button back">Go Back to Alerts</a>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
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
            <input type="submit" value="Update Alert">
        </div>
    </form>
</body>
</html>
