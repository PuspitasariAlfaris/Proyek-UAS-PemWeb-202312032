<?php
include '../auth/cek_login.php';
include '../backend/koneksi.php';

// Proses simpan data produk
if (isset($_POST['simpan'])) {
    $nama_produk = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $harga_produk = (int)$_POST['harga_produk'];
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // proses upload gambar
    $gambar_produk = "";
    if (isset($_FILES['gambar_produk']) && $_FILES['gambar_produk']['error'] == 0) {
        $target_dir = "../assets/img/";
        $nama_file = basename($_FILES["gambar_produk"]["name"]);
        $target_file = $target_dir . $nama_file;

        if (move_uploaded_file($_FILES["gambar_produk"]["tmp_name"], $target_file)) {
            $gambar_produk = $nama_file;
        } else {
            echo "<script>alert('Gagal upload gambar');</script>";
        }
    }

    // simpan ke database
    $query = "INSERT INTO produk (nama_produk, gambar_produk, harga_produk, deskripsi) 
              VALUES ('$nama_produk', '$gambar_produk', $harga_produk, '$deskripsi')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Produk berhasil ditambahkan'); window.location='produk.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan produk');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk - Scarlett Store</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Poppins', sans-serif;
            background: #fff0f5;
        }

        /* SIDEBAR persis dashboard */
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
        }

        .page-title {
            font-size: 28px;
            color: #d63384;
            margin: 0 0 20px 0;
            text-align: center;
        }

        .form-container {
            background: #fff;
            padding: 30px;
            width: 500px;
            margin: 0 auto;
            box-shadow: 0 0 10px #ffcce5;
            border-radius: 10px;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #d63384;
        }

        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container textarea,
        .form-container input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ffb6c1;
            border-radius: 5px;
            font-size: 14px;
        }

        .btn {
            background-color: #ff69b4;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            display: inline-block;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #e754a6;
        }

        .btn-back {
            background-color: #6c757d;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<!-- SIDEBAR persis dashboard -->
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

<div class="main-content">
    <div class="page-title">Tambah Produk</div>
    <div class="form-container">
        <form method="POST" enctype="multipart/form-data">
            <label>Nama Produk</label>
            <input type="text" name="nama_produk" required>

            <label>Gambar Produk</label>
            <input type="file" name="gambar_produk" accept="image/*">

            <label>Harga Produk</label>
            <input type="number" name="harga_produk" required>

            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="4" required></textarea>

            <button type="submit" name="simpan" class="btn">Simpan</button>
            <a href="produk.php" class="btn btn-back">Batal</a>
        </form>
    </div>
</div>

</body>
</html>