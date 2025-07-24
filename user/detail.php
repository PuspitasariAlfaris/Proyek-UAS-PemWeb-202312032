<?php
session_start();
include '../backend/koneksi.php';

$id = $_GET['id'];
$q = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$p = mysqli_fetch_assoc($q);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Detail Produk - <?= $p['name'] ?></title>
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
    .shopping-type {
      margin: 20px 0;
      text-align: center;
    }
    .shopping-type h3 {
      color: #d63384;
      margin-bottom: 15px;
    }
    .type-buttons {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-bottom: 20px;
    }
    .type-btn {
      padding: 12px 30px;
      border: 2px solid #d63384;
      background: white;
      color: #d63384;
      border-radius: 25px;
      cursor: pointer;
      font-weight: bold;
      transition: all 0.3s;
    }
    .type-btn.active {
      background: #d63384;
      color: white;
    }
    .type-btn:hover {
      background: #d63384;
      color: white;
    }
    .form-section {
      display: none;
      margin-top: 20px;
    }
    .form-section.active {
      display: block;
    }
    .form-group {
      margin-bottom: 15px;
      text-align: left;
    }
    .form-group label {
      font-weight: bold;
      display: block;
      color: #d63384;
    }
    .form-group input {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: 2px solid #ffcce5;
      box-sizing: border-box;
      font-size: 14px;
    }
    .form-group input:focus {
      border-color: #d63384;
      outline: none;
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
      padding: 12px 30px;
      border-radius: 25px;
      cursor: pointer;
      font-weight: bold;
      font-size: 16px;
      transition: all 0.3s;
    }
    .btn:hover {
      background-color: #b71c5f;
      transform: translateY(-2px);
    }
    .offline-section {
      text-align: center;
      padding: 20px;
    }
    .offline-section h4 {
      color: #d63384;
      margin-bottom: 15px;
    }
  </style>
  <script>
    function selectType(type) {
      // Reset semua button
      document.querySelectorAll('.type-btn').forEach(btn => {
        btn.classList.remove('active');
      });
      
      // Reset semua form section
      document.querySelectorAll('.form-section').forEach(section => {
        section.classList.remove('active');
      });
      
      // Aktifkan button yang dipilih
      event.target.classList.add('active');
      
      // Tampilkan form yang sesuai
      document.getElementById(type + '-form').classList.add('active');
    }
    
    function hitungTotal() {
      var harga = <?= $p['price'] ?>;
      var qty = document.getElementById('jumlah').value;
      var total = harga * qty;
      document.getElementById('total_harga').innerText = "Total: Rp " + total.toLocaleString('id-ID');
    }
    
    function beliOffline() {
      window.location.href = 'pemesanan_sukses.php?type=offline';
    }
  </script>
</head>
<body>

<div class="container">
  <h2><?= $p['name'] ?></h2>
  <?php
    // Handle both external URLs and local files for images
    $gambar_produk = htmlspecialchars($p['image']);
    if (preg_match('/^https?:\/\//', $gambar_produk)) {
        $img_src = $gambar_produk;
    } else {
        $img_src = "../assets/img/" . $gambar_produk;
    }
  ?>
  <img src="<?= $img_src ?>" alt="<?= $p['name'] ?>">
  <p><b>Rp <?= number_format($p['price'], 0, ",", "."); ?></b></p>
  <p><?= $p['description'] ?></p>

  <div class="shopping-type">
    <h3>Pilih Metode Belanja</h3>
    <div class="type-buttons">
      <button class="type-btn" onclick="selectType('online')">Online</button>
      <button class="type-btn" onclick="selectType('offline')">Offline</button>
    </div>
  </div>

  <!-- Form Online -->
  <div id="online-form" class="form-section">
    <form action="proses_pesan.php" method="post">
      <input type="hidden" name="id_produk" value="<?= $p['id'] ?>">
      <input type="hidden" name="type" value="online">
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
        Total: Rp <?= number_format($p['price'], 0, ",", "."); ?>
      </div>
      <button type="submit" class="btn">Beli Sekarang</button>
    </form>
  </div>

  <!-- Form Offline -->
  <div id="offline-form" class="form-section">
    <div class="offline-section">
      <h4>Belanja Offline</h4>
      <p>Silakan datang langsung ke toko kami untuk melakukan pembelian.</p>
      <button type="button" class="btn" onclick="beliOffline()">Konfirmasi Belanja Offline</button>
    </div>
  </div>
</div>

</body>
</html>