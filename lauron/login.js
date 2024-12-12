// Lockout Mechanism Variables
let failedLoginAttempts = 0;
let lockoutTimer = 0;
let lockoutInterval;

// Function to disable browser back button
function disableBackButton() {
    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.pushState(null, null, location.href);
    };
}

// Function to start lockout timer
function startLockoutTimer(duration) {
    const loginButton = document.querySelector("#formlogin button[type='submit']");
    const registerButton = document.querySelector(".register-button");
    const lockoutMessage = document.getElementById("lockout-message");

    // Disable buttons
    loginButton.disabled = true;
    if (registerButton) registerButton.disabled = true;

    // Prevent back navigation
    disableBackButton();

    // Start timer
    lockoutTimer = duration;
    lockoutMessage.style.display = "block";
    lockoutMessage.textContent = `Too many failed login attempts. Please try again after ${lockoutTimer} seconds.`;

    lockoutInterval = setInterval(() => {
        lockoutTimer--;
        lockoutMessage.textContent = `Too many failed login attempts. Please try again after ${lockoutTimer} seconds.`;

        if (lockoutTimer <= 0) {
            clearInterval(lockoutInterval);

            // Re-enable buttons
            loginButton.disabled = false;
            if (registerButton) registerButton.disabled = false;

            lockoutMessage.style.display = "none";
        }
    }, 1000);
}

// Function to validate input for malicious content
function validateInput(...inputs) {
    const unsafeChars = /<.*?>/g; // Detect HTML or script tags in input
    for (const input of inputs) {
        if (unsafeChars.test(input)) {
            alert("Invalid input detected! Please avoid using unsafe characters.");
            return false;
        }
    }
    return true;
}

// Event listener for login
const loginForm = document.getElementById("formlogin");
if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
        e.preventDefault();

        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        // Prevent unsafe inputs
        if (!validateInput(username, password)) {
            return;
        }

        // Check lockout status
        if (lockoutTimer > 0) {
            alert(`Account is locked. Please try again after ${lockoutTimer} seconds.`);
            return;
        }

        // Send login data to PHP using fetch (AJAX)
        fetch("login.php", {
            method: "POST",
            body: new URLSearchParams({
                username: username,
                password: password
            })
        })
        .then(response => response.text())
        .then(data => {
            if (data.includes("Invalid password") || data.includes("User not found")) {
                failedLoginAttempts++;
                alert("Login failed: " + data);

                // Handle lockout timing
                if (failedLoginAttempts === 3) {
                    startLockoutTimer(15); // Lock for 15 seconds after 3 failed attempts
                } else if (failedLoginAttempts === 6) {
                    startLockoutTimer(30); // Lock for 30 seconds after 6 failed attempts
                } else if (failedLoginAttempts === 9) {
                    startLockoutTimer(60); // Lock for 60 seconds after 9 failed attempts
                }
            } else {
                alert("Login successful! Welcome.");
                window.location.href = "dashboard.php"; // Redirect to the dashboard
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("There was an issue with your login. Please try again.");
        });
    });
}

// Add lockout message element to DOM
const lockoutMessage = document.createElement("p");
lockoutMessage.id = "lockout-message";
lockoutMessage.style.display = "none";
lockoutMessage.style.color = "red";
lockoutMessage.style.textAlign = "center";
loginForm.insertAdjacentElement("beforebegin", lockoutMessage);
