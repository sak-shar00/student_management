<?php
// db_connection.php

// Database connection details
$servername = "localhost";
$username = "root";   // Default XAMPP MySQL username
$password = "";       // Default XAMPP MySQL password (usually empty)
$dbname = "student_management";  // Name of your database
$port=3307;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname,$port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
