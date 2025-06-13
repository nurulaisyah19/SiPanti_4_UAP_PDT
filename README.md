Dokumentasi Proyek: Sistem Manajemen Donasi dan Penyaluran Bantuan Sosial (SiPanti)
1. Judul Proyek
Sistem Manajemen Donasi dan Penyaluran Bantuan Sosial (SiPanti)
2. Tujuan Aplikasi
- Mencatat data donasi secara aman dan terstruktur.
- Menyalurkan bantuan secara teratur dan terdokumentasi.
- Memberikan kontrol dan visualisasi total donasi kepada user.
- Menyediakan fitur CRUD, login, hingga proteksi data.
3. Struktur Database
Nama database: sipanti

Tabel-tabel:
Tabel	Fungsi
users	Menyimpan data user, email, password, role
donations	Mencatat donasi (jenis, jumlah, user)
penyaluran	Mencatat distribusi bantuan
log_donasi	Mencatat histori insert dari trigger donasi
4. Penjelasan Query SQL
a. CREATE DATABASE & USE
Digunakan untuk membuat dan memilih database yang digunakan.
b. CREATE TABLE
Contoh tabel users:
CREATE TABLE users (...);
c. Transaction
Menjamin konsistensi saat donasi:
START TRANSACTION; INSERT ... COMMIT;
d. Procedure
Untuk memasukkan penyaluran:
CALL tambah_penyaluran(...)
e. Function
Menghitung total donasi user:
SELECT total_donasi_user(1);
f. Trigger
Log otomatis setiap donasi ditambahkan.
5. Penjelasan File PHP
- login.php & register.php: Form login dan register dengan password hash dan session.
- config.php: Koneksi database MySQL.
- dashboard.php: Menampilkan total donasi dan riwayat donasi.
- donasi.php: Form donasi dan trigger insert ke log.
- penyaluran.php: Form penyaluran bantuan.
- logout.php: Menghapus session dan redirect.
6. Desain Web
Menggunakan HTML + CSS3.
Desain responsif, bersih, dan modern.
Form tertata rapi dan tombol interaktif.
7. Backup DB & GitHub
Backup database disimpan dalam file .sql
Struktur folder:
sipanti/
├── login.php
├── donasi.php
├── backup/sipanti.sql
...
8. Kesimpulan
✅ Fitur sesuai permintaan UAP:
- Login & proteksi halaman
- CRUD data
- Transaction, Procedure, Function, Trigger
- Backup database
- Upload ke GitHub
