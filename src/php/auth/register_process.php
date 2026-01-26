<?php
include '../config/connection.php';

$email            = $_POST['email'];
$password         = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

$check = mysqli_query(
    $conn,
    "SELECT id FROM users WHERE email='$email'"
);
if (mysqli_num_rows($check) > 0) {
    session_start();
    $_SESSION['error'] = "Email already registered.";
    header("Location: ../../../public/register.php");
    exit;
}
if ($_POST['password'] !== $_POST['confirm_password']) {
    session_start();
    $_SESSION['error'] = "Password and Confirm Password do not match.";
    header("Location: ../../../public/register.php");
    exit;
}

$password = ($_POST['password']);
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$query = mysqli_query(
    $conn,
    "INSERT INTO users (email, password)
    VALUES ('$email', '$hashed_password')"
);

if ($query) {
    header("Location: ../../../public/index.php");
} else {
    echo "Registration failed.";
}