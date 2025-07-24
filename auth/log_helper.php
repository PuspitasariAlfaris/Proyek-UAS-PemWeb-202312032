<?php
// Helper untuk log aktivitas yang aman
function safe_log_aktivitas($conn, $aktivitas, $deskripsi = '', $user_id = null) {
    // Jika user_id tidak diberikan, ambil dari session
    if ($user_id === null) {
        if (!isset($_SESSION['user_id'])) {
            return false;
        }
        $user_id = $_SESSION['user_id'];
    }
    
    // Pastikan koneksi database tersedia
    if (!$conn) {
        return false;
    }
    
    // Cek apakah user_id ada di tabel users
    $check_user = mysqli_query($conn, "SELECT id FROM users WHERE id = '$user_id'");
    if (!$check_user || mysqli_num_rows($check_user) == 0) {
        error_log("User ID $user_id tidak ditemukan di database");
        return false;
    }
    
    // Cek apakah tabel activity_log ada
    $check_table = mysqli_query($conn, "SHOW TABLES LIKE 'activity_log'");
    if (!$check_table || mysqli_num_rows($check_table) == 0) {
        error_log("Tabel activity_log tidak ditemukan");
        return false;
    }
    
    // Escape string untuk keamanan
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $user_agent = mysqli_real_escape_string($conn, $_SERVER['HTTP_USER_AGENT']);
    $aktivitas = mysqli_real_escape_string($conn, $aktivitas);
    $deskripsi = mysqli_real_escape_string($conn, $deskripsi);
    
    // Query insert
    $query = "INSERT INTO activity_log (user_id, activity, description, ip_address, user_agent) 
             VALUES ('$user_id', '$aktivitas', '$deskripsi', '$ip_address', '$user_agent')";
    
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        error_log("Log aktivitas gagal: " . mysqli_error($conn));
        return false;
    }
    
    return true;
}

// Fungsi untuk membuat tabel activity_log jika belum ada
function create_log_table_if_not_exists($conn) {
    $create_table = "CREATE TABLE IF NOT EXISTS activity_log (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        activity VARCHAR(255) NOT NULL,
        description TEXT,
        ip_address VARCHAR(45),
        user_agent TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_user_id (user_id),
        INDEX idx_created (created_at),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    
    $result = mysqli_query($conn, $create_table);
    if (!$result) {
        error_log("Gagal membuat tabel activity_log: " . mysqli_error($conn));
        return false;
    }
    
    return true;
}
?>
