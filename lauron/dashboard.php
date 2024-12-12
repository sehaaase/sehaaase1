<?php
// Start session to check if user is logged in
session_start();

// Check if user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Get user details from session
$userFirstName = $_SESSION['first_name'];
$userLastName = $_SESSION['last_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dstyle.css"> <!-- Add your own styles here -->
</head>
<body>

<div class="dashboard-container">
    <h1>Welcome, <?php echo htmlspecialchars($userFirstName) . ' ' . htmlspecialchars($userLastName); ?>!</h1>

    <div class="gif-container">
        <h2>Enjoy this GIF:</h2>
        <img src="your-gif.gif" alt="Fun GIF" width="600"> <!-- Change "your-gif.gif" to the actual path of your gif -->
    </div>

    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
</div>

</body>
</html>
