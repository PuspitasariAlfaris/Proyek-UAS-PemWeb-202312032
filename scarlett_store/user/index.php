<?php
session_start();
include '../auth/cek_login.php';
include '../backend/koneksi.php';

// Proteksi role hanya untuk user
if ($_SESSION['role'] != 'user') {
    header("Location: ../admin/index.php");
    exit;
}

$produk = mysqli_query($conn, "SELECT * FROM produk LIMIT 10");
$testimoni = mysqli_query($conn, "SELECT * FROM testimoni LIMIT 10");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Scarlett Store - Home</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff0f5;
      margin: 0;
      padding: 0;
    }

    .header {
      background-color: #ff69b4;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1px 30px;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 999;
      height: 80px;
    }

    .logo-container {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .logo-container img {
      width: 140px;
      height: auto;
    }

    .logo-container span {
      font-size: 28px;
      color: white;
      font-weight: bold;
    }

    .logout-btn {
      background-color: white;
      color: #ff69b4;
      padding: 8px 16px;
      border: none;
      border-radius: 20px;
      font-size: 14px;
      cursor: pointer;
      font-weight: bold;
      transition: 0.3s;
    }

    .logout-btn:hover {
      background-color: #ffe6f0;
    }

    .slider {
      margin-top: 0;
      width: 100%;
      height: calc(100vh - 80px);
      overflow: hidden;
      position: relative;
    }

    .slides {
      display: flex;
      width: 200%;
      height: 100%;
      animation: slide 10s infinite;
    }

    .slides img {
      width: 50%;
      height: 100%;
      object-fit: cover;
    }

    @keyframes slide {
      0%, 45% { transform: translateX(0%); }
      55%, 100% { transform: translateX(-50%); }
    }

    h2.section-title {
      text-align: center;
      color: #d63384;
      margin: 40px 0 20px;
      font-size: 30px;
      font-weight: bold;
    }

    .produk-container {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      justify-content: center;
      padding: 0 20px 40px;
    }

    .produk-item {
      background: white;
      border-radius: 10px;
      padding: 15px;
      box-shadow: 0 0 10px #ffcce5;
      text-align: center;
    }

    .produk-item img {
      width: 100%;
      height: 200px;
      object-fit: contain;
      border-radius: 8px;
      margin-bottom: 10px;
    }

    .produk-item h4 {
      margin: 10px 0 5px;
      color: #d63384;
      font-size: 16px;
      min-height: 40px;
    }

    .produk-item p {
      color: #555;
      margin: 0;
      font-size: 14px;
    }

    .btn-detail {
      margin-top: 10px;
      padding: 8px 16px;
      background-color: #ff69b4;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      font-size: 14px;
      display: inline-block;
    }

    .row-center {
      grid-column: 2 / span 2;
      display: flex;
      justify-content: center;
      gap: 20px;
    }

    .row-center .produk-item {
      width: 220px;
    }

    .testimoni-table {
      margin: 0 auto 60px;
      border-spacing: 30px;
      table-layout: fixed;
      width: 100%;
    }

    .testimoni-item {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 0 10px #ffcce5;
      text-align: center;
      height: 100%;
    }

    .testimoni-item img {
      width: 100%;
      height: 200px;
      object-fit: contain;
      background-color: #f8f8f8;
      border-radius: 10px;
      margin-bottom: 15px;
    }

    .testimoni-item p {
      color: #333;
      font-size: 16px;
      margin: 0;
      line-height: 1.4;
    }

    footer {
      background: #ff69b4;
      text-align: center;
      padding: 15px;
      color: white;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="header">
  <div class="logo-container">
    <img src="../assets/img/logo.png" alt="Logo Scarlett">
    <span>Scarlett Store</span>
  </div>
  <form action="../auth/logout.php" method="post">
    <button type="submit" class="logout-btn">Logout</button>
  </form>
</div>

<div class="slider">
  <div class="slides">
    <img src="../assets/img/slider1.jpeg" alt="Slider 1">
    <img src="../assets/img/slider2.jpg" alt="Slider 2">
  </div>
</div>

<h2 class="section-title">Daftar Produk</h2>

<div class="produk-container">
  <?php
    $no = 0;
    while ($p = mysqli_fetch_assoc($produk)):
      $no++;
      if ($no === 9) echo '<div class="row-center">';
  ?>
      <div class="produk-item">
        <img src="../assets/img/<?= htmlspecialchars($p['gambar_produk']); ?>" alt="<?= htmlspecialchars($p['nama_produk']); ?>">
        <h4><?= htmlspecialchars($p['nama_produk']); ?></h4>
        <p><b>Rp <?= number_format($p['harga_produk'], 0, ",", "."); ?></b></p>
        <a href="detail.php?id=<?= $p['id']; ?>" class="btn-detail">Lihat Detail</a>
      </div>
  <?php
      if ($no === 10) echo '</div>';
    endwhile;
  ?>
</div>

<h2 class="section-title">Testimoni Pengguna</h2>

<table class="testimoni-table">
  <colgroup>
    <col style="width: 50%;">
    <col style="width: 50%;">
  </colgroup>
  <tr>
    <td>
      <div class="testimoni-item">
        <img src="../assets/img/testimoni1.webp" alt="Testimoni">
        <p>Produk Scarlett bikin kulitku makin glowing dan sehat. Recomended banget</p>
      </div>
    </td>
    <td>
      <div class="testimoni-item">
        <img src="../assets/img/testimoni2.jpg" alt="Testimoni">
        <p>Suka banget sama produknya kulit saya jauh lebih baik love banget deh buat scarlet</p>
      </div>
    </td>
  </tr>
  <tr>
    <td>
      <div class="testimoni-item">
        <img src="../assets/img/testimoni3.jpeg" alt="Testimoni">
        <p>Scarlett bikin kulit cerah dan lembab. Hasilnya kerasa banget setelah rutin pakai</p>
      </div>
    </td>
    <td>
      <div class="testimoni-item">
        <img src="../assets/img/testimoni4.jpg" alt="Testimoni">
        <p>Kualitas produknya super! Kulit makin halus, glowing, dan wangi seharian.</p>
      </div>
    </td>
  </tr>
</table>

<footer>
  BY PUSPITASARI ALFARIS
</footer>

</body>
</html>