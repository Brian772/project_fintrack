<?php
function getUserSettings($conn, $user_id) {
    if (!$user_id) return null;
    $q = $conn->prepare("SELECT name, email, profile_picture, theme, language, currency FROM users WHERE id = ?");
    $q->execute([$user_id]);
    return $q->fetch(PDO::FETCH_ASSOC);
}

function getTranslations($langCode) {
    $translations = [
        'id' => [
            'dashboard' => 'Dashboard',
            'your_email_is' => 'Email Anda',
            'transactions' => 'Transaksi',
            'settings' => 'Pengaturan',
            'balance' => 'Saldo',
            'income' => 'Pemasukan',
            'expense' => 'Pengeluaran',
            'income_this_month' => 'Pemasukan (Bulan Ini)',
            'expense_this_month' => 'Pengeluaran (Bulan Ini)',
            'statistics' => 'Statistik',
            'recent_transactions' => 'Transaksi Terakhir',
            'view_all' => 'Lihat Semua',
            'this_week' => 'Minggu Ini',
            'this_month' => 'Bulan Ini',
            'this_year' => 'Tahun Ini',
            'add_transaction' => 'Tambah Transaksi',
            'nominal' => 'Nominal',
            'type' => 'Tipe',
            'category' => 'Kategori',
            'asset' => 'Aset',
            'description' => 'Keterangan',
            'date_time' => 'Tanggal & Waktu',
            'cancel' => 'Batal',
            'add' => 'Tambah',
            'hello' => 'Halo',
            'edit_transaction' => 'Edit Transaksi',
            'update' => 'Perbarui',
            'daily' => 'Harian',
            'income_filter' => 'Pemasukan',
            'expense_filter' => 'Pengeluaran',
            'delete_transaction_title' => 'Hapus Transaksi?',
            'delete_transaction_message' => 'Apakah Anda yakin ingin menghapus transaksi ini? Tindakan ini tidak dapat dibatalkan.',
            'delete' => 'Hapus',
            'edit' => 'Edit',
            'profile' => 'Profil',
            'security' => 'Keamanan',
            'preferences' => 'Preferensi',
            'data_account' => 'Data & Akun',
            'full_name' => 'Nama Lengkap',
            'email' => 'Email',
            'profile_picture' => 'Foto Profil',
            'choose_file' => 'Pilih File',
            'update_profile' => 'Perbarui Profil',
            'change_password' => 'Ganti Password',
            'current_password' => 'Password Saat Ini',
            'new_password' => 'Password Baru',
            'confirm_new_password' => 'Konfirmasi Password Baru',
            'email_verification' => 'Verifikasi Email',
            'account_actions' => 'Tindakan Akun',
            'logout' => 'Keluar',
            'dark_mode' => 'Mode Gelap',
            'enable_dark_mode' => 'Aktifkan Mode Gelap',
            'language' => 'Bahasa',
            'currency_format' => 'Format Mata Uang',
            'update_preferences' => 'Perbarui Preferensi',
            'export_data' => 'Ekspor Data',
            'export_json' => 'Ekspor sebagai JSON',
            'download_data_text' => 'Unduh semua data keuangan Anda dalam format JSON.',
            'reset_transactions' => 'Reset Semua Transaksi',
            'reset_transactions_text' => 'Ini akan menghapus semua data transaksi Anda secara permanen. Tindakan ini tidak dapat dibatalkan.',
            'delete_account' => 'Hapus Akun',
            'delete_account_text' => 'Hapus akun Anda secara permanen dan hapus semua data',
            'delete_account_danger' => 'Setelah Anda menghapus akun, tidak ada jalan kembali. Harap yakin.',
            'verified' => 'Terverifikasi',
            'not_verified' => 'Email Anda belum diverifikasi.',
            'resend_verification' => 'Kirim Ulang Email Verifikasi'
        ],
        'en' => [
            'dashboard' => 'Dashboard',
            'your_email_is' => 'Your email is',
            'transactions' => 'Transactions',
            'settings' => 'Settings',
            'balance' => 'Balance',
            'income' => 'Income',
            'expense' => 'Expense',
            'income_this_month' => 'Income (This Month)',
            'expense_this_month' => 'Expense (This Month)',
            'statistics' => 'Statistics',
            'recent_transactions' => 'Recent Transactions',
            'view_all' => 'View All',
            'this_week' => 'This Week',
            'this_month' => 'This Month',
            'this_year' => 'This Year',
            'add_transaction' => 'Add Transaction',
            'nominal' => 'Amount',
            'type' => 'Type',
            'category' => 'Category',
            'asset' => 'Asset',
            'description' => 'Description',
            'date_time' => 'Date & Time',
            'cancel' => 'Cancel',
            'add' => 'Add',
            'hello' => 'Hello',
            'edit_transaction' => 'Edit Transaction',
            'update' => 'Update',
            'daily' => 'Daily',
            'income_filter' => 'Income',
            'expense_filter' => 'Expense',
            'delete_transaction_title' => 'Delete Transaction?',
            'delete_transaction_message' => 'Are you sure you want to delete this transaction? This action cannot be undone.',
            'delete' => 'Delete',
            'edit' => 'Edit',
            'profile' => 'Profile',
            'security' => 'Security',
            'preferences' => 'Preferences',
            'data_account' => 'Data & Account',
            'full_name' => 'Full Name',
            'email' => 'Email',
            'profile_picture' => 'Profile Picture',
            'choose_file' => 'Choose File',
            'update_profile' => 'Update Profile',
            'change_password' => 'Change Password',
            'current_password' => 'Current Password',
            'new_password' => 'New Password',
            'confirm_new_password' => 'Confirm New Password',
            'email_verification' => 'Email Verification',
            'account_actions' => 'Account Actions',
            'logout' => 'Logout',
            'dark_mode' => 'Dark Mode',
            'enable_dark_mode' => 'Enable Dark Mode',
            'language' => 'Language',
            'currency_format' => 'Currency Format',
            'update_preferences' => 'Update Preferences',
            'export_data' => 'Export Data',
            'export_json' => 'Export as JSON',
            'download_data_text' => 'Download all your financial data in JSON format.',
            'reset_transactions' => 'Reset All Transactions',
            'reset_transactions_text' => 'This will permanently delete all your transaction data. This action cannot be undone.',
            'delete_account' => 'Delete Account',
            'delete_account_text' => 'Permanently delete your account and remove all data.',
            'delete_account_danger' => 'Once you delete your account, there is no going back. Please be certain.',
            'verified' => 'Verified',
            'not_verified' => 'Your email is not verified.',
            'resend_verification' => 'Resend Verification Email'
        ],
        'rs' => [
            'dashboard' => 'Панель управления',
            'your_email_is' => 'Ваш email',
            'transactions' => 'Транзакции',
            'settings' => 'Настройки',
            'balance' => 'Баланс',
            'income' => 'Доход',
            'expense' => 'Расходы',
            'income_this_month' => 'Доход (в этом месяце)',
            'expense_this_month' => 'Расходы (в этом месяце)',
            'statistics' => 'Статистика',
            'recent_transactions' => 'Последние транзакции',
            'view_all' => 'Показать все',
            'this_week' => 'Эта неделя',
            'this_month' => 'Этот месяц',
            'this_year' => 'Этот год',
            'add_transaction' => 'Добавить транзакцию',
            'nominal' => 'Сумма',
            'type' => 'Тип',
            'category' => 'Категория',
            'asset' => 'Актив',
            'description' => 'Описание',
            'date_time' => 'Дата и время',
            'cancel' => 'Отмена',
            'add' => 'Добавить',
            'hello' => 'Здравствуйте',
            'edit_transaction' => 'Редактировать транзакцию',
            'update' => 'Обновить',
            'daily' => 'Ежедневно',
            'income_filter' => 'Доход',
            'expense_filter' => 'Расходы',
            'delete_transaction_title' => 'Удалить транзакцию?',
            'delete_transaction_message' => 'Вы уверены, что хотите удалить эту транзакцию? Это действие нельзя отменить.',
            'delete' => 'Удалить',
            'edit' => 'Редактировать',
            'profile' => 'Профиль',
            'security' => 'Безопасность',
            'preferences' => 'Настройки',
            'data_account' => 'Данные и аккаунт',
            'full_name' => 'Полное имя',
            'email' => 'Email',
            'profile_picture' => 'Фото профиля',
            'choose_file' => 'Выбрать файл',
            'update_profile' => 'Обновить профиль',
            'change_password' => 'Изменить пароль',
            'current_password' => 'Текущий пароль',
            'new_password' => 'Новый пароль',
            'confirm_new_password' => 'Подтвердите новый пароль',
            'email_verification' => 'Подтверждение Email',
            'account_actions' => 'Действия с аккаунтом',
            'logout' => 'Выйти',
            'dark_mode' => 'Темный режим',
            'enable_dark_mode' => 'Включить темный режим',
            'language' => 'Язык',
            'currency_format' => 'Формат валюты',
            'update_preferences' => 'Обновить настройки',
            'export_data' => 'Экспорт данных',
            'export_json' => 'Экспорт в JSON',
            'download_data_text' => 'Скачать все ваши финансовые данные в формате JSON.',
            'reset_transactions' => 'Сбросить все транзакции',
            'reset_transactions_text' => 'Это действие навсегда удалит все данные о транзакциях. Это действие нельзя отменить.',
            'delete_account' => 'Удалить аккаунт',
            'delete_account_text' => 'Навсегда удалить ваш аккаунт и все данные.',
            'delete_account_danger' => 'Как только вы удалите свой аккаунт, пути назад не будет. Пожалуйста, будьте уверены.',
            'verified' => 'Подтверждено',
            'not_verified' => 'Ваш email не подтвержден.',
            'resend_verification' => 'Отправить повторно'
        ],
        'fr' => [
            'dashboard' => 'Tableau de bord',
            'your_email_is' => 'Votre email est',
            'transactions' => 'Transactions',
            'settings' => 'Paramètres',
            'balance' => 'Solde',
            'income' => 'Revenu',
            'expense' => 'Dépense',
            'income_this_month' => 'Revenu (ce mois-ci)',
            'expense_this_month' => 'Dépense (ce mois-ci)',
            'statistics' => 'Statistiques',
            'recent_transactions' => 'Transactions récentes',
            'view_all' => 'Voir tout',
            'this_week' => 'Cette semaine',
            'this_month' => 'Ce mois-ci',
            'this_year' => 'Cette année',
            'add_transaction' => 'Ajouter une transaction',
            'nominal' => 'Montant',
            'type' => 'Type',
            'category' => 'Catégorie',
            'asset' => 'Actif',
            'description' => 'Description',
            'date_time' => 'Date et heure',
            'cancel' => 'Annuler',
            'add' => 'Ajouter',
            'hello' => 'Bonjour',
            'edit_transaction' => 'Modifier la transaction',
            'update' => 'Mettre à jour',
            'daily' => 'Journalier',
            'income_filter' => 'Revenu',
            'expense_filter' => 'Dépense',
            'delete_transaction_title' => 'Supprimer la transaction?',
            'delete_transaction_message' => 'Êtes-vous sûr de vouloir supprimer cette transaction? Cette action ne peut pas être annulée.',
            'delete' => 'Supprimer',
            'edit' => 'Modifier',
            'profile' => 'Profil',
            'security' => 'Sécurité',
            'preferences' => 'Préférences',
            'data_account' => 'Données & Compte',
            'full_name' => 'Nom complet',
            'email' => 'Email',
            'profile_picture' => 'Photo de profil',
            'choose_file' => 'Choisir un fichier',
            'update_profile' => 'Mettre à jour le profil',
            'change_password' => 'Changer le mot de passe',
            'current_password' => 'Mot de passe actuel',
            'new_password' => 'Nouveau mot de passe',
            'confirm_new_password' => 'Confirmer le nouveau mot de passe',
            'email_verification' => 'Vérification de l\'email',
            'account_actions' => 'Actions du compte',
            'logout' => 'Se déconnecter',
            'dark_mode' => 'Mode sombre',
            'enable_dark_mode' => 'Activer le mode sombre',
            'language' => 'Langue',
            'currency_format' => 'Format de devise',
            'update_preferences' => 'Mettre à jour les préférences',
            'export_data' => 'Exporter les données',
            'export_json' => 'Exporter en JSON',
            'download_data_text' => 'Téléchargez toutes vos données financières au format JSON.',
            'reset_transactions' => 'Réinitialiser toutes les transactions',
            'reset_transactions_text' => 'Cela supprimera définitivement toutes vos données de transaction. Cette action ne peut pas être annulée.',
            'delete_account' => 'Supprimer le compte',
            'delete_account_text' => 'Supprimer définitivement votre compte et effacer toutes les données.',
            'delete_account_danger' => 'Une fois votre compte supprimé, il n\'y a pas de retour en arrière. Soyez certain.',
            'verified' => 'Vérifié',
            'not_verified' => 'Votre email n\'est pas vérifié.',
            'resend_verification' => 'Renvoyer l\'email de vérification'
        ]
    ];
    return $translations[$langCode] ?? $translations['id'];
}

