<?php
if (!isset($conn)) {
    require 'connection_sqlite.php'; // Use the new SQLite connection
}

try {
    // Create users table
    $conn->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        email TEXT UNIQUE,
        password TEXT,
        name TEXT,
        profile_picture TEXT,
        theme TEXT DEFAULT 'light',
        language TEXT DEFAULT 'id',
        currency TEXT DEFAULT 'IDR',
        remember_token TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    // Create budgets table
    $conn->exec("CREATE TABLE IF NOT EXISTS budgets (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        monthly_budget REAL DEFAULT 0,
        category_budgets TEXT,
        alert_threshold REAL DEFAULT 80,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");

    // Create transactions table
    $conn->exec("CREATE TABLE IF NOT EXISTS transactions (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER,
        nominal REAL,
        tipe TEXT,
        tanggal DATETIME,
        kategori TEXT,
        aset TEXT,
        ket TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )");

    echo "Database initialized successfully.";
} catch (PDOException $e) {
    echo "Error initializing database: " . $e->getMessage();
}
?>
