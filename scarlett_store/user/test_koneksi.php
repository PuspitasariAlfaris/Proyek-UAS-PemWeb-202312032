<?php
$host = "localhost";
$user = "root";
$pass = "123";
$db   = "scarlett_store";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
