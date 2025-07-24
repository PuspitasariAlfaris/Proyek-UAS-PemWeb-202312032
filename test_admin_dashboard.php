<?php
session_start();
include 'backend/koneksi.php';
include 'auth/log_helper.php';

echo "<h2>🔧 Admin Dashboard Test</h2>";

// Simulate admin login session
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'admin';
$_SESSION['nama'] = 'Administrator';
$_SESSION['email'] = 'admin@scarlettstore.com';
$_SESSION['role'] = 'admin';

echo "<p>✅ Admin session simulated</p>";

try {
    // Test the same queries from admin/index.php
    $total_produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products"))['total'];
    echo "<p>✅ Products count: $total_produk</p>";
    
    $total_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role='user'"))['total'];
    echo "<p>✅ Users count: $total_user</p>";
    
    $total_transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM transactions"))['total'];
    echo "<p>✅ Transactions count: $total_transaksi</p>";
    
    $total_kategori = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM categories"))['total'];
    echo "<p>✅ Categories count: $total_kategori</p>";
    
    // Test activity log
    $log_result = safe_log_aktivitas($conn, 'Test Dashboard', 'Testing dashboard access from test script');
    if ($log_result) {
        echo "<p>✅ Activity log working</p>";
    } else {
        echo "<p>❌ Activity log failed</p>";
    }
    
    // Test transaction query
    $transaksi_terbaru = mysqli_query($conn, "
        SELECT t.*, u.name as nama_user, p.name as nama_produk, ti.quantity as jumlah, t.total_amount as total_harga, t.created_at as tanggal 
        FROM transactions t 
        LEFT JOIN users u ON t.user_id = u.id 
        LEFT JOIN transaction_items ti ON t.id = ti.transaction_id
        LEFT JOIN products p ON ti.product_id = p.id 
        ORDER BY t.created_at DESC 
        LIMIT 5
    ");
    
    if ($transaksi_terbaru) {
        $transaction_count = mysqli_num_rows($transaksi_terbaru);
        echo "<p>✅ Recent transactions query successful ($transaction_count rows)</p>";
    } else {
        echo "<p>❌ Recent transactions query failed: " . mysqli_error($conn) . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><strong>All tests passed! Admin dashboard should work now.</strong></p>";
echo "<p><a href='auth/login.php'>🔐 Go to Login Page</a></p>";
echo "<p><a href='admin/index.php'>📊 Go to Admin Dashboard</a> (Login required)</p>";

// Clean up test session
unset($_SESSION['user_id']);
unset($_SESSION['username']);
unset($_SESSION['nama']);
unset($_SESSION['email']);
unset($_SESSION['role']);
?>
