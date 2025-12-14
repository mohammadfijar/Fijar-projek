<?php
session_start();
include 'koneksi.php';

// Cek login dan parameter ID
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$transaksi_id = (int) $_GET['id'];

// Ambil data transaksi
$query = "
    SELECT 
        t.id AS transaksi_id,
        c.nama,
        c.alamat,
        t.status_pembayaran,
        t.status_pengiriman,
        p.namaproduk,
        do.quantity
    FROM transaksi t
    JOIN customer c ON t.user_id = c.user_id
    JOIN detail_order do ON do.transaksi_id = t.id
    JOIN produk p ON p.idproduk = do.idproduk
    WHERE t.id = $transaksi_id
    LIMIT 1
";
$result = mysqli_query($conn, $query);
$transaksi = mysqli_fetch_assoc($result);

if (!$transaksi) {
    echo "Data tidak ditemukan!";
    exit;
}

// Proses update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status_pembayaran = mysqli_real_escape_string($conn, $_POST['status_pembayaran']);
    $status_pengiriman = mysqli_real_escape_string($conn, $_POST['status_pengiriman']);

    $allowed_pembayaran = ['belum_bayar', 'menunggu_verifikasi', 'sudah_bayar'];
    $allowed_pengiriman = ['belum_dikirim', 'dikirim', 'barang_sudah_sampai', 'selesai'];

    if (in_array($status_pembayaran, $allowed_pembayaran) && in_array($status_pengiriman, $allowed_pengiriman)) {
        $update = "
            UPDATE transaksi 
            SET 
                status_pembayaran = '$status_pembayaran',
                status_pengiriman = '$status_pengiriman'
            WHERE id = $transaksi_id
        ";
        mysqli_query($conn, $update);
    }

    // Redirect berdasarkan role
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
        header("Location: pesanan.php");
    } else {
        header("Location: laporan(kary).php");
    }
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pesanan - Ubay Galon</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3>Edit Status Pesanan</h3>

    <form method="POST">
        <div class="mb-3">
            <label>Nama Customer</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($transaksi['nama']) ?>" readonly>
        </div>

        <div class="mb-3">
            <label>Alamat</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($transaksi['alamat']) ?>" readonly>
        </div>

        <div class="mb-3">
            <label>Produk</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($transaksi['namaproduk']) ?>" readonly>
        </div>

        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" class="form-control" value="<?= $transaksi['quantity'] ?>" readonly>
        </div>

        <div class="mb-3">
            <label>Status Pembayaran</label>
            <select name="status_pembayaran" class="form-control" required>
                <option value="belum_bayar" <?= $transaksi['status_pembayaran'] == 'belum_bayar' ? 'selected' : '' ?>>Belum Dibayar</option>
                <option value="menunggu_verifikasi" <?= $transaksi['status_pembayaran'] == 'menunggu_verifikasi' ? 'selected' : '' ?>>Menunggu Verifikasi</option>
                <option value="sudah_bayar" <?= $transaksi['status_pembayaran'] == 'sudah_bayar' ? 'selected' : '' ?>>Sudah Dibayar</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Status Pengiriman</label>
            <select name="status_pengiriman" class="form-control" required>
                <option value="belum_dikirim" <?= $transaksi['status_pengiriman'] == 'belum_dikirim' ? 'selected' : '' ?>>Belum Dikirim</option>
                <option value="dikirim" <?= $transaksi['status_pengiriman'] == 'dikirim' ? 'selected' : '' ?>>Dikirim</option>
                <option value="barang_sudah_sampai" <?= $transaksi['status_pengiriman'] == 'barang_sudah_sampai' ? 'selected' : '' ?>>Barang Sudah Sampai</option>
                <option value="selesai" <?= $transaksi['status_pengiriman'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
            </select>
        </div>

        <button class="btn btn-primary">Simpan Perubahan</button>
        <a href="<?= ($_SESSION['role'] == 'admin') ? 'pesanan.php' : 'laporan(kary).php' ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
