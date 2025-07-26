# 📝 Usage Guide - Scarlett Store

**Proyek Ujian Akhir Semester - Pemrograman Web**  
**Puspitasari Alfaris (202312032) - Sekolah Tinggi Teknologi Bontang**  
**Email: puspitasarialfaris0@gmail.com**

---

## Overview

Scarlett Store adalah aplikasi web e-commerce yang memungkinkan pengguna untuk berbelanja produk secara online. Sistem ini memiliki dua jenis pengguna utama: **Administrator** dan **Customer**.

## Getting Started

### Accessing the Application
1. Buka browser web
2. Akses URL aplikasi: `http://localhost/clone-puspita/`
3. Anda akan melihat halaman beranda toko online

### User Roles

#### Administrator
- Mengelola seluruh sistem
- Manajemen produk dan kategori
- Manajemen pengguna
- Monitoring pesanan
- Laporan dan statistik

#### Customer
- Melihat katalog produk
- Melakukan pemesanan
- Melihat riwayat pesanan
- Mengelola profil

## User Authentication

### Login
1. Klik tombol **"Login"** di navigation bar
2. Masukkan **Username** dan **Password**
3. Klik **"Login"**
4. Sistem akan mengarahkan Anda ke dashboard sesuai role:
   - Admin → Admin Dashboard
   - Customer → Customer Area

### Default Test Accounts

#### Admin Account
- **Username:** `admin`
- **Password:** `admin123`
- **Access:** Full system administration

#### Customer Account
- **Username:** `customer`
- **Password:** `customer123`
- **Access:** Customer shopping features

> 🔒 **Password Security:** Semua password menggunakan hash untuk keamanan maksimal

## Customer Features

### 1. Browse Products
Setelah mengakses halaman utama, customer dapat:

#### Product Catalog
- Lihat semua produk yang tersedia
- Filter berdasarkan kategori
- Melihat detail produk (gambar, deskripsi, harga)
- Search produk berdasarkan nama

#### Product Details
Setiap produk menampilkan:
- **Foto produk**
- **Nama dan deskripsi**
- **Harga**
- **Kategori**
- **Stock tersedia**
- **Tombol "Pesan Sekarang"**

### 2. Order Process

#### Step 1: Select Product
1. Pilih produk dari katalog
2. Klik **"Pesan Sekarang"**

#### Step 2: Order Form
Isi form pemesanan dengan:
- **Nama Pemesan**
- **Alamat Lengkap**
- **Nomor Telepon**
- **Jumlah Produk**
- **Total Harga** (otomatis terhitung)

#### Step 3: Confirmation
- Review detail pesanan
- Klik **"Proses Pesanan"**

#### Step 4: Order Status
Setelah pesanan berhasil:
- Status: **"Pending"** (menunggu konfirmasi admin)
- Customer akan menerima konfirmasi
- Pesanan dapat dilihat di riwayat

### 3. Order History
Customer dapat melihat:
- **Semua pesanan yang pernah dibuat**
- **Status pesanan** (Pending, Confirmed, Completed, Cancelled)
- **Detail produk yang dipesan**
- **Total pembayaran**
- **Tanggal pemesanan**

## Administrator Features

### 1. Admin Dashboard
Akses setelah login sebagai admin:

#### System Statistics
- **Total Products:** Jumlah produk tersedia
- **Total Orders:** Jumlah pesanan
- **Total Users:** Jumlah pengguna terdaftar
- **Recent Activities:** Aktivitas terbaru

#### Quick Actions
- Link cepat ke modul manajemen
- Statistik real-time
- Recent orders

### 2. Product Management
Akses melalui **Admin → Products**

#### View Products
- Daftar semua produk
- Informasi: nama, kategori, harga, stock
- Filter berdasarkan kategori atau status

#### Add New Product
1. Klik **"Add New Product"**
2. Isi form:
   - Product name
   - Category
   - Description
   - Price
   - Stock quantity
   - Upload product image
3. Klik **"Save"**

#### Edit Product
1. Klik **"Edit"** pada produk yang dipilih
2. Update informasi yang diperlukan
3. Klik **"Update"**

#### Delete Product
1. Klik **"Delete"** pada produk yang dipilih
2. Konfirmasi penghapusan
3. Produk akan dihapus dari sistem

### 3. Category Management
Akses melalui **Admin → Categories**

#### View Categories
- Daftar semua kategori produk
- Informasi: nama, jumlah produk

#### Add New Category
1. Klik **"Add New Category"**
2. Isi form:
   - Category name
   - Description
3. Klik **"Save"**

#### Edit Category
1. Klik **"Edit"** pada kategori yang dipilih
2. Update informasi yang diperlukan
3. Klik **"Update"**

### 4. Order Management
Akses melalui **Admin → Orders**

#### View All Orders
- Daftar semua pesanan
- Filter berdasarkan status atau tanggal
- Search berdasarkan customer atau produk

#### Order Actions
**Confirm Order:**
1. Pilih order dengan status "Pending"
2. Klik **"Confirm"**
3. Status berubah menjadi "Confirmed"

