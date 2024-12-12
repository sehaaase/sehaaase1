<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="lstyle.css">
    <script src="login.js" defer></script>
</head>
<body>

<div class="login-form" id="loginFormContainer">
    <h2>Login</h2>
    <form id="formlogin" method="POST" action="login.php">
        <label for="username">Gmail:</label>
        <input type="text" id="username" name="username" placeholder="Enter your Gmail" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>

        <button type="submit">Login</button>
    </form>
    <button class="register-button" onclick="redirectToRegister()">Register</button>
    <p id="output"></p>
    <p id="lockout-message"></p> <!-- Lockout message element -->
</div>

<script>
    function redirectToRegister() {
        window.location.href = "register.php"; // Path to register page
    }
</script>

</body>
</html>
