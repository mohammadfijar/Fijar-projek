<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'karyawan')) {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID transaksi tidak valid.";
    exit;
}

$transaksi_id = intval($_GET['id']);

// Ambil data transaksi + customer
$query_transaksi = "
    SELECT 
        t.id,
        t.total_harga,
        t.metode_pembayaran,
        t.status_pembayaran,
        t.status_pengiriman,
        t.tanggal_transaksi,
        t.bukti_pembayaran,
        c.nama,
        c.no_telepon,
        c.alamat
    FROM transaksi t
    JOIN customer c ON t.user_id = c.user_id
    WHERE t.id = $transaksi_id
";
$result_transaksi = mysqli_query($conn, $query_transaksi);
if (mysqli_num_rows($result_transaksi) == 0) {
    echo "Transaksi tidak ditemukan.";
    exit;
}
$transaksi = mysqli_fetch_assoc($result_transaksi);

// Ambil detail order
$query_detail = "
    SELECT p.namaproduk, do.quantity, do.harga
    FROM detail_order do
    JOIN produk p ON do.idproduk = p.idproduk
    WHERE do.transaksi_id = $transaksi_id
";
$result_detail = mysqli_query($conn, $query_detail);

// Ambil data rating jika ada (gunakan kolom 'rating')
$query_rating = "SELECT rating, komentar FROM rating WHERE transaksi_id = $transaksi_id LIMIT 1";
$result_rating = mysqli_query($conn, $query_rating);
$rating_data = mysqli_fetch_assoc($result_rating);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Transaksi #<?= $transaksi_id ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .star {
            font-size: 1.8rem;
        }
        .star.filled {
            color: #ffc107; /* kuning */
        }
        .star.unfilled {
            color: #e4e5e9; /* abu */
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3>Detail Transaksi #<?= $transaksi_id ?></h3>

    <div class="mb-4">
        <strong>Nama Customer:</strong> <?= htmlspecialchars($transaksi['nama']) ?><br>
        <strong>No Telepon:</strong> <?= htmlspecialchars($transaksi['no_telepon']) ?><br>
        <strong>Alamat:</strong> <?= htmlspecialchars($transaksi['alamat']) ?><br>
        <strong>Status Pembayaran:</strong> <?= htmlspecialchars($transaksi['status_pembayaran']) ?><br>
        <strong>Status Pengiriman:</strong> <?= htmlspecialchars($transaksi['status_pengiriman']) ?><br>
        <strong>Metode Pembayaran:</strong> <?= htmlspecialchars($transaksi['metode_pembayaran']) ?><br>
        <strong>Tanggal Transaksi:</strong> <?= date('d-m-Y H:i', strtotime($transaksi['tanggal_transaksi'])) ?><br>
        <strong>Total Harga:</strong> Rp <?= number_format($transaksi['total_harga'], 0, ',', '.') ?><br>
        <?php if (!empty($transaksi['bukti_pembayaran'])): ?>
            <strong>Bukti Pembayaran:</strong><br>
            <a href="uploads/<?= htmlspecialchars($transaksi['bukti_pembayaran']) ?>" target="_blank">
                <img src="uploads/<?= htmlspecialchars($transaksi['bukti_pembayaran']) ?>" alt="Bukti Pembayaran" style="max-width:200px; border:1px solid #ccc; border-radius:4px;">
            </a>
        <?php endif; ?>
    </div>

    <h4>Produk yang dipesan:</h4>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1; 
            $total = 0; 
            while ($row = mysqli_fetch_assoc($result_detail)): 
                $subtotal = $row['quantity'] * $row['harga'];
                $total += $subtotal;
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['namaproduk']) ?></td>
                <td><?= $row['quantity'] ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
            </tr>
            <?php endwhile; ?>
            <tr>
                <td colspan="4" class="text-end"><strong>Total</strong></td>
                <td><strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></td>
            </tr>
        </tbody>
    </table>

    <?php if ($rating_data): ?>
        <div class="mt-4 p-3 bg-white border rounded shadow-sm">
            <h5 class="mb-3">⭐ Rating dari Pelanggan:</h5>
            <div>
                <?php
                $nilai = intval($rating_data['rating']);
                for ($i = 1; $i <= 5; $i++) {
                    $kelas = ($i <= $nilai) ? 'filled' : 'unfilled';
                    echo '<span class="star ' . $kelas . '">&#9733;</span>';
                }
                ?>
            </div>
            <div class="mt-2">
                <strong>Komentar:</strong>
                <p><?= nl2br(htmlspecialchars($rating_data['komentar'])) ?></p>
            </div>
        </div>
    <?php endif; ?>

    <a href="pesanan.php" class="btn btn-secondary mt-4">⬅️ Kembali ke Daftar Pesanan</a>
</div>

</body>
</html>
