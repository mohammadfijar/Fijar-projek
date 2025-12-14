<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header("Location: index.php");
    exit;
}

// Ambil data produk
$produk = mysqli_query($conn, "SELECT * FROM produk");

// Ambil riwayat stok (join dengan nama produk)
$riwayat = mysqli_query($conn, "
    SELECT r.*, p.namaproduk 
    FROM stok_history r 
    JOIN produk p ON r.idproduk = p.idproduk 
    ORDER BY r.tanggal DESC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok & Riwayat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="display:flex; min-height:100vh; overflow-x:hidden;">

<?php include 'sidebar_owner.php'; ?>

<div id="main-content" class="content">
    <h3 class="mb-4">📦 Laporan Stok Produk</h3>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr><th>Nama Produk</th><th>Stok Tersedia</th></tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($produk)) { ?>
            <tr>
                <td><?= htmlspecialchars($row['namaproduk']) ?></td>
                <td><?= $row['stok'] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <h4 class="mt-5">📑 Riwayat Barang Masuk / Keluar</h4>
    <table class="table table-striped table-bordered">
        <thead class="table-secondary">
            <tr>
                <th>Tanggal</th>
                <th>Nama Produk</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($log = mysqli_fetch_assoc($riwayat)) { ?>
            <tr>
                <td><?= date("d-m-Y H:i", strtotime($log['tanggal'])) ?></td>
                <td><?= htmlspecialchars($log['namaproduk']) ?></td>
                <td>
                    <span class="badge <?= $log['jenis'] == 'masuk' ? 'bg-success' : 'bg-danger' ?>">
                        <?= ucfirst($log['jenis']) ?>
                    </span>
                </td>
                <td><?= $log['jumlah'] ?></td>
                <td><?= htmlspecialchars($log['keterangan']) ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <a href="dashboard_owner.php" class="btn btn-secondary mt-3">⬅️ Kembali ke Dashboard</a>
</div>

</body>
</html>
