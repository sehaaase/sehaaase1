<?php
session_start(); // Start session to track user

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
$username = $_POST['username'];
$password = $_POST['password'];

// Basic validation
if (empty($username) || empty($password)) {
    echo "Username and password cannot be empty!";
    exit();
}

// Prepare and execute the query to check the credentials
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username); // 's' means the parameter is a string
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $user['password'])) {
        // Password is correct, login successful
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['first_name'] = $user['firstName'];
        $_SESSION['last_name'] = $user['lastName'];
        
        // Redirect to dashboard or home page
        header("Location: dashboard.php"); // Redirect to a protected page
        exit();
    } else {
        echo "Invalid password!";
    }
} else {
    echo "User not found!";
}

$stmt->close();
$conn->close();
?>
