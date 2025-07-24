<?php
include '../auth/cek_login.php';
include '../backend/koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "DELETE FROM slider WHERE id=$id");

if ($query) {
  header("Location: slider.php");
} else {
  echo "Gagal menghapus slider!";
}
?>