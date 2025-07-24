<?php
session_start();
include '../backend/koneksi.php';

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    echo "<script>alert('Username dan password harus diisi!'); window.location.href='login.php';</script>";
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' LIMIT 1");
$user = mysqli_fetch_assoc($query);

if ($user) {
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nama'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['login_time'] = date('Y-m-d H:i:s');

        $ip_address = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $log_query = "INSERT INTO activity_log (user_id, activity, description, ip_address, user_agent) 
                      VALUES ('{$user['id']}', 'Login', 'User berhasil login sebagai {$user['role']}', '$ip_address', '$user_agent')";
        mysqli_query($conn, $log_query);

        if ($user['role'] == 'admin') {
            header("Location: ../admin/index.php");
        } else {
            header("Location: ../user/index.php");
        }
        exit;
    } else {
        echo "<script>alert('Password salah!'); window.location.href='login.php';</script>";
    }
} else {
    echo "<script>alert('Username atau password salah!'); window.location.href='login.php';</script>";
}
?>
