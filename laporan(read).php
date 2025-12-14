<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Ambil data pesanan dengan menggabungkan tabel transaksi, customer, dan detail_order
$query = "
    SELECT 
        t.id AS transaksi_id,
        t.total_harga,
        t.metode_pembayaran AS metode_pembayaran_transaksi,
        t.status_pembayaran,
        t.tanggal_transaksi,
        c.nama AS nama_customer,
        c.no_telepon,
        c.alamat,
        t.status_pengiriman,
        c.created_at,
        p.namaproduk,
        do.quantity,
        do.harga
    FROM transaksi t
    JOIN customer c ON t.user_id = c.user_id
    JOIN detail_order do ON t.id = do.transaksi_id
    JOIN produk p ON do.idproduk = p.idproduk
    ORDER BY t.id DESC
";
$pesanan = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Pesanan - Ubay Galon</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body style="display:flex; min-height:100vh; overflow-x:hidden;">

<?php include 'sidebar_owner.php'; ?>

<div id="main-content" class="content">

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Customer</th>
                <th>No Telepon</th>
                <th>Alamat</th>
                <th>Status Pesanan</th>
                <th>Status Pembayaran</th>
                <th>Total Harga</th>
                <th>Metode Pembayaran</th>
                <th>Tanggal Transaksi</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga Produk</th>
               
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while($row = mysqli_fetch_assoc($pesanan)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_customer']) ?></td>
                <td><?= htmlspecialchars($row['no_telepon']) ?></td>
                <td><?= htmlspecialchars($row['alamat']) ?></td>
                <td><?= htmlspecialchars($row['status_pengiriman']) ?></td>
                <td><?= htmlspecialchars($row['status_pembayaran']) ?></td>
                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($row['metode_pembayaran_transaksi']) ?></td>
                <td><?= date('d-m-Y H:i', strtotime($row['tanggal_transaksi'])) ?></td>
                <td><?= htmlspecialchars($row['namaproduk']) ?></td>
                <td><?= $row['quantity'] ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
            
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="dashboard_owner.php" class="btn btn-secondary">Kembali ke Dashboard</a>
</div>
</body>
</html>
