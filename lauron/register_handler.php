<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "lauron";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data from POST request
$firstName = $_POST['firstName'];
$middleName = isset($_POST['middleName']) ? $_POST['middleName'] : null;
$lastName = $_POST['lastName'];
$email = $_POST['gmail'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];
$purok = $_POST['purok'];
$barangay = $_POST['barangay'];
$city = $_POST['city'];
$province = $_POST['province'];
$country = $_POST['country'];
$zipCode = $_POST['zipCode'];

// Basic validation
if ($password !== $confirmPassword) {
    echo "Passwords do not match!";
    exit();
}

// Password hashing for security
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert into database
$query = "INSERT INTO users (firstName, middleName, lastName, email, password, purok, barangay, city, province, country, zipCode) 
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($query);
$stmt->bind_param("sssssssssss", $firstName, $middleName, $lastName, $email, $hashedPassword, $purok, $barangay, $city, $province, $country, $zipCode);

if ($stmt->execute()) {
    // Redirect to the login page if registration is successful
    header("Location: index.php"); // Redirect to login page
    exit;
} else {
    // Display error message with styling if something goes wrong
    $errorMessage = "Error: " . $stmt->error;
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Registration Error</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f1f1f1;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }
            .error-container {
                background-color: #ff6b6b;
                color: white;
                padding: 40px;
                border-radius: 12px;
                text-align: center;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 600px;
            }
            .error-container h1 {
                font-size: 32px;
                margin-bottom: 15px;
            }
            .error-container p {
                font-size: 18px;
                margin: 10px 0;
                line-height: 1.5;
            }
            .error-container a {
                color: white;
                text-decoration: none;
                background-color: #007bff;
                padding: 14px 24px;
                border-radius: 6px;
                font-weight: bold;
                display: inline-block;
                margin-top: 20px;
                transition: background-color 0.3s, transform 0.3s;
            }
            .error-container a:hover {
                background-color: #0056b3;
                transform: scale(1.05);
            }
            .error-container a:focus {
                outline: none;
                background-color: #004085;
            }
            .error-container .retry-message {
                margin-top: 20px;
                font-size: 16px;
                color: #f1f1f1;
            }
        </style>
    </head>
    <body>
        <div class='error-container'>
            <h1>Registration Failed</h1>
            <p>{$errorMessage}</p>
            <a href='register.php'>Go Back and Try Again</a>
            <p class='retry-message'>Please ensure your data is correct and try again.</p>
        </div>
    </body>
    </html>";
}

$stmt->close();
$conn->close();
?>
