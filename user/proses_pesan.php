<?php
session_start();
include '../backend/koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

// Ambil data dari form
$id_produk = $_POST['id_produk'];
$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$telepon = $_POST['telepon'];
$jumlah = $_POST['jumlah'];
$user_id = $_SESSION['user_id'];

// Validasi input
if (empty($id_produk) || empty($nama) || empty($alamat) || empty($telepon) || empty($jumlah)) {
    echo "<script>alert('Semua field harus diisi!'); window.history.back();</script>";
    exit();
}

// Ambil data produk
$query_produk = mysqli_query($conn, "SELECT * FROM products WHERE id = $id_produk");
$produk = mysqli_fetch_assoc($query_produk);

if (!$produk) {
    echo "<script>alert('Produk tidak ditemukan!'); window.history.back();</script>";
    exit();
}

// Hitung total harga
$harga = $produk['price'];
$total_harga = $harga * $jumlah;

// Cek stok
if ($produk['stock'] < $jumlah) {
    echo "<script>alert('Stok tidak mencukupi! Stok tersedia: " . $produk['stock'] . "'); window.history.back();</script>";
    exit();
}

// Generate transaction code
$transaction_code = 'TRX' . date('Ymd') . rand(1000, 9999);

// Insert ke tabel transactions
$query_transaksi = "INSERT INTO transactions (transaction_code, user_id, total_amount, status, payment_method, shipping_address) 
                   VALUES ('$transaction_code', '$user_id', '$total_harga', 'pending', 'cod', '$alamat')";

if (mysqli_query($conn, $query_transaksi)) {
    // Get the inserted transaction ID
    $transaction_id = mysqli_insert_id($conn);
    
    // Insert transaction item
    $subtotal = $harga * $jumlah;
    $query_item = "INSERT INTO transaction_items (transaction_id, product_id, quantity, unit_price, subtotal) 
                  VALUES ('$transaction_id', '$id_produk', '$jumlah', '$harga', '$subtotal')";
    mysqli_query($conn, $query_item);
    
    // Update stok produk
    $stok_baru = $produk['stock'] - $jumlah;
    mysqli_query($conn, "UPDATE products SET stock = $stok_baru WHERE id = $id_produk");
    
    // Log aktivitas
    $aktivitas = "Melakukan pemesanan produk: " . $produk['name'];
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    
    $query_log = "INSERT INTO activity_log (user_id, activity, description, ip_address, user_agent) 
                  VALUES ('$user_id', '$aktivitas', 'Jumlah: $jumlah, Total: Rp " . number_format($total_harga) . "', '$ip_address', '$user_agent')";
    mysqli_query($conn, $query_log);
    
    echo "<script>
        window.location.href = 'pemesanan_sukses.php?type=online';
    </script>";
} else {
    echo "<script>
        alert('Gagal membuat pesanan: " . mysqli_error($conn) . "');
        window.history.back();
    </script>";
}
?>
