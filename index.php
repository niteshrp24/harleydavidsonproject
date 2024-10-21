<?php
session_start();
include 'db.php'; // Include your database connection file

// Capture the action (book or review) and store it in session
if (isset($_GET['action'])) {
    $_SESSION['action'] = $_GET['action'];
}

// Handle registration
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $password);
    
    if ($stmt->execute()) {
        $register_success = "Registration successful! Please log in.";
    } else {
        $register_error = "Registration failed: " . $stmt->error;
    }

    $stmt->close();
}

// Handle login
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_email'] = $user['email'];

            // Redirect based on the previous action
            if (isset($_SESSION['action'])) {
                if ($_SESSION['action'] === 'book') {
                    header("Location: testride.html"); // Redirect to test ride page
                } elseif ($_SESSION['action'] === 'review') {
                    header("Location: review.html"); // Redirect to review page
                }
                unset($_SESSION['action']); // Clear the action after redirection
            } else {
                header("Location: index.html"); // Default redirect
            }
            exit();
        } else {
            $login_error = "Invalid password.";
        }
    } else {
        $login_error = "No account found with that email.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark background */
            color: #e0e0e0; /* Light text color */
            padding: 50px;
            margin: 0;
        }
        .container {
            max-width: 400px;
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
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #ffffff; /* Label color */
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #444; /* Dark border */
            border-radius: 4px;
            background-color: #2c2c2c; /* Dark input background */
            color: #ffffff; /* Light input text */
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        a {
            color: #1e90ff; /* Link color */
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Welcome!</h2>

    <div id="messages">
        <?php
        if (isset($register_success)) {
            echo "<p style='color: green;'>$register_success</p>";
        }
        if (isset($register_error)) {
            echo "<p style='color: red;'>$register_error</p>";
        }
        if (isset($login_error)) {
            echo "<p style='color: red;'>$login_error</p>";
        }
        ?>
    </div>

    <div id="form-container">
        <div id="register-form" style="display: none;">
            <h2>Register</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" name="register">Register</button>
                <p>Already have an account? <a href="#" id="show-login">Login here</a></p>
            </form>
        </div>

        <div id="login-form">
            <h2>Login</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" name="login">Login</button>
                <p>Don't have an account? <a href="#" id="show-register">Register here</a></p>
            </form>
        </div>
    </div>
</div>

<script>
    // Toggle between login and register forms
    document.getElementById('show-register').onclick = function() {
        document.getElementById('login-form').style.display = 'none';
        document.getElementById('register-form').style.display = 'block';
    };

    document.getElementById('show-login').onclick = function() {
        document.getElementById('register-form').style.display = 'none';
        document.getElementById('login-form').style.display = 'block';
    };
</script>

</body>
</html>
