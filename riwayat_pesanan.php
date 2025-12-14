<?php 
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil status pengiriman terbaru dari database
$query_status = "SELECT id, status_pengiriman FROM transaksi WHERE user_id = $user_id AND deleted_at IS NULL";
$result_status = mysqli_query($conn, $query_status);

$status_baru = [];
while ($row = mysqli_fetch_assoc($result_status)) {
    $status_baru[$row['id']] = $row['status_pengiriman'];
}

// Cek apakah status pengiriman berubah dibanding sesi sebelumnya
if (isset($_SESSION['status_pengiriman_terakhir'])) {
    foreach ($status_baru as $id => $status) {
        if (
            isset($_SESSION['status_pengiriman_terakhir'][$id]) &&
            $_SESSION['status_pengiriman_terakhir'][$id] !== $status
        ) {
            $_SESSION['notifikasi_status'] = "Status pengiriman untuk pesanan <strong>#{$id}</strong> telah berubah menjadi <strong>{$status}</strong>.";
            break;
        }
    }
}

// Simpan status terbaru ke sesi
$_SESSION['status_pengiriman_terakhir'] = $status_baru;

// Tangani konfirmasi dari pelanggan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['konfirmasi_sampai'])) {
    $transaksi_id = intval($_POST['transaksi_id']);

    $cekQuery = mysqli_query($conn, "SELECT * FROM transaksi WHERE id = $transaksi_id AND user_id = $user_id");

    if (mysqli_num_rows($cekQuery) > 0) {
        mysqli_query($conn, "UPDATE transaksi SET status_pengiriman = 'barang_sudah_sampai' WHERE id = $transaksi_id");
    }
}

// Ambil riwayat transaksi user beserta rating jika ada
$query = "
    SELECT t.*, r.rating, r.komentar
    FROM transaksi t
    LEFT JOIN rating r ON t.id = r.transaksi_id AND r.user_id = $user_id
    WHERE t.user_id = $user_id AND t.deleted_at IS NULL
    ORDER BY t.id DESC
