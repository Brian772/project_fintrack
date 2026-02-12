<?php
session_start();
include '../config/connection.php';

if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("UPDATE users SET remember_token=NULL WHERE id=?");
    $stmt->execute([$_SESSION['user_id']]);
}

setcookie("remember_token", "", time() - 3600, "/");
session_destroy();
header("Location: ../../../public/index.php");
