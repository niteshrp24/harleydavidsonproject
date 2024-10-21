<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Database connection
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

// Get form data
$name = $_SESSION['user_name']; // Get the name from the session
$email = $_SESSION['user_email']; // Get the email from the session
$phone = $_POST['phone'];
$model = $_POST['preferred_bike_model'];
$date = $_POST['booking_date'];
$time = $_POST['booking_time'];
$license = $_POST['license'];
$licenseNumber = ($license === 'yes') ? (isset($_POST['licenseNumber']) ? $_POST['licenseNumber'] : 'N/A') : 'N/A';
$city = $_POST['city'];
$message = $_POST['message'];

// Insert data into database
$sql = "INSERT INTO test_ride_bookings (name, email, phone, preferred_bike_model, booking_date, booking_time, license_number, city, message) 
        VALUES ('$name', '$email', '$phone', '$model', '$date', '$time', '$licenseNumber', '$city', '$message')";

if ($conn->query($sql) === TRUE) {
    // Acknowledgment message
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Booking Confirmation</title>
        <style>
            body {
                background-color: #121212; /* Dark background */
                color: #e0e0e0; /* Light text color */
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 20px;
            }
            .container {
                max-width: 600px;
                margin: auto;
                background: #1e1e1e; /* Darker container */
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            }
            h2 {
                color: #ffd600; /* Accent color for headings */
                text-align: center;
            }
            p {
                margin: 10px 0;
                text-align: center; /* Center align text */
            }
            strong {
                color: #ffd600; /* Accent color for strong text */
            }
            a {
                display: inline-block;
                margin-top: 20px;
                padding: 10px 20px;
                background-color: #007bff; /* Button color */
                color: #ffffff; /* Button text color */
                text-decoration: none;
                border-radius: 4px;
                text-align: center;
            }
            a:hover {
                background-color: #0056b3; /* Darker button on hover */
            }
        </style>
    </head>
    <body>
    <div class='container'>";

    echo "<h2>Booking Confirmation</h2>";
    echo "<p>Thank you, <strong>" . htmlspecialchars($name) . "</strong>!</p>";
    echo "<p>Your test ride for the <strong>" . htmlspecialchars($model) . "</strong> model has been booked on <strong>" . htmlspecialchars($date) . "</strong> at <strong>" . htmlspecialchars($time) . "</strong> in <strong>" . htmlspecialchars($city) . "</strong>.</p>";
    echo "<p>We will contact you at <strong>" . htmlspecialchars($phone) . "</strong> or <strong>" . htmlspecialchars($email) . "</strong> for further details.</p>";
    echo "<a href='index.html'>Return to Homepage</a>"; // Button to return to homepage

    echo "</div></body></html>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
