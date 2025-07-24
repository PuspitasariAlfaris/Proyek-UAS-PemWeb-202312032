<?php
session_start();
include '../backend/koneksi.php';
include 'log_helper.php';

// Log aktivitas logout jika user masih login
if (isset($_SESSION['user_id'])) {
    safe_log_aktivitas($conn, 'Logout', 'User berhasil logout dari sistem');
}

// Hapus semua data session
$_SESSION = array();

// Hapus session cookie jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy session
session_destroy();

// Redirect ke halaman login
header("Location: login.php");
exit;
?>