<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';

if (isset($_POST['simpan'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // validasi sederhana
    if (strlen($password) < 6) {
        $error = "Password minimal 6 karakter";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed);

        if ($stmt->execute()) {
            $success = "Admin baru berhasil ditambahkan!";
        } else {
            $error = "Gagal menambahkan admin!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <form method="post" class="bg-white p-6 rounded shadow w-96 space-y-4">
        <h2 class="text-xl font-bold text-center">Registrasi Admin Baru</h2>

        <?php if (isset($success)): ?>
            <div class="text-green-600 text-sm"><?= $success ?></div>
        <?php elseif (isset($error)): ?>
            <div class="text-red-600 text-sm"><?= $error ?></div>
        <?php endif; ?>

        <input type="text" name="username" placeholder="Username" class="w-full border px-3 py-2 rounded" required>

        <input type="password" name="password" placeholder="Password" class="w-full border px-3 py-2 rounded" required>

        <button name="simpan" type="submit" class="bg-blue-600 text-white w-full py-2 rounded hover:bg-blue-700">
            Simpan Admin
        </button>

        <a href="dashboard.php" class="text-sm text-gray-600 hover:underline block text-center mt-2">← Kembali ke Dashboard</a>
    </form>
</body>
</html>
