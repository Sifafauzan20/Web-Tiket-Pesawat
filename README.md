# Web Tiket Pesawat (AyoTerbang)

Aplikasi web pemesanan tiket pesawat sederhana berbasis PHP Native dan MySQL.

## Fitur
- Pencarian jadwal penerbangan
- Pemilihan kelas & kursi penerbangan
- Autentikasi Pengguna (Login & Register)
- Pengisian data identitas penumpang
- Transaksi dan pencetakan tiket penerbangan

## Kebutuhan Sistem
- Web Server (Apache via XAMPP)
- PHP 7.4 / 8.x
- MySQL / MariaDB

## Panduan Instalasi & Penggunaan
1. Pastikan folder projek berada di direktori web server (misal: `htdocs/WebTiketPesawat`).
2. Jalankan modul **Apache** dan **MySQL** melalui XAMPP Control Panel.
3. Buka browser dan buka `http://localhost/phpmyadmin`.
4. Buat database baru dengan nama `ERD`.
5. Import file SQL yang ada pada direktori `db/ERD.sql` ke dalam database `ERD`.
6. Buka browser dan akses aplikasi melalui `http://localhost/WebTiketPesawat`.
