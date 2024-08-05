<?php
$servername = "localhost"; // or your database server IP
$username = "root"; // your MySQL username
$password = ""; // your MySQL password
$dbname = "Alert_Kenya";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
// Enable error reporting for debugging
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>

