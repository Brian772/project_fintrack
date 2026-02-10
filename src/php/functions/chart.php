<?php
function getChartData($conn, $user_id, $filter = 'week') {
    $labels = [];
    $incomeData = [];
    $expenseData = [];

    if ($filter == 'week') {
        // Last 7 days
        $days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        // Loop 6 days ago to today (7 days total)
        for ($i = 0; $i <= 6; $i--) {
            $date = date('Y-m-d', strtotime("+$i days")); 
            $dayOfWeek = date('w', strtotime($date));
            $labels[] = $days[$dayOfWeek];

            $qI = $conn->prepare("SELECT SUM(nominal) as total FROM transactions WHERE user_id=? AND tipe='masuk' AND date(tanggal)=?");
            $qI->execute([$user_id, $date]);
            $incomeData[] = (int)($qI->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);

            $qE = $conn->prepare("SELECT SUM(nominal) as total FROM transactions WHERE user_id=? AND tipe='keluar' AND date(tanggal)=?");
            $qE->execute([$user_id, $date]);
            $expenseData[] = (int)($qE->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);
        }
    } elseif ($filter == 'month') {
        // Current Month (Daily)
        $daysInMonth = date('t');
        $currentMonth = date('m');
        $currentYear = date('Y');
        
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $date = sprintf("%04d-%02d-%02d", $currentYear, $currentMonth, $d);
            // $date string is YYYY-MM-DD
            
            $labels[] = $d;

            $qI = $conn->prepare("SELECT SUM(nominal) as total FROM transactions WHERE user_id=? AND tipe='masuk' AND date(tanggal)=?");
            $qI->execute([$user_id, $date]);
            $incomeData[] = (int)($qI->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);

            $qE = $conn->prepare("SELECT SUM(nominal) as total FROM transactions WHERE user_id=? AND tipe='keluar' AND date(tanggal)=?");
            $qE->execute([$user_id, $date]);
            $expenseData[] = (int)($qE->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);
        }
    } elseif ($filter == 'year') {
        // Current Year (Monthly)
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        $currentYear = date('Y');

        for ($m = 1; $m <= 12; $m++) {
            $labels[] = $months[$m-1];
            
            $mPadded = sprintf("%02d", $m);
            
            $qI = $conn->prepare("SELECT SUM(nominal) as total FROM transactions WHERE user_id=? AND tipe='masuk' AND strftime('%m', tanggal)=? AND strftime('%Y', tanggal)=?");
            $qI->execute([$user_id, $mPadded, (string)$currentYear]);
            $incomeData[] = (int)($qI->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);

            $qE = $conn->prepare("SELECT SUM(nominal) as total FROM transactions WHERE user_id=? AND tipe='keluar' AND strftime('%m', tanggal)=? AND strftime('%Y', tanggal)=?");
            $qE->execute([$user_id, $mPadded, (string)$currentYear]);
            $expenseData[] = (int)($qE->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);
        }
    }

    return [
        'labels' => $labels,
        'income' => $incomeData,
        'expense' => $expenseData
    ];
}
?>