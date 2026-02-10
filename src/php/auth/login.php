<?php
session_start();
require '../config/connection_sqlite.php';

$email = trim($_POST['email']);
$password = $_POST['password'];

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['email'] = $user['email'];

    if (isset($_POST['remember'])) {
        $token = bin2hex(random_bytes(32));

        $update = $conn->prepare("UPDATE users SET remember_token = :token WHERE id = :id");
        $update->bindParam(':token', $token);
        $update->bindParam(':id', $user['id']);
        $update->execute();

        setcookie(
            "remember_token",
            $token,
            time() + (86400 * 30), // 30 days
            "/"
        );
    }
        
    $_SESSION['success'] = "Login successful";
    header("Location: ../../../public/dashboard.php");
    exit;

} else {
    $_SESSION['error'] = "Invalid email or password.";
    header("Location: ../../../public/index.php");
}
?>