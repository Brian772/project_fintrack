<?php
session_start();
require '../config/connection_sqlite.php';

$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
$stmt->bindParam(':email', $email);
$stmt->execute();

if ($stmt->fetch()) {
    $_SESSION['error'] = "Email already registered.";
    header("Location: ../../../public/register.php");
    exit;
}

if ($password !== $confirm_password) {
    $_SESSION['error'] = "Password and Confirm Password do not match.";
    header("Location: ../../../public/register.php");
    exit;
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert new user
$stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (:email, :password)");
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $hashed_password);

if ($stmt->execute()) {
    $_SESSION['success'] = "Registration successful";
    header("Location: ../../../public/index.php");
} else {
    echo "Registration failed.";
}
?>