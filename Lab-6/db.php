<?php
$servername = "localhost";  // Localhost for XAMPP/MAMP
$username = "root";         // Default MySQL username
$password = "";             // Default password is empty for XAMPP
$dbname = "file_management"; // The name of the database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
