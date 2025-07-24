<?php include '../auth/cek_login.php'; ?>
<?php include '../backend/koneksi.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM testimoni WHERE id=$id"));

if (isset($_POST['submit'])) {
  $nama = $_POST['nama'];
  $isi = $_POST['isi'];
  $foto = $_POST['foto'];
  $query = mysqli_query($conn, "UPDATE testimoni SET nama='$nama', isi='$isi', foto='$foto' WHERE id=$id");
  if ($query) {
    header("Location: testimoni.php");
  } else {
    echo "Gagal update testimoni!";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Testimoni</title>
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
      background: #ffc107; color: white;
      padding: 10px 15px; margin-top: 15px;
      border: none; border-radius: 5px;
    }
  </style>
</head>
<body>
  <h2>Edit Testimoni</h2>
  <form method="POST">
    <label>Nama</label>
    <input type="text" name="nama" value="<?= $data['nama'] ?>" required>
    <label>Isi Testimoni</label>
    <textarea name="isi" required><?= $data['isi'] ?></textarea>
    <label>Link Gambar (URL)</label>
    <input type="text" name="foto" value="<?= $data['foto'] ?>" required>
    <button type="submit" name="submit">Update</button>
  </form>
</body>
</html>