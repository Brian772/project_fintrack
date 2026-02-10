<?php
$db_path = __DIR__ . '/../../database/database.sqlite';
$db_dir = dirname($db_path);
$is_new_db = !file_exists($db_path);

if (!file_exists($db_dir)) {
    mkdir($db_dir, 0777, true);
}

try {
    $conn = new PDO("sqlite:$db_path");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    if ($is_new_db) {
        require_once __DIR__ . '/init_db.php';
    }
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