function updateUserProfile($conn, $user_id, $name, $email, $profile_picture = null) {
    if ($profile_picture) {
        $q = $conn->prepare("UPDATE users SET name = ?, email = ?, profile_picture = ? WHERE id = ?");
        $q->execute([$name, $email, $profile_picture, $user_id]);
    } else {
        $q = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $q->execute([$name, $email, $user_id]);
    }
    return true; // Simplified success for PDO
}

function updateUserPassword($conn, $user_id, $new_password) {
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $q = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    return $q->execute([$hashed_password, $user_id]);
}

function getExchangeRates() {
    // Rates are: 1 IDR = X Target Currency
    return [
        'IDR' => 1,
        'USD' => 0.00006329, // ~15,800 IDR
        'EUR' => 0.00005882, // ~17,000 IDR
        'RUB' => 0.005882    // ~170 IDR
    ];
}

function updateUserPreferences($conn, $user_id, $theme, $language, $currency) {
    // Get current settings to check if currency changed
    $currentSettings = getUserSettings($conn, $user_id);
    $oldCurrency = $currentSettings['currency'] ?? 'IDR';

    // Update preferences
    $q = $conn->prepare("UPDATE users SET theme = ?, language = ?, currency = ? WHERE id = ?");
    $q->execute([$theme, $language, $currency, $user_id]);
    $success = true;

    // If currency changed and update was successful, convert transactions and budget
    if ($success && $oldCurrency !== $currency) {
        $rates = getExchangeRates();
        $sourceRate = $rates[$oldCurrency] ?? 1;
        $targetRate = $rates[$currency] ?? 1;

        if ($sourceRate > 0) {
            $conversionFactor = $targetRate / $sourceRate;

            // Update transactions
            $updateTrx = $conn->prepare("UPDATE transactions SET nominal = nominal * ? WHERE user_id = ?");
            $updateTrx->execute([$conversionFactor, $user_id]);

            // Update monthly budget
            $updateBudget = $conn->prepare("UPDATE budgets SET monthly_budget = monthly_budget * ? WHERE user_id = ?");
            $updateBudget->execute([$conversionFactor, $user_id]);
        }
    }

    return $success;
}

