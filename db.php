<?php
$servername = "localhost"; // Change it to your server address (e.g., "127.0.0.1")
$username = "root";        // Your MySQL username
$password = "";            // Your MySQL password
$dbname = "user_db";       // The database you want to use

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
