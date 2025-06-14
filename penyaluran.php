<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: login.php");
include 'config.php';

// Tambah Penyaluran
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];
    $stmt = $conn->prepare("INSERT INTO penyaluran (nama_penerima, jenis_bantuan, jumlah, keterangan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $nama, $jenis, $jumlah, $keterangan);
    $stmt->execute();
    header("Location: penyaluran.php");
}

// Ambil Data
$data = $conn->query("SELECT * FROM penyaluran ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Penyaluran Bantuan - SiPanti</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2>Form Penyaluran Bantuan</h2>
  <form method="POST" class="card p-4 shadow-sm bg-white mb-4">
    <div class="mb-3">
      <label for="nama" class="form-label">Nama Penerima</label>
      <input type="text" class="form-control" name="nama" required>
    </div>
    <div class="mb-3">
      <label for="jenis" class="form-label">Jenis Bantuan</label>
      <input type="text" class="form-control" name="jenis" required>
    </div>
    <div class="mb-3">
      <label for="jumlah" class="form-label">Jumlah</label>
      <input type="number" class="form-control" name="jumlah" required>
    </div>
    <div class="mb-3">
      <label for="keterangan" class="form-label">Keterangan</label>
      <textarea class="form-control" name="keterangan"></textarea>
    </div>
    <button type="submit" name="add" class="btn btn-success">Tambah Penyaluran</button>
    <a href="dashboard.php" class="btn btn-dark float-end">Kembali ke Dashboard</a>
  </form>

  <h4>Riwayat Penyaluran</h4>
  <table class="table table-bordered table-striped">
    <thead>
      <tr><th>Nama</th><th>Jenis</th><th>Jumlah</th><th>Keterangan</th><th>Tanggal</th></tr>
    </thead>
    <tbody>
      <?php while($row = $data->fetch_assoc()): ?>
        <tr>
          <td><?= $row['nama_penerima'] ?></td>
          <td><?= $row['jenis_bantuan'] ?></td>
          <td><?= $row['jumlah'] ?></td>
          <td><?= $row['keterangan'] ?></td>
          <td><?= $row['created_at'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
