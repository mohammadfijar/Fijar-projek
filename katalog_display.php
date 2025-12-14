<?php include "header.php"; ?>
<?php
session_start();
include 'koneksi.php';

$produk = mysqli_query($conn, "SELECT * FROM Produk ORDER BY idproduk DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog Produk Kami</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- AOS (Animate On Scroll) -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .hero {
            background: linear-gradient(135deg, #1d3557, #457b9d);
            color: white;
            padding: 60px 30px;
            text-align: center;
            border-radius: 12px;
            margin-bottom: 40px;
        }

        .card:hover {
            transform: translateY(-6px);
            transition: 0.3s ease-in-out;
            box-shadow: 0 8px 20px rgba(148, 201, 196, 0.57);
        }

        .btn-primary {
            background-color: #0077cc;
            border: none;
        }
          .produk-img {
            height: 350px;
            object-fit: cover;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .btn-primary:hover {
            background-color: #005fa3;
        }

        .btn-login {
            margin-top: 10px;
            display: inline-block;
            color: #fff;
            background: #e63946;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn-login:hover {
            background: #c62828;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <!-- Hero Section -->
    <div class="hero" data-aos="fade-down">
        <h1>Selamat Datang di Katalog Kami!</h1>
        <p>Lihat produk terbaik kami sebelum Anda bergabung atau memesan.</p>
        <a href="index.php" class="btn-login">🔐 Login untuk Membeli</a>
    </div>

    <!-- Produk List -->
    <h2 class="mb-4 text-center" data-aos="fade-down">Produk Tersedia</h2>
    
    <div class="row">
        <?php $delay = 0; ?>
        <?php while ($p = mysqli_fetch_assoc($produk)) : ?>
            <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="<?= $delay ?>">
                
                <div class="card h-100 shadow-sm">
                    <img src="uploads/<?= htmlspecialchars($p['foto']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['namaproduk']) ?>" style="height: 250px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($p['namaproduk']) ?></h5>
                        <p class="card-text">Harga: <strong>Rp <?= number_format($p['harga'], 0, ',', '.') ?></strong></p>
                        <a href="index.php" class="btn btn-primary mt-auto">🛒 Login untuk Beli</a>
                    </div>
                </div>
            </div>
            <?php $delay += 100; ?>
        <?php endwhile; ?>
    </div>
</div>

<!-- AOS JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 1000,
    once: true
  });
</script>

</body>
</html>
