==================================================
 RESTOPOS - SISTEM KASIR RESTORAN (PHP + MySQL)
 Project UKK Rekayasa Perangkat Lunak
==================================================

CARA INSTALASI (XAMPP)
1. Copy seluruh isi folder ini ke:
   C:\xampp\htdocs\project-ukk\
2. Jalankan Apache dan MySQL dari XAMPP Control Panel.
3. Buka phpMyAdmin (http://localhost/phpmyadmin), buat database baru
   bernama db_kasir_restoran, lalu import file database.sql.
4. Buka browser ke: http://localhost/project-ukk/
   (otomatis diarahkan ke halaman login)

AKUN DEMO LOGIN
- Admin    : admin@example.com   / password
- Kasir    : kasir@example.com   / password
- Manajer  : manajer@example.com / password

FITUR
- Login & manajemen sesi berbasis role (admin, kasir, manajer)
- Dashboard: ringkasan pendapatan, transaksi hari ini, stok menipis, grafik 7 hari
- Kasir / POS: pilih menu, keranjang real-time, checkout, cetak struk
- Master Data: kelola kategori & menu (tambah/edit/hapus)
- Riwayat Transaksi & Laporan Penjualan (filter tanggal, cetak)
- Struk transaksi siap cetak
- Desain elegan, seragam di semua halaman, dan responsive (desktop/tablet/HP)

CATATAN PERBAIKAN DARI VERSI SEBELUMNYA
- Menambahkan kolom `status` pada tabel transactions (versi lama query-nya
  memfilter WHERE status='paid' padahal kolom itu belum ada di database.sql,
  sehingga Dashboard & Laporan error setelah login). Sudah diperbaiki.
- Halaman login didesain ulang (split-screen, lebih elegan) tanpa mengubah
  logika autentikasi — tetap aman menggunakan prepared statement + password
  hash (MD5, sesuai level project sekolah).

STRUKTUR FOLDER
- config.php        -> koneksi database & helper (auth, role, format rupiah)
- login.php / logout.php
- index.php          -> dashboard
- pos.php            -> halaman kasir
- checkout.php       -> proses transaksi (AJAX, transaksi database aman)
- menus.php / categories.php -> master data (khusus admin)
- transactions.php   -> riwayat transaksi
- reports.php        -> laporan penjualan
- receipt.php         -> struk transaksi
- partials/           -> header & footer bersama (sidebar, topbar)
- database.sql        -> struktur & data awal database
