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
$query = mysqli_query($conn, "SELECT * FROM transactions WHERE id = $id_transaksi");
$transaksi = mysqli_fetch_assoc($query);

if (!$transaksi) {
    echo "Data transaksi tidak ditemukan di database!";
    exit;
}

// Handle submit form
if (isset($_POST['submit'])) {
    $user_id = (int) $_POST['user_id'];
    $produk_id = (int) $_POST['produk_id'];
    $jumlah = (int) $_POST['jumlah'];

    // Ambil harga produk
    $produk_q = mysqli_query($conn, "SELECT price FROM products WHERE id = $produk_id");
    $produk = mysqli_fetch_assoc($produk_q);

    if ($produk) {
        $harga_produk = $produk['price'];
        $total_harga = $jumlah * $harga_produk;
        $tanggal = date("Y-m-d H:i:s");

        $update = mysqli_query($conn, "UPDATE transactions SET 
            user_id = $user_id,
            product_id = $produk_id,
            quantity = $jumlah,
            total_price = $total_harga,
            date = '$tanggal'
            WHERE id = $id_transaksi
        ");

        if ($update) {
            header("Location: transaksi.php");
            exit;
        } else {
            echo "Gagal mengupdate transaksi!";
        }
    } else {
        echo "Produk tidak ditemukan!";
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
        <h2>Edit Transaksi</h2>
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
                <label>Produk:</label>
                <select name="produk_id" required>
                    <option value="">-- Pilih Produk --</option>
                    <?php
                    $produk_q = mysqli_query($conn, "SELECT id, name FROM products");
                    while ($produk = mysqli_fetch_assoc($produk_q)) {
                        $selected = ($produk['id'] == $transaksi['product_id']) ? "selected" : "";
                        echo "<option value='".$produk['id']."' $selected>".$produk['name']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah:</label>
                <input type="number" name="jumlah" min="1" value="<?php echo $transaksi['quantity']; ?>" required>
            </div>
            <button type="submit" name="submit" class="btn">Simpan Perubahan</button>
        </form>
    </div>
</div>

</body>
</html>