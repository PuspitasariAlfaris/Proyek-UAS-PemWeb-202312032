<?php
session_start();
include '../auth/cek_login.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pesanan Berhasil - Scarlett Store</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff0f5;
      margin: 0;
      padding: 0;
    }

    .header {
      background-color: #ff69b4;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 15px 50px;
      color: white;
      font-weight: bold;
    }

    .container {
      max-width: 600px;
      margin: 100px auto;
      background: white;
      padding: 40px;
      text-align: center;
      border-radius: 10px;
      box-shadow: 0 0 10px #ffcce5;
    }

    .container h2 {
      color: #d63384;
      margin-bottom: 20px;
      font-size: 28px;
    }

    .container p {
      font-size: 16px;
      color: #333;
      margin-bottom: 30px;
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #ff69b4;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
      transition: 0.3s;
    }

    .btn:hover {
      background-color: #d63384;
    }
  </style>
</head>
<body>

<div class="header">
  <div>Scarlett Store</div>
  <form action="../auth/logout.php" method="post" style="margin: 0;">
    <button type="submit" class="btn" style="background:white; color:#ff69b4;">Logout</button>
  </form>
</div>

<div class="container">
  <h2>Pesanan Berhasil!</h2>
  <p>Terima kasih telah berbelanja di Scarlett Store.<br>
    Pesanan Anda telah berhasil diproses.<br>
    Silakan cek email Anda untuk detail pesanan atau lihat riwayat pesanan Anda di dashboard.</p>

  <a href="index.php" class="btn">Kembali ke Beranda</a>
</div>

</body>
</html>