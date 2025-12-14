<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header("Location: index.php");
    exit;
}

// Total pendapatan
$pendapatan = mysqli_query($conn, "SELECT SUM(total_harga) as total FROM transaksi WHERE status_pembayaran = 'sudah_bayar'");
$total_pendapatan = mysqli_fetch_assoc($pendapatan)['total'] ?? 0;

// Jumlah transaksi
$result = mysqli_query($conn, "SELECT SUM(total_harga) as pendapatan, COUNT(*) as jumlah_transaksi FROM transaksi WHERE deleted_at IS NULL");
$data = mysqli_fetch_assoc($result);

// Ambil data pendapatan per bulan
$chartDataQuery = mysqli_query($conn, "
    SELECT DATE_FORMAT(tanggal_transaksi, '%Y-%m') AS bulan, 
           SUM(total_harga) AS total
    FROM transaksi 
    WHERE status_pembayaran = 'sudah_bayar' AND deleted_at IS NULL
    GROUP BY bulan 
    ORDER BY bulan ASC
");

$labels = [];
$values = [];

while ($row = mysqli_fetch_assoc($chartDataQuery)) {
    $labels[] = $row['bulan'];
    $values[] = $row['total'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body style="display:flex; min-height:100vh; overflow-x:hidden;">

<?php include 'sidebar_owner.php'; ?>

<div id="main-content" class="content p-4 w-100">
    <h3 class="mb-4">📈 Laporan Keuangan</h3>

    <div class="card mb-4">
        <div class="card-body">
            <h5>Total Pendapatan: <strong>Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></strong></h5>
            <h5>Jumlah Transaksi: <strong><?= $data['jumlah_transaksi'] ?></strong></h5>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Grafik Pendapatan per Bulan</div>
        <div class="card-body">
            <canvas id="grafikPendapatan" height="100"></canvas>
        </div>
    </div>

    <a href="dashboard_owner.php" class="btn btn-secondary mt-4">⬅️ Kembali ke Dashboard</a>
</div>

<script>
    const ctx = document.getElementById('grafikPendapatan').getContext('2d');
    const grafikPendapatan = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Total Pendapatan (Rp)',
                data: <?= json_encode($values) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Total Pendapatan per Bulan'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>

</body>
</html>
