<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "harley";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch all reviews
$sql = "SELECT rider_name, experience, video_path FROM reviews"; // Use the correct column names
$result = $conn->query($sql);

// Prepare an array to hold the reviews
$reviews = [];

if ($result->num_rows > 0) {
    // Fetch each review
    while ($row = $result->fetch_assoc()) {
        $reviews[] = [
            'rider_name' => htmlspecialchars($row['rider_name']),
            'experience' => nl2br(htmlspecialchars($row['experience'])),
            'video_path' => htmlspecialchars($row['video_path']),
        ];
    }
} else {
    $reviews = []; // No reviews available
}

// Close connection
$conn->close();

// Convert reviews array to JSON format for use in the HTML page
header('Content-Type: application/json'); // Set header for JSON response
echo json_encode($reviews);
?>
