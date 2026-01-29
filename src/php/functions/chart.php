<?php
function getWeeklyExpenseCharts($conn, $user_id) {
    // Get data for the last 7 days
    $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    
    // Initialize arrays for all 7 days
    $labels = [];
    $incomeData = [];
    $expenseData = [];
    
    // Get the last 7 days
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $dayOfWeek = date('w', strtotime($date)); // 0 (Sunday) to 6 (Saturday)
        $labels[] = $days[$dayOfWeek];
        
        // Get income for this day
        $queryIncome = $conn->prepare("
            SELECT SUM(nominal) AS total
            FROM transactions
            WHERE user_id=? AND tipe='masuk' AND DATE(tanggal)=?
        ");
        $queryIncome->bind_param("is", $user_id, $date);
        $queryIncome->execute();
        $resultIncome = $queryIncome->get_result()->fetch_assoc();
        $incomeData[] = (int)($resultIncome['total'] ?? 0);
        
        // Get expense for this day
        $queryExpense = $conn->prepare("
            SELECT SUM(nominal) AS total
            FROM transactions
            WHERE user_id=? AND tipe='keluar' AND DATE(tanggal)=?
        ");
        $queryExpense->bind_param("is", $user_id, $date);
        $queryExpense->execute();
        $resultExpense = $queryExpense->get_result()->fetch_assoc();
        $expenseData[] = (int)($resultExpense['total'] ?? 0);
    }
    
    return [
        'labels' => $labels,
        'income' => $incomeData,
        'expense' => $expenseData
    ];
}