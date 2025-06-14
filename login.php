<?php
session_start(); include 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email']; $password = $_POST['password'];
    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    $user = $result->fetch_assoc();
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: dashboard.php");
    } else $error = "Login gagal.";
}
?>
<!DOCTYPE html>
<html><head><title>Login - SiPanti</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head><body class="bg-light">
<div class="container mt-5 col-md-6">
<h3>Login</h3>
<?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
<form method="POST" class="card p-4 shadow-sm bg-white">
  <div class="mb-3"><label>Email</label><input name="email" type="email" class="form-control" required></div>
  <div class="mb-3"><label>Password</label><input name="password" type="password" class="form-control" required></div>
  <button class="btn btn-success">Login</button>
  <a href="register.php" class="btn btn-link">Belum punya akun?</a>
</form></div></body></html>
