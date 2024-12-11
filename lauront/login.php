<?php
include "conn.php";

$username = trim($_POST['username']);
$password = trim($_POST['password']);

try {
    $stmt = $conn->prepare("SELECT * FROM tbl_user WHERE email = :email");
    $stmt->bindParam(':email', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        echo json_encode(["status" => "success", "message" => "Login successful"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid email or password."]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>
