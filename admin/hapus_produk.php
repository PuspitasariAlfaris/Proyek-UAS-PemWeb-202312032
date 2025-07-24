<?php
include '../auth/cek_login.php';
include '../backend/koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($conn, "DELETE FROM products WHERE id = $id");
if ($query) {
  header("Location: produk.php");
} else {
  echo "Gagal menghapus produk!";
}
?>