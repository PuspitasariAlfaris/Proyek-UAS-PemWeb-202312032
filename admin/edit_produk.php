<?php
include '../auth/cek_login.php';
include '../backend/koneksi.php';

// Ambil data berdasarkan ID
if (!isset($_GET['id'])) {
    header("Location: produk.php");
    exit;
}
$id = (int)$_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$data = mysqli_fetch_assoc($query);

// Proses update
if (isset($_POST['update'])) {
    $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    $gambar = isset($_POST['gambar']) ? trim($_POST['gambar']) : '';
    if ($gambar == '') {
        $gambar = 'https://via.placeholder.com/150?text=No+Image';
    } else {
        $gambar = mysqli_real_escape_string($conn, $gambar);
    }
    
    $update = mysqli_query($conn, "UPDATE products SET 
        name = '$nama_produk', 
        image = '$gambar', 
        price = '$harga', 
        description = '$deskripsi' 
        WHERE id = $id");

    if ($update) {
        header("Location: produk.php");
        exit;
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk - Scarlett Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #fff0f5;
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
            padding: 30px;
            min-height: 100vh;
        }

        .form-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 10px #ffcce5;
            width: 400px;
            margin: 0 auto;
        }

        .form-container h1 {
            color: #d63384;
            margin-bottom: 30px;
            font-size: 28px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #99004d;
            font-weight: bold;
            font-size: 14px;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ffb6c1;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .btn {
            background-color: #ff69b4;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
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

<!-- Form Edit -->
<div class="main-content">
    <div class="form-container">
        <h1>Edit Produk</h1>
        <form method="POST">
            <div class="form-group">
                <label>Nama Produk:</label>
                <input type="text" name="nama_produk" value="<?= htmlspecialchars($data['name']) ?>" required>
            </div>
            <div class="form-group">
                <label>Link Gambar:</label>
                <input type="text" name="gambar" value="<?= htmlspecialchars($data['image']) ?>">
            </div>
            <div class="form-group">
                <label>Harga:</label>
                <input type="number" name="harga" value="<?= htmlspecialchars($data['price']) ?>" required>
            </div>
            <div class="form-group">
                <label>Deskripsi:</label>
                <textarea name="deskripsi" rows="3" required><?= htmlspecialchars($data['description']) ?></textarea>
            </div>
            <button type="submit" name="update" class="btn">Update</button>
        </form>
    </div>
</div>

</body>
</html>
