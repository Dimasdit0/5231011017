<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Tambah Barang</h2>

        <form method="post" class="space-y-4 max-w-md bg-white p-6 rounded shadow">
            <div>
                <label class="block font-medium">Nama Barang:</label>
                <input type="text" name="nama" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block font-medium">Jenis:</label>
                <select name="jenis" class="w-full border rounded px-3 py-2" required>
                    <option value="ekspor">Ekspor</option>
                    <option value="impor">Impor</option>
                </select>
            </div>
            <div>
                <label class="block font-medium">Negara Tujuan:</label>
                <input type="text" name="negara" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block font-medium">Jumlah:</label>
                <input type="number" name="jumlah" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" required>
            </div>
            <button type="submit" name="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
            <a href="index.php" class="ml-2 text-gray-600 hover:underline">Kembali</a>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $nama = $_POST['nama'];
            $jenis = $_POST['jenis'];
            $negara = $_POST['negara'];
            $jumlah = $_POST['jumlah'];
            $tanggal = $_POST['tanggal'];


            $conn->query("INSERT INTO barang (nama_barang, jenis, negara_tujuan, jumlah, tanggal)
VALUES ('$nama', '$jenis', '$negara', '$jumlah', '$tanggal')");
            header("Location: index.php");
        }
        ?>
    </div>
</body>
</html>
