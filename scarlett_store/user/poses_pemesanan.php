<?php
session_start();
include '../backend/koneksi.php';

// Pastikan semua data terkirim
if (
    isset($_POST['id_produk']) &&
    isset($_POST['nama']) &&
    isset($_POST['alamat']) &&
    isset($_POST['telepon']) &&
    isset($_POST['jumlah']) &&
    isset($_POST['total_harga'])
) {
    $id_produk = $_POST['id_produk'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $jumlah = $_POST['jumlah'];
    $total_harga = $_POST['total_harga'];

    // Simpan ke database
    $query = mysqli_query($conn, "
      INSERT INTO pemesanan 
      (id_produk, nama, alamat, telepon, jumlah, total_harga, tanggal)
      VALUES 
      ('$id_produk', '$nama', '$alamat', '$telepon', '$jumlah', '$total_harga', NOW())
    ");

    if ($query) {
        header("Location: index.php?pesan=sukses");
        exit;
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
} else {
    echo "Data tidak lengkap.";
}
?>