<?php
include '../../auth/cek_login.php';
include '../../backend/koneksi.php';

// Cek jika request PDF
if (isset($_GET['pdf'])) {
    include 'pdf_helper.php';
    
    // Query untuk data pendapatan
    $query = mysqli_query($conn, "
        SELECT 
            DATE(created_at) AS tanggal,
            SUM(total_amount) AS total_pendapatan
        FROM transactions
        GROUP BY DATE(created_at)
        ORDER BY tanggal DESC
    ");
    
    // Siapkan data untuk PDF
    $data = [];
    $total_keseluruhan = 0;
    while ($row = mysqli_fetch_assoc($query)) {
        $data[] = [
            date('d/m/Y', strtotime($row['tanggal'])),
            'Rp ' . number_format($row['total_pendapatan'], 0, ',', '.')
        ];
        $total_keseluruhan += $row['total_pendapatan'];
    }
    
    // Buat PDF
    $pdf = new PDFHelper('Laporan Pendapatan Harian');
    $pdf->addSummary('
        <strong>Total Keseluruhan Pendapatan:</strong> Rp ' . number_format($total_keseluruhan, 0, ',', '.') . '<br>
        <strong>Periode:</strong> ' . date('d/m/Y') . '<br>
        <strong>Jumlah Hari Transaksi:</strong> ' . count($data) . ' hari
    ');
    
    $headers = ['Tanggal', 'Total Pendapatan'];
    $pdf->setData($data, $headers);
    $pdf->generate('laporan_pendapatan_' . date('Y-m-d') . '.pdf');
    exit;
}

// Ambil pendapatan per hari
$query = mysqli_query($conn, "
    SELECT 
        DATE(created_at) AS tanggal,
        SUM(total_amount) AS total_pendapatan
    FROM transactions
    GROUP BY DATE(created_at)
    ORDER BY tanggal DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendapatan Harian - Scarlett Store</title>
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
        .card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px #ffcce5;
        }
        .pdf-icon {
            width: 16px;
            height: 16px;
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
        <h1>📊 Laporan Pendapatan Harian</h1>
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
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Total Pendapatan (Rp)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars(date("d-m-Y", strtotime($row['tanggal']))) . "</td>";
                    echo "<td>Rp " . number_format($row['total_pendapatan'], 0, ",", ".") . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>