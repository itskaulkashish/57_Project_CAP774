<?php
// Database connection credentials
$host = 'localhost';  // Typically 'localhost' if the database is on the same server
$db   = 'finance_manager';  // Name of your database
$user = 'root';  // Your MySQL username (adjust accordingly)
$pass = '';  // Your MySQL password (leave empty if no password)

// Create connection
$conn = mysqli_connect($host, $user, $pass, $db);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
