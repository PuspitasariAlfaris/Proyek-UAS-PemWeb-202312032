<?php
session_start();
include 'backend/koneksi.php';

echo "<h2>🔍 Database Compatibility Check - Scarlett Store</h2>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    .success { color: green; }
    .error { color: red; }
    .warning { color: orange; }
    table { border-collapse: collapse; width: 100%; margin: 10px 0; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
</style>";

if (!$conn) {
    echo "<p class='error'>❌ Database connection failed: " . mysqli_connect_error() . "</p>";
    exit;
}

echo "<p class='success'>✅ Database connected successfully</p>";

// Check required tables
$required_tables = [
    'users', 'categories', 'products', 'sliders', 'testimonials', 
    'transactions', 'transaction_items', 'favorites', 'addresses', 'activity_log'
];

$existing_tables = [];
$result = mysqli_query($conn, "SHOW TABLES");
while ($row = mysqli_fetch_row($result)) {
    $existing_tables[] = $row[0];
}

echo "<h3>📋 Tables Status</h3>";
echo "<table>";
echo "<tr><th>Table Name</th><th>Status</th><th>Row Count</th></tr>";

foreach ($required_tables as $table) {
    if (in_array($table, $existing_tables)) {
        $count_result = mysqli_query($conn, "SELECT COUNT(*) as count FROM $table");
        $count = mysqli_fetch_assoc($count_result)['count'];
        echo "<tr><td>$table</td><td class='success'>✅ EXISTS</td><td>$count rows</td></tr>";
    } else {
        echo "<tr><td>$table</td><td class='error'>❌ MISSING</td><td>-</td></tr>";
    }
}
echo "</table>";

// Check old tables that should not exist
$old_tables = ['produk', 'kategori', 'transaksi', 'log_aktivitas', 'testimoni', 'slider'];
$old_table_found = false;

echo "<h3>🗑️ Legacy Tables (Should be removed)</h3>";
echo "<table>";
echo "<tr><th>Old Table Name</th><th>Status</th></tr>";

foreach ($old_tables as $table) {
    if (in_array($table, $existing_tables)) {
        echo "<tr><td>$table</td><td class='warning'>⚠️ STILL EXISTS (Should be removed)</td></tr>";
        $old_table_found = true;
    } else {
        echo "<tr><td>$table</td><td class='success'>✅ REMOVED</td></tr>";
    }
}
echo "</table>";

// Test demo users
echo "<h3>👤 Demo Users Test</h3>";
$users_result = mysqli_query($conn, "SELECT username, name, role FROM users WHERE username IN ('admin', 'user')");

if (mysqli_num_rows($users_result) > 0) {
    echo "<table>";
    echo "<tr><th>Username</th><th>Name</th><th>Role</th><th>Password Test</th></tr>";
    
    $test_passwords = ['admin' => 'admin123', 'user' => 'user123'];
    
    while ($user = mysqli_fetch_assoc($users_result)) {
        $username = $user['username'];
        $test_pass = $test_passwords[$username];
        
        // Get password hash
        $pass_result = mysqli_query($conn, "SELECT password FROM users WHERE username='$username'");
        $pass_data = mysqli_fetch_assoc($pass_result);
        
        $password_test = password_verify($test_pass, $pass_data['password']) ? 
                        "<span class='success'>✅ VALID</span>" : 
                        "<span class='error'>❌ INVALID</span>";
        
        echo "<tr>";
        echo "<td>{$user['username']}</td>";
        echo "<td>{$user['name']}</td>";
        echo "<td>{$user['role']}</td>";
        echo "<td>$password_test</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p class='error'>❌ No demo users found</p>";
}

// Test activity log
echo "<h3>📝 Activity Log Test</h3>";
$log_test = mysqli_query($conn, "INSERT INTO activity_log (user_id, activity, description, ip_address) VALUES (1, 'System Check', 'Database compatibility check', '127.0.0.1')");

if ($log_test) {
    echo "<p class='success'>✅ Activity log insert test successful</p>";
    // Clean up test entry
    mysqli_query($conn, "DELETE FROM activity_log WHERE activity = 'System Check'");
} else {
    echo "<p class='error'>❌ Activity log insert test failed: " . mysqli_error($conn) . "</p>";
}

// Check sample data
echo "<h3>📊 Sample Data Status</h3>";
$sample_checks = [
    'Categories' => 'SELECT COUNT(*) as count FROM categories',
    'Products' => 'SELECT COUNT(*) as count FROM products',
    'Sliders' => 'SELECT COUNT(*) as count FROM sliders',
    'Testimonials' => 'SELECT COUNT(*) as count FROM testimonials'
];

echo "<table>";
echo "<tr><th>Data Type</th><th>Count</th><th>Status</th></tr>";

foreach ($sample_checks as $label => $query) {
    $result = mysqli_query($conn, $query);
    if ($result) {
        $count = mysqli_fetch_assoc($result)['count'];
        $status = $count > 0 ? "<span class='success'>✅ HAS DATA</span>" : "<span class='warning'>⚠️ NO DATA</span>";
        echo "<tr><td>$label</td><td>$count</td><td>$status</td></tr>";
    } else {
        echo "<tr><td>$label</td><td>-</td><td class='error'>❌ ERROR</td></tr>";
    }
}
echo "</table>";

echo "<hr>";
echo "<h3>🎯 Quick Actions</h3>";
echo "<p><a href='auth/login.php'>🔐 Go to Login Page</a></p>";
echo "<p><a href='test_login_simple.php'>🧪 Test Login System</a></p>";

if ($old_table_found) {
    echo "<p class='warning'>⚠️ Warning: Old tables still exist. Consider cleaning them up for consistency.</p>";
}

mysqli_close($conn);
?>
