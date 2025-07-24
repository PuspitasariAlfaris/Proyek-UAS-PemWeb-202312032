<?php
include '../auth/cek_login.php';
include '../backend/koneksi.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM users WHERE id='$id'");
header("Location: pengguna.php");
exit;
?>