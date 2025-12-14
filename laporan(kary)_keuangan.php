<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], [ 'karyawan'])) {
    header("Location: index.php");
    exit;
}

$pesanan = mysqli_query($conn, "
    SELECT 
        t.id, 
        l.name AS nama,
        t.total_harga,
        t.metode_pembayaran,
        t.status_pembayaran,
        t.tanggal_transaksi
    FROM transaksi t
    LEFT JOIN login l ON t.user_id = l.id
    WHERE t.deleted_at IS NULL
    ORDER BY t.id DESC
");

$riwayat = mysqli_query($conn, "
    SELECT r.*, p.namaproduk 
    FROM stok_history r 
    JOIN produk p ON r.idproduk = p.idproduk 
    ORDER BY r.tanggal DESC
");

$pendapatan = mysqli_query($conn, "SELECT SUM(total_harga) as total FROM transaksi WHERE status_pembayaran = 'sudah_bayar' AND deleted_at IS NULL");
$total_pendapatan = mysqli_fetch_assoc($pendapatan)['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pesanan & Stok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #fff;
            color: #000;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #000 !important;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #e9ecef !important;
        }
        .fw-bold {
            font-weight: bold;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                margin: 0;
            }
            th, td {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>

<div id="main-content" class="content">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Laporan Pesanan</h3>
            <button onclick="window.print()" class="btn btn-primary no-print">🖨️ Cetak</button>
        </div>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Customer</th>
                <th>Metode Pembayaran</th>
                <th>Status Pembayaran</th>
                <th>Total Harga</th>
                <th>Tanggal Transaksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            if ($pesanan && mysqli_num_rows($pesanan) > 0):
                while ($row = mysqli_fetch_assoc($pesanan)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['metode_pembayaran']) ?></td>
                        <td><?= ucfirst(str_replace('_', ' ', $row['status_pembayaran'])) ?></td>
                        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($row['tanggal_transaksi'])) ?></td>
                    </tr>
                <?php endwhile;
            else: ?>
                <tr><td colspan="6" class="text-center">Tidak ada data transaksi.</td></tr>
            <?php endif; ?>
            <tr class="fw-bold">
                <td colspan="4" class="text-end">Total Pendapatan (Sudah Dibayar)</td>
                <td colspan="2">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></td>
            </tr>
        </tbody>
    </table>

    <h3>Riwayat Barang Masuk / Keluar</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Produk</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($riwayat && mysqli_num_rows($riwayat) > 0):
                while ($log = mysqli_fetch_assoc($riwayat)): ?>
                    <tr>
                        <td><?= date("d-m-Y H:i", strtotime($log['tanggal'])) ?></td>
                        <td><?= htmlspecialchars($log['namaproduk']) ?></td>
                        <td><?= ucfirst($log['jenis']) ?></td>
                        <td><?= $log['jumlah'] ?></td>
                        <td><?= htmlspecialchars($log['keterangan']) ?></td>
                    </tr>
            <?php endwhile;
            else: ?>
                <tr><td colspan="5" class="text-center">Tidak ada data riwayat stok.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="mt-4 no-print">
        <a href="dashboard_karyawan.php" class="btn btn-secondary">⬅️ Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>
