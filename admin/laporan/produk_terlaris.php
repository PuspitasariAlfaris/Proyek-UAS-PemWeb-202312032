<?php
include '../../auth/cek_login.php';
include '../../backend/koneksi.php';

$query = mysqli_query($conn, "
    SELECT p.name as nama_produk, SUM(ti.quantity) as total_terjual
    FROM transaction_items ti
    LEFT JOIN products p ON ti.product_id = p.id
    LEFT JOIN transactions t ON ti.transaction_id = t.id
    WHERE t.status != 'cancelled'
    GROUP BY p.id, p.name
    ORDER BY total_terjual DESC
    LIMIT 10
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Produk Terlaris - Scarlett Store</title>
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
    <div class="card">
        <h2>Produk Terlaris Scarlett Store</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Total Terjual</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                    echo "<td>".$no++."</td>";
                    echo "<td>".htmlspecialchars($row['nama_produk'])."</td>";
                    echo "<td>".htmlspecialchars($row['total_terjual'])."</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>