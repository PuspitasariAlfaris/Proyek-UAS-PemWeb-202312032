<?php
session_start();
include '../auth/cek_login.php';

// Cek role user
cek_role('user');

$type = isset($_GET['type']) ? $_GET['type'] : 'online';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Pemesanan Berhasil - Scarlett Store</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #fff0f5, #ffe6f0);
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .success-container {
      background: white;
      padding: 50px;
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(255, 105, 180, 0.2);
      text-align: center;
      max-width: 600px;
      width: 90%;
      position: relative;
      overflow: hidden;
    }

    .success-container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 5px;
      background: linear-gradient(90deg, #ff69b4, #d63384, #ff69b4);
    }

    .success-icon {
      width: 100px;
      height: 100px;
      background: linear-gradient(135deg, #ff69b4, #d63384);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 30px;
      animation: bounce 1s ease-in-out;
    }

    .success-icon::after {
      content: '✓';
      color: white;
      font-size: 50px;
      font-weight: bold;
    }

    @keyframes bounce {
      0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
      }
      40% {
        transform: translateY(-20px);
      }
      60% {
        transform: translateY(-10px);
      }
    }

    .success-title {
      color: #d63384;
      font-size: 32px;
      font-weight: 700;
      margin-bottom: 20px;
      line-height: 1.2;
    }

    .success-message {
      color: #666;
      font-size: 18px;
      margin-bottom: 40px;
      line-height: 1.6;
    }

    .store-name {
      color: #ff69b4;
      font-weight: 600;
      font-size: 20px;
    }

    .buttons {
      display: flex;
      gap: 20px;
      justify-content: center;
      flex-wrap: wrap;
    }

    .btn {
      padding: 15px 30px;
      border: none;
      border-radius: 25px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      transition: all 0.3s ease;
      min-width: 150px;
    }

    .btn-primary {
      background: linear-gradient(135deg, #ff69b4, #d63384);
      color: white;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(255, 105, 180, 0.3);
    }

    .btn-secondary {
      background: white;
      color: #d63384;
      border: 2px solid #d63384;
    }

    .btn-secondary:hover {
      background: #d63384;
      color: white;
      transform: translateY(-2px);
    }

    .decorative-hearts {
      position: absolute;
      top: 20px;
      right: 20px;
      color: #ffcce5;
      font-size: 20px;
      opacity: 0.6;
    }

    .decorative-hearts-left {
      position: absolute;
      bottom: 20px;
      left: 20px;
      color: #ffcce5;
      font-size: 20px;
      opacity: 0.6;
    }

    @media (max-width: 600px) {
      .success-container {
        padding: 30px 20px;
      }
      
      .success-title {
        font-size: 24px;
      }
      
      .success-message {
        font-size: 16px;
      }
      
      .buttons {
        flex-direction: column;
        align-items: center;
      }
      
      .btn {
        width: 100%;
        max-width: 250px;
      }
    }
  </style>
</head>
<body>

<div class="success-container">
  <div class="decorative-hearts">💖 💕 💖</div>
  <div class="decorative-hearts-left">💕 💖 💕</div>
  
  <div class="success-icon"></div>
  
  <?php if ($type === 'online'): ?>
    <h1 class="success-title">PEMESANAN ANDA BERHASIL, TERIMA KASIH SUDAH BERBELANJA DI SCARLETT STORE</h1>
    <p class="success-message">
      Pesanan Anda sedang diproses dan akan segera dikirim ke alamat yang telah Anda berikan.
    </p>
  <?php else: ?>
    <h1 class="success-title">TERIMA KASIH TELAH BERBELANJA DI SCARLETT STORE</h1>
    <p class="success-message">
      Silakan datang ke toko kami untuk menyelesaikan pembelian Anda.
    </p>
  <?php endif; ?>
  
  <div class="buttons">
    <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
    <?php if ($type === 'online'): ?>
      <a href="riwayat.php" class="btn btn-secondary">Lihat Riwayat</a>
    <?php endif; ?>
  </div>
</div>

</body>
</html>