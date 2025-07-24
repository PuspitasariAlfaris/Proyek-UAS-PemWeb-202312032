<?php
session_start();
include 'backend/koneksi.php';

echo "<h2>Test Login Scarlett Store</h2>";

// Test koneksi database
if ($conn) {
    echo "<p style='color: green;'>✓ Database connected successfully</p>";
    
    // Test login demo
    $username = 'admin';
    $password = 'admin123';
    
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' LIMIT 1");
    $user = mysqli_fetch_assoc($query);
    
    if ($user) {
        if (password_verify($password, $user['password'])) {
            echo "<p style='color: green;'>✓ Admin login test successful</p>";
            
            // Test log insertion
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $user_agent = mysqli_real_escape_string($conn, $_SERVER['HTTP_USER_AGENT']);
            $log_query = "INSERT INTO activity_log (user_id, activity, description, ip_address, user_agent) 
                          VALUES ('{$user['id']}', 'Test Login', 'Login test berhasil', '$ip_address', '$user_agent')";
            
            if (mysqli_query($conn, $log_query)) {
                echo "<p style='color: green;'>✓ Activity log test successful</p>";
            } else {
                echo "<p style='color: red;'>✗ Activity log failed: " . mysqli_error($conn) . "</p>";
            }
        } else {
            echo "<p style='color: red;'>✗ Password verification failed</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ User not found</p>";
    }
    
} else {
    echo "<p style='color: red;'>✗ Database connection failed</p>";
}

echo "<hr>";
echo "<p><a href='auth/login.php'>Go to Login Page</a></p>";
?>
