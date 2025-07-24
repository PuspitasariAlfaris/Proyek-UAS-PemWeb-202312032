<?php
include '../auth/cek_login.php';
include '../backend/koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "DELETE FROM kategori WHERE id=$id");

if ($query) {
  header("Location: kategori.php");
} else {
  echo "Gagal menghapus!";
}
?>