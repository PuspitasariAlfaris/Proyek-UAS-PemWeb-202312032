# 📖 Installation Guide - Scarlett Store

**Proyek Ujian Akhir Semester - Pemrograman Web**  
**Puspitasari Alfaris (202312032) - Sekolah Tinggi Teknologi Bontang**  
**Email: puspitasarialfaris0@gmail.com**

---

## Prerequisites

Sebelum memulai instalasi, pastikan sistem Anda memenuhi persyaratan berikut:

### System Requirements
- **Operating System:** Windows 10/11, macOS 10.15+, atau Linux (Ubuntu 18.04+)
- **Web Server:** Apache 2.4+ atau Nginx 1.18+
- **PHP:** Version 7.4 atau lebih tinggi
- **Database:** MySQL 5.7+ atau MariaDB 10.5+
- **Memory:** Minimum 512MB RAM
- **Storage:** Minimum 100MB disk space

### Required PHP Extensions
```bash
php-pdo
php-pdo-mysql
php-session
php-json
php-mbstring
php-openssl
php-curl
php-gd (untuk manipulasi gambar)
```

## Installation Methods

### Method 1: XAMPP (Recommended for Development)

#### Step 1: Download and Install XAMPP
1. Kunjungi [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Download XAMPP untuk sistem operasi Anda
3. Install XAMPP dengan pengaturan default
4. Jalankan XAMPP Control Panel

#### Step 2: Start Services
```bash
# Melalui XAMPP Control Panel, start:
- Apache
- MySQL
```

#### Step 3: Download Project
```bash
# Option A: Download ZIP
# Download project dari repository dan extract ke folder htdocs

# Option B: Git Clone (jika Git tersedia)
cd C:\xampp\htdocs\  # Windows
cd /Applications/XAMPP/htdocs/  # macOS
cd /opt/lampp/htdocs/  # Linux

git clone <repository-url> clone-puspita
```

#### Step 4: Database Setup
1. Buka browser dan akses `http://localhost/phpmyadmin`
2. Klik "New" untuk membuat database baru
3. Nama database: `scarlett_store`
4. Collation: `utf8mb4_unicode_ci`
5. Klik "Create"
6. Pilih database yang baru dibuat
7. Klik tab "Import"
8. Pilih file `database/scarlett_store.sql` dari folder project
9. Klik "Go" untuk import

#### Step 5: Configuration
Edit file `backend/koneksi.php`:
```php
<?php
$host = 'localhost';
$username = 'root';
$password = '';  // Kosong untuk XAMPP default
$database = 'scarlett_store';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
```

#### Step 6: Setup Upload Directories
```bash
# Create directories untuk file upload
mkdir assets/img/products
mkdir assets/img/sliders
mkdir assets/img/testimonials
chmod 755 assets/img/products
chmod 755 assets/img/sliders
chmod 755 assets/img/testimonials
```

#### Step 7: Access Application
Buka browser dan akses: `http://localhost/clone-puspita/`

## Post-Installation Setup

### 1. Verify Installation
Akses aplikasi melalui browser dan pastikan:
- Halaman utama dapat diakses
- Database connection berhasil
- Tidak ada error PHP

### 2. Test Default Accounts
Login dengan akun default:

**Admin Account:**
- Username: `admin`
- Password: `admin123`

**Customer Account:**
- Username: `customer`
- Password: `customer123`

> 🔒 **Password Security:** Semua password menggunakan hash untuk keamanan maksimal

### 3. Security Configuration

#### Change Default Passwords
```sql
-- Update admin password
UPDATE users SET password = MD5('new_password') WHERE username = 'admin';

-- Update customer password
UPDATE users SET password = MD5('new_password') WHERE username = 'customer';
```

#### File Permissions (Linux)
```bash
# Set proper ownership
sudo chown -R www-data:www-data /var/www/html/clone-puspita/

# Set proper permissions
sudo find /var/www/html/clone-puspita/ -type d -exec chmod 755 {} \;
sudo find /var/www/html/clone-puspita/ -type f -exec chmod 644 {} \;
```

## Troubleshooting

### Common Installation Issues

#### 1. Database Connection Failed
**Error:** `Connection failed: SQLSTATE[HY000] [1045] Access denied`

**Solution:**
```bash
# Check MySQL service
sudo systemctl status mysql

# Reset MySQL password
sudo mysql -u root -p
ALTER USER 'root'@'localhost' IDENTIFIED BY 'new_password';
FLUSH PRIVILEGES;
```

#### 2. Permission Denied
**Error:** `Permission denied` atau `403 Forbidden`

**Solution:**
```bash
# Fix file permissions
sudo chown -R www-data:www-data /var/www/html/clone-puspita/
sudo chmod -R 755 /var/www/html/clone-puspita/
```

#### 3. PHP Extensions Missing
**Error:** `Call to undefined function PDO()`

**Solution:**
```bash
# Install missing PHP extensions
sudo apt install php7.4-mysql php7.4-pdo -y
sudo systemctl restart apache2
```

## Verification Checklist

Setelah instalasi selesai, pastikan semua item berikut berfungsi:

- [ ] Aplikasi dapat diakses melalui browser
- [ ] Database connection berhasil
- [ ] Login admin berfungsi
- [ ] Login customer berfungsi
- [ ] Catalog produk dapat dilihat
- [ ] Form pemesanan berfungsi
- [ ] Dashboard admin dapat diakses
- [ ] Navigasi antar halaman berfungsi
- [ ] Upload gambar berfungsi (jika ada)
- [ ] Session management berfungsi

## Next Steps

Setelah instalasi berhasil:

1. Baca [USAGE.md](USAGE.md) untuk panduan penggunaan
2. Baca [DATABASE.md](DATABASE.md) untuk memahami struktur database
3. Baca [DEPLOYMENT.md](DEPLOYMENT.md) untuk deployment ke production
4. Customize aplikasi sesuai kebutuhan
5. Setup backup dan monitoring

## Support

Jika mengalami masalah selama instalasi:

1. Periksa log error di `/var/log/apache2/error.log`
2. Periksa log PHP error
3. Pastikan semua service berjalan
4. Verifikasi konfigurasi database
5. Periksa file permissions

Untuk bantuan lebih lanjut, silakan hubungi developer atau buat issue di repository.
