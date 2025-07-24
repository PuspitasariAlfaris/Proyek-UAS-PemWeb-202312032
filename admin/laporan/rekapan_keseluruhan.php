<?php
include '../../auth/cek_login.php';
include '../../backend/koneksi.php';

// Cek jika request PDF download
if (isset($_GET['download_pdf'])) {
    include 'pdf_helper.php';
    
    // Hitung semua statistik
    $total_users_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
    $total_users = mysqli_fetch_assoc($total_users_query)['total'] ?? 0;
    
    $admin_count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'admin'");
    $admin_count = mysqli_fetch_assoc($admin_count_query)['total'] ?? 0;
    
    $user_count = $total_users - $admin_count;
    
    $total_produk_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM products");
    $total_produk = mysqli_fetch_assoc($total_produk_query)['total'] ?? 0;
    
    $total_transaksi_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM transactions");
    $total_transaksi = mysqli_fetch_assoc($total_transaksi_query)['total'] ?? 0;
    
    $transaksi_selesai_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM transactions WHERE status = 'delivered'");
    $transaksi_selesai = mysqli_fetch_assoc($transaksi_selesai_query)['total'] ?? 0;
    
    $total_pendapatan_query = mysqli_query($conn, "SELECT SUM(total_amount) as total FROM transactions WHERE status = 'delivered'");
    $total_pendapatan = mysqli_fetch_assoc($total_pendapatan_query)['total'] ?? 0;
    
    // Produk terlaris
    $produk_terlaris_query = mysqli_query($conn, "
        SELECT p.name as nama_produk, COUNT(ti.id) as total_terjual, SUM(ti.quantity) as total_qty
        FROM products p 
        LEFT JOIN transaction_items ti ON p.id = ti.product_id 
        LEFT JOIN transactions t ON ti.transaction_id = t.id
        WHERE t.status = 'delivered' 
        GROUP BY p.id, p.name 
        ORDER BY total_qty DESC 
        LIMIT 5
    ");
    
    $produk_terlaris = [];
    while ($row = mysqli_fetch_assoc($produk_terlaris_query)) {
        $produk_terlaris[] = [
            $row['nama_produk'],
            $row['total_terjual'] ?? 0
        ];
    }
    
    // Buat PDF
    $pdf = new PDFHelper('Rekapan Keseluruhan Sistem');
    $pdf->addSummary(
        '<strong>Total Pengguna:</strong> ' . $total_users . ' orang (Admin: ' . $admin_count . ', User: ' . $user_count . ')<br>' .
        '<strong>Total Produk:</strong> ' . $total_produk . ' produk<br>' .
        '<strong>Total Transaksi:</strong> ' . $total_transaksi . ' (Selesai: ' . $transaksi_selesai . ')<br>' .
        '<strong>Total Pendapatan:</strong> Rp ' . number_format($total_pendapatan, 0, ',', '.') . '<br>' .
        '<strong>Tanggal Laporan:</strong> ' . date('d/m/Y H:i:s')
    );
    
    $headers = ['Produk Terlaris', 'Total Terjual'];
    $pdf->setData($produk_terlaris, $headers);
    $pdf->generate('rekapan_keseluruhan_' . date('Y-m-d') . '.pdf');
    exit;
}

// Cek jika request preview PDF
$show_preview = isset($_GET['preview']);
if ($show_preview) {
    // Ambil data untuk preview
    $preview_total_users_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
    $preview_total_users = mysqli_fetch_assoc($preview_total_users_query)['total'] ?? 0;
    
    $preview_admin_count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'admin'");
    $preview_admin_count = mysqli_fetch_assoc($preview_admin_count_query)['total'] ?? 0;
    
    $preview_user_count = $preview_total_users - $preview_admin_count;
    
    $preview_total_produk_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM products");
    $preview_total_produk = mysqli_fetch_assoc($preview_total_produk_query)['total'] ?? 0;
    
    $preview_total_transaksi_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM transactions");
    $preview_total_transaksi = mysqli_fetch_assoc($preview_total_transaksi_query)['total'] ?? 0;
    
    $preview_transaksi_selesai_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM transactions WHERE status = 'delivered'");
    $preview_transaksi_selesai = mysqli_fetch_assoc($preview_transaksi_selesai_query)['total'] ?? 0;
    
    $preview_total_pendapatan_query = mysqli_query($conn, "SELECT SUM(total_amount) as total FROM transactions WHERE status = 'delivered'");
    $preview_total_pendapatan = mysqli_fetch_assoc($preview_total_pendapatan_query)['total'] ?? 0;
    
    // Produk terlaris untuk preview
    $preview_produk_terlaris_query = mysqli_query($conn, "
        SELECT p.name as nama_produk, COUNT(ti.id) as total_terjual, SUM(ti.quantity) as total_qty
        FROM products p 
        LEFT JOIN transaction_items ti ON p.id = ti.product_id 
        LEFT JOIN transactions t ON ti.transaction_id = t.id
        WHERE t.status = 'delivered' 
        GROUP BY p.id, p.name 
        ORDER BY total_qty DESC 
        LIMIT 5
    ");
}

// Query untuk data tampilan
$total_users_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$total_users = mysqli_fetch_assoc($total_users_query)['total'] ?? 0;

$admin_count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role = 'admin'");
$admin_count = mysqli_fetch_assoc($admin_count_query)['total'] ?? 0;

$user_count = $total_users - $admin_count;

$total_produk_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM products");
$total_produk = mysqli_fetch_assoc($total_produk_query)['total'] ?? 0;

$total_transaksi_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM transactions");
$total_transaksi = mysqli_fetch_assoc($total_transaksi_query)['total'] ?? 0;

$transaksi_pending_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM transactions WHERE status = 'pending'");
$transaksi_pending = mysqli_fetch_assoc($transaksi_pending_query)['total'] ?? 0;

$transaksi_selesai_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM transactions WHERE status = 'delivered'");
$transaksi_selesai = mysqli_fetch_assoc($transaksi_selesai_query)['total'] ?? 0;

$transaksi_batal_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM transactions WHERE status = 'cancelled'");
$transaksi_batal = mysqli_fetch_assoc($transaksi_batal_query)['total'] ?? 0;

$total_pendapatan_query = mysqli_query($conn, "SELECT SUM(total_amount) as total FROM transactions WHERE status = 'delivered'");
$total_pendapatan = mysqli_fetch_assoc($total_pendapatan_query)['total'] ?? 0;

$pendapatan_hari_ini_query = mysqli_query($conn, "SELECT SUM(total_amount) as total FROM transactions WHERE status = 'delivered' AND DATE(created_at) = CURDATE()");
$pendapatan_hari_ini = mysqli_fetch_assoc($pendapatan_hari_ini_query)['total'] ?? 0;

// Produk terlaris
$produk_terlaris_query = mysqli_query($conn, "
    SELECT p.name as nama_produk, p.price as harga, COUNT(ti.id) as total_terjual, SUM(ti.quantity) as total_qty
    FROM products p 
    LEFT JOIN transaction_items ti ON p.id = ti.product_id 
    LEFT JOIN transactions t ON ti.transaction_id = t.id
    WHERE t.status = 'delivered' 
    GROUP BY p.id, p.name, p.price 
    ORDER BY total_qty DESC 
    LIMIT 10
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekapan Keseluruhan - Scarlett Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #fff0f5;
        }
        .sidebar {
            width: 220px;
            background-color: #ff5da2;
            color: white;
            position: fixed;
            height: 100%;
            padding-top: 30px;
        }
        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
            color: #fff;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            font-size: 16px;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background-color: #ff80b3;
        }
        .main-content {
            margin-left: 240px;
            padding: 30px;
        }
        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ffcce5;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            color: #d63384;
            margin: 0;
        }
        .btn {
            background: linear-gradient(135deg, #ff69b4, #d63384);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 105, 180, 0.4);
        }
        .btn-pdf {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }
        .btn-pdf:hover {
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
        }
        .pdf-icon {
            width: 16px;
            height: 16px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(255, 105, 180, 0.2);
            text-align: center;
            border-left: 5px solid #ff69b4;
            transition: transform 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(255, 105, 180, 0.3);
        }
        .stat-card.highlight {
            border-left-color: #28a745;
            background: linear-gradient(135deg, #f8fff8, #e8f5e8);
        }
        .stat-card.warning {
            border-left-color: #ffc107;
            background: linear-gradient(135deg, #fffef8, #fff8e8);
        }
        .stat-card.danger {
            border-left-color: #dc3545;
            background: linear-gradient(135deg, #fff8f8, #ffe8e8);
        }
        .stat-card h3 {
            color: #d63384;
            margin: 0 0 15px 0;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .stat-card .value {
            font-size: 32px;
            font-weight: bold;
            color: #ff69b4;
            margin-bottom: 10px;
        }
        .stat-card .desc {
            color: #666;
            font-size: 12px;
        }
        .table-container {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(255, 105, 180, 0.2);
            margin-bottom: 30px;
        }
        .table-container h2 {
            color: #d63384;
            margin: 0 0 20px 0;
            font-size: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ffb6c1;
            padding: 12px;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #ffcce5;
            color: #d63384;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #fff0f5;
        }
        tr:hover {
            background-color: #ffe6f0;
        }
        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 40px;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            animation: fadeIn 0.3s;
        }
        
        @keyframes fadeIn {
            from {opacity: 0}
            to {opacity: 1}
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 0;
            border-radius: 15px;
            width: 80%;
            max-width: 800px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            animation: slideIn 0.3s;
        }
        
        @keyframes slideIn {
            from {transform: translateY(-50px); opacity: 0}
            to {transform: translateY(0); opacity: 1}
        }
        
        .modal-header {
            background: linear-gradient(135deg, #ff69b4, #d63384);
            color: white;
            padding: 20px;
            border-radius: 15px 15px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .modal-header h2 {
            margin: 0;
            font-size: 24px;
        }
        
        .close {
            color: white;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }
        
        .close:hover {
            color: #ffcce5;
        }
        
        .modal-body {
            padding: 30px;
            max-height: 60vh;
            overflow-y: auto;
        }
        
        .preview-section {
            margin-bottom: 25px;
            padding: 20px;
            border: 2px solid #ffcce5;
            border-radius: 10px;
            background: #fff0f5;
        }
        
        .preview-section h3 {
            color: #d63384;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .preview-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .preview-stat {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border-left: 4px solid #ff69b4;
        }
        
        .preview-stat .label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .preview-stat .value {
            font-size: 20px;
            font-weight: bold;
            color: #d63384;
        }
        
        .preview-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        
        .preview-table th,
        .preview-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 13px;
        }
        
        .preview-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        
        .modal-footer {
            padding: 20px 30px;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="../index.php">Dashboard</a>
    <a href="../produk.php">Produk</a>
    <a href="../kategori.php">Kategori</a>
    <a href="../transaksi.php">Transaksi</a>
    <a href="../pesanan.php">Pesanan</a>
    <a href="../pengguna.php">Pengguna</a>
    <a href="../log.php">Log</a>
    <a href="../laporan.php">Laporan</a>
    <a href="../../auth/logout.php">Logout</a>
</div>

<div class="main-content">
    <div class="header">
        <h1>📊 Rekapan Keseluruhan Sistem</h1>
        <div>
            <button onclick="showPreview()" class="btn btn-pdf">
                <svg class="pdf-icon" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                </svg>
                Cetak PDF
            </button>
            <a href="../laporan.php" class="btn">← Kembali</a>
        </div>
    </div>

    <!-- Statistik Pengguna -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Pengguna</h3>
            <div class="value"><?= $total_users ?></div>
            <div class="desc">Seluruh pengguna sistem</div>
        </div>
        <div class="stat-card">
            <h3>Administrator</h3>
            <div class="value"><?= $admin_count ?></div>
            <div class="desc">Pengguna dengan akses admin</div>
        </div>
        <div class="stat-card">
            <h3>User Biasa</h3>
            <div class="value"><?= $user_count ?></div>
            <div class="desc">Pengguna pelanggan</div>
        </div>
        <div class="stat-card">
            <h3>Total Produk</h3>
            <div class="value"><?= $total_produk ?></div>
            <div class="desc">Produk dalam katalog</div>
        </div>
    </div>

    <!-- Statistik Transaksi -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Transaksi</h3>
            <div class="value"><?= $total_transaksi ?></div>
            <div class="desc">Semua transaksi</div>
        </div>
        <div class="stat-card warning">
            <h3>Pending</h3>
            <div class="value"><?= $transaksi_pending ?></div>
            <div class="desc">Menunggu pembayaran</div>
        </div>
        <div class="stat-card highlight">
            <h3>Selesai</h3>
            <div class="value"><?= $transaksi_selesai ?></div>
            <div class="desc">Transaksi berhasil</div>
        </div>
        <div class="stat-card danger">
            <h3>Dibatalkan</h3>
            <div class="value"><?= $transaksi_batal ?></div>
            <div class="desc">Transaksi batal</div>
        </div>
    </div>

    <!-- Statistik Pendapatan -->
    <div class="stats-grid">
        <div class="stat-card highlight" style="grid-column: span 2;">
            <h3>Total Pendapatan</h3>
            <div class="value" style="font-size: 28px;">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></div>
            <div class="desc">Pendapatan keseluruhan dari transaksi selesai</div>
        </div>
        <div class="stat-card">
            <h3>Pendapatan Hari Ini</h3>
            <div class="value" style="font-size: 20px;">Rp <?= number_format($pendapatan_hari_ini, 0, ',', '.') ?></div>
            <div class="desc">Pendapatan hari ini</div>
        </div>
    </div>

    <!-- Tabel Produk Terlaris -->
    <div class="table-container">
        <h2>🏆 Top 10 Produk Terlaris</h2>
        <?php if (mysqli_num_rows($produk_terlaris_query) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Total Transaksi</th>
                        <th>Total Qty Terjual</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $rank = 1;
                    mysqli_data_seek($produk_terlaris_query, 0);
                    while ($row = mysqli_fetch_assoc($produk_terlaris_query)): 
                    ?>
                    <tr>
                        <td style="text-align: center; font-weight: bold; color: #ff69b4;">#<?= $rank++ ?></td>
                        <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td><?= $row['total_terjual'] ?? 0 ?></td>
                        <td style="font-weight: bold; color: #28a745;"><?= $row['total_qty'] ?? 0 ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">Belum ada data produk terlaris</div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Preview PDF -->
<div id="previewModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Preview Laporan PDF</h2>
            <span class="close" onclick="closePreview()">&times;</span>
        </div>
        <div class="modal-body">
            <div class="preview-section">
                <h3>📊 Ringkasan Sistem</h3>
                <div class="preview-stats">
                    <div class="preview-stat">
                        <div class="label">Total Pengguna</div>
                        <div class="value"><?= $total_users ?></div>
                    </div>
                    <div class="preview-stat">
                        <div class="label">Administrator</div>
                        <div class="value"><?= $admin_count ?></div>
                    </div>
                    <div class="preview-stat">
                        <div class="label">User Biasa</div>
                        <div class="value"><?= $user_count ?></div>
                    </div>
                    <div class="preview-stat">
                        <div class="label">Total Produk</div>
                        <div class="value"><?= $total_produk ?></div>
                    </div>
                    <div class="preview-stat">
                        <div class="label">Total Transaksi</div>
                        <div class="value"><?= $total_transaksi ?></div>
                    </div>
                    <div class="preview-stat">
                        <div class="label">Transaksi Selesai</div>
                        <div class="value"><?= $transaksi_selesai ?></div>
                    </div>
                    <div class="preview-stat">
                        <div class="label">Total Pendapatan</div>
                        <div class="value">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></div>
                    </div>
                    <div class="preview-stat">
                        <div class="label">Tanggal Laporan</div>
                        <div class="value"><?= date('d/m/Y H:i:s') ?></div>
                    </div>
                </div>
            </div>
            
            <div class="preview-section">
                <h3>🏆 Top 5 Produk Terlaris</h3>
                <?php 
                mysqli_data_seek($produk_terlaris_query, 0);
                $has_data = false;
                ?>
                <table class="preview-table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Nama Produk</th>
                            <th>Total Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $rank = 1;
                        $count = 0;
                        while ($row = mysqli_fetch_assoc($produk_terlaris_query) && $count < 5): 
                            $has_data = true;
                            $count++;
                        ?>
                        <tr>
                            <td>#<?= $rank++ ?></td>
                            <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                            <td><?= $row['total_qty'] ?? 0 ?></td>
                        </tr>
                        <?php endwhile; ?>
                        <?php if (!$has_data): ?>
                        <tr>
                            <td colspan="3" style="text-align: center; color: #666; font-style: italic;">Belum ada data produk terlaris</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button onclick="closePreview()" class="btn-secondary">Tutup</button>
            <a href="?download_pdf=1" class="btn btn-pdf">Download PDF</a>
        </div>
    </div>
</div>

<script>
function showPreview() {
    document.getElementById('previewModal').style.display = 'block';
}

function closePreview() {
    document.getElementById('previewModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('previewModal');
    if (event.target === modal) {
        closePreview();
    }
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closePreview();
    }
});
</script>

</body>
</html>
