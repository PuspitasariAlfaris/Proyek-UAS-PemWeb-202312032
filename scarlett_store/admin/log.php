<?php
include '../auth/cek_login.php';
include '../backend/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Log Aktivitas - Scarlett Store</title>
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
        .card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px #ffcce5;
        }
        h2 {
            color: #d63384;
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ffb6c1;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #ffcce5;
            color: #99004d;
        }
        tr:hover {
            background-color: #fff0f5;
        }
    </style>
</head>
<body>

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

<div class="main-content">
    <div class="card">
        <h2>Aktivitas Terbaru (Detail Transaksi)</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama User</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($conn, "
                    SELECT 
                        u.nama AS nama_user,
                        p.nama_produk AS nama_produk,
                        t.jumlah,
                        t.total_harga,
                        t.tanggal
                    FROM transaksi t
                    LEFT JOIN users u ON t.user_id = u.id
                    LEFT JOIN produk p ON t.produk_id = p.id
                    ORDER BY t.tanggal DESC
                    LIMIT 10
                ");

                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nama_user']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_produk']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['jumlah']) . "</td>";
                    echo "<td>Rp " . number_format($row['total_harga'], 0, ",", ".") . "</td>";
                    echo "<td>" . htmlspecialchars($row['tanggal']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>