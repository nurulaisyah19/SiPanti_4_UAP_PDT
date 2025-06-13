## 📌 Sistem Manajemen Donasi dan Penyaluran Bantuan Sosial (SiPanti)

SiPanti adalah sistem informasi berbasis web yang dibangun untuk mempermudah proses pencatatan, pemantauan, dan pelaporan **donasi** serta **penyaluran bantuan sosial**, seperti uang, barang, dan sembako, terutama untuk lembaga sosial seperti panti asuhan. Sistem ini memastikan integritas dan transparansi dengan dukungan berbagai fitur keamanan, database canggih, serta antarmuka yang mudah digunakan.



## 🎯 Tujuan Sistem

* Mengelola data donasi dari pengguna secara real-time.
* Menyediakan pencatatan penyaluran bantuan ke penerima manfaat.
* Memberikan visualisasi total donasi untuk masing-masing user.
* Menjaga keandalan data melalui penggunaan fitur basis data lanjutan seperti: `Transaction`, `Trigger`, `Stored Procedure`, dan `Function`.



## 🗃️ Struktur Database

### Nama Database: `sipanti`

| Tabel        | Fungsi                                                                 |
| ------------ | ---------------------------------------------------------------------- |
| `users`      | Menyimpan informasi akun pengguna seperti nama, email, password, role. |
| `donations`  | Mencatat semua donasi dari pengguna (uang/barang).                     |
| `penyaluran` | Menyimpan data penyaluran bantuan ke penerima.                         |
| `log_donasi` | Mencatat log otomatis setiap ada donasi masuk, menggunakan *trigger*.  |

---

## 🧩 Fitur dan Implementasi SQL Lanjutan

### 1. ✅ **Transaction**

#### Fungsi:

Menjamin integritas saat proses insert data donasi, agar data tidak setengah jalan jika terjadi kegagalan.

#### Implementasi:

```sql
START TRANSACTION;
-- insert ke donations
-- insert ke log_donasi (oleh trigger)
COMMIT;
```

#### Pemanggilan:

Dipanggil secara otomatis saat pengguna mengisi dan mengirimkan form donasi (`donasi.php`), untuk memastikan data tersimpan utuh.

---

### 2. ✅ **Trigger: `after_donasi_insert`**

#### Fungsi:

Mencatat log donasi secara otomatis ke tabel `log_donasi` setiap kali pengguna menambahkan donasi.

#### Implementasi:

```sql
CREATE TRIGGER after_donasi_insert
AFTER INSERT ON donations
FOR EACH ROW
BEGIN
    INSERT INTO log_donasi (user_id, amount)
    VALUES (NEW.user_id, NEW.amount);
END
```

#### Pemanggilan:

Aktif otomatis saat pengguna menambahkan donasi via form di `donasi.php`.

---

### 3. ✅ **Stored Procedure: `tambah_penyaluran`**

#### Fungsi:

Memasukkan data penyaluran bantuan secara modular dan lebih terkontrol.

#### Implementasi:

```sql
CREATE PROCEDURE tambah_penyaluran (
  IN nama VARCHAR(100),
  IN jenis VARCHAR(50),
  IN jumlah DOUBLE,
  IN ket TEXT
)
BEGIN
  INSERT INTO penyaluran (nama_penerima, jenis_bantuan, jumlah, keterangan)
  VALUES (nama, jenis, jumlah, ket);
END;
```

#### Pemanggilan:

Dipanggil dari file `penyaluran.php` ketika admin melakukan penyaluran bantuan:

```php
CALL tambah_penyaluran('$nama', '$jenis', $jumlah, '$keterangan');
```

---

### 4. ✅ **Function: `total_donasi_user`**

#### Fungsi:

Menghitung total jumlah donasi yang telah diberikan oleh satu pengguna tertentu.

#### Implementasi:

```sql
CREATE FUNCTION total_donasi_user(uid INT) RETURNS DOUBLE
BEGIN
    DECLARE total DOUBLE;
    SELECT SUM(amount) INTO total FROM donations WHERE user_id = uid;
    RETURN IFNULL(total, 0);
END;
```

#### Pemanggilan:

Dipanggil di `dashboard.php` untuk menampilkan total donasi oleh user saat login:

```php
SELECT total_donasi_user($user_id);
```

---

## 🧾 File-File dalam Sistem dan Fungsinya

| File             | Fungsi                                                           |
| ---------------- | ---------------------------------------------------------------- |
| `login.php`      | Form login dan proses autentikasi menggunakan password hash.     |
| `register.php`   | Form registrasi user baru.                                       |
| `dashboard.php`  | Menampilkan total donasi user (memanggil `total_donasi_user`).   |
| `donasi.php`     | Form input donasi → memicu `transaction` dan `trigger`.          |
| `penyaluran.php` | Form input penyaluran → memanggil `procedure tambah_penyaluran`. |
| `logout.php`     | Menghapus session dan logout user.                               |
| `config.php`     | Koneksi ke database MySQL.                                       |

---

## 💾 Backup Database

Backup tersedia dalam file `sipanti.sql`, mencakup:

* Struktur tabel
* Data awal pengguna, donasi, dan penyaluran
* Implementasi lengkap `Function`, `Procedure`, `Trigger`, dan `Transaction`
* Relasi antar tabel dan foreign key (`donations.user_id → users.id`)

---
