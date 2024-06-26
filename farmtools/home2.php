<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <style>
         body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            /* background-image: url('background.jpg'); Replace with your image file name or URL */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            overflow: hidden; /* To ensure falling papers don't cause scrollbars */
        }
        .message-box {
            background-color: rgba(255, 255, 255, 0.9); /* Semi-transparent background */
            padding: 20px 40px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            margin: auto;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .message-box:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        .success-message {
            color: #28a745;
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        .error-message {
            color: #dc3545;
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        .message-icon {
            font-size: 50px;
            margin-bottom: 10px;
        }
        .success-icon {
            color: #28a745;
        }
        .error-icon {
            color: #dc3545;
        }
        .paper {
            position: fixed;
            width: 20px;
            height: 20px;
            background: #fff;
            border-radius: 50%;
            opacity: 0;
            animation: fall 3s infinite;
        }
        @keyframes fall {
            0% {
                transform: translateY(-100vh) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(360deg);
                opacity: 0;
            }
        }
    </style>
</head>
<body>

<?php
// Check if the form is submitted and the POST variables are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && 
    isset($_POST['firstName']) && 
    isset($_POST['lastName']) && 
    isset($_POST['email']) && 
    isset($_POST['password']) && 
    isset($_POST['mobile']) && 
    isset($_POST['gender'])) {

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mobile = $_POST['mobile'];
    $gender = $_POST['gender'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'register', '3307');
    
    // Check connection
    if ($conn->connect_error) {
        echo '<div class="message-box"><p class="message-icon error-icon">❌</p><p class="error-message">Connection Failed: ' . $conn->connect_error . '</p></div>';
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO registration (firstName, lastName, email, password, mobile, gender) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $firstName, $lastName, $email, $password, $mobile, $gender);

        // Execute the statement
        if ($stmt->execute()) {
            echo '<div class="message-box"><p class="message-icon success-icon">✅</p><p class="success-message">Registration Successful!</p></div>';
        } else {
            echo '<div class="message-box"><p class="message-icon error-icon">❌</p><p class="error-message">Error: ' . $stmt->error . '</p></div>';
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
} else {
    echo '<div class="message-box"><p class="message-icon error-icon">❌</p><p class="error-message">Form data is missing.</p></div>';
}
?>

</body>
</html>
