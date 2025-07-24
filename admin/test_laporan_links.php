<?php
include '../auth/cek_login.php';

echo "<h2>Test Laporan Links</h2>";
echo "<p>Testing semua link laporan:</p>";

$links = [
    'laporan.php' => 'Menu Laporan Utama',
    'laporan/laporan_pendapatan.php' => 'Laporan Pendapatan',
    'laporan/laporan_pengguna.php' => 'Laporan Pengguna', 
    'laporan/laporan_transaksi.php' => 'Laporan Transaksi',
    'laporan/produk_terlaris.php' => 'Produk Terlaris'
];

foreach ($links as $link => $title) {
    echo "<div style='margin: 10px; padding: 10px; border: 1px solid #ccc;'>";
    echo "<strong>$title</strong><br>";
    echo "<a href='$link' target='_blank'>$link</a><br>";
    
    // Check if file exists
    $file_path = __DIR__ . '/' . $link;
    if (file_exists($file_path)) {
        echo "<span style='color: green;'>✓ File exists</span>";
    } else {
        echo "<span style='color: red;'>✗ File NOT found at: $file_path</span>";
    }
    echo "</div>";
}

echo "<h3>PDF Helper Test</h3>";
$pdf_helper_path = __DIR__ . '/laporan/pdf_helper.php';
if (file_exists($pdf_helper_path)) {
    echo "<span style='color: green;'>✓ PDF Helper exists</span>";
} else {
    echo "<span style='color: red;'>✗ PDF Helper NOT found</span>";
}
?>
