<?php
session_start();
include 'db.php'; // Database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['user_email'])) {
        echo "You must be logged in to submit a review.";
        exit;
    }

    // Get form data
    $riderName = $_POST['rider_name'];
    $riderEmail = $_POST['rider_email'];
    $experience = $_POST['experience'];

    // Handle file upload
    $dest_path = ''; // Initialize path variable
    if (isset($_FILES['video_upload']) && $_FILES['video_upload']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['video_upload']['tmp_name'];
        $fileName = $_FILES['video_upload']['name'];
        $fileSize = $_FILES['video_upload']['size'];
        $fileType = $_FILES['video_upload']['type'];

        // Specify the directory where you want to save the file
        $uploadFileDir = './uploads/';
        $dest_path = $uploadFileDir . $fileName;

        // Move the file to the specified directory
        if (!move_uploaded_file($fileTmpPath, $dest_path)) {
            echo "Error uploading the file.";
            exit;
        }
    }

    // Insert data into the database
    $sql = "INSERT INTO reviews (rider_name, rider_email, experience, video_path) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $riderName, $riderEmail, $experience, $dest_path);

    if ($stmt->execute()) {
        echo "Review submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Review</title>
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
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #ffffff; /* Label color */
        }
        .form-group input,
        .form-group textarea {
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
    </style>
</head>
<body>

<div class="container">
    <h2>Submit Your Review</h2>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="rider_name">Your Name:</label>
            <input type="text" name="rider_name" required>
        </div>
        <div class="form-group">
            <label for="rider_email">Your Email:</label>
            <input type="email" name="rider_email" required>
        </div>
        <div class="form-group">
            <label for="experience">Experience:</label>
            <textarea name="experience" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="video_upload">Upload Video (optional):</label>
            <input type="file" name="video_upload">
        </div>
        <button type="submit">Submit Review</button>
    </form>
</div>

</body>
</html>
