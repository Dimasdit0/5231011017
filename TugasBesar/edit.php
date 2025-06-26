<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'config.php';
$id = $_GET['id'];
$data = $conn->query("SELECT * FROM barang WHERE id=$id")->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Barang</h2>

        <form method="post" class="space-y-4 max-w-md bg-white p-6 rounded shadow">
            <div>
                <label class="block font-medium">Nama Barang:</label>
                <input type="text" name="nama" class="w-full border rounded px-3 py-2" value="<?= $data['nama_barang'] ?>" required>
            </div>
            <div>
                <label class="block font-medium">Jenis:</label>
                <select name="jenis" class="w-full border rounded px-3 py-2" required>
                    <option value="ekspor" <?= $data['jenis'] == 'ekspor' ? 'selected' : '' ?>>Ekspor</option>
                    <option value="impor" <?= $data['jenis'] == 'impor' ? 'selected' : '' ?>>Impor</option>
                </select>
            </div>
            <div>
                <label class="block font-medium">Negara Tujuan:</label>
                <input type="text" name="negara" class="w-full border rounded px-3 py-2" value="<?= $data['negara_tujuan'] ?>" required>
            </div>
            <div>
                <label class="block font-medium">Jumlah:</label>
                <input type="number" name="jumlah" class="w-full border rounded px-3 py-2" value="<?= $data['jumlah'] ?>" required>
            </div>
            <div>
                <label class="block font-medium">Tanggal:</label>
                <input type="date" name="tanggal" value="<?= $data['tanggal'] ?>">
            </div>
            <button type="submit" name="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Update</button>
            <a href="index.php" class="ml-2 text-gray-600 hover:underline">Kembali</a>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $nama = $_POST['nama'];
            $jenis = $_POST['jenis'];
            $negara = $_POST['negara'];
            $jumlah = $_POST['jumlah'];
            $tanggal = $_POST['tanggal'];

            $conn->query("UPDATE barang SET nama_barang='$nama', jenis='$jenis', negara_tujuan='$negara', jumlah='$jumlah', tanggal='$tanggal' WHERE id=$id");
            header("Location: index.php");
        }
        ?>
    </div>
</body>
</html>
