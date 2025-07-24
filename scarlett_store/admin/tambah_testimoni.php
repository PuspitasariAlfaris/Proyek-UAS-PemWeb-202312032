<?php include '../auth/cek_login.php'; ?>
<?php include '../backend/koneksi.php';

if (isset($_POST['submit'])) {
  $nama = $_POST['nama'];
  $isi = $_POST['isi'];
  $foto = $_POST['foto'];
  $query = mysqli_query($conn, "INSERT INTO testimoni (nama, isi, foto) VALUES ('$nama', '$isi', '$foto')");
  if ($query) {
    header("Location: testimoni.php");
  } else {
    echo "Gagal tambah testimoni!";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tambah Testimoni</title>
  <style>
    body { font-family: 'Poppins'; background: #fff0f5; padding: 40px; }
    h2 { color: #d63384; }
    form {
      background: white; padding: 25px; border-radius: 10px;
      max-width: 400px;
    }
    input, textarea {
      width: 100%; padding: 10px;
      margin-top: 10px; border: 1px solid #ccc; border-radius: 5px;
    }
    button {
      background: #d63384; color: white;
      padding: 10px 15px; margin-top: 15px;
      border: none; border-radius: 5px;
    }
  </style>
</head>
<body>
  <h2>Tambah Testimoni</h2>
  <form method="POST">
    <label>Nama</label>
    <input type="text" name="nama" required>
    <label>Isi Testimoni</label>
    <textarea name="isi" required></textarea>
    <label>Link Gambar (URL)</label>
    <input type="text" name="foto" required>
    <button type="submit" name="submit">Simpan</button>
  </form>
</body>
</html>