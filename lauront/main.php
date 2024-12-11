<?php
include "conn.php";

$firstName = trim($_POST['firstName']);
$lastName = trim($_POST['lastName']);
$middleName = trim($_POST['middleName']) ?: NULL;
$gmail = trim($_POST['gmail']);
$password = trim($_POST['password']);
$confirmPassword = trim($_POST['confirmPassword']);

$purok = trim($_POST['purok']);
$barangay = trim($_POST['barangay']);
$city = trim($_POST['city']);
$province = trim($_POST['province']);
$country = trim($_POST['country']);
$zipCode = trim($_POST['zipCode']);

if ($password !== $confirmPassword) {
    die("Passwords do not match. Please go back and try again.");
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    // Check if Gmail is already registered
    $stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_user WHERE gmail = :gmail");
    $stmt->bindParam(':gmail', $gmail);
    $stmt->execute();
    if ($stmt->fetchColumn() > 0) {
        die("Email already registered.");
    }

    // Insert user data into the database
    $command = "INSERT INTO tbl_user 
        (first_name, last_name, middle_name, gmail, password, purok, barangay, city, province, country, zip_code) 
        VALUES (:firstName, :lastName, :middleName, :gmail, :password, :purok, :barangay, :city, :province, :country, :zipCode)";
    
    $statement = $conn->prepare($command);
    $statement->bindParam(':firstName', $firstName);
    $statement->bindParam(':lastName', $lastName);
    $statement->bindParam(':middleName', $middleName);
    $statement->bindParam(':gmail', $gmail);
    $statement->bindParam(':password', $hashedPassword);
    $statement->bindParam(':purok', $purok);
    $statement->bindParam(':barangay', $barangay);
    $statement->bindParam(':city', $city);
    $statement->bindParam(':province', $province);
    $statement->bindParam(':country', $country);
    $statement->bindParam(':zipCode', $zipCode);

    $statement->execute();

    echo "Registration successful! <a href='index.html'>Go to Login</a>";
} catch (PDOException $e) {
    error_log("PDOException: " . $e->getMessage());
    echo "An error occurred during registration. Please try again later.";
}
?>
