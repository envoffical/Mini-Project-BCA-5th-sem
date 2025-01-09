<?php
// Database configuration
$servername = "localhost"; // Change this to your MySQL server address
$username = "env"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$database = "result_management"; // Change this to your MySQL database name
//$database = "miniproject_db"; // Change this to your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed ");
}
?>
