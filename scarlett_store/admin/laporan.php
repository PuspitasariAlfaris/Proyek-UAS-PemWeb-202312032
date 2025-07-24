<?php
include '../auth/cek_login.php';
include '../backend/koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan - Scarlett Store</title>
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
            padding: 40px;
            box-shadow: 0 0 10px #ffcce5;
            text-align: center;
        }
        .card h2 {
            color: #d63384;
            margin-bottom: 30px;
        }
        .btn {
            background-color: #ff69b4;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            margin: 10px;
            display: inline-block;
            font-size: 16px;
            transition: background 0.3s;
        }
        .btn:hover {
            background-color: #e754a6;
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
    <a href="laporan.php">Laporan</a>
    <a href="../auth/logout.php">Logout</a>
</div>

<div class="main-content">
    <div class="card">
        <h2>Pilih Laporan Scarlett Store</h2>
        <a class="btn" href="/scarlett_store/admin/laporan/laporan_pendapatan.php">Laporan Pendapatan</a>
        <a class="btn" href="laporan_pengguna.php">Laporan Pengguna</a>
        <a class="btn" href="laporan_transaksi.php">Laporan Transaksi</a>
        <a class="btn" href="produk_terlaris.php">Produk Terlaris</a>
    </div>
</div>

</body>
</html>