function getUserBudget($conn, $user_id) {
    $q = $conn->prepare("SELECT monthly_budget, category_budgets, alert_threshold FROM budgets WHERE user_id = ?");
    $q->execute([$user_id]);
    $budget = $q->fetch(PDO::FETCH_ASSOC);

    if (!$budget) {
        // Create default budget entry if not exists
        $q = $conn->prepare("INSERT INTO budgets (user_id) VALUES (?)");
        $q->execute([$user_id]);
        return ['monthly_budget' => 0, 'category_budgets' => '{}', 'alert_threshold' => 80];
    }

    return $budget;
}

function updateUserBudget($conn, $user_id, $monthly_budget, $category_budgets, $alert_threshold) {
    $q = $conn->prepare("UPDATE budgets SET monthly_budget = ?, category_budgets = ?, alert_threshold = ? WHERE user_id = ?");
    $q->execute([$monthly_budget, $category_budgets, $alert_threshold, $user_id]);
    
    if ($q->rowCount() === 0) {
        // check if row really missing
        $check = $conn->prepare("SELECT 1 FROM budgets WHERE user_id = ?");
        $check->execute([$user_id]);
        if (!$check->fetch()) {
            $q = $conn->prepare("INSERT INTO budgets (user_id, monthly_budget, category_budgets, alert_threshold) VALUES (?, ?, ?, ?)");
            $q->execute([$user_id, $monthly_budget, $category_budgets, $alert_threshold]);
        }
    }
    return true;
}

