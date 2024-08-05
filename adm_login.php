<?php
session_start();


// Database connection
$servername = "localhost"; // Change to your server name
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "Alert_Kenya"; // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$login = $_POST['login'];
$pass = $_POST['password'];

// Prepare and execute query
$sql = $conn->prepare("SELECT * FROM admins WHERE (username = ? OR email = ?) AND password = ?");
$sql->bind_param("sss", $login, $login, $pass);
$sql->execute();
$result = $sql->get_result();

// Check if a matching record was found
if ($result->num_rows > 0) {
    // Start session and store user information
    $_SESSION['logged in'] = true;
    $_SESSION['user'] = $result->fetch_assoc();
    header("Location: adm_dash.php"); // Redirect to dashboard or desired page
    exit();
} else {
    // If login fails, redirect back to login page with an error
    header("Location: login.php?error=invalid");
    exit();
}

// Close connection
$sql->close();
$conn->close();
?>
