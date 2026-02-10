<?php
function formatCurrency($amount, $currency = 'IDR') {
    switch ($currency) {
        case 'IDR':
            return 'Rp ' . number_format($amount, 0, ',', '.');
        case 'USD':
            return '$ ' . number_format($amount, 2, '.', ',');
        case 'EUR':
            return '€ ' . number_format($amount, 2, ',', '.');
        case 'RUB':
            return '₽ ' . number_format($amount, 2, ',', '.');
        default:
            return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}

function formatRupiah($angka) {
    return formatCurrency($angka, 'IDR');
}

function getDashboardData($conn, $user_id) {
    $q = $conn->prepare("
        SELECT SUM(
            CASE WHEN tipe='masuk' THEN nominal ELSE -nominal END
            ) AS saldo
            FROM transactions WHERE user_id=?
        ");
    $q->execute([$user_id]);
    $saldo = $q->fetch(PDO::FETCH_ASSOC)['saldo'] ?? 0;

    //income
    // SQLite: Compare YYYY-MM
    $q = $conn->prepare("
        SELECT SUM(nominal) AS pemasukan
        FROM transactions
        WHERE user_id=? AND tipe='masuk' AND strftime('%Y-%m', tanggal) = strftime('%Y-%m', 'now')
        ");
    $q->execute([$user_id]);
    $masuk = $q->fetch(PDO::FETCH_ASSOC)['pemasukan'] ?? 0;

    //expense
    $q = $conn->prepare("
        SELECT SUM(nominal) AS pengeluaran
        FROM transactions
        WHERE user_id=? AND tipe='keluar' AND strftime('%Y-%m', tanggal) = strftime('%Y-%m', 'now')
        ");
    $q->execute([$user_id]);
    $keluar = $q->fetch(PDO::FETCH_ASSOC)['pengeluaran'] ?? 0;

    return [
        'saldo' => $saldo,
        'masuk' => $masuk,
        'keluar' => $keluar
    ];
}

function getLastTransactions($conn, $user_id, $limit = 5) {
    $q = $conn->prepare("
        SELECT ket, tanggal, nominal, tipe, kategori
        FROM transactions
        WHERE user_id=?
        ORDER BY tanggal DESC
        LIMIT ?
    ");
    $q->bindValue(1, $user_id, PDO::PARAM_INT);
    $q->bindValue(2, $limit, PDO::PARAM_INT);
    $q->execute();
    $transactions = $q->fetchAll(PDO::FETCH_ASSOC);
    return $transactions;
}
?>
