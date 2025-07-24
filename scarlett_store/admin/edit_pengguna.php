<?php 
include '../auth/cek_login.php';
include '../backend/koneksi.php';

if (!isset($_GET['id'])) {
    echo "ID pengguna tidak ditemukan!";
    exit;
}

$id = (int) $_GET['id'];

// Ambil data pengguna dari database
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
$pengguna = mysqli_fetch_assoc($query);

if (!$pengguna) {
    echo "Data pengguna tidak ditemukan!";
    exit;
}

// Saat form disubmit
if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $query = mysqli_query($conn, "UPDATE users SET 
        nama = '$nama', 
        email = '$email', 
        username = '$username', 
        role = '$role' 
        WHERE id = $id");

    if ($query) {
        header("Location: pengguna.php");
        exit;
    } else {
        echo "Gagal mengupdate pengguna!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pengguna - Scarlett Store</title>
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
            margin-left: 240px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }
        .form-container {
            background: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 0 10px #ffcce5;
            width: 500px;
        }
        .form-container h2 {
            text-align: center;
            color: #d63384;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #99004d;
            font-weight: bold;
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
            background-color: #ff69b4;
            color: white;
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
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
    <div class="form-container">
        <h2>Edit Pengguna</h2>
        <form method="POST">
            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="nama" value="<?php echo htmlspecialchars($pengguna['nama']); ?>" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($pengguna['email']); ?>" required>
            </div>
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($pengguna['username']); ?>" required>
            </div>
            <div class="form-group">
                <label>Role:</label>
                <select name="role" required>
                    <option value="admin" <?php if ($pengguna['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="user" <?php if ($pengguna['role'] == 'user') echo 'selected'; ?>>User</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn">Simpan Perubahan</button>
        </form>
    </div>
</div>

</body>
</html>