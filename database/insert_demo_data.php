<?php
include '../backend/koneksi.php';

// Insert demo users
$demo_users = [
    [
        'nama' => 'Administrator',
        'email' => 'admin@scarlettstore.com',
        'username' => 'admin123',
        'password' => password_hash('admin123', PASSWORD_DEFAULT),
        'role' => 'admin'
    ],
    [
        'nama' => 'User Demo',
        'email' => 'user@scarlettstore.com', 
        'username' => 'user123',
        'password' => password_hash('user123', PASSWORD_DEFAULT),
        'role' => 'user'
    ]
];

echo "<h2>Menambahkan Data Demo...</h2>";

// Hapus data lama jika ada
mysqli_query($conn, "DELETE FROM users WHERE username IN ('admin123', 'user123') OR email IN ('admin@scarlettstore.com', 'user@scarlettstore.com')");

// Insert users
foreach ($demo_users as $user) {
    $query = "INSERT INTO users (nama, email, username, password, role) VALUES 
             ('{$user['nama']}', '{$user['email']}', '{$user['username']}', '{$user['password']}', '{$user['role']}')";
    
    if (mysqli_query($conn, $query)) {
        echo "✅ User {$user['username']} berhasil ditambahkan<br>";
    } else {
        echo "❌ Gagal menambahkan user {$user['username']}: " . mysqli_error($conn) . "<br>";
    }
}

echo "<br><h3>Data Demo Berhasil Ditambahkan!</h3>";
echo "<p><strong>Login Admin:</strong></p>";
echo "Username: admin123<br>";
echo "Password: admin123<br><br>";
echo "<p><strong>Login User:</strong></p>";
echo "Username: user123<br>";
echo "Password: user123<br><br>";
echo "<a href='../auth/login.php'>Klik di sini untuk login</a>";
?>