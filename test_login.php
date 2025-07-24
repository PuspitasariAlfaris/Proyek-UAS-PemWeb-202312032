<?php
// Test file untuk memverifikasi login demo
include 'backend/koneksi.php';

echo "<h1>Test Login Scarlett Store</h1>";

// Test koneksi database
if ($conn) {
    echo "<p style='color: green;'>✓ Koneksi database berhasil</p>";
} else {
    echo "<p style='color: red;'>✗ Koneksi database gagal</p>";
    die();
}

// Test users
$users = mysqli_query($conn, "SELECT username, name, email, role FROM users");
if ($users && mysqli_num_rows($users) > 0) {
    echo "<h2>Demo Users:</h2>";
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>Username</th><th>Name</th><th>Email</th><th>Role</th></tr>";
    
    while ($user = mysqli_fetch_assoc($users)) {
        echo "<tr>";
        echo "<td>" . $user['username'] . "</td>";
        echo "<td>" . $user['name'] . "</td>";
        echo "<td>" . $user['email'] . "</td>";
        echo "<td>" . $user['role'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

// Test password verification
$admin_password = 'admin123';
$user_password = 'user123';

// Get hashed passwords from database
$admin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT password FROM users WHERE username='admin'"));
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT password FROM users WHERE username='user'"));

echo "<h2>Password Test:</h2>";
if (password_verify($admin_password, $admin['password'])) {
    echo "<p style='color: green;'>✓ Admin password 'admin123' valid</p>";
} else {
    echo "<p style='color: red;'>✗ Admin password 'admin123' invalid</p>";
}

if (password_verify($user_password, $user['password'])) {
    echo "<p style='color: green;'>✓ User password 'user123' valid</p>";
} else {
    echo "<p style='color: red;'>✗ User password 'user123' invalid</p>";
}

echo "<h2>Database Content:</h2>";
echo "<p>Categories: " . mysqli_num_rows(mysqli_query($conn, "SELECT * FROM categories")) . "</p>";
echo "<p>Products: " . mysqli_num_rows(mysqli_query($conn, "SELECT * FROM products")) . "</p>";
echo "<p>Sliders: " . mysqli_num_rows(mysqli_query($conn, "SELECT * FROM sliders")) . "</p>";
echo "<p>Testimonials: " . mysqli_num_rows(mysqli_query($conn, "SELECT * FROM testimonials")) . "</p>";

echo "<h2>Login Links:</h2>";
echo "<p><a href='auth/login.php'>Login Page</a></p>";
echo "<p><a href='admin/index.php'>Admin Dashboard (Login Required)</a></p>";
echo "<p><a href='user/index.php'>User Page (Login Required)</a></p>";

mysqli_close($conn);
?>
