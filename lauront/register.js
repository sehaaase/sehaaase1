// Function to sanitize and check for unsafe characters
function sanitizeInput(input) {
    const element = document.createElement("div");
    if (input) {
        element.innerText = input;
        element.textContent = input;
    }
    return element.innerHTML;
}

// Function to validate input for malicious content
function validateInput(...inputs) {
    const unsafeChars = /<.*?>/g; // Detect HTML or script in input
    for (const input of inputs) {
        if (unsafeChars.test(input)) {
            alert("Invalid input detected! Please avoid using unsafe characters.");
            return false;
        }
    }
    return true;
}

// Function to validate name format
function validateName(name) {
    const namePattern = /^[A-Z][a-z]*$/;
    return namePattern.test(name);
}

// Function to validate email format
function isValidEmail(email) {
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return emailPattern.test(email);
}

// Function to get password strength
function getPasswordStrength(password) {
    const minLength = 8;
    const hasLetters = /[a-zA-Z]/.test(password);
    const hasNumbers = /\d/.test(password);
    const hasSpecialChars = /[!@#$%^&*]/.test(password);

    if (password.length < minLength) return "weak";
    if (hasLetters && hasNumbers) return hasSpecialChars ? "strong" : "medium";
    return "weak";
}

// Function to validate address fields
function validateAddressFields(purok, barangay, city, province, country, zipCode) {
    const alphaRegex = /^[a-zA-Z\s]+$/;
    const zipRegex = /^\d{4,6}$/;

    if (!purok || /[^a-zA-Z0-9\s]/.test(purok)) {
        return "Purok/Street must not be empty and should not include special characters.";
    }
    if (!alphaRegex.test(barangay)) {
        return "Barangay must contain only alphabetic characters.";
    }
    if (!alphaRegex.test(city)) {
        return "City must contain only alphabetic characters.";
    }
    if (!alphaRegex.test(province)) {
        return "Province must contain only alphabetic characters.";
    }
    if (!alphaRegex.test(country)) {
        return "Country must contain only alphabetic characters.";
    }
    if (!zipRegex.test(zipCode)) {
        return "ZIP Code must be numeric and 4-6 digits long.";
    }
    return null;
}

// Function to handle registration
function handleRegistration(
    firstName,
    lastName,
    middleName,
    email,
    password,
    confirmPassword,
    addressFields
) {
    const errors = [];

    // Prevent unsafe inputs
    if (
        !validateInput(
            firstName,
            lastName,
            middleName,
            email,
            password,
            confirmPassword,
            ...Object.values(addressFields)
        )
    ) {
        return;
    }

    // Validate first name
    if (!validateName(firstName)) {
        errors.push("First name must start with a capital letter and only contain alphabets.");
    }

    // Validate last name
    if (!validateName(lastName)) {
        errors.push("Last name must start with a capital letter and only contain alphabets.");
    }

    // Validate middle name (if provided)
    if (middleName && !validateName(middleName)) {
        errors.push("Middle name must start with a capital letter and only contain alphabets.");
    }

    // Validate email
    if (!isValidEmail(email)) {
        errors.push("Please enter a valid email address.");
    }

    // Validate password
    if (password !== confirmPassword) {
        errors.push("Passwords do not match.");
    }

    // Check password strength
    const passwordStrength = getPasswordStrength(password);
    if (passwordStrength === "weak") {
        errors.push("Password is too weak. Use at least 8 characters with letters, numbers, and special characters.");
    }

    // Validate address fields
    const addressValidationError = validateAddressFields(
        addressFields.purok,
        addressFields.barangay,
        addressFields.city,
        addressFields.province,
        addressFields.country,
        addressFields.zipCode
    );
    if (addressValidationError) {
        errors.push(addressValidationError);
    }

    // Show errors if any
    if (errors.length > 0) {
        alert(errors.join("\n"));
        return;
    }

    // Save user data
    localStorage.setItem("firstName", sanitizeInput(firstName));
    localStorage.setItem("lastName", sanitizeInput(lastName));
    localStorage.setItem("middleName", sanitizeInput(middleName));
    localStorage.setItem("email", sanitizeInput(email));
    localStorage.setItem("password", sanitizeInput(password));

    // Save address fields
    Object.entries(addressFields).forEach(([fieldName, value]) => {
        localStorage.setItem(fieldName, sanitizeInput(value));
    });

    alert("Registration successful! You can now log in.");
}

// Real-time password strength indicator
const passwordInput = document.getElementById("password");
const strengthIndicator = document.getElementById("password-strength");

if (passwordInput && strengthIndicator) {
    passwordInput.addEventListener("input", function () {
        const strength = getPasswordStrength(passwordInput.value);
        let strengthMessage = "";

        switch (strength) {
            case "weak":
                strengthMessage = "Weak (must be at least 8 characters long)";
                strengthIndicator.style.color = "red";
                break;
            case "medium":
                strengthMessage = "Medium (add special characters for a stronger password)";
                strengthIndicator.style.color = "orange";
                break;
            case "strong":
                strengthMessage = "Strong (great password!)";
                strengthIndicator.style.color = "green";
                break;
        }

        strengthIndicator.textContent = strengthMessage;
    });
}

// Event listener for registration
const registerForm = document.getElementById("formregister");
if (registerForm) {
    registerForm.addEventListener("submit", function (e) {
        e.preventDefault();

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
            zipCode: document.getElementById("zipCode").value,
        };

        handleRegistration(firstName, lastName, middleName, email, password, confirmPassword, addressFields);
    });
}
