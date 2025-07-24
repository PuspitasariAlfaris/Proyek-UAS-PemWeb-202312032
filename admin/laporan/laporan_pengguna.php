<?php
include '../../auth/cek_login.php';
include '../../backend/koneksi.php';

// Cek jika request PDF
if (isset($_GET['pdf'])) {
    include 'pdf_helper.php';
    
    // Query untuk data pengguna
    $query = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");
    
    // Siapkan data untuk PDF
    $data = [];
    $total_users = 0;
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = [
            $row['username'],
            $row['email'],
            $row['nama'] ?? 'Belum diisi',
            ucfirst($row['role']),
            date('d/m/Y', strtotime($row['created_at'] ?? date('Y-m-d')))
        ];
        $total_users++;
    }
    
    // Buat PDF
    $pdf = new PDFHelper('Laporan Data Pengguna');
    $pdf->addSummary('
        <strong>Total Pengguna:</strong> ' . $total_users . ' orang<br>
        <strong>Tanggal Laporan:</strong> ' . date('d/m/Y') . '<br>
        <strong>Status:</strong> Semua pengguna aktif
    ');
    
    $headers = ['Username', 'Email', 'Nama Lengkap', 'Role', 'Tanggal Daftar'];
    $pdf->setData($data, $headers);
    $pdf->generate('laporan_pengguna_' . date('Y-m-d') . '.pdf');
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengguna - Scarlett Store</title>
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
        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ffcce5;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            color: #d63384;
            margin: 0;
        }
        .btn {
            background: linear-gradient(135deg, #ff69b4, #d63384);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 105, 180, 0.4);
        }
        .btn-pdf {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }
        .btn-pdf:hover {
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
        }
        .pdf-icon {
            width: 16px;
            height: 16px;
        }
        .card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px #ffcce5;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ffcce5;
            text-align: center;
        }
        .stat-card h3 {
            color: #d63384;
            margin: 0 0 10px 0;
            font-size: 18px;
        }
        .stat-card .value {
            font-size: 24px;
            font-weight: bold;
            color: #ff69b4;
        }
        .role-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .role-admin {
            background-color: #ff69b4;
            color: white;
        }
        .role-user {
            background-color: #28a745;
            color: white;
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
    <div class="header">
        <h1>👥 Laporan Data Pengguna</h1>
        <div>
            <a href="?pdf=1" class="btn btn-pdf">
                <svg class="pdf-icon" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                </svg>
                Cetak PDF
            </a>
            <a href="../laporan.php" class="btn">← Kembali</a>
        </div>
    </div>

    <?php
    // Hitung statistik
    mysqli_data_seek($query, 0); // Reset pointer
    $total_users = 0;
    $admin_count = 0;
    $user_count = 0;
    
    while ($row = mysqli_fetch_assoc($query)) {
        $total_users++;
        if ($row['role'] == 'admin') $admin_count++;
        else $user_count++;
    }
    mysqli_data_seek($query, 0); // Reset pointer lagi
    ?>

    <div class="stats">
        <div class="stat-card">
            <h3>Total Pengguna</h3>
            <div class="value"><?= $total_users ?></div>
        </div>
        <div class="stat-card">
            <h3>Admin</h3>
            <div class="value"><?= $admin_count ?></div>
        </div>
        <div class="stat-card">
            <h3>User</h3>
            <div class="value"><?= $user_count ?></div>
        </div>
    </div>

    <div class="card">
        <h2>Detail Data Pengguna</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Nama Lengkap</th>
                    <th>Role</th>
                    <th>Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                    echo "<td>".$no++."</td>";
                    echo "<td>".htmlspecialchars($row['username'])."</td>";
                    echo "<td>".htmlspecialchars($row['email'])."</td>";
                    echo "<td>".htmlspecialchars($row['nama'] ?? 'Belum diisi')."</td>";
                    echo "<td><span class='role-badge role-".$row['role']."'>".ucfirst($row['role'])."</span></td>";
                    echo "<td>".date('d/m/Y', strtotime($row['created_at'] ?? date('Y-m-d')))."</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>