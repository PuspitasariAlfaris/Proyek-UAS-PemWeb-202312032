<?php include '../auth/cek_login.php'; ?>
<?php include '../backend/koneksi.php';

if (isset($_POST['submit'])) {
  $judul = $_POST['judul'];
  $gambar = $_POST['gambar']; // link URL gambar slider
  $query = mysqli_query($conn, "INSERT INTO slider (judul, gambar) VALUES ('$judul', '$gambar')");
  if ($query) {
    header("Location: slider.php");
  } else {
    echo "Gagal menambah slider!";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tambah Slider</title>
  <style>
    body { font-family: 'Poppins'; background-color: #fff0f5; padding: 40px; }
    h2 { color: #d63384; }
    form { max-width: 400px; background: #fff; padding: 20px; border-radius: 10px; }
    input[type=text] {
      width: 100%; padding: 10px; margin-top: 10px;
      border: 1px solid #ccc; border-radius: 5px;
    }
    button {
      margin-top: 15px;
      padding: 10px 20px;
      background: #d63384;
      color: white; border: none; border-radius: 5px;
    }
  </style>
</head>
<body>
  <h2>Tambah Gambar Slider</h2>
  <form method="POST">
    <label>Judul Slider:</label>
    <input type="text" name="judul" required>
    <label>Link Gambar (URL):</label>
    <input type="text" name="gambar" required>
    <button type="submit" name="submit">Simpan</button>
  </form>
</body>
</html>