function exportUserData($conn, $user_id) {
    // Get user info
    $q = $conn->prepare("SELECT name, email, created_at FROM users WHERE id = ?");
    $q->execute([$user_id]);
    $user = $q->fetch(PDO::FETCH_ASSOC);

    // Get all transactions
    $q = $conn->prepare("SELECT * FROM transactions WHERE user_id = ? ORDER BY tanggal DESC");
    $q->execute([$user_id]);
    $transactions = $q->fetchAll(PDO::FETCH_ASSOC);

    // Get budget settings
    $budget = getUserBudget($conn, $user_id);

    return [
        'user' => $user,
        'transactions' => $transactions,
        'budget_settings' => $budget,
        'export_date' => date('Y-m-d H:i:s')
    ];
}

function resetUserTransactions($conn, $user_id) {
    $q = $conn->prepare("DELETE FROM transactions WHERE user_id = ?");
    return $q->execute([$user_id]);
}

function deleteUserAccount($conn, $user_id) {
    // Delete budget settings
    $q = $conn->prepare("DELETE FROM budgets WHERE user_id = ?");
    $q->execute([$user_id]);

    // Delete transactions
    $q = $conn->prepare("DELETE FROM transactions WHERE user_id = ?");
    $q->execute([$user_id]);

    // Delete user account
    $q = $conn->prepare("DELETE FROM users WHERE id = ?");
    return $q->execute([$user_id]);
}
?>
