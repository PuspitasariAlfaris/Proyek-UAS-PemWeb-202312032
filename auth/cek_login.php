<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Fungsi untuk cek role
function cek_role($required_role) {
    if ($_SESSION['role'] != $required_role) {
        if ($required_role == 'admin') {
            header("Location: ../user/index.php");
        } else {
            header("Location: ../admin/index.php");
        }
        exit;
    }
}

// Include helper log aktivitas
include_once 'log_helper.php';

// Fungsi untuk log aktivitas (wrapper untuk kompatibilitas)
function log_aktivitas($conn, $aktivitas, $deskripsi = '') {
    return safe_log_aktivitas($conn, $aktivitas, $deskripsi);
}
?>