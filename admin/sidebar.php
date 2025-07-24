<?php
include '../backend/koneksi.php';

// Hitung jumlah pesanan baru
$query = mysqli_query($conn, "SELECT COUNT(*) as total FROM pemesanan WHERE status_pesanan='Baru'");
$data = mysqli_fetch_assoc($query);
$jml_pesan_baru = $data['total'];
?>

<div class="sidebar">
  <h2>Admin Panel</h2>
  <a href="index.php">Dashboard</a>
  <a href="produk.php">Produk</a>
  <a href="kategori.php">Kategori</a>
  <a href="pemesanan.php">
    Pemesanan
    <?php if ($jml_pesan_baru > 0): ?>
      <span class="badge"><?= $jml_pesan_baru; ?></span>
    <?php endif; ?>
  </a>
  <a href="transaksi.php">Transaksi</a>
  <a href="pengguna.php">Pengguna</a>
  <a href="log.php">Log</a>

  <button class="dropdown-btn">Laporan ▼</button>
  <div class="dropdown-container">
    <a href="admin/laporan/laporan_pendapatan.php">Laporan Pendapatan</a>
    <a href="laporan/laporan_pengguna.php">Laporan Pengguna</a>
    <a href="laporan/laporan_transaksi.php">Laporan Transaksi</a>
    <a href="laporan/produk_terlaris.php">Produk Terlaris</a>
  </div>

  <a href="../auth/logout.php">Logout</a>
</div>

<style>
.sidebar {
  width: 220px;
  background-color: #ff5da2;
  color: white;
  position: fixed;
  height: 100%;
  padding-top: 30px;
  top: 0;
  left: 0;
}
.sidebar h2 {
  text-align: center;
  margin-bottom: 30px;
  font-size: 24px;
}
.sidebar a {
  display: block;
  color: white;
  padding: 12px 20px;
  text-decoration: none;
  position: relative;
  transition: background 0.3s;
}
.sidebar a:hover {
  background-color: #ff80b3;
}
.sidebar .badge {
  background-color: red;
  color: white;
  border-radius: 10px;
  padding: 2px 8px;
  font-size: 12px;
  position: absolute;
  right: 20px;
  top: 50%;
  transform: translateY(-50%);
}
.dropdown-btn {
  padding: 12px 20px;
  text-align: left;
  background-color: #ff5da2;
  color: white;
  border: none;
  outline: none;
  width: 100%;
  font-size: 16px;
  cursor: pointer;
}
.dropdown-btn:hover {
  background-color: #ff80b3;
}
.dropdown-container {
  display: none;
  background-color: #ff80b3;
  padding-left: 10px;
}
.dropdown-container a {
  padding: 10px 20px;
  text-decoration: none;
  color: white;
  display: block;
}
.dropdown-container a:hover {
  background-color: #ff99c8;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
  var dropdown = document.getElementsByClassName("dropdown-btn");
  for (var i = 0; i < dropdown.length; i++) {
    dropdown[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var dropdownContent = this.nextElementSibling;
      if (dropdownContent.style.display === "block") {
        dropdownContent.style.display = "none";
      } else {
        dropdownContent.style.display = "block";
      }
    });
  }
});
</script>
