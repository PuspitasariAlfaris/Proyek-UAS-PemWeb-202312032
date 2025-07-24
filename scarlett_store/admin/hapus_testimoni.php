<?php
include '../auth/cek_login.php';
include '../backend/koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "DELETE FROM testimoni WHERE id=$id");

if ($query) {
  header("Location: testimoni.php");
} else {
  echo "Gagal hapus testimoni!";
}
?>