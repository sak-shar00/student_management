<?php
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default password (if you have one, change it here)
$dbname = "student_management"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
