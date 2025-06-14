<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Selamat Datang - SiPanti</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container text-center mt-5">
  <h1 class="mb-3">Selamat Datang di SiPanti</h1>
  <p class="lead">Sistem Donasi & Penyaluran Bantuan untuk Panti Asuhan</p>
  <a href="login.php" class="btn btn-primary btn-lg mt-4">Masuk</a>
  <a href="register.php" class="btn btn-outline-secondary btn-lg mt-4">Daftar</a>
</div>
</body>
</html>