";
$riwayat = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan - Ubay Galon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .order-card { border-left: 6px solid #0d6efd; transition: transform 0.2s ease; }
        .order-card:hover { transform: scale(1.01); }
        .order-header {
            background-color: #0d6efd;
            color: white;
            padding: 10px 15px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .order-body {
            background: #fff;
            padding: 15px;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }
        .star-display {
            color: #ffc107;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">📦 Riwayat Pesanan Anda</h2>

    <!-- Notifikasi perubahan status -->
    <?php if (isset($_SESSION['notifikasi_status'])): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?= $_SESSION['notifikasi_status']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['notifikasi_status']); ?>
    <?php endif; ?>

    <?php if (mysqli_num_rows($riwayat) > 0): ?>
        <?php while($row = mysqli_fetch_assoc($riwayat)): ?>
            <?php
                $transaksi_id = $row['id'];
                $produk_query = "
                    SELECT d.*, p.namaproduk 
                    FROM detail_order d 
                    JOIN produk p ON d.idproduk = p.idproduk 
                    WHERE d.transaksi_id = $transaksi_id
                ";
                $produk_result = mysqli_query($conn, $produk_query);
            ?>
            <div class="card mb-4 shadow-sm order-card">
                <div class="order-header d-flex justify-content-between align-items-center">
                    <span>🧾 Pesanan #<?= $transaksi_id ?></span>
                    <span class="small"><?= date('d-m-Y H:i', strtotime($row['tanggal_transaksi'])) ?></span>
                </div>
                <div class="order-body">
                    <p><strong>Produk:</strong></p>
                    <ul>
                        <?php while ($produk = mysqli_fetch_assoc($produk_result)): ?>
                            <li><?= htmlspecialchars($produk['namaproduk']) ?> 
                                <span class="badge bg-info">x<?= $produk['quantity'] ?></span> 
                                <small>(Rp <?= number_format($produk['harga'], 0, ',', '.') ?>)</small>
                            </li>
                        <?php endwhile; ?>
                    </ul>

                    <p><strong>Total:</strong> Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></p>
                    <p><strong>Metode Pembayaran:</strong> <?= htmlspecialchars($row['metode_pembayaran']) ?></p>
                    <p><strong>Status Pembayaran:</strong>
                        <?php 
                        switch ($row['status_pembayaran']) {
                            case 'belum_bayar':
                                echo '<span class="badge bg-warning text-dark">Belum Dibayar</span>';
                                break;
                            case 'menunggu_verifikasi':
                                echo '<span class="badge bg-info text-dark">Menunggu Verifikasi</span>';
                                break;
                            case 'sudah_bayar':
                                echo '<span class="badge bg-success">Sudah Dibayar</span>';
                                break;
                            default:
                                echo '<span class="badge bg-secondary">Status Tidak Dikenal</span>';
                        }
                        ?>
                    </p>

                    <p><strong>Status Pengiriman:</strong>
                        <?php 
                        switch ($row['status_pengiriman']) {
                            case 'belum_dikirim':
                                echo '<span class="badge bg-secondary">Belum Dikirim</span>';
                                break;
                            case 'dikirim':
                                echo '<span class="badge bg-primary">Sedang Dikirim</span>';
                                break;
                            case 'barang_sudah_sampai':
                                echo '<span class="badge bg-success">Barang Sudah Sampai</span>';
                                break;
                            case 'selesai':
                                echo '<span class="badge bg-success">Pesanan Selesai</span>';
                                break;
                            default:
                                echo '<span class="badge bg-dark">Belum Dikirim</span>';
                        }
                        ?>
                    </p>

                    <?php if ($row['status_pengiriman'] == 'dikirim'): ?>
                        <form method="post" class="d-inline">
                            <input type="hidden" name="transaksi_id" value="<?= $row['id'] ?>">
                            <button type="submit" name="konfirmasi_sampai" class="btn btn-sm btn-warning">
                                📩 Konfirmasi Barang Sudah Sampai
                            </button>
                        </form>
                    <?php endif; ?>

                    <?php 
                    // Jika status sudah barang_sudah_sampai dan belum ada rating, tampilkan tombol rating
                    if ($row['status_pengiriman'] == 'barang_sudah_sampai' && $row['rating'] === null): ?>
                        <a href="rating.php?id=<?= $transaksi_id ?>" class="btn btn-sm btn-success mt-2">
                            ⭐ Pesanan Diterima - Beri Rating
                        </a>
                    <?php endif; ?>

                    <?php 
                    // Jika sudah ada rating, tampilkan rating dan komentar
                    if ($row['rating'] !== null): ?>
                        <hr>
                        <div>
                            <strong>Rating Anda:</strong> 
                            <span class="star-display">
                                <?php 
                                for ($i=1; $i <= 5; $i++) {
                                    echo ($i <= $row['rating']) ? '★' : '☆';
                                }
                                ?>
                            </span>
                        </div>
                        <?php if (!empty(trim($row['komentar']))): ?>
                            <div><strong>Komentar:</strong> <?= nl2br(htmlspecialchars($row['komentar'])) ?></div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- Upload / lihat bukti pembayaran -->
                    <div class="mt-2">
                        <?php 
                        $metode = strtolower($row['metode_pembayaran']);
                        if ($metode === 'qris'): 
                            if (empty($row['bukti_pembayaran'])): ?>
                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal<?= $row['id'] ?>">📤 Upload Bukti Pembayaran</button>
                            <?php else: ?>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#lihatBukti<?= $row['id'] ?>">🖼️ Lihat Bukti Pembayaran</button>
                            <?php endif; 
                        elseif ($metode === 'cod'): ?>
                            <span class="badge bg-secondary">Bayar di Tempat (COD)</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Metode Tidak Dikenal</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Modal Upload -->
            <div class="modal fade" id="uploadModal<?= $row['id'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="upload_bukti.php" method="post" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title">Upload Bukti Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="transaksi_id" value="<?= $row['id'] ?>">
                                <input type="file" name="bukti_pembayaran" class="form-control" required>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="upload" class="btn btn-primary">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Lihat Bukti -->
            <div class="modal fade" id="lihatBukti<?= $row['id'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Bukti Pembayaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="uploads/<?= htmlspecialchars($row['bukti_pembayaran']) ?>" class="img-fluid rounded shadow-sm" alt="Bukti Pembayaran">
                        </div>
                    </div>
                </div>
            </div>

        <?php endwhile; ?>
    <?php else: ?>
        <div class="alert alert-info text-center">
            Belum ada riwayat pesanan. <a href="katalog.php" class="alert-link">Belanja sekarang</a>.
        </div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="dashboard_pelanggan.php" class="btn btn-secondary">⬅️ Kembali ke Dashboard</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
