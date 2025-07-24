<?php
include '../auth/cek_login.php';
include '../backend/koneksi.php';

// Cek role admin
cek_role('admin');

// Log aktivitas
log_aktivitas($conn, 'Akses Dashboard', 'Admin mengakses halaman dashboard');

// Ambil statistik data
$total_produk = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products"))['total'];
$total_user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role='user'"))['total'];
$total_transaksi = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM transactions"))['total'];
$total_kategori = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM categories"))['total'];

// Ambil transaksi terbaru
$transaksi_terbaru = mysqli_query($conn, "
    SELECT t.*, u.name as nama_user, p.name as nama_produk, ti.quantity as jumlah, t.total_amount as total_harga, t.created_at as tanggal 
    FROM transactions t 
    LEFT JOIN users u ON t.user_id = u.id 
    LEFT JOIN transaction_items ti ON t.id = ti.transaction_id
    LEFT JOIN products p ON ti.product_id = p.id 
    ORDER BY t.created_at DESC 
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Scarlett Store</title>
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
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #ff80b3;
        }

        .main-content {
            margin-left: 240px;
            padding: 30px;
            text-align: center;
        }

        h1 {
            color: #d63384;
            margin-bottom: 30px;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            margin: 0 auto;
            max-width: 700px;
            box-shadow: 0 0 10px #ffcce5;
            text-align: left;
        }

        .card h2 {
            color: #d63384;
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ffb6c1;
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }

        th {
            background-color: #ffcce5;
            color: #99004d;
        }

        tr:nth-child(even) {
            background-color: #fff0f5;
        }

        tr:nth-child(odd) {
            background-color: #ffffff;
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px #ffcce5;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            font-size: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #ff69b4, #d63384);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .stat-info h3 {
            margin: 0;
            font-size: 24px;
            color: #d63384;
            font-weight: bold;
        }
        
        .stat-info p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 14px;
        }
        
        .status-completed {
            background-color: #28a745;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        
        .status-pending {
            background-color: #ffc107;
            color: #212529;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        
        .status-cancelled {
            background-color: #dc3545;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="index.php">Dashboard</a>
    <a href="produk.php">Produk</a>
    <a href="kategori.php">Kategori</a>
    <a href="transaksi.php">Transaksi</a>
    <a href="pesanan.php">Pesanan</a>
    <a href="pengguna.php">Pengguna</a>
    <a href="log.php">Log</a>
    <a href="laporan.php">Laporan</a>
    <a href="../auth/logout.php">Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <h1>Selamat Datang, <?= htmlspecialchars($_SESSION['nama']); ?>!</h1>
    <p style="text-align: center; color: #666; margin-bottom: 30px;">Dashboard Administrator Scarlett Store</p>

    <!-- Statistik Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon">📦</div>
            <div class="stat-info">
                <h3><?= $total_produk ?></h3>
                <p>Total Produk</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-info">
                <h3><?= $total_user ?></h3>
                <p>Total User</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🛒</div>
            <div class="stat-info">
                <h3><?= $total_transaksi ?></h3>
                <p>Total Transaksi</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">📂</div>
            <div class="stat-info">
                <h3><?= $total_kategori ?></h3>
                <p>Total Kategori</p>
            </div>
        </div>
    </div>

    <!-- Transaksi Terbaru -->
    <div class="card">
        <h2>Transaksi Terbaru</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($t = mysqli_fetch_assoc($transaksi_terbaru)) {
                    $status_class = $t['status'] == 'completed' ? 'status-completed' : ($t['status'] == 'pending' ? 'status-pending' : 'status-cancelled');
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($t['nama_user']) . "</td>";
                    echo "<td>" . htmlspecialchars($t['nama_produk']) . "</td>";
                    echo "<td>" . $t['jumlah'] . "</td>";
                    echo "<td>Rp " . number_format($t['total_harga'], 0, ',', '.') . "</td>";
                    echo "<td>" . date('d/m/Y H:i', strtotime($t['tanggal'])) . "</td>";
                    echo "<td><span class='$status_class'>" . ucfirst($t['status']) . "</span></td>";
                    echo "</tr>";
                }
                if (mysqli_num_rows($transaksi_terbaru) == 0) {
                    echo "<tr><td colspan='7' style='text-align: center; color: #666;'>Belum ada transaksi</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>