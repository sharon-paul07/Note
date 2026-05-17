<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$dbname = "user_db"; // Replace with your database name

// Create database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
