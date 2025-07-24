<?php
include 'backend/koneksi.php';

echo "<h2>Struktur Tabel Produk</h2>";

// Cek struktur tabel produk
$query = "DESCRIBE produk";
$result = mysqli_query($conn, $query);

if ($result) {
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "<td>" . $row['Default'] . "</td>";
        echo "<td>" . $row['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Error: " . mysqli_error($conn);
}

echo "<br><br><h2>Sample Data Produk</h2>";
$sample = mysqli_query($conn, "SELECT * FROM produk LIMIT 3");
if ($sample) {
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr>";
    $fields = mysqli_fetch_fields($sample);
    foreach ($fields as $field) {
        echo "<th>" . $field->name . "</th>";
    }
    echo "</tr>";
    
    while ($row = mysqli_fetch_assoc($sample)) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

echo "<br><a href='admin/edit_produk.php?id=1'>← Test Edit Produk</a>";
?>
