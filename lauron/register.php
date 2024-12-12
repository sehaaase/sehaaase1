<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="rstyle.css">
    <script src="register.js" defer></script>
</head>
<body>

    <div class="register-form" id="registerFormContainer">
        <h2>Register</h2>
        <form id="formregister" method="POST" action="register_handler.php" onsubmit="return validateForm()">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" placeholder="Enter your first name" required>
            
            <label for="middleName">Middle Name/Initial (Optional):</label>
            <input type="text" id="middleName" name="middleName" placeholder="Enter your middle name">
    
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" placeholder="Enter your last name" required>
    
            <label for="gmail">Gmail:</label>
            <input type="text" id="gmail" name="gmail" placeholder="Enter your Gmail" required>
    
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <p id="password-strength"></p> 
    
            <label for="confirmPassword">Confirm Password:</label>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>

            <!-- Address fields -->
            <label for="address">Address:</label>
            <div class="address-container">
                <input type="text" id="purok" name="purok" placeholder="Purok/Street" required>
                <input type="text" id="barangay" name="barangay" placeholder="Barangay" required>
                <input type="text" id="city" name="city" placeholder="Municipal/City" required>
                <input type="text" id="province" name="province" placeholder="Province" required>
                <input type="text" id="country" name="country" placeholder="Country" required>
                <input type="text" id="zipCode" name="zipCode" placeholder="ZIP Code" required>
            </div>
    
            <button type="submit">Register</button>

        </form>
        <button class="back-button" onclick="redirectToLogin()">Back to Login</button>
        <p id="output"></p>
    </div>

<script>
    function redirectToLogin() {
        window.location.href = "index.php"; // Path to login page
    }

    // Call the validation function from JS
    function validateForm() {
        const firstName = document.getElementById("firstName").value;
        const lastName = document.getElementById("lastName").value;
        const middleName = document.getElementById("middleName").value || null;
        const email = document.getElementById("gmail").value;
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirmPassword").value;
        
        const addressFields = {
            purok: document.getElementById("purok").value,
            barangay: document.getElementById("barangay").value,
            city: document.getElementById("city").value,
            province: document.getElementById("province").value,
            country: document.getElementById("country").value,
            zipCode: document.getElementById("zipCode").value
        };

        return handleRegistration(firstName, lastName, middleName, email, password, confirmPassword, addressFields);
    }
</script>

</body>
</html>
