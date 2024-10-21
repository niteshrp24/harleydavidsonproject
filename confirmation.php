<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "harley"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the latest booking details
$sql = "SELECT * FROM test_ride_bookings ORDER BY id DESC LIMIT 1"; // Get the last inserted booking
$result = $conn->query($sql);

// Prepare variables for the booking details
$bookingDetails = "";
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Store booking details in a variable for display
    $bookingDetails = "
        <h2>Booking Confirmation</h2>
        <p>Thank you, <strong>" . htmlspecialchars($row['name']) . "</strong>!</p>
        <p>Your test ride for the <strong>" . htmlspecialchars($row['preferred_bike_model']) . "</strong> model has been booked on <strong>" . htmlspecialchars($row['booking_date']) . "</strong>.</p>
        <p><strong>Additional details:</strong></p>
        <p><strong>Message:</strong> " . htmlspecialchars($row['message']) . "</p>
        <p><strong>Booking Date:</strong> " . htmlspecialchars($row['booking_date']) . "</p>
        <p>We will contact you at <strong>" . htmlspecialchars($row['phone']) . "</strong> or <strong>" . htmlspecialchars($row['email']) . "</strong> for further details.</p>
    ";
} else {
    $bookingDetails = "<p>No booking found!</p>";
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark background */
            color: #e0e0e0; /* Light text color */
            padding: 50px;
            margin: 0;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #1e1e1e; /* Dark container background */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        h2 {
            text-align: center;
            color: #ffffff; /* White color for headings */
        }
        p {
            margin: 10px 0;
        }
        strong {
            color: #00bcd4; /* Highlight color for important text */
        }
    </style>
</head>
<body>

<div class="container">
    <?php echo $bookingDetails; // Display booking details ?>
</div>

</body>
</html>
