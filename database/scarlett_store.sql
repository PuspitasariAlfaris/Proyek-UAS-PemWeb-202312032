-- ========================================
-- SCARLETT STORE - DATABASE LENGKAP
-- E-commerce System untuk Produk Kecantikan
-- ========================================
-- Created: 2025
-- Demo Login:
-- Admin: username=admin, password=admin123
-- User:  username=user,  password=user123
-- ========================================

-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS scarlett_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE scarlett_store;

-- ========================================
-- DROP EXISTING TABLES (untuk clean install)
-- ========================================
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS activity_log;
DROP TABLE IF EXISTS transaction_items;
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS favorites;
DROP TABLE IF EXISTS addresses;
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS testimonials;
DROP TABLE IF EXISTS sliders;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

-- ========================================
-- CREATE TABLES
-- ========================================

-- 1. Tabel Users untuk Autentikasi
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_email (email),
    INDEX idx_role (role)
);

-- 2. Tabel Categories untuk Kategori Produk
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_name (name)
);

-- 3. Tabel Products untuk Produk
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    category_id INT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_name (name),
    INDEX idx_category (category_id),
    INDEX idx_price (price),
    CONSTRAINT fk_products_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- 4. Tabel Sliders untuk Homepage Banner
CREATE TABLE sliders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200),
    description TEXT,
    image VARCHAR(255) NOT NULL,
    order_number INT DEFAULT 0,
    active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_order (order_number),
    INDEX idx_active (active)
);

-- 5. Tabel Testimonials untuk Review Pelanggan
CREATE TABLE testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    image VARCHAR(255),
    rating INT DEFAULT 5 CHECK (rating >= 1 AND rating <= 5),
    active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_rating (rating),
    INDEX idx_active (active)
);

-- 6. Tabel Transactions untuk Pesanan
CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_code VARCHAR(20) UNIQUE NOT NULL,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'confirmed', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    payment_method ENUM('transfer', 'cod', 'ewallet') DEFAULT 'transfer',
    shipping_address TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_code (transaction_code),
    INDEX idx_status (status),
    CONSTRAINT fk_transactions_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 7. Tabel Transaction Items untuk Detail Pesanan
CREATE TABLE transaction_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    INDEX idx_transaction (transaction_id),
    INDEX idx_product (product_id),
    CONSTRAINT fk_items_transaction FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE,
    CONSTRAINT fk_items_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- 8. Tabel Favorites untuk Wishlist
CREATE TABLE favorites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_product (product_id),
    UNIQUE KEY unique_favorite (user_id, product_id),
    CONSTRAINT fk_favorites_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_favorites_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- 9. Tabel Addresses untuk Alamat Pengiriman
CREATE TABLE addresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    address_name VARCHAR(100) NOT NULL,
    full_address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    postal_code VARCHAR(10) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    is_default TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_default (is_default),
    CONSTRAINT fk_addresses_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 10. Tabel Activity Log untuk Log Sistem
CREATE TABLE activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    activity VARCHAR(255) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_created (created_at),
    INDEX idx_activity (activity),
    CONSTRAINT fk_log_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ========================================
-- INSERT DEMO DATA
-- ========================================

-- Demo Users (admin/admin123 dan user/user123)
INSERT INTO users (name, email, username, password, role) VALUES 
('Administrator', 'admin@scarlettstore.com', 'admin', '$2y$10$lJHQzpYrra5xNdqC5dLzBefY.SuqZV2oX9v/BNv9wzxB4.KTH.2DS', 'admin'),
('User Demo', 'user@scarlettstore.com', 'user', '$2a$12$jZLI5JMdTkoCDnPOiD.WFemKdEeQwb9/b1hL1f2uK2vhmP2EEBwca', 'user');

-- Categories
INSERT INTO categories (id, name, description) VALUES 
(1, 'Skincare', 'Produk perawatan kulit wajah dan tubuh'),
(2, 'Makeup', 'Produk kosmetik dan makeup lengkap'),
(3, 'Haircare', 'Produk perawatan rambut'),
(4, 'Bodycare', 'Produk perawatan tubuh'),
(5, 'Fragrance', 'Parfum dan produk wewangian');

