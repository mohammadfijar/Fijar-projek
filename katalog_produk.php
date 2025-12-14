<?php
session_start();
include 'koneksi.php';


$produk = mysqli_query($conn, "SELECT * FROM Produk ORDER BY idproduk DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Produk yang kami jual</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4 text-center">📦 Katalog Produk</h2>

    <div class="row">
        <?php while ($p = mysqli_fetch_assoc($produk)) : ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <img src="uploads/<?= htmlspecialchars($p['foto']) ?>" class="card-img-top" style="height: 250px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($p['namaproduk']) ?></h5>
                        <p class="card-text">Harga: <strong>Rp <?= number_format($p['harga'], 0, ',', '.') ?></strong></p>
                        <a href="checkout.php?idproduk=<?= $p['idproduk'] ?>" class="btn btn-primary mt-auto">🛒 Beli Sekarang</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="text-center mt-4">
        <a href="dashboard_pelanggan.php" class="btn btn-secondary">⬅️ Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>
