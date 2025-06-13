SiPanti - Sistem Donasi dan Penyaluran Bantuan Sosial
1. Pendahuluan

SiPanti adalah sistem informasi berbasis web yang dikembangkan untuk memudahkan pengelolaan donasi dan penyaluran bantuan sosial. 
Sistem ini menyediakan antarmuka pengguna yang intuitif serta mencakup proses login, registrasi, manajemen donasi uang, penyaluran bantuan, 
dan pengelolaan data dengan fitur keamanan dan akuntabilitas.

2. Fitur Sistem

- Login & Register: Otentikasi pengguna menggunakan email dan password.
- Dashboard: Menampilkan total donasi dan riwayat donasi pengguna.
- CRUD Donasi: Tambah, edit, dan hapus donasi uang.
- Penyaluran Bantuan: Input data penyaluran kepada penerima.
- Proteksi Halaman: Semua halaman terproteksi session.
- Logout: Mengakhiri session pengguna.
- Desain Responsif: Menggunakan Bootstrap agar tampilan menarik dan mobile-friendly.

3. Struktur Database

Tabel utama dalam database:
- users: Menyimpan data pengguna (id, name, email, password, role).
- donations: Menyimpan data donasi uang (id, user_id, amount, description, created_at).
- penyaluran: Menyimpan data penyaluran bantuan (id, nama_penerima, jenis_bantuan, jumlah, keterangan, created_at).

4. Stored Procedure

a. tambah_penyaluran:
Prosedur untuk menambahkan data penyaluran bantuan ke tabel `penyaluran`.

DELIMITER //
CREATE PROCEDURE tambah_penyaluran (
    IN nama VARCHAR(100),
    IN jenis VARCHAR(50),
    IN jumlah DOUBLE,
    IN ket TEXT
)
BEGIN
    INSERT INTO penyaluran (nama_penerima, jenis_bantuan, jumlah, keterangan)
    VALUES (nama, jenis, jumlah, ket);
END //
DELIMITER ;

5. Function

a. get_total_donasi:
Function untuk menghitung total donasi berdasarkan user_id.

DELIMITER //
CREATE FUNCTION get_total_donasi(uid INT) RETURNS DOUBLE
BEGIN
    DECLARE total DOUBLE;
    SELECT SUM(amount) INTO total FROM donations WHERE user_id = uid;
    RETURN IFNULL(total, 0);
END //
DELIMITER ;

6. Trigger

a. before_insert_donasi:
Trigger untuk validasi data sebelum memasukkan donasi agar tidak nol atau negatif.

DELIMITER //
CREATE TRIGGER before_insert_donasi
BEFORE INSERT ON donations FOR EACH ROW
BEGIN
    IF NEW.amount <= 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Jumlah donasi harus lebih dari 0';
    END IF;
END //
DELIMITER ;

7. Backup Database

Backup dapat dilakukan dengan tools seperti phpMyAdmin atau dengan command:
mysqldump -u root -p sipanti > sipanti_backup.sql

Ini menyimpan seluruh isi database ke dalam file .sql yang dapat direstore ulang.

8. Kesimpulan

Sistem SiPanti dirancang untuk memudahkan proses donasi dan penyaluran bantuan sosial secara digital. 
Dengan implementasi fitur CRUD, fungsi database, trigger, dan prosedur, sistem ini dapat menjamin integritas dan keandalan data.