-- Products
INSERT INTO products (id, name, description, price, stock, category_id, image) VALUES 
(1, 'Serum Vitamin C Brightening', 'Serum brightening dengan vitamin C untuk kulit glowing dan cerah', 150000.00, 50, 1, 'produk1.png'),
(2, 'Foundation Natural Coverage', 'Foundation dengan coverage natural untuk kulit Indonesia', 200000.00, 30, 2, 'produk2.webp'),
(3, 'Shampoo Anti Dandruff', 'Shampoo khusus untuk mengatasi ketombe dan kulit kepala gatal', 75000.00, 40, 3, 'produk3.png'),
(4, 'Body Lotion Whitening', 'Lotion pemutih badan dengan ekstrak alami dan SPF', 120000.00, 25, 4, 'produk4.png'),
(5, 'Moisturizer Anti Acne', 'Pelembab khusus untuk kulit berjerawat dengan salicylic acid', 180000.00, 35, 1, 'produk5.webp'),
(6, 'Lipstick Matte Long Lasting', 'Lipstik dengan formula matte tahan lama hingga 12 jam', 95000.00, 60, 2, 'produk6.png'),
(7, 'Hair Mask Repair', 'Masker rambut untuk rambut rusak dan kering', 110000.00, 20, 3, 'produk7.webp'),
(8, 'Sunscreen SPF 50 PA+++', 'Tabir surya dengan perlindungan maksimal dari UV', 165000.00, 45, 1, 'produk8.jpg'),
(9, 'Concealer High Coverage', 'Concealer dengan coverage tinggi untuk menyamarkan noda', 85000.00, 55, 2, 'produk9.png'),
(10, 'Body Scrub Coffee', 'Scrub tubuh dengan ekstrak kopi untuk kulit halus', 90000.00, 30, 4, 'produk10.png'),
(11, 'Parfum Floral Elegant', 'Parfum dengan aroma floral yang elegan dan tahan lama', 250000.00, 15, 5, 'produk11.jpg'),
(12, 'Face Wash Acne Care', 'Pembersih wajah khusus untuk kulit berjerawat', 65000.00, 80, 1, 'produk12.png');

-- Sliders
INSERT INTO sliders (id, title, description, image, order_number, active) VALUES 
(1, 'Welcome to Scarlett Store', 'Temukan produk kecantikan terbaik untuk perawatan harian Anda', 'slider1.jpeg', 1, 1),
(2, 'Beauty Products Collection', 'Koleksi lengkap produk kecantikan berkualitas premium', 'slider2.jpg', 2, 1),
(3, 'Special Discount Up to 50%', 'Dapatkan diskon spesial hingga 50% untuk produk pilihan', 'slider3.jpg', 3, 1);

-- Testimonials
INSERT INTO testimonials (id, name, message, rating, image, active) VALUES 
(1, 'Sarah Johnson', 'Produk skincare di Scarlett Store sangat bagus! Kulit saya jadi lebih cerah dan sehat dalam 2 minggu pemakaian.', 5, 'testimoni1.webp', 1),
(2, 'Maya Putri', 'Pelayanan cepat dan produk original. Pengiriman juga sangat aman, packaging rapi sekali!', 5, 'testimoni2.jpg', 1),
(3, 'Rina Sari', 'Harga terjangkau dengan kualitas premium. Sudah langganan beli di sini hampir setahun.', 5, 'testimoni3.jpeg', 1),
(4, 'Lisa Amanda', 'Customer service responsif dan helpful. Terima kasih Scarlett Store sudah membantu pilihkan produk yang cocok!', 5, 'testimoni4.jpg', 1),
(5, 'Dinda Maharani', 'Produk makeup-nya awet dan pigmented. Lipstick matte-nya favorit banget, tahan seharian!', 5, 'testimoni5.jpg', 1);

-- Demo Addresses untuk user demo
INSERT INTO addresses (user_id, address_name, full_address, city, postal_code, phone, is_default) VALUES 
(2, 'Rumah', 'Jl. Sudirman No. 123, Kelurahan Senayan', 'Jakarta Selatan', '12190', '08123456789', 1);

-- Sample Activity Log
INSERT INTO activity_log (user_id, activity, description, ip_address) VALUES 
(1, 'Login', 'Admin berhasil login ke sistem', '127.0.0.1'),
(2, 'Register', 'User demo terdaftar dalam sistem', '127.0.0.1');

-- ========================================
-- SETUP COMPLETED
-- ========================================
-- Database Scarlett Store telah berhasil dibuat!
-- Login credentials:
-- Admin: admin / admin123
-- User:  user / user123
-- ========================================
