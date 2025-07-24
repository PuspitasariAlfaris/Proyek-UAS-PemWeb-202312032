<?php
include '../auth/cek_login.php';
include '../backend/koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Kategori - Scarlett Store</title>
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
            margin: 0;
            text-align: center;
            margin-bottom: 20px;
        }

        .button-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .table-container {
            padding: 0 20px 20px 20px;
        }

        table {
            width: 60%;
            margin: 0 auto;
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
            font-size: 14px;
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
            transition: background 0.3s;
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
    <div class="page-title">Data Kategori Scarlett Store</div>
    <div class="button-container">
        <a class="btn" href="tambah_kategori.php">+ Tambah Kategori</a>
    </div>
    <div class="table-container">
        <table>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
            <?php
            $no = 1;
            $query = mysqli_query($conn, "SELECT * FROM kategori");
            while ($row = mysqli_fetch_assoc($query)) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row['nama_kategori']) . "</td>";
                echo "<td>
                    <a class='btn' href='edit_kategori.php?id=" . $row['id'] . "'>Edit</a>
                    <a class='btn' href='hapus_kategori.php?id=" . $row['id'] . "' onclick=\"return confirm('Yakin hapus kategori ini?')\">Hapus</a>
                </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>
