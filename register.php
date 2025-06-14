<?php
include 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name']; $email = $_POST['email']; $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);
    $stmt->execute();
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html><head><title>Register - SiPanti</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="bg-light">
<div class="container mt-5 col-md-6">
<h3>Registrasi</h3>
<form method="POST" class="card p-4 shadow-sm bg-white">
  <div class="mb-3"><label>Nama</label><input name="name" class="form-control" required></div>
  <div class="mb-3"><label>Email</label><input name="email" type="email" class="form-control" required></div>
  <div class="mb-3"><label>Password</label><input name="password" type="password" class="form-control" required></div>
  <button class="btn btn-primary">Daftar</button>
  <a href="login.php" class="btn btn-link">Sudah punya akun?</a>
</form></div></body></html>
