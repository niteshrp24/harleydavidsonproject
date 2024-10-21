<?php
session_start();

// Set a logout message before destroying the session
$_SESSION['logout_message'] = "You have successfully logged out.";

// Destroy the session
session_destroy();

// Redirect to login.php after a short delay to show the message
header("Refresh: 2; URL=index.html"); // Redirect after 2 seconds
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark background */
            color: #e0e0e0; /* Light text color */
            text-align: center;
            padding: 50px;
            margin: 0;
        }
        h2 {
            color: #ffffff; /* White color for headings */
        }
        p {
            margin: 20px 0;
        }
        .message {
            background: #1e1e1e; /* Dark container for the message */
            padding: 20px;
            border-radius: 5px;
            display: inline-block;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        a {
            color: #007bff; /* Link color */
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline; /* Underline on hover */
        }
    </style>
</head>
<body>
    <h2>Logout</h2>
    <div class="message">
        <p><?php echo $_SESSION['logout_message']; ?></p>
        <p>You will be redirected to the home page shortly.</p>
    </div>
</body>
</html>
