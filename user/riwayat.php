<?php
session_start();
include '../auth/cek_login.php';
include '../backend/koneksi.php';

$user_id = $_SESSION['user_id'];
$query = "SELECT t.*, ti.quantity as jumlah, ti.unit_price as harga, p.name as nama_produk, t.created_at as tanggal
          FROM transactions t 
          JOIN transaction_items ti ON t.id = ti.transaction_id
          JOIN products p ON ti.product_id = p.id 
          WHERE t.user_id = $user_id 
          ORDER BY t.created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Pembelian - Scarlett Store</title>
  <style>
    body {
      background-color: #fff0f5;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
    }
    h2 {
      text-align: center;
      color: #d63384;
      margin-top: 30px;
    }
    table {
      width: 90%;
      margin: 30px auto;
      border-collapse: collapse;
      background: #fff;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      border-radius: 10px;
      overflow: hidden;
    }
    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #eee;
    }
    th {
      background-color: #d63384;
      color: white;
    }
    tr:hover {
      background-color: #fce4ec;
    }
    .btn-back {
      background-color: #ff69b4;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 5px;
      display: inline-block;
      margin: 20px auto;
      font-weight: bold;
      transition: background-color 0.3s;
    }
    .btn-back:hover {
      background-color: #e754a6;
    }
    .button-container {
      text-align: center;
      margin-top: 20px;
    }
  </style>
</head>
<body>

<h2>Riwayat Pembelian Anda </h2>

<table>
  <tr>
    <th>No</th>
    <th>Produk</th>
    <th>Harga</th>
    <th>Jumlah</th>
    <th>Total</th>
    <th>Tanggal</th>
  </tr>
  <?php
  $no = 1;
  while ($row = mysqli_fetch_assoc($result)) {
    $total = $row['jumlah'] * $row['harga'];
    echo "<tr>
            <td>{$no}</td>
            <td>{$row['nama_produk']}</td>
            <td>Rp " . number_format($row['harga']) . "</td>
            <td>{$row['jumlah']}</td>
            <td>Rp " . number_format($total) . "</td>
            <td>{$row['tanggal']}</td>
          </tr>";
    $no++;
  }
  ?>
</table>

<div class="button-container">
  <a href="index.php" class="btn-back">← Kembali ke Halaman Utama</a>
</div>

</body>
</html>