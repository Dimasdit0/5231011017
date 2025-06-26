<?php
include 'config.php';

// Query total ekspor
$ekspor = $conn->query("SELECT SUM(jumlah) AS total FROM barang WHERE jenis='ekspor'")->fetch_assoc()['total'] ?? 0;

// Query total impor
$impor = $conn->query("SELECT SUM(jumlah) AS total FROM barang WHERE jenis='impor'")->fetch_assoc()['total'] ?? 0;

// Query pengguna baru (misalnya dari tabel admin)
$pengguna = $conn->query("SELECT COUNT(*) AS total FROM admin")->fetch_assoc()['total'] ?? 0;

// Contoh ambil data ekspor per bulan
$bulan = [];
$data_ekspor = [];
$data_impor = [];

for ($i = 1; $i <= 5; $i++) {
    $bulanName = date('M', mktime(0, 0, 0, $i, 1));
    $bulan[] = $bulanName;

    $eksporPerBulan = $conn->query("SELECT SUM(jumlah) AS total FROM barang WHERE jenis='ekspor' AND MONTH(tanggal)=$i")->fetch_assoc()['total'] ?? 0;
    $data_ekspor[] = $eksporPerBulan;

    $imporPerBulan = $conn->query("SELECT SUM(jumlah) AS total FROM barang WHERE jenis='impor' AND MONTH(tanggal)=$i")->fetch_assoc()['total'] ?? 0;
    $data_impor[] = $imporPerBulan;
}


session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
<style>
  body { font-family: 'Inter', sans-serif; }
</style>

</head>

<body class="bg-gray-100 flex">


  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow h-screen fixed">
    <div class="p-6 font-bold text-lg border-b">🚀 Ekspor-Impor</div>
    <nav class="p-4 space-y-4">
      <a href="dashboard.php" class="block text-blue-600 font-semibold">🏠 Dashboard</a>
      <a href="index.php" class="block hover:text-blue-600">📦 Data Barang</a>
      <a href="register_admin.php" class="block hover:text-blue-600">👤 Tambah Admin</a>
      <a href="logout.php" class="block text-red-500 hover:underline mt-10">🔓 Logout</a>
    </nav>
  </aside>

  <!-- Content -->
  <main class="ml-64 flex-1 p-6">
    <!-- Top bar -->
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Dashboard</h1>
      <input type="text" placeholder="Search..." class="border px-3 py-1 rounded">
    </div>

<!-- Grid utama untuk statistik dan grafik -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
  <!-- Statistik cards -->
  <div class="col-span-1 lg:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white p-4 rounded shadow">
      <p class="text-sm text-gray-500">Total Ekspor</p>
      <h2 class="text-xl font-bold">13 unit</h2>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <p class="text-sm text-gray-500">Total Impor</p>
      <h2 class="text-xl font-bold">10 unit</h2>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <p class="text-sm text-gray-500">Pengguna</p>
      <h2 class="text-xl font-bold">3 admin</h2>
    </div>
  </div>

  <!-- Grafik -->
  <div class="bg-white p-4 rounded shadow flex items-center justify-center">
    <div class="w-full">
      <h2 class="text-lg font-semibold mb-2 text-center">Grafik Ekspor / Impor</h2>
      <canvas id="grafikBar" class="w-full" style="height: 300px;"></canvas>
    </div>
  </div>
</div>


<script>
const ctx = document.getElementById('grafikBar').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($bulan) ?>,
        datasets: [{
            label: 'Ekspor',
            data: <?= json_encode($data_ekspor) ?>,
            backgroundColor: 'rgba(59, 130, 246, 0.6)'
        },
        {
            label: 'Impor',
            data: <?= json_encode($data_impor) ?>,
            backgroundColor: 'rgba(16, 185, 129, 0.6)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          legend: { labels: { color: '#000' } }
        },
        scales: {
          x: { ticks: { color: '#000' } },
          y: { ticks: { color: '#000' } }
        }
    }
});
</script>




    <!-- Table or quick info -->
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-lg font-bold mb-4">📍 Negara Tujuan Ekspor</h2>
      <table class="w-full text-left border-collapse">
        <thead>
          <tr>
            <th class="border-b p-2">Negara</th>
            <th class="border-b p-2">Jumlah</th>
            <th class="border-b p-2">Nilai</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="p-2">🇺🇸 Amerika Serikat</td>
            <td class="p-2">2500 unit</td>
            <td class="p-2">$230,900</td>
          </tr>
          <tr>
            <td class="p-2">🇩🇪 Jerman</td>
            <td class="p-2">3900 unit</td>
            <td class="p-2">$440,000</td>
          </tr>
          <tr>
            <td class="p-2">🇨🇳 China</td>
            <td class="p-2">4800 unit</td>
            <td class="p-2">$540,000</td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>

</body>
</html>
