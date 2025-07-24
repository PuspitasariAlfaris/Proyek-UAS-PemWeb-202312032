<?php include '../auth/cek_login.php'; ?>
<?php include '../backend/koneksi.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Manajemen Testimoni</title>
  <style>
    body { font-family: 'Poppins'; background: #fff0f5; padding: 30px; }
    h2 { color: #d63384; }
    a.btn-tambah {
      background-color: #d63384; color: white; padding: 10px 15px;
      text-decoration: none; border-radius: 5px;
    }
    table {
      width: 100%; margin-top: 20px;
      border-collapse: collapse; background: white; border-radius: 10px;
    }
    th, td {
      padding: 12px; text-align: left;
      border-bottom: 1px solid #ddd;
    }
    img { height: 80px; }
    .btn-edit, .btn-hapus {
      padding: 6px 10px; border-radius: 5px;
      text-decoration: none; font-size: 13px;
    }
    .btn-edit { background: #ffc107; color: white; }
    .btn-hapus { background: #dc3545; color: white; }
  </style>
</head>
<body>
  <h2>Data Testimoni</h2>
  <a href="tambah_testimoni.php" class="btn-tambah">+ Tambah Testimoni</a>

  <table>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Isi</th>
      <th>Foto</th>
      <th>Aksi</th>
    </tr>
    <?php
    $no = 1;
    $sql = mysqli_query($conn, "SELECT * FROM testimoni ORDER BY id DESC");
    while ($row = mysqli_fetch_assoc($sql)) {
      echo "
        <tr>
          <td>$no</td>
          <td>{$row['nama']}</td>
          <td>{$row['isi']}</td>
          <td><img src='{$row['foto']}'></td>
          <td>
            <a href='edit_testimoni.php?id={$row['id']}' class='btn-edit'>Edit</a>
            <a href='hapus_testimoni.php?id={$row['id']}' class='btn-hapus' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
          </td>
        </tr>
      ";
      $no++;
    }
    ?>
  </table>
</body>
</html>