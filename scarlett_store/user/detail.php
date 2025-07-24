<?php
session_start();
include '../backend/koneksi.php';

$id = $_GET['id'];
$q = mysqli_query($conn, "SELECT * FROM produk WHERE id = $id");
$p = mysqli_fetch_assoc($q);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Detail Produk - <?= $p['nama_produk'] ?></title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #fff0f5;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 900px;
      margin: 30px auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px #ffcce5;
      text-align: center;
    }
    .container img {
      width: 300px;
      height: auto;
      object-fit: contain;
      margin-bottom: 20px;
    }
    .form-group {
      margin-bottom: 15px;
      text-align: left;
    }
    .form-group label {
      font-weight: bold;
      display: block;
    }
    .form-group input {
      width: 100%;
      padding: 8px;
      border-radius: 5px;
      border: 1px solid #ddd;
    }
    .total {
      font-size: 18px;
      margin: 15px 0;
      color: #d63384;
      font-weight: bold;
    }
    .btn {
      background-color: #d63384;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }
    .btn:hover {
      background-color: #b71c5f;
    }
  </style>
  <script>
    function hitungTotal() {
      var harga = <?= $p['harga_produk'] ?>;
      var qty = document.getElementById('jumlah').value;
      var total = harga * qty;
      document.getElementById('total_harga').innerText = "Total: Rp " + total.toLocaleString('id-ID');
    }
  </script>
</head>
<body>

<div class="container">
  <h2><?= $p['nama_produk'] ?></h2>
  <img src="../assets/img/<?= $p['gambar_produk'] ?>" alt="<?= $p['nama_produk'] ?>">
  <p><b>Rp <?= number_format($p['harga_produk'], 0, ",", "."); ?></b></p>
  <p><?= $p['deskripsi'] ?></p>

  <form action="proses_pesan.php" method="post">
    <input type="hidden" name="id_produk" value="<?= $p['id'] ?>">
    <div class="form-group">
      <label>Nama</label>
      <input type="text" name="nama" required>
    </div>
    <div class="form-group">
      <label>Alamat</label>
      <input type="text" name="alamat" required>
    </div>
    <div class="form-group">
      <label>No Telepon</label>
      <input type="text" name="telepon" maxlength="12" required>
    </div>
    <div class="form-group">
      <label>Jumlah Beli</label>
      <input type="number" name="jumlah" id="jumlah" min="1" value="1" onchange="hitungTotal()" required>
    </div>
    <div class="total" id="total_harga">
      Total: Rp <?= number_format($p['harga_produk'], 0, ",", "."); ?>
    </div>
    <button type="submit" class="btn">Beli Sekarang</button>
  </form>
</div>

</body>
</html>