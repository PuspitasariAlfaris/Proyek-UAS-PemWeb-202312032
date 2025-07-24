<?php
// Tampilkan error agar tidak blank saat ada error
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../auth/cek_login.php';
include '../backend/koneksi.php';

// Pastikan parameter id ada
if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan di URL!";
    exit;
}

$id_transaksi = (int) $_GET['id'];

// Ambil data transaksi
$query = mysqli_query($conn, "SELECT t.*, u.name as user_name FROM transactions t 
    LEFT JOIN users u ON t.user_id = u.id 
    WHERE t.id = $id_transaksi");
$transaksi = mysqli_fetch_assoc($query);

if (!$transaksi) {
    echo "Data transaksi tidak ditemukan di database!";
    exit;
}

// Ambil item transaksi
$items_query = mysqli_query($conn, "SELECT ti.*, p.name as product_name FROM transaction_items ti 
    LEFT JOIN products p ON ti.product_id = p.id 
    WHERE ti.transaction_id = $id_transaksi");
$transaction_items = [];
while ($item = mysqli_fetch_assoc($items_query)) {
    $transaction_items[] = $item;
}

// Handle submit form
if (isset($_POST['submit'])) {
    $user_id = (int) $_POST['user_id'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $shipping_address = mysqli_real_escape_string($conn, $_POST['shipping_address']);
    $tanggal = date("Y-m-d H:i:s");

    // Validate status values
    $allowed_statuses = ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'];
    if (!in_array($status, $allowed_statuses)) {
        echo "Status tidak valid!";
        exit;
    }

    // Validate payment methods
    $allowed_payment_methods = ['transfer', 'cod', 'ewallet'];
    if (!in_array($payment_method, $allowed_payment_methods)) {
        echo "Metode pembayaran tidak valid!";
        exit;
    }

    $update = mysqli_query($conn, "UPDATE transactions SET 
        user_id = $user_id,
        status = '$status',
        payment_method = '$payment_method',
        shipping_address = '$shipping_address',
        updated_at = '$tanggal'
        WHERE id = $id_transaksi
    ");

    if ($update) {
        echo "<script>alert('Transaksi berhasil diupdate!'); window.location.href='transaksi.php';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal mengupdate transaksi: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Transaksi - Scarlett Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            background-color: #fff0f5;
            font-family: 'Poppins', sans-serif;
            height: 100%;
        }

        .sidebar {
            width: 220px;
            background-color: #ff5da2;
            color: white;
            position: fixed;
            height: 100%;
            padding-top: 30px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
            color: #fff;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            font-size: 16px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #ff80b3;
        }

        .main-content {
            margin-left: 220px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .form-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ffcce5;
            width: 400px;
        }

        .form-container h2 {
            color: #d63384;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #99004d;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ffb6c1;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #ff69b4;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            text-align: center;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #e754a6;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="index.php">Dashboard</a>
    <a href="produk.php">Produk</a>
    <a href="kategori.php">Kategori</a>
    <a href="transaksi.php">Transaksi</a>
    <a href="pesanan.php">Pesanan</a>
    <a href="pengguna.php">Pengguna</a>
    <a href="log.php">Log</a>
    <a href="laporan.php">Laporan</a>
    <a href="../auth/logout.php">Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="form-container">
        <h2>Edit Transaksi #<?php echo $transaksi['transaction_code']; ?></h2>
        
        <!-- Display Transaction Items (Read Only) -->
        <div class="form-group">
            <label>Item Transaksi:</label>
            <div style="border: 1px solid #ffb6c1; padding: 10px; border-radius: 5px; background: #f9f9f9;">
                <?php if (!empty($transaction_items)): ?>
                    <?php foreach ($transaction_items as $item): ?>
                        <div style="margin-bottom: 5px;">
                            <?php echo $item['product_name']; ?> - 
                            Qty: <?php echo $item['quantity']; ?> - 
                            Rp <?php echo number_format($item['subtotal'], 2); ?>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <strong>Total: Rp <?php echo number_format($transaksi['total_amount'], 2); ?></strong>
                <?php else: ?>
                    <em>Tidak ada item</em>
                <?php endif; ?>
            </div>
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label>User:</label>
                <select name="user_id" required>
                    <option value="">-- Pilih User --</option>
                    <?php
                    $users = mysqli_query($conn, "SELECT id, name FROM users");
                    while ($user = mysqli_fetch_assoc($users)) {
                        $selected = ($user['id'] == $transaksi['user_id']) ? "selected" : "";
                        echo "<option value='".$user['id']."' $selected>".$user['name']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Status:</label>
                <select name="status" required>
                    <option value="pending" <?php echo ($transaksi['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                    <option value="confirmed" <?php echo ($transaksi['status'] == 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                    <option value="shipped" <?php echo ($transaksi['status'] == 'shipped') ? 'selected' : ''; ?>>Shipped</option>
                    <option value="delivered" <?php echo ($transaksi['status'] == 'delivered') ? 'selected' : ''; ?>>Delivered</option>
                    <option value="cancelled" <?php echo ($transaksi['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                </select>
            </div>
            <div class="form-group">
                <label>Payment Method:</label>
                <select name="payment_method" required>
                    <option value="transfer" <?php echo ($transaksi['payment_method'] == 'transfer') ? 'selected' : ''; ?>>Transfer</option>
                    <option value="cod" <?php echo ($transaksi['payment_method'] == 'cod') ? 'selected' : ''; ?>>Cash on Delivery</option>
                    <option value="ewallet" <?php echo ($transaksi['payment_method'] == 'ewallet') ? 'selected' : ''; ?>>E-Wallet</option>
                </select>
            </div>
            <div class="form-group">
                <label>Shipping Address:</label>
                <textarea name="shipping_address" rows="3" style="width: 100%; padding: 10px; border: 1px solid #ffb6c1; border-radius: 5px; font-size: 14px; box-sizing: border-box; resize: vertical; font-family: 'Poppins', sans-serif;" required><?php echo htmlspecialchars($transaksi['shipping_address']); ?></textarea>
            </div>
            <button type="submit" name="submit" class="btn">Simpan Perubahan</button>
        </form>
    </div>
</div>

</body>
</html>