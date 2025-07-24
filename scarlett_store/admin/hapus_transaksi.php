<?php
include '../auth/cek_login.php';
include '../backend/koneksi.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Gunakan prepared statement untuk keamanan
    $stmt = mysqli_prepare($conn, "DELETE FROM transaksi WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: transaksi.php");
        exit;
    } else {
        echo "Gagal menghapus transaksi!";
    }

    mysqli_stmt_close($stmt);
} else {
    echo "ID transaksi tidak ditemukan!";
}
?>
