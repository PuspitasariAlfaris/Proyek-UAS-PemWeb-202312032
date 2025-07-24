<?php
include '../auth/cek_login.php';
include '../backend/koneksi.php';

// Cek role
if ($_SESSION['role'] != 'admin') {
    header("Location: ../user/index.php");
    exit;
}
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
    <h1>Selamat Datang, Admin <?= htmlspecialchars($_SESSION['username']); ?>!</h1>

    <div class="card">
        <h2>Statistik Data</h2>

        <table>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
            </tr>
            <?php
            $produk_list = mysqli_query($conn, "SELECT nama_produk FROM produk");
            $no = 1;
            while ($p = mysqli_fetch_assoc($produk_list)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($p['nama_produk']) . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>