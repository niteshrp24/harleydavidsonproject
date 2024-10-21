<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "harley";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            echo "Login successful! Redirecting to the booking page...";
            header("Location: testride.html"); // Redirect to test ride form
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found with that email.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark background */
            color: #e0e0e0; /* Light text color */
            padding: 50px;
            margin: 0;
        }
        h2 {
            text-align: center;
            color: #ffffff; /* White color for headings */
        }
        form {
            max-width: 400px;
            margin: auto;
            background: #1e1e1e; /* Dark container background */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #444; /* Darker border */
            border-radius: 4px;
            background: #2c2c2c; /* Dark input background */
            color: #e0e0e0; /* Light text color */
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff; /* Button color */
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3; /* Darker button color on hover */
        }
        .message {
            text-align: center;
            color: red; /* Error message color */
        }
    </style>
</head>
<body>
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Login</button>
    </form>
    <div class="message">
        <?php
        // Display error messages
        if (isset($error)) {
            echo "<p>$error</p>";
        }
        ?>
    </div>
</body>
</html>
