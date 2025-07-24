<?php include '../auth/cek_login.php'; ?>
<?php include '../backend/koneksi.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM slider WHERE id=$id"));

if (isset($_POST['submit'])) {
  $judul = $_POST['judul'];
  $gambar = $_POST['gambar'];
  $query = mysqli_query($conn, "UPDATE slider SET judul='$judul', gambar='$gambar' WHERE id=$id");
  if ($query) {
    header("Location: slider.php");
  } else {
    echo "Gagal mengedit slider!";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Slider</title>
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
      background: #ffc107;
      color: white; border: none; border-radius: 5px;
    }
  </style>
</head>
<body>
  <h2>Edit Slider</h2>
  <form method="POST">
    <label>Judul Slider:</label>
    <input type="text" name="judul" value="<?= $data['judul']; ?>" required>
    <label>Link Gambar (URL):</label>
    <input type="text" name="gambar" value="<?= $data['gambar']; ?>" required>
    <button type="submit" name="submit">Update</button>
  </form>
</body>
</html>