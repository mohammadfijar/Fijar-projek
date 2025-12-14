<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'owner')) {
    header("Location: index.php");
    exit;
}

$query = "SELECT p.nama_produk, COUNT(c.id) as total_terjual, SUM(p.harga) as total_pendapatan
          FROM Customer c
          JOIN Produk p ON c.produk_id = p.id
          WHERE c.status_pesanan = 'selesai'
          GROUP BY p.id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h2>Laporan Penjualan</h2>
    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>Nama Produk</th>
                <th>Total Terjual</th>
                <th>Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['nama_produk'] ?></td>
                <td><?= $row['total_terjual'] ?></td>
                <td>Rp <?= number_format($row['total_pendapatan']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
