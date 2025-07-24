<?php
include '../auth/cek_login.php';
include '../backend/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Transaksi - Scarlett Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background: #fff0f5;
            font-family: 'Poppins', sans-serif;
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
            margin-left: 220px;
            padding: 30px;
        }

        .page-title {
            font-size: 28px;
            color: #d63384;
            text-align: center;
            margin: 20px 0;
        }

        .button-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .table-container {
            display: flex;
            justify-content: center;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px #ffc1d3;
            border-radius: 10px;
            overflow: hidden;
        }

        table, th, td {
            border: 1px solid #ffb6c1;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #ffcce5;
            color: #99004d;
        }

        tr:hover {
            background-color: #fff0f5;
        }

        .btn {
            background-color: #ff69b4;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            display: inline-block;
        }

        .btn:hover {
            background-color: #e754a6;
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
    <div class="page-title">Data Transaksi Scarlett Store</div>

    <div class="button-container">
        <a class="btn" href="tambah_transaksi.php">+ Tambah Transaksi</a>
    </div>

    <div class="table-container">
        <table>
            <tr>
                <th>No</th>
                <th>ID Transaksi</th>
                <th>User ID</th>
                <th>Produk ID</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
            <?php
            $no = 1;
            $query = mysqli_query($conn, "SELECT * FROM transaksi");
            while ($row = mysqli_fetch_assoc($query)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['produk_id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['jumlah']) . "</td>";
                echo "<td>Rp " . number_format($row['total_harga'], 0, ',', '.') . "</td>";
                echo "<td>" . htmlspecialchars($row['tanggal']) . "</td>";
                echo "<td>
                        <a class='btn' href='edit_transaksi.php?id=" . $row['id'] . "'>Edit</a>
                        <a class='btn' href='hapus_transaksi.php?id=" . $row['id'] . "' onclick=\"return confirm('Yakin hapus transaksi ini?')\">Hapus</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>
