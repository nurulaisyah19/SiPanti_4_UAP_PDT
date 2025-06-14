<?php
$conn = new mysqli("localhost", "root", "", "sipanti");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);
?>
