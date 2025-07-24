<?php
include '../auth/cek_login.php';
include '../backend/koneksi.php';

// Cek role user
cek_role('user');

// Log aktivitas
log_aktivitas($conn, 'Akses Homepage', 'User mengakses halaman utama');

// Ambil data untuk homepage
$produk = mysqli_query($conn, "SELECT * FROM products ORDER BY created_at DESC LIMIT 10");
$testimoni = mysqli_query($conn, "SELECT * FROM testimonials WHERE active = 1 ORDER BY created_at DESC LIMIT 4");
$slider = mysqli_query($conn, "SELECT * FROM sliders WHERE active = 1 ORDER BY order_number ASC LIMIT 2");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Scarlett Store - Home</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff0f5;
      margin: 0;
      padding: 0;
    }

    .header {
      background: linear-gradient(135deg, #ff69b4, #d63384);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 1px 30px;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 999;
      height: 80px;
      box-shadow: 0 2px 10px rgba(255, 105, 180, 0.3);
    }

    .logo-container {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .logo-container img {
      width: 140px;
      height: auto;
    }

    .logo-container span {
      font-size: 28px;
      color: white;
      font-weight: bold;
    }

    .user-menu {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .user-info {
      color: white;
      font-size: 14px;
    }

    .user-info strong {
      font-weight: bold;
    }

    .nav-btn {
      background-color: rgba(255, 255, 255, 0.2);
      color: white;
      padding: 8px 12px;
      border: none;
      border-radius: 15px;
      font-size: 12px;
      cursor: pointer;
      font-weight: bold;
      transition: 0.3s;
      text-decoration: none;
      display: inline-block;
    }

    .nav-btn:hover {
      background-color: rgba(255, 255, 255, 0.3);
      transform: translateY(-1px);
    }

    .logout-btn {
      background-color: white;
      color: #ff69b4;
      padding: 8px 16px;
      border: none;
      border-radius: 20px;
      font-size: 14px;
      cursor: pointer;
      font-weight: bold;
      transition: 0.3s;
      text-decoration: none;
    }

    .logout-btn:hover {
      background-color: #ffe6f0;
      transform: translateY(-1px);
    }

    .slider {
      margin-top: 0;
      width: 100%;
      height: 100vh;
      overflow: hidden;
      position: relative;
    }

    .slides {
      display: flex;
      width: 200%;
      height: 100%;
      animation: slide 10s infinite;
    }

    .slides img {
      width: 50%;
      height: 100%;
      object-fit: cover;
      object-position: center;
    }

    @keyframes slide {
      0%, 45% { transform: translateX(0%); }
      55%, 100% { transform: translateX(-50%); }
    }

    h2.section-title {
      text-align: center;
      color: #d63384;
      margin: 40px 0 20px;
      font-size: 30px;
      font-weight: bold;
    }

    .produk-container {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
      justify-content: center;
      padding: 0 20px 40px;
    }

    .produk-item {
      background: white;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 5px 15px rgba(255, 105, 180, 0.1);
      text-align: center;
      transition: all 0.3s ease;
      border: 1px solid rgba(255, 105, 180, 0.1);
    }

    .produk-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(255, 105, 180, 0.15);
      border-color: rgba(255, 105, 180, 0.3);
    }

    .produk-item img {
      width: 100%;
      height: 200px;
      object-fit: contain;
      border-radius: 8px;
      margin-bottom: 10px;
    }

    .produk-item h4 {
      margin: 10px 0 5px;
      color: #d63384;
      font-size: 16px;
      min-height: 40px;
    }

    .produk-item p {
      color: #555;
      margin: 0;
      font-size: 14px;
    }

    .btn-detail {
      margin-top: 15px;
      padding: 10px 20px;
      background: linear-gradient(45deg, #ff69b4, #d63384);
      color: white;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      text-decoration: none;
      font-size: 14px;
      font-weight: 600;
      display: inline-block;
      transition: all 0.3s ease;
      box-shadow: 0 3px 10px rgba(255, 105, 180, 0.3);
    }

    .btn-detail:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(255, 105, 180, 0.4);
    }

    .row-center {
      grid-column: 2 / span 2;
      display: flex;
      justify-content: center;
      gap: 20px;
    }

    .row-center .produk-item {
      width: 220px;
    }

    .testimoni-table {
      margin: 0 auto 60px;
      border-spacing: 30px;
      table-layout: fixed;
      width: 100%;
    }

    .testimoni-item {
      background-color: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 0 10px #ffcce5;
      text-align: center;
      height: 100%;
    }

    .testimoni-item img {
      width: 100%;
      height: 200px;
      object-fit: contain;
      background-color: #f8f8f8;
      border-radius: 10px;
      margin-bottom: 15px;
    }

    .testimoni-item p {
      color: #333;
      font-size: 16px;
      margin: 0;
      line-height: 1.4;
    }

    footer {
      background: #ff69b4;
      text-align: center;
      padding: 15px;
      color: white;
      font-weight: bold;
    }

    /* Content section styling */
    .content-section {
      background: white;
      min-height: 100vh;
      padding: 60px 0;
      position: relative;
      z-index: 2;
    }

    /* Scroll indicator styling */
    .scroll-indicator {
      position: fixed;
      bottom: 30px;
      left: 50%;
      transform: translateX(-50%);
      background: linear-gradient(135deg, #ff69b4, #d63384);
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      box-shadow: 0 4px 20px rgba(255, 105, 180, 0.4);
      z-index: 1000;
      transition: all 0.3s ease;
      animation: bounceUp 2s infinite;
    }

    .scroll-indicator:hover {
      transform: translateX(-50%) scale(1.1);
      box-shadow: 0 6px 30px rgba(255, 105, 180, 0.6);
    }

    .scroll-indicator.hidden {
      opacity: 0;
      visibility: hidden;
    }

    .scroll-arrow {
      width: 0;
      height: 0;
      border-left: 8px solid transparent;
      border-right: 8px solid transparent;
      border-top: 12px solid white;
      margin-bottom: 3px;
    }

    .scroll-text {
      position: absolute;
      top: 70px;
      left: 50%;
      transform: translateX(-50%);
      background: rgba(255, 255, 255, 0.9);
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 12px;
      color: #ff69b4;
      font-weight: bold;
      white-space: nowrap;
      opacity: 0;
      transition: opacity 0.3s ease;
      pointer-events: none;
    }

    .scroll-indicator:hover .scroll-text {
      opacity: 1;
    }

    @keyframes bounceUp {
      0%, 20%, 50%, 80%, 100% {
        transform: translateX(-50%) translateY(0);
      }
      40% {
        transform: translateX(-50%) translateY(-10px);
      }
      60% {
        transform: translateX(-50%) translateY(-5px);
      }
    }

    /* Smooth scrolling */
    html {
      scroll-behavior: smooth;
    }

    /* Responsive design */
    @media (max-width: 768px) {
      .produk-container {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
        padding: 0 15px 40px;
      }
      
      .scroll-indicator {
        width: 50px;
        height: 50px;
        bottom: 20px;
      }
      
      .scroll-text {
        font-size: 10px;
        top: 60px;
      }
      
      .header {
        padding: 1px 15px;
      }
      
      .logo-container span {
        font-size: 20px;
      }
      
      .logo-container img {
        width: 100px;
      }
    }

    @media (max-width: 480px) {
      .produk-container {
        grid-template-columns: 1fr;
      }
      
      .testimoni-table {
        border-spacing: 15px;
      }
    }
  </style>
</head>
<body>

<div class="header">
  <div class="logo-container">
    <img src="../assets/img/logo.png" alt="Logo Scarlett">
    <span>Store</span>
  </div>
  <div class="user-menu">
    <div class="user-info">
      Selamat datang, <strong><?= htmlspecialchars($_SESSION['username'] ?? $_SESSION['nama'] ?? 'User'); ?></strong>
    </div>
    <a href="riwayat.php" class="nav-btn">Riwayat</a>
    <a href="../auth/logout.php" class="logout-btn">Logout</a>
  </div>
</div>

<div class="slider">
  <div class="slides">
    <img src="../assets/img/slider1.jpeg" alt="Slider 1">
    <img src="../assets/img/slider2.jpg" alt="Slider 2">
  </div>
</div>

<!-- Scroll Indicator -->
<div class="scroll-indicator" id="scrollIndicator">
  <div class="scroll-arrow"></div>
  <div class="scroll-text">Scroll ke bawah untuk melihat produk</div>
</div>

<!-- Content Section -->
<div class="content-section" id="contentSection">
  <h2 class="section-title">Daftar Produk</h2>

  <div class="produk-container">
  <?php
    $no = 0;
    while ($p = mysqli_fetch_assoc($produk)):
      $no++;
      if ($no === 9) echo '<div class="row-center">';
  ?>
      <div class="produk-item">
        <?php
          // Handle both external URLs and local files for images
          $gambar_produk = htmlspecialchars($p['image']);
          if (preg_match('/^https?:\/\//', $gambar_produk)) {
              $img_src = $gambar_produk;
          } else {
              $img_src = "../assets/img/" . $gambar_produk;
          }
        ?>
        <img src="<?= $img_src ?>" alt="<?= htmlspecialchars($p['name']); ?>">
        <h4><?= htmlspecialchars($p['name']); ?></h4>
        <p><?= htmlspecialchars(substr($p['description'], 0, 50)); ?>...</p>
        <p><b>Rp <?= number_format($p['price'], 0, ",", "."); ?></b></p>
        <a href="detail.php?id=<?= $p['id']; ?>" class="btn-detail">Lihat Detail</a>
      </div>
  <?php
      if ($no === 10) echo '</div>';
    endwhile;
  ?>
</div>

<h2 class="section-title">Testimoni Pengguna</h2>

<table class="testimoni-table">
  <colgroup>
    <col style="width: 50%;">
    <col style="width: 50%;">
  </colgroup>
  <?php
  $testimoni_array = [];
  while ($t = mysqli_fetch_assoc($testimoni)) {
    $testimoni_array[] = $t;
  }
  
  for ($i = 0; $i < count($testimoni_array); $i += 2) {
    echo "<tr>";
    
    // Testimoni pertama
    if (isset($testimoni_array[$i])) {
      echo "<td>";
      echo "<div class='testimoni-item'>";
      echo "<img src='../assets/img/" . htmlspecialchars($testimoni_array[$i]['image']) . "' alt='Testimoni'>";
      echo "<p><strong>" . htmlspecialchars($testimoni_array[$i]['name']) . "</strong></p>";
      echo "<p>" . htmlspecialchars($testimoni_array[$i]['message']) . "</p>";
      echo "<p style='color: #ff69b4;'>" . str_repeat('⭐', $testimoni_array[$i]['rating']) . "</p>";
      echo "</div>";
      echo "</td>";
    }
    
    // Testimoni kedua
    if (isset($testimoni_array[$i + 1])) {
      echo "<td>";
      echo "<div class='testimoni-item'>";
      echo "<img src='../assets/img/" . htmlspecialchars($testimoni_array[$i + 1]['image']) . "' alt='Testimoni'>";
      echo "<p><strong>" . htmlspecialchars($testimoni_array[$i + 1]['name']) . "</strong></p>";
      echo "<p>" . htmlspecialchars($testimoni_array[$i + 1]['message']) . "</p>";
      echo "<p style='color: #ff69b4;'>" . str_repeat('⭐', $testimoni_array[$i + 1]['rating']) . "</p>";
      echo "</div>";
      echo "</td>";
    } else {
      echo "<td></td>"; // Cell kosong jika testimoni ganjil
    }
    
    echo "</tr>";
  }
  ?>
  </table>

  <footer>
    BY PUSPITASARI ALFARIS
  </footer>
</div>

<script>
// Scroll indicator functionality
document.addEventListener('DOMContentLoaded', function() {
  const scrollIndicator = document.getElementById('scrollIndicator');
  const contentSection = document.getElementById('contentSection');
  
  // Hide scroll indicator when user scrolls
  window.addEventListener('scroll', function() {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    if (scrollTop > 100) {
      scrollIndicator.classList.add('hidden');
    } else {
      scrollIndicator.classList.remove('hidden');
    }
  });
  
  // Smooth scroll to content when indicator is clicked
  scrollIndicator.addEventListener('click', function() {
    contentSection.scrollIntoView({ 
      behavior: 'smooth',
      block: 'start'
    });
  });
  
  // Auto-hide after 5 seconds
  setTimeout(function() {
    scrollIndicator.style.opacity = '0.6';
  }, 5000);
});
</script>

</body>
</html>