<?php
include 'backend/koneksi.php';
include 'auth/log_helper.php';

// Buat tabel log_aktivitas jika belum ada
$create_table = "CREATE TABLE IF NOT EXISTS log_aktivitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    aktivitas VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    waktu TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user_id (user_id),
    INDEX idx_waktu (waktu),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if (mysqli_query($conn, $create_table)) {
    echo "✅ Tabel log_aktivitas berhasil dibuat atau sudah ada.<br>";
} else {
    echo "❌ Error membuat tabel: " . mysqli_error($conn) . "<br>";
}

// Cek apakah ada data users
$check_users = mysqli_query($conn, "SELECT COUNT(*) as count FROM users");
$user_count = mysqli_fetch_assoc($check_users)['count'];

if ($user_count == 0) {
    echo "⚠️ Tidak ada data users. Silakan registrasi user terlebih dahulu.<br>";
} else {
    echo "✅ Ditemukan $user_count user(s) di database.<br>";
}

// Test insert log
$test_user = mysqli_query($conn, "SELECT id FROM users LIMIT 1");
if ($test_user && mysqli_num_rows($test_user) > 0) {
    $user = mysqli_fetch_assoc($test_user);
    $user_id = $user['id'];
    
    $test_insert = "INSERT INTO log_aktivitas (user_id, aktivitas, deskripsi, ip_address, user_agent) 
                   VALUES ('$user_id', 'Test Setup', 'Test setup log aktivitas', '127.0.0.1', 'Setup Script')";
    
    if (mysqli_query($conn, $test_insert)) {
        echo "✅ Test insert log aktivitas berhasil.<br>";
        
        // Hapus test data
        mysqli_query($conn, "DELETE FROM log_aktivitas WHERE aktivitas = 'Test Setup'");
        echo "✅ Test data dibersihkan.<br>";
    } else {
        echo "❌ Error test insert: " . mysqli_error($conn) . "<br>";
    }
}

echo "<br><a href='user/index.php'>← Kembali ke Homepage</a>";
?>
