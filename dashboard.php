<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: login.php");
include 'config.php';

$uid = $_SESSION['user_id'];
$total = $conn->query("SELECT SUM(amount) AS total FROM donations WHERE user_id = $uid")->fetch_assoc()['total'] ?? 0;
$riwayat = $conn->query("SELECT amount, description, created_at FROM donations WHERE user_id = $uid ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard - SiPanti</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #c9d6ff, #e2e2e2);
      min-height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }
    .card-total {
      background: linear-gradient(to right, #00b09b, #96c93d);
      color: white;
      border: none;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }
    .table thead {
      background-color: #007bff;
      color: white;
    }
    .btn {
      border-radius: 20px;
    }
  </style>
</head>
<body>
<div class="container py-5">
  <h2 class="text-center mb-4 fw-bold">Dashboard Anda</h2>

  <div class="card card-total mb-5">
    <div class="card-body text-center">
      <h5 class="card-title">Total Donasi Anda</h5>
      <p class="display-6 fw-bold">Rp <?= number_format($total, 0, ',', '.') ?></p>
    </div>
  </div>

  <div class="bg-white p-4 rounded shadow-sm">
    <h5 class="mb-3">Riwayat Donasi</h5>
    <table class="table table-bordered table-striped">
      <thead>
        <tr><th>Jumlah</th><th>Deskripsi</th><th>Tanggal</th></tr>
      </thead>
      <tbody>
        <?php while($row = $riwayat->fetch_assoc()): ?>
        <tr>
          <td>Rp <?= number_format($row['amount'], 0, ',', '.') ?></td>
          <td><?= $row['description'] ?></td>
          <td><?= date('d M Y H:i', strtotime($row['created_at'])) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <div class="mt-4 d-flex justify-content-between">
      <div>
        <a href="donasi.php" class="btn btn-success">Donasi Lagi</a>
        <a href="penyaluran.php" class="btn btn-outline-primary">Penyaluran</a>
      </div>
      <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
  </div>
</div>
</body>
</html>
