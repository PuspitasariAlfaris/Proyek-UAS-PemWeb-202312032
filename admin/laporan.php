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
            background: linear-gradient(135deg, #ff69b4, #d63384);
            color: #fff;
            padding: 15px 25px;
            border-radius: 12px;
            text-decoration: none;
            margin: 10px;
            display: inline-block;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3);
            min-width: 200px;
            text-align: center;
        }
        .btn:hover {
            background: linear-gradient(135deg, #e754a6, #b91c5c);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 105, 180, 0.4);
        }
        .btn-special {
            background: linear-gradient(135deg, #28a745, #20c997);
            font-size: 18px;
            padding: 20px 30px;
            margin: 20px 10px;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }
        .btn-special:hover {
            background: linear-gradient(135deg, #218838, #17a2b8);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        }
        .btn-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 15px;
        }
        .divider {
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #ff69b4, transparent);
            margin: 20px 0;
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
        <h2>Pilih Laporan Scarlett Store</h2>
        
        <div class="btn-container">
            <a class="btn" href="laporan/laporan_pendapatan.php">📊 Laporan Pendapatan</a>
            <a class="btn" href="laporan/laporan_pengguna.php">👥 Laporan Pengguna</a>
            <a class="btn" href="laporan/laporan_transaksi.php">💳 Laporan Transaksi</a>
            <a class="btn" href="laporan/produk_terlaris.php">🏆 Produk Terlaris</a>
        </div>
        
        <div class="divider"></div>
        
        <div class="btn-container">
            <a class="btn btn-special" href="laporan/rekapan_keseluruhan.php">
                📈 Rekapan Keseluruhan
                <div style="font-size: 12px; margin-top: 5px; opacity: 0.9;">Ringkasan lengkap semua data sistem</div>
            </a>
        </div>
    </div>
</div>

</body>
</html>
