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
    <title>Data Ekspor-Impor</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <nav class="bg-white shadow p-4 flex justify-between">
  <h1 class="font-bold">WEBSITE EKSPOR-IMPOR</h1>
</nav>

</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-6">
        <h2 class="text-2xl font-bold mb-4">Daftar Barang Ekspor-Impor</h2>
        
        <!-- Form Filter & Search -->
        <form method="get" class="flex flex-wrap gap-4 items-center mb-6">
            <input type="text" name="cari" placeholder="Cari nama barang..." value="<?= $_GET['cari'] ?? '' ?>"
                class="border rounded px-3 py-2 w-64">

            <select name="jenis" class="border rounded px-3 py-2">
                <option value="">Semua Jenis</option>
                <option value="ekspor" <?= (($_GET['jenis'] ?? '') == 'ekspor') ? 'selected' : '' ?>>Ekspor</option>
                <option value="impor" <?= (($_GET['jenis'] ?? '') == 'impor') ? 'selected' : '' ?>>Impor</option>
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>
            <a href="index.php" class="text-gray-600 hover:underline ml-2">Reset</a>
        </form>
        
        <a href="logout.php" class="inline-block bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 mb-4 float-right">Logout</a>
        <a href="tambah.php" class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mb-4">+ Tambah Data</a>
        <a href="dashboard.php" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">➤ Menuju Dashboard</a>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded shadow">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="py-2 px-4">ID</th>
                        <th class="py-2 px-4">Nama Barang</th>
                        <th class="py-2 px-4">Jenis</th>
                        <th class="py-2 px-4">Negara Tujuan</th>
                        <th class="py-2 px-4">Jumlah</th>
                        <th class="py-2 px-4">Tanggal</th>
                        <th class="py-2 px-4">Aksi</th>
                    </tr>
                </thead>
              <tbody>
<?php
// Filter SQL
$cari = $_GET['cari'] ?? '';
$jenis = $_GET['jenis'] ?? '';

$where = [];
if ($cari != '') {
    $where[] = "nama_barang LIKE '%" . $conn->real_escape_string($cari) . "%'";
}
if ($jenis != '') {
    $where[] = "jenis = '" . $conn->real_escape_string($jenis) . "'";
}

$sql = "SELECT * FROM barang";
if (count($where) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Format tanggal
        $tanggal_format = !empty($row['tanggal']) ? date('d-m-Y', strtotime($row['tanggal'])) : '-';

        echo "<tr class='border-t hover:bg-gray-100'>
            <td class='py-2 px-4'>{$row['id']}</td>
            <td class='py-2 px-4'>{$row['nama_barang']}</td>
            <td class='py-2 px-4 capitalize'>{$row['jenis']}</td>
            <td class='py-2 px-4'>{$row['negara_tujuan']}</td>
            <td class='py-2 px-4'>{$row['jumlah']}</td>
            <td class='py-2 px-4'>{$tanggal_format}</td>
            <td class='py-2 px-4 space-x-2'>
                <a href='edit.php?id={$row['id']}' class='text-blue-600 hover:underline'>Edit</a>
                <a href='hapus.php?id={$row['id']}' onclick='return confirm(\"Yakin?\")' class='text-red-600 hover:underline'>Hapus</a>
            </td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='7' class='text-center py-4 text-gray-500'>Data tidak ditemukan</td></tr>";
}
?>
</tbody>

            </table>
        </div>
    </div>
</body>
</html>
