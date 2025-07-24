<?php
include '../backend/koneksi.php';
$id = (int)$_GET['id'];
$q = mysqli_query($conn, "SELECT * FROM produk WHERE id = $id");
$p = mysqli_fetch_assoc($q);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pemesanan - Scarlett Store</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff0f5;
    }
    .form-container {
      max-width: 600px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px #ffcce5;
    }
    input, textarea {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    button {
      background: #ff69b4;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>
<div class="form-container">
  <h2>Form Pemesanan</h2>
  <form action="proses_pemesanan.php" method="post">
    <input type="hidden" name="produk_id" value="<?= $p['id']; ?>">
    <p><strong><?= $p['nama_produk']; ?></strong></p>
    <p>Harga: Rp <?= number_format($p['harga_produk'], 0, ',', '.'); ?></p>
    <label>Nama:</label>
    <input type="text" name="nama" required>
    <label>Alamat:</label>
    <textarea name="alamat" required></textarea>
    <label>No. Telepon (12 digit):</label>
    <input type="text" name="telepon" maxlength="12" required>
    <label>Jumlah:</label>
    <input type="number" name="jumlah" min="1" value="1" required>
    <button type="submit">Pesan Sekarang</button>
  </form>
</div>
</body>
</html>