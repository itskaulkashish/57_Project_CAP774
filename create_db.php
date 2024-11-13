<?php
// Connect to MySQL server
$conn = mysqli_connect("localhost", "root", "");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully<br>";
$sql = "CREATE DATABASE finance_manager";
if (!mysqli_query($conn, $sql)) {
    die("Error creating database: " . mysqli_error($conn));
}
echo "Database 'finance_manager' created successfully or already exists<br>";

// Select the database
mysqli_select_db($conn, "finance_manager");

// Users table
$sql1 = "CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
if (!mysqli_query($conn, $sql1)) {
    die("Error creating database: " . mysqli_error($conn));
}
echo "Table 'users' created successfully or already exists<br>";

//Income table
$sql2 = "CREATE TABLE incomes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    title VARCHAR(50) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    date DATE NOT NULL,
    type VARCHAR(50) NOT NULL,
    description VARCHAR(255)
)";
if (!mysqli_query($conn, $sql2)) {
    die("Error creating database: " . mysqli_error($conn));
}
echo "Table 'income' created successfully or already exists<br>";

//Expenses table
$sql3 = "CREATE TABLE expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    expense_name VARCHAR(100) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    category VARCHAR(50) NOT NULL,
    expense_date DATE NOT NULL,
    description VARCHAR(255)
)";
if (!mysqli_query($conn, $sql3)) {
    die("Error creating database: " . mysqli_error($conn));
}
echo "Table 'expenses' created successfully or already exists<br>";

?>