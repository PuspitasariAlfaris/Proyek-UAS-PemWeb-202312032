<?php
// Test script untuk mengecek apakah detail.php bisa mengambil data produk

include 'backend/koneksi.php';

echo "<h2>Test Koneksi Database</h2>";

// Test koneksi database
if ($conn) {
    echo "<p style='color: green;'>✓ Koneksi database berhasil</p>";
} else {
    echo "<p style='color: red;'>✗ Koneksi database gagal: " . mysqli_connect_error() . "</p>";
    exit;
}

// Test query products table
echo "<h2>Test Query Products Table</h2>";
$query = mysqli_query($conn, "SELECT * FROM products LIMIT 5");

if ($query) {
    $count = mysqli_num_rows($query);
    echo "<p style='color: green;'>✓ Query berhasil. Ditemukan $count produk (menampilkan 5 pertama)</p>";
    
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background: #f0f0f0;'><th>ID</th><th>Name</th><th>Description</th><th>Price</th><th>Image</th></tr>";
    
    while ($row = mysqli_fetch_assoc($query)) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . substr($row['description'], 0, 50) . "...</td>";
        echo "<td>Rp " . number_format($row['price'], 0, ",", ".") . "</td>";
        echo "<td>" . $row['image'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Reset pointer untuk test berikutnya
    mysqli_data_seek($query, 0);
    $first_product = mysqli_fetch_assoc($query);
    $product_id = $first_product['id'];
    
    echo "<h2>Test Link Detail</h2>";
    echo "<p>Klik link berikut untuk test halaman detail:</p>";
    echo "<a href='user/detail.php?id=$product_id' target='_blank' style='color: blue; text-decoration: underline;'>Test Detail Produk ID: $product_id</a>";
    
} else {
    echo "<p style='color: red;'>✗ Query gagal: " . mysqli_error($conn) . "</p>";
}

mysqli_close($conn);
?>
