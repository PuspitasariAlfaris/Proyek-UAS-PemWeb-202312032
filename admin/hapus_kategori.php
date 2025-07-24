<?php
include '../auth/cek_login.php';
include '../backend/koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "DELETE FROM categories WHERE id=$id");

if ($query) {
  header("Location: kategori.php");
} else {
  echo "Gagal menghapus!";
}
?>