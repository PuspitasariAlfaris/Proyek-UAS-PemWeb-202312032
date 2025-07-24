<?php
session_start();
include '../backend/koneksi.php';

// Tangkap data dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Cari user di database
$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' LIMIT 1");
$user = mysqli_fetch_assoc($query);

if ($user) {
    // Cek password
    if (password_verify($password, $user['password']) || $password == $user['password']) {
        // Simpan data user ke session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'] ?? 'user';

        if ($_SESSION['role'] == 'admin') {
            header("Location: ../admin/index.php");
        } else {
            header("Location: ../user/index.php");
        }
        exit;
    } else {
        echo "<script>alert('Password salah'); window.location.href='login.php';</script>";
    }
} else {
    echo "<script>alert('User tidak ditemukan'); window.location.href='login.php';</script>";
}
?>