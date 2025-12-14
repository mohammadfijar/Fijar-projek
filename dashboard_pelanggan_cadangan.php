<?php
session_start();
include 'koneksi.php';

// Cek apakah user login dan memiliki role karyawan atau owner
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['karyawan', 'owner'])) {
    header("Location: index.php");
    exit;
}

$riwayat = mysqli_query($conn, "SELECT c.id, l.name AS nama_pelanggan, c.alamat, c.status_pesanan, c.metode_pembayaran, c.created_at 
    FROM customer c 
    LEFT JOIN login l ON c.user_id = l.id 
    ORDER BY c.created_at DESC");
?>
?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pesanan - Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">

<h3>📑 Riwayat Pesanan Pelanggan</h3>

<table class="table table-bordered mt-4 bg-white">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nama Pelanggan</th>
            <th>Alamat</th>
            <th>Status</th>
            <th>Metode Pembayaran</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($data = mysqli_fetch_assoc($riwayat)) { ?>
        <tr>
            <td><?= $data['id'] ?></td>
            <td><?= $data['nama_pelanggan'] ?></td>
            <td><?= $data['alamat'] ?></td>
            <td><?= $data['status_pesanan'] ?></td>
            <td><?= $data['metode_pembayaran'] ?></td>
            <td><?= $data['created_at'] ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

    <div class="mt-4 text-center no-print">
        <a href="dashboard_owner.php" class="btn btn-secondary">⬅️ Kembali ke Dashboard Owner</a>
       
    </div>
</div>

</body>
</html>
