<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'pelanggan') {
    header("Location: index.php");
    exit;
}

$produk = mysqli_query($conn, "SELECT * FROM Produk");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog Produk - Ubay Galon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            background:rgba(11, 7, 32, 1);
            font-family: 'Segoe UI', sans-serif;
        }
        .card-img-top {
    height: 200px;
    object-fit: contain;
    background-color: white;
    padding: 10px;
}

        .produk-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        .produk-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .produk-img {
            height: 350px;
            object-fit: cover;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .produk-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .produk-harga {
            font-size: 1rem;
            font-weight: bold;
            color: #28a745;
        }

        .btn-cart {
            background-color: #007bff;
            color: #fff;
        }

        .btn-cart:hover {
            background-color: #0056b3;
        }

        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">🛒 Katalog Produk</h3>
        <a href="dashboard_pelanggan.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="row g-4">
        <?php while($row = mysqli_fetch_assoc($produk)): ?>
        <div class="col-md-4 col-sm-6">
            <div class="card produk-card h-100">
                <img src="uploads/<?= $row['foto'] ?>" class="produk-img" alt="<?= $row['namaproduk'] ?>">
                <div class="card-body text-center">
                    <h5 class="produk-title"><?= $row['namaproduk'] ?></h5>
                    <p class="produk-harga">Rp <?= number_format($row['harga'], 0, ',', '.') ?></p>
                    <a href="keranjang.php?add=<?= $row['idproduk'] ?>" class="btn btn-cart w-100 mt-2">
                        <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
