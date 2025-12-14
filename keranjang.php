<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'pelanggan') {
    header("Location: index.php");
    exit;
}

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

if (isset($_GET['add'])) {
    $id_produk = (int)$_GET['add'];
    $_SESSION['keranjang'][$id_produk] = ($_SESSION['keranjang'][$id_produk] ?? 0) + 1;
    header("Location: keranjang.php");
    exit;
}

if (isset($_GET['min'])) {
    $id_produk = (int)$_GET['min'];
    if (isset($_SESSION['keranjang'][$id_produk])) {
        $_SESSION['keranjang'][$id_produk]--;
        if ($_SESSION['keranjang'][$id_produk] <= 0) {
            unset($_SESSION['keranjang'][$id_produk]);
        }
    }
    header("Location: keranjang.php");
    exit;
}

if (isset($_GET['remove'])) {
    $id_produk = (int)$_GET['remove'];
    unset($_SESSION['keranjang'][$id_produk]);
    header("Location: keranjang.php");
    exit;
}

$keranjang = $_SESSION['keranjang'];
$produk_data = [];
$total_harga = 0;

if (!empty($keranjang)) {
    $ids = implode(',', array_keys($keranjang));
    $query = mysqli_query($conn, "SELECT * FROM Produk WHERE idproduk IN ($ids)");
    while ($row = mysqli_fetch_assoc($query)) {
        $produk_data[$row['idproduk']] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang Belanja - Ubay Galon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right,rgb(13, 89, 102), #c7ecee);
            font-family: 'Segoe UI', sans-serif;
        }
        .table thead {
            background-color: #007bff;
            color: white;
        }
        .produk-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #dee2e6;
        }
        .card-box {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 20px;
        }
        .btn-qty {
            width: 35px;
            height: 35px;
            padding: 0;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .total-harga {
            font-size: 1.4rem;
            font-weight: bold;
            color: #28a745;
        }
        .table td, .table th {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <h3 class="text-center mb-4">🛒 Keranjang Belanja Anda</h3>

    <div class="card-box">
        <?php if (empty($keranjang)): ?>
            <div class="alert alert-info text-center">
                Keranjang Anda kosong. <a href="katalog.php" class="alert-link">Belanja sekarang</a> 😊
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($keranjang as $id => $jumlah): 
                            if (!isset($produk_data[$id])) continue;
                            $produk = $produk_data[$id];
                            $subtotal = $produk['harga'] * $jumlah;
                            $total_harga += $subtotal;
                        ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <img src="uploads/<?= $produk['foto'] ?>" class="produk-img" alt="<?= $produk['namaproduk'] ?>">
                                    <strong><?= htmlspecialchars($produk['namaproduk']) ?></strong>
                                </div>
                            </td>
                            <td>Rp <?= number_format($produk['harga'], 0, ',', '.') ?></td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center">
                                    <a href="?min=<?= $id ?>" class="btn btn-sm btn-warning btn-qty"><i class="bi bi-dash"></i></a>
                                    <span class="mx-2"><?= $jumlah ?></span>
                                    <a href="?add=<?= $id ?>" class="btn btn-sm btn-primary btn-qty"><i class="bi bi-plus"></i></a>
                                </div>
                            </td>
                            <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                            <td>
                                <a href="?remove=<?= $id ?>" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="total-harga">Total: Rp <?= number_format($total_harga, 0, ',', '.') ?></div>
                <div>
                    <a href="katalog.php" class="btn btn-outline-primary me-2"><i class="bi bi-arrow-left-circle"></i> Lanjut Belanja</a>
                    <a href="checkout.php" class="btn btn-success"><i class="bi bi-credit-card-2-front-fill"></i> Checkout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="text-center mt-4">
        <a href="dashboard_pelanggan.php" class="btn btn-secondary"><i class="bi bi-house-door-fill"></i> Kembali ke Dashboard</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
