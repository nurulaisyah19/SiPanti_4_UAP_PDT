

# 🧩 Sistem Manajemen Donasi dan Penyaluran Bantuan Sosial (SiPanti)

**SiPanti** adalah sistem informasi berbasis web untuk mencatat, mengelola, dan memantau aliran **donasi** serta proses **penyaluran bantuan sosial** secara transparan. Sistem ini mendukung fitur autentikasi pengguna, pencatatan donasi, proses penyaluran, serta pelaporan log donasi dengan teknologi basis data terkini (trigger, function, procedure, dan transaction).

![Screenshot 2025-06-14 005949](https://github.com/user-attachments/assets/dd5df629-1b00-430d-9942-394509b672dc)


---

## 🎯 Tujuan Sistem

* Mempermudah pencatatan donasi dan bantuan.
* Menjamin keamanan dan integritas data.
* Menyediakan pelaporan dan riwayat donasi.
* Mengotomatisasi pencatatan log transaksi penting.
* Mengelola data donasi besar secara terpisah.

---

## ⚙️ Struktur Tabel & Fungsinya

| Tabel        | Deskripsi Fungsi                                                                      |
| ------------ | ------------------------------------------------------------------------------------- |
| `users`      | Menyimpan data pengguna, termasuk nama, email, password hash, dan role user |
| `donations`  | Menyimpan catatan donasi pengguna, termasuk nominal dan deskripsi                     |
| `log_donasi` | Menyimpan log otomatis dari donasi yang ditambahkan                     |
| `penyaluran` | Menyimpan catatan distribusi bantuan ke penerima manfaat                              |

---

## 🛠️ Fitur SQL Tingkat Lanjut

### 1. ✅ **Stored Procedure**: `tambah_penyaluran`

Digunakan untuk mempermudah proses input penyaluran bantuan secara modular.

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

**Dipanggil di:** `penyaluran.php` saat admin menginput distribusi bantuan.
![image](https://github.com/user-attachments/assets/68492748-90fb-4a5f-8b42-6dc3c6eac109)

---

### 2. ✅ **Function**: `total_donasi`

Menghitung total seluruh donasi berdasarkan ID user.

```sql
CREATE FUNCTION total_donasi(uid INT) RETURNS DOUBLE
BEGIN
  DECLARE total DOUBLE;
  SELECT SUM(amount) INTO total FROM donations WHERE user_id = uid;
  RETURN IFNULL(total, 0);
END;
```

**Dipanggil di:** `dashboard.php` untuk menampilkan total donasi user yang sedang login.
![image](https://github.com/user-attachments/assets/fd51fe08-842b-46c8-9b94-83595f4f5e41)

---

### 3. ✅ **Trigger**:

#### a. `after_donasi_insert`

Mencatat log setiap donasi baru ke tabel `log_donasi`.

```sql
CREATE TRIGGER after_donasi_insert
AFTER INSERT ON donations
FOR EACH ROW
BEGIN
  INSERT INTO log_donasi (user_id, amount, description)
  VALUES (NEW.user_id, NEW.amount, NEW.description);
END;
```

**Dipicu otomatis saat:** pengguna mengisi `donasi.php`.
![image](https://github.com/user-attachments/assets/ad609b18-8411-48e2-b1b4-772eb71d0f99)


---

### 4. ✅ **Transaction**

Digunakan untuk menjamin atomicity saat penyimpanan donasi dan pemanggilan trigger.

```sql
START TRANSACTION;
-- INSERT INTO donations ...
-- Trigger otomatis jalan
COMMIT;
```

**Dilakukan secara implisit di backend PHP saat donasi dilakukan.**

---

## 🧾 Penjelasan File PHP

| File             | Fungsi                                               |
| ---------------- | ---------------------------------------------------- |
| `login.php`      | Login pengguna, cek email & password hash            |
| `register.php`   | Form registrasi pengguna baru                        |
| `dashboard.php`  | Menampilkan total donasi user (gunakan function SQL) |
| `donasi.php`     | Form tambah donasi → otomatis trigger dan insert     |
| `penyaluran.php` | Form tambah bantuan → memanggil prosedur SQL         |
| `logout.php`     | Menghapus session dan logout                         |
| `config.php`     | Koneksi database MySQL                               |
| `style.css`      | Desain tampilan antar halaman web                    |



---

## 💾 Backup Database

* File backup: `backup_mysql.bat`
* Berisi seluruh struktur dan data tabel `users`, `donations`, `penyaluran`, `log_donasi`
* Termasuk: `procedure`, `function`, `trigger`, `transaction`, `foreign key`

---
