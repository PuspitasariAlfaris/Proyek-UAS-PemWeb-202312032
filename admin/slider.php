<?php include '../auth/cek_login.php'; ?>
<?php include '../backend/koneksi.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Manajemen Slider</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #ffe6f0;
      padding: 30px;
    }
    h2 {
      color: #d63384;
    }
    .btn-tambah {
      background-color: #d63384;
      color: white;
      padding: 8px 15px;
      border: none;
      border-radius: 5px;
      text-decoration: none;
    }
    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
    }
    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }
    img {
      height: 80px;
    }
    .btn-edit, .btn-hapus {
      padding: 6px 12px;
      text-decoration: none;
      border-radius: 5px;
      font-size: 13px;
    }
    .btn-edit {
      background-color: #ffc107;
      color: white;
    }
    .btn-hapus {
      background-color: #dc3545;
      color: white;
    }
  </style>
</head>
<body>
  <h2>Manajemen Gambar Slider</h2>
  <a href="tambah_slider.php" class="btn-tambah">+ Tambah Slider</a>
  <table>
    <tr>
      <th>No</th>
      <th>Judul</th>
      <th>Gambar</th>
      <th>Aksi</th>
    </tr>
    <?php
    $no = 1;
    $slider = mysqli_query($conn, "SELECT * FROM slider ORDER BY id DESC");
    while ($row = mysqli_fetch_assoc($slider)) {
      echo "
      <tr>
        <td>$no</td>
        <td>{$row['judul']}</td>
        <td><img src='{$row['gambar']}'></td>
        <td>
          <a href='edit_slider.php?id={$row['id']}' class='btn-edit'>Edit</a>
          <a href='hapus_slider.php?id={$row['id']}' class='btn-hapus' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
        </td>
      </tr>
      ";
      $no++;
    }
    ?>
  </table>
</body>
</html>