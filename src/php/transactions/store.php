<?php
session_start();
require '../config/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../public/index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$nominal = $_POST['nominal'];
$tipe = $_POST['tipe'];
$ket = $_POST['ket'];
$tanggal = date('Y-m-d');

$query = $conn->prepare("
    INSERT INTO transactions (user_id, ket, nominal, tipe, tanggal)
    VALUES (?, ?, ?, ?, ?)
");

$query->bind_param(
    "isiss",
    $user_id,
    $ket,
    $nominal,
    $tipe,
    $tanggal
);

$query->execute();

header("Location: ../../../public/dashboard.php");
