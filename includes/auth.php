<?php
// Start session
session_start();

// Check if the user is logged in by checking if a session variable exists
if (!isset($_SESSION['user_id'])) {
    // If the session doesn't exist, redirect the user to the signin page
    header("Location: ../pages/signin.php");
    exit(); // Stop further execution to ensure the page is not loaded
}
?>
