<?php
include '../auth/cek_login.php';
include '../backend/koneksi.php';

// Ambil data pesanan
$query = mysqli_query($conn, "SELECT * FROM pesanan");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pesanan - Scarlett Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            background: #fff0f5;
            font-family: 'Poppins', sans-serif;
            height: 100%;
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
    <div class="page-title">Data Pesanan Scarlett Store</div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No Telepon</th>
                    <th>Jumlah Beli</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['no_telepon']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['jumlah_beli']) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
