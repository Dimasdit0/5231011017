<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $result = $conn->query("SELECT * FROM admin WHERE username = '$user'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            $_SESSION['login'] = true;
            header("Location: index.php");
            exit;
        }
    }
    $error = "Username atau password salah!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <form method="post" class="bg-white p-6 rounded shadow w-80 space-y-4">
        <h2 class="text-xl font-bold text-center">Login Admin</h2>

        <?php if (isset($error)): ?>
            <p class="text-red-500 text-sm"><?= $error ?></p>
        <?php endif; ?>

        <div>
            <input type="text" name="username" placeholder="Username"
                class="w-full border rounded px-3 py-2" required>
        </div>
        <div>
            <input type="password" name="password" placeholder="Password"
                class="w-full border rounded px-3 py-2" required>
        </div>
        <button type="submit" name="login"
            class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Login</button>
    </form>
</body>
</html>
