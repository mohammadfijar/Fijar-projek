<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    echo "ID transaksi tidak ditemukan.";
    exit;
}

$transaksi_id = intval($_GET['id']);

// Cek apakah transaksi milik user
$cek = mysqli_query($conn, "SELECT * FROM transaksi WHERE id = $transaksi_id AND user_id = $user_id");
if (mysqli_num_rows($cek) == 0) {
    echo "Transaksi tidak valid.";
    exit;
}

// Cek apakah sudah pernah memberi rating
$cek_rating = mysqli_query($conn, "SELECT * FROM rating WHERE transaksi_id = $transaksi_id AND user_id = $user_id");
if (mysqli_num_rows($cek_rating) > 0) {
    echo "<script>alert('Anda sudah memberi rating untuk pesanan ini.'); window.location='riwayat_pesanan.php';</script>";
    exit;
}

// Ambil data produk
$produk = mysqli_query($conn, "
    SELECT p.namaproduk, d.quantity, d.harga
    FROM detail_order d
    JOIN produk p ON d.idproduk = p.idproduk
    WHERE d.transaksi_id = $transaksi_id
");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rating = intval($_POST['rating']);
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);

    $simpan = mysqli_query($conn, "
        INSERT INTO rating (transaksi_id, user_id, rating, komentar, tanggal_rating)
        VALUES ($transaksi_id, $user_id, $rating, '$komentar', NOW())
    ");

    if ($simpan) {
        echo "<script>alert('Terima kasih atas penilaian Anda!'); window.location='riwayat_pesanan.php';</script>";
        exit;
    } else {
        echo "Gagal menyimpan rating.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beri Rating - Ubay Galon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .star-rating {
            font-size: 2rem;
            direction: rtl;
            display: inline-flex;
            justify-content: center;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s;
        }
        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #ffc107;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center mb-4">⭐ Beri Rating Pesanan Anda</h3>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">🧾 Detail Produk</h5>
            <ul>
                <?php while ($row = mysqli_fetch_assoc($produk)): ?>
                    <li><?= htmlspecialchars($row['namaproduk']) ?> 
                        <span class="badge bg-info">x<?= $row['quantity'] ?></span>
                        <small>(Rp <?= number_format($row['harga'], 0, ',', '.') ?>)</small>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>

    <form method="post">
        <div class="mb-3 text-center">
            <label for="rating" class="form-label">Nilai Kepuasan Anda:</label><br>
            <div class="star-rating">
                <input type="radio" name="rating" id="star5" value="5"><label for="star5">★</label>
                <input type="radio" name="rating" id="star4" value="4"><label for="star4">★</label>
                <input type="radio" name="rating" id="star3" value="3"><label for="star3">★</label>
                <input type="radio" name="rating" id="star2" value="2"><label for="star2">★</label>
                <input type="radio" name="rating" id="star1" value="1"><label for="star1">★</label>
            </div>
        </div>

        <div class="mb-3">
            <label for="komentar" class="form-label">Komentar / Keluhan (Opsional)</label>
            <textarea name="komentar" class="form-control" rows="4" placeholder="Tulis komentar Anda..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Rating</button>
        <a href="riwayat_pesanan.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
