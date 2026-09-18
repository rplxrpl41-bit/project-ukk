CREATE DATABASE IF NOT EXISTS db_kasir_restoran;
USE db_kasir_restoran;

DROP TABLE IF EXISTS transaction_details;
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS menus;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 email VARCHAR(100) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 role ENUM('admin','kasir','manajer') NOT NULL DEFAULT 'kasir'
);

CREATE TABLE categories (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL
);

CREATE TABLE menus (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 category_id BIGINT UNSIGNED NOT NULL,
 name VARCHAR(100) NOT NULL,
 price INT NOT NULL DEFAULT 0,
 stock INT NOT NULL DEFAULT 0,
 image VARCHAR(255) NULL,
 FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE transactions (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 invoice_code VARCHAR(50) NOT NULL UNIQUE,
 user_id BIGINT UNSIGNED NOT NULL,
 total_amount INT NOT NULL,
 pay_amount INT NOT NULL,
 change_amount INT NOT NULL,
 table_number VARCHAR(20) NULL,
 order_type ENUM('dine_in','takeaway') DEFAULT 'dine_in',
 payment_method ENUM('cash','e_wallet') DEFAULT 'cash',
 status ENUM('paid','cancelled') NOT NULL DEFAULT 'paid',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE transaction_details (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 transaction_id BIGINT UNSIGNED NOT NULL,
 menu_id BIGINT UNSIGNED NOT NULL,
 qty INT NOT NULL,
 subtotal INT NOT NULL,
 FOREIGN KEY (transaction_id) REFERENCES transactions(id) ON DELETE CASCADE,
 FOREIGN KEY (menu_id) REFERENCES menus(id)
);

INSERT INTO users (name,email,password,role) VALUES
('Admin','admin@example.com',MD5('password'),'admin'),
('Kasir','kasir@example.com',MD5('password'),'kasir'),
('Manajer','manajer@example.com',MD5('password'),'manajer');

INSERT INTO categories (name) VALUES ('Makanan'),('Minuman'),('Dessert');

INSERT INTO menus (category_id,name,price,stock) VALUES
(1,'Nasi Goreng',18000,50),
(1,'Mie Goreng',16000,50),
(1,'Ayam Geprek',20000,40),
(2,'Es Teh',5000,100),
(2,'Jus Jeruk',10000,60),
(2,'Kopi Susu',12000,50),
(3,'Pisang Coklat',12000,40);
