<?php 
include '../auth/cek_login.php';
include '../backend/koneksi.php';

// Ambil data users
$users = mysqli_query($conn, "SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pengguna - Scarlett Store</title>
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
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }
        .card {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px #ffcce5;
            width: 900px;
        }
        .header-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .header-container h2 {
            color: #d63384;
            margin-bottom: 10px;
        }
        .header-container .btn {
            display: inline-block;
            background-color: #ff69b4;
            color: #fff;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
            font-size: 16px;
        }
        .header-container .btn:hover {
            background-color: #e754a6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
        .btn-action {
            background-color: #ff69b4;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-action:hover {
            background-color: #e754a6;
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
        <div class="header-container">
            <h2>Data Pengguna Scarlett Store</h2>
            <a class="btn" href="tambah_pengguna.php">+ Tambah Pengguna</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($users)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars(ucfirst($row['role'])) . "</td>";
                    echo "<td>
                        <a class='btn-action' href='edit_pengguna.php?id=" . $row['id'] . "'>Edit</a>
                        <a class='btn-action' href='hapus_pengguna.php?id=" . $row['id'] . "' onclick=\"return confirm('Yakin hapus pengguna?')\">Hapus</a>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>