<?php
function getAllTransactions($conn, $user_id, $filters = []) {
    $where = ["user_id = ?"];
    $params = [$user_id];
    
    // Filter by type
    if (!empty($filters['type']) && in_array($filters['type'], ['masuk', 'keluar'])) {
        $where[] = "tipe = ?";
        $params[] = $filters['type'];
    }
    
    // Filter by search
    if (!empty($filters['search'])) {
        $where[] = "ket LIKE ?";
        $params[] = "%" . $filters['search'] . "%";
    }
    
    // Filter by date range
    if (!empty($filters['date_from'])) {
        $where[] = "date(tanggal) >= ?";
        $params[] = $filters['date_from'];
    }
    
    if (!empty($filters['date_to'])) {
        $where[] = "date(tanggal) <= ?";
        $params[] = $filters['date_to'];
    }
    
    $whereSql = implode(" AND ", $where);
    $orderBy = $filters['order_by'] ?? 'tanggal DESC';
    
    // Whitelist order by to prevent SQL injection
    $allowedOrders = ['tanggal DESC', 'tanggal ASC', 'nominal DESC', 'nominal ASC'];
    if (!in_array($orderBy, $allowedOrders)) {
        $orderBy = 'tanggal DESC';
    }

    $sql = "SELECT id, ket, tanggal, nominal, tipe, kategori, aset
            FROM transactions 
            WHERE $whereSql 
            ORDER BY $orderBy";
    
    $q = $conn->prepare($sql);
    $q->execute($params);
    
    return $q->fetchAll(PDO::FETCH_ASSOC);
}

function getTransactionStats($conn, $user_id, $filters = []) {
    $where = ["user_id = ?"];
    $params = [$user_id];
    
    // Apply same filters as getAllTransactions
    if (!empty($filters['type']) && in_array($filters['type'], ['masuk', 'keluar'])) {
        $where[] = "tipe = ?";
        $params[] = $filters['type'];
    }
    
    if (!empty($filters['search'])) {
        $where[] = "ket LIKE ?";
        $params[] = "%" . $filters['search'] . "%";
    }
    
    if (!empty($filters['date_from'])) {
        $where[] = "date(tanggal) >= ?";
        $params[] = $filters['date_from'];
    }
    
    if (!empty($filters['date_to'])) {
        $where[] = "date(tanggal) <= ?";
        $params[] = $filters['date_to'];
    }
    
    $whereSql = implode(" AND ", $where);
    
    // Get income
    $sql = "SELECT COALESCE(SUM(nominal), 0) as total 
            FROM transactions 
            WHERE $whereSql AND tipe = 'masuk'";
    
    $q = $conn->prepare($sql);
    $q->execute($params);
    $income = $q->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Get expense
    $sql = "SELECT COALESCE(SUM(nominal), 0) as total 
            FROM transactions 
            WHERE $whereSql AND tipe = 'keluar'";
    $q = $conn->prepare($sql);
    $q->execute($params);
    $expense = $q->fetch(PDO::FETCH_ASSOC)['total'];
    
    return [
        'income' => $income,
        'expense' => $expense,
        'balance' => $income - $expense
    ];
}

function getTransactionById($conn, $transaction_id, $user_id) {
    $q = $conn->prepare("SELECT * FROM transactions WHERE id = ? AND user_id = ?");
    $q->execute([$transaction_id, $user_id]);
    return $q->fetch(PDO::FETCH_ASSOC);
}

function deleteTransaction($conn, $transaction_id, $user_id) {
    $q = $conn->prepare("DELETE FROM transactions WHERE id = ? AND user_id = ?");
    if (!$q->execute([$transaction_id, $user_id])) {
        $errorInfo = $q->errorInfo();
        $GLOBALS['stmt_error'] = $errorInfo[2];
        return false;
    }
    return true;
}

function updateTransaction($conn, $transaction_id, $user_id, $data) {
    $q = $conn->prepare("
        UPDATE transactions 
        SET nominal = ?, tipe = ?, ket = ?, tanggal = ?, kategori = ?, aset = ?
        WHERE id = ? AND user_id = ?
    ");
    
    $params = [
        $data['nominal'],
        $data['tipe'],
        $data['ket'],
        $data['tanggal'],
        $data['kategori'],
        $data['aset'],
        $transaction_id,
        $user_id
    ];
    
    if (!$q->execute($params)) {
        $errorInfo = $q->errorInfo();
        $GLOBALS['stmt_error'] = $errorInfo[2];
        return false;
    }
    return true;
}
?>
