<?php
session_start();
include 'koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Ambil data transaksi dan customer tanpa join ke detail_order agar tidak duplikat
$query = "
    SELECT 
        t.id AS transaksi_id,
        t.total_harga,
        t.metode_pembayaran,
        t.status_pembayaran,
        t.status_pengiriman,
        t.tanggal_transaksi,
        t.bukti_pembayaran,
        c.nama AS nama_customer,
        c.no_telepon,
        c.alamat
    FROM transaksi t
    JOIN customer c ON t.user_id = c.user_id
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

<?php include 'sidebar_karyawan.php'; ?>

<div id="main-content" class="content p-4 w-100">
    <h3 class="text-center">Data Pesanan</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Customer</th>
                    <th>No Telepon</th>
                    <th>Alamat</th>
                    <th>Status Pengiriman</th>
                    <th>Status Pembayaran</th>
                    <th>Total Harga</th>
                    <th>Metode Pembayaran</th>
                    <th>Tanggal Transaksi</th>
                    <th>Bukti Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while($row = mysqli_fetch_assoc($pesanan)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_customer']) ?></td>
                    <td><?= htmlspecialchars($row['no_telepon']) ?></td>
                    <td><?= htmlspecialchars($row['alamat']) ?></td>
                    <td><?= htmlspecialchars($row['status_pengiriman']) ?? 'Belum diproses' ?></td>
                    <td><?= htmlspecialchars($row['status_pembayaran']) ?></td>
                    <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['metode_pembayaran']) ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($row['tanggal_transaksi'])) ?></td>
                    <td>
                        <?php if (!empty($row['bukti_pembayaran'])): ?>
                            <a href="uploads/<?= htmlspecialchars($row['bukti_pembayaran']) ?>" target="_blank">
                                <img src="uploads/<?= htmlspecialchars($row['bukti_pembayaran']) ?>" alt="Bukti" style="width:80px; height:auto; border:1px solid #ccc; border-radius:4px;">
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Belum Upload</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="detail_transaksi.php?id=<?= $row['transaksi_id'] ?>" class="btn btn-info btn-sm">Lihat Detail</a>
                        <a href="edit_pesanan.php?id=<?= $row['transaksi_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus_pesanan.php?id=<?= $row['transaksi_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus pesanan ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <a href="dashboard_karyawan.php" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
</div>

</body>
</html>
