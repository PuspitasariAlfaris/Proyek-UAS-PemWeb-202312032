<?php
include '../auth/cek_login.php';
include '../backend/koneksi.php';

// Proses tambah pengguna
if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah username atau email sudah terdaftar
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' OR email = '$email'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username atau email sudah digunakan!'); window.location='tambah_pengguna.php';</script>";
        exit;
    }

    $query = mysqli_query($conn, "INSERT INTO users (nama, email, username, password, role) 
                                  VALUES ('$nama', '$email', '$username', '$password', '$role')");

    if ($query) {
        header("Location: pengguna.php");
        exit;
    } else {
        echo "Gagal menambahkan pengguna: " . mysqli_error($conn);
    }
}
?>
