<?php
session_start();
require '../config/connection_sqlite.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../public/index.php");
    exit;
}

// Deduplication guard: prevent double form submission
$form_token = $_POST['form_token'] ?? '';
if ($form_token && isset($_SESSION['used_form_tokens']) && in_array($form_token, $_SESSION['used_form_tokens'])) {
    // This token was already used — this is a duplicate submission
    if (isset($_POST['ajax'])) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Transaction already added (duplicate prevented).']);
        exit;
    }
    if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: ../../../public/dashboard.php");
    }
    exit;
}

// Mark this token as used
if ($form_token) {
    if (!isset($_SESSION['used_form_tokens'])) {
        $_SESSION['used_form_tokens'] = [];
    }
    $_SESSION['used_form_tokens'][] = $form_token;
    // Keep only last 10 tokens to prevent session bloat
    if (count($_SESSION['used_form_tokens']) > 10) {
        $_SESSION['used_form_tokens'] = array_slice($_SESSION['used_form_tokens'], -10);
    }
}

date_default_timezone_set('Asia/Jakarta');
$user_id = $_SESSION['user_id'];
$nominal = $_POST['nominal'];
$tipe = $_POST['tipe'];
$ket = !empty($_POST['ket']) ? $_POST['ket'] : '-';
$tanggal = !empty($_POST['tanggal']) ? $_POST['tanggal'] : date('Y-m-d H:i:s');
$kategori = $_POST['kategori'];
$aset = $_POST['aset'];

try {
    $stmt = $conn->prepare("
        INSERT INTO transactions (user_id, ket, nominal, tipe, tanggal, kategori, aset)
        VALUES (:user_id, :ket, :nominal, :tipe, :tanggal, :kategori, :aset)
    ");

    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':ket', $ket);
    $stmt->bindParam(':nominal', $nominal);
    $stmt->bindParam(':tipe', $tipe);
    $stmt->bindParam(':tanggal', $tanggal);
    $stmt->bindParam(':kategori', $kategori);
    $stmt->bindParam(':aset', $aset);

    $success = $stmt->execute();
} catch (PDOException $e) {
    $success = false;
    $error_message = $e->getMessage();
}

if (isset($_POST['ajax'])) {
    header('Content-Type: application/json');
    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Transaction added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add transaction: ' . ($error_message ?? 'Unknown error')]);
    }
    exit;
}

if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    header("Location: ../../../public/dashboard.php");
}
?>
