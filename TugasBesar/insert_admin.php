<?php
// Jalankan satu kali untuk insert
include 'config.php';
$hashed = password_hash("admin123", PASSWORD_DEFAULT);
$conn->query("INSERT INTO admin (username, password) VALUES ('admin', '$hashed')");
echo "Admin ditambahkan!";
?>
