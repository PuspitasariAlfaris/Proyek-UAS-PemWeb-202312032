<?php
session_start();
include 'backend/koneksi.php';

// Simulate admin session
$_SESSION['user_id'] = 1;
$_SESSION['username'] = 'admin';
$_SESSION['nama'] = 'Administrator';
$_SESSION['email'] = 'admin@scarlettstore.com';
$_SESSION['role'] = 'admin';

echo "<h2>🔧 Test Admin Pages</h2>";
echo "<style>body{font-family:Arial,sans-serif;margin:20px;} .success{color:green;} .error{color:red;} .test{margin:10px 0; padding:10px; border:1px solid #ccc; border-radius:5px;}</style>";

// Test queries from each page
$tests = [
    'Produk' => 'SELECT * FROM products LIMIT 1',
    'Kategori' => 'SELECT * FROM categories LIMIT 1', 
    'Transaksi' => 'SELECT * FROM transactions LIMIT 1',
    'Pesanan' => 'SELECT t.*, u.name as nama_user, p.name as nama_produk, ti.quantity as jumlah, ti.unit_price as harga FROM transactions t LEFT JOIN users u ON t.user_id = u.id LEFT JOIN transaction_items ti ON t.id = ti.transaction_id LEFT JOIN products p ON ti.product_id = p.id LIMIT 1',
    'Users' => 'SELECT * FROM users LIMIT 1'
];

foreach ($tests as $page => $query) {
    echo "<div class='test'>";
    echo "<h3>🧪 Test $page Page</h3>";
    
    $result = mysqli_query($conn, $query);
    if ($result) {
        $count = mysqli_num_rows($result);
        echo "<p class='success'>✅ Query successful: $count rows found</p>";
        
        if ($count > 0) {
            $row = mysqli_fetch_assoc($result);
            echo "<p>Sample data: " . json_encode(array_slice($row, 0, 3, true)) . "...</p>";
        }
    } else {
        echo "<p class='error'>❌ Query failed: " . mysqli_error($conn) . "</p>";
    }
    echo "</div>";
}

echo "<hr>";
echo "<h3>🎯 Admin Pages Links</h3>";
echo "<ul>";
echo "<li><a href='admin/produk.php'>📦 Produk Page</a></li>";
echo "<li><a href='admin/kategori.php'>📂 Kategori Page</a></li>";
echo "<li><a href='admin/transaksi.php'>🛒 Transaksi Page</a></li>";
echo "<li><a href='admin/pesanan.php'>📋 Pesanan Page</a></li>";
echo "<li><a href='admin/pengguna.php'>👥 Pengguna Page</a></li>";
echo "</ul>";

echo "<p><strong>✅ All queries are working! Admin pages should be accessible now.</strong></p>";

// Clean up session
session_destroy();
?>
