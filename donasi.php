<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: login.php");
include 'config.php';

$uid = $_SESSION['user_id'];

// Tambah Donasi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $stmt = $conn->prepare("INSERT INTO donations (user_id, amount, description) VALUES (?, ?, ?)");
    $stmt->bind_param("ids", $uid, $amount, $description);
    $stmt->execute();
    header("Location: donasi.php");
}

// Hapus Donasi
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM donations WHERE id = $id AND user_id = $uid");
    header("Location: donasi.php");
}

// Edit Donasi
$editData = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM donations WHERE id = $id AND user_id = $uid");
    $editData = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $stmt = $conn->prepare("UPDATE donations SET amount = ?, description = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("dsii", $amount, $description, $id, $uid);
    $stmt->execute();
    header("Location: donasi.php");
}

$donations = $conn->query("SELECT * FROM donations WHERE user_id = $uid ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Donasi - SiPanti</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2><?= $editData ? 'Edit Donasi' : 'Form Donasi Uang' ?></h2>
  <form method="POST" class="card p-4 shadow-sm bg-white mb-4">
    <input type="hidden" name="id" value="<?= $editData['id'] ?? '' ?>">
    <div class="mb-3">
      <label class="form-label">Jumlah Donasi (Rp)</label>
      <input type="number" class="form-control" name="amount" required min="1000" value="<?= $editData['amount'] ?? '' ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Deskripsi</label>
      <textarea class="form-control" name="description"><?= $editData['description'] ?? '' ?></textarea>
    </div>
    <button type="submit" name="<?= $editData ? 'update' : 'add' ?>" class="btn btn-<?= $editData ? 'warning' : 'success' ?>">
      <?= $editData ? 'Update' : 'Donasi' ?>
    </button>
    <?php if ($editData): ?>
      <a href="donasi.php" class="btn btn-secondary">Batal</a>
    <?php endif; ?>
    <a href="dashboard.php" class="btn btn-dark float-end">Kembali</a>
  </form>

  <h4>Riwayat Donasi</h4>
  <table class="table table-striped">
    <thead><tr><th>Jumlah</th><th>Deskripsi</th><th>Tanggal</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php while($row = $donations->fetch_assoc()): ?>
      <tr>
        <td>Rp <?= number_format($row['amount'], 0, ',', '.') ?></td>
        <td><?= $row['description'] ?></td>
        <td><?= $row['created_at'] ?></td>
        <td>
          <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
          <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus donasi ini?')">Hapus</a>
        </td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
