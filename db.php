<?php
$servername = "localhost"; // or your database host
$username = "root";        // default for XAMPP
$password = "";            // default password for root in XAMPP
$dbname = "harley"; // the name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