**Complete Order:**
1. Pilih order dengan status "Confirmed"
2. Klik **"Complete"**
3. Status berubah menjadi "Completed"

**Cancel Order:**
1. Pilih order yang akan dibatalkan
2. Klik **"Cancel"**
3. Berikan alasan pembatalan
4. Status berubah menjadi "Cancelled"

### 5. User Management
Akses melalui **Admin → Users**

#### View Users
- Daftar semua pengguna
- Informasi: username, email, role, tanggal daftar
- Filter berdasarkan role

#### Add New User
1. Klik **"Add New User"**
2. Isi form:
   - Username
   - Email
   - Password
   - Role (Admin/Customer)
3. Klik **"Save"**

#### Edit User
1. Klik **"Edit"** pada user yang dipilih
2. Update informasi yang diperlukan
3. Klik **"Update"**

### 6. Reports
Akses melalui **Admin → Reports**

#### Sales Report
- Laporan penjualan harian, bulanan, tahunan
- Grafik tren penjualan
- Top selling products

#### User Report
- Statistik registrasi pengguna
- Active users
- Customer analytics

#### Order Report
- Status pesanan overview
- Order completion rate
- Revenue analytics

### 7. System Logs
Akses melalui **Admin → Logs**

#### Activity Monitoring
- Login/logout activities
- Order activities
- System changes

#### Log Information
- **User:** Siapa yang melakukan aksi
- **Action:** Jenis aksi yang dilakukan
- **Timestamp:** Kapan aksi dilakukan
- **Description:** Detail tambahan

## Navigation Guide

### Main Navigation (All Users)
- **Home:** Halaman utama
- **Products:** Katalog produk
- **Categories:** Kategori produk
- **Login:** Untuk guest users

### Customer Navigation
- **Home:** Halaman beranda
- **Products:** Katalog produk
- **My Orders:** Riwayat pesanan
- **Profile:** Manage profile
- **Logout:** Keluar dari sistem

### Admin Navigation
- **Dashboard:** Admin dashboard
- **Products:** Manajemen produk
- **Categories:** Manajemen kategori
- **Orders:** Manajemen pesanan
- **Users:** Manajemen pengguna
- **Reports:** Laporan sistem
- **Logs:** System logs
- **Logout:** Keluar dari sistem

## Best Practices

### For Customers

#### Shopping Tips
1. **Browse Categories:** Gunakan filter kategori untuk pencarian yang lebih efisien
2. **Check Stock:** Pastikan produk tersedia sebelum memesan
3. **Complete Information:** Isi data pemesanan dengan lengkap dan akurat
4. **Save Order Details:** Simpan detail pesanan untuk referensi

#### Profile Management
1. **Keep Information Updated:** Selalu update informasi kontak
2. **Check Order Status:** Cek status pesanan secara berkala
3. **Contact Admin:** Hubungi admin jika ada masalah dengan pesanan

### For Administrators

#### Product Management
1. **Accurate Information:** Pastikan informasi produk akurat dan lengkap
2. **High Quality Images:** Upload gambar produk berkualitas tinggi
3. **Stock Updates:** Update stock secara real-time
4. **Category Organization:** Organisir produk dalam kategori yang tepat

#### Order Management
1. **Quick Response:** Respon cepat terhadap pesanan baru
2. **Regular Updates:** Update status pesanan secara berkala
3. **Customer Communication:** Komunikasi yang baik dengan customer

#### Security
1. **Regular Password Change:** Ganti password admin secara berkala
2. **Monitor Logs:** Periksa log sistem untuk aktivitas mencurigakan
3. **User Verification:** Verifikasi pengguna baru jika diperlukan

## Troubleshooting

### Common Issues

#### Login Problems
**Problem:** Cannot login  
**Solution:**
1. Check username and password
2. Ensure account is active
3. Clear browser cache
4. Contact administrator

#### Order Issues
**Problem:** Cannot complete order  
**Solution:**
1. Check product availability
2. Ensure all required fields are filled
3. Check if you're logged in (if required)
4. Try refreshing the page

#### Product Display Issues
**Problem:** Products not showing  
**Solution:**
1. Check internet connection
2. Clear browser cache
3. Try different browser
4. Contact administrator

### Error Messages

#### "Database Connection Failed"
- Check internet connection
- Contact system administrator
- Try refreshing the page

#### "Access Denied"
- Ensure you're logged in with proper credentials
- Check if you have proper permissions
- Contact administrator if needed

#### "Page Not Found"
- Check the URL
- Use navigation menu instead of direct URL
- Contact administrator if page should exist

## Support and Contact

### Getting Help
1. **Check Documentation:** Review this user guide
2. **Contact Administrator:** Use contact form or email
3. **Report Issues:** Report bugs or problems
4. **Feature Requests:** Suggest new features

### System Maintenance
- **Scheduled Maintenance:** Usually announced in advance
- **Emergency Maintenance:** May occur without notice
- **Backup Schedule:** Regular automatic backups

### Updates and Changes
- **Feature Updates:** New features added regularly
- **Security Updates:** Applied automatically
- **User Notifications:** Important changes will be announced

---

**Note:** This user guide is regularly updated. Please check for the latest version periodically.
