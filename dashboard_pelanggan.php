<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'pelanggan') {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pelanggan - </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/img/icon/toko.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg,rgba(3, 31, 49, 1), #5c6446ff);
            color: #4f5458ff;
            min-height: 100vh;
        }
       
        .navbar {
            background-color: rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
        }
        .navbar-brand {
            font-weight: bold;
        }
        .card {
            border: none;
            border-radius: 20px;
            padding: 30px;
            background: #fff;
            color: #333;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .card:hover {
            transform: scale(1.03);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }
        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin: 0 auto 15px;
            font-size: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-outline-light {
            border-color: #fff;
            color: #fff;
        }
        .btn-outline-light:hover {
            background-color: #fff;
            color: #333;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark py-3">
    <div class="container">
        <a class="navbar-brand" href="#">Nasrun Gunshop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a class="nav-link text-white" href="katalog.php">Katalog Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="keranjang.php">Keranjang 🛒</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="riwayat_pesanan.php">Riwayat Pesanan</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <?= $_SESSION['name'] ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="profil.php">Profil Saya</a></li>
                        <li><a class="dropdown-item" href="logout.php" onclick="return confirm('Yakin mau keluar?')">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Content -->
<div class="container py-5">
    <h2 class="text-center mb-2">Halo, <strong><?= $_SESSION['name'] ?></strong> 👋</h2>
    <p class="text-center mb-5">Selamat datang di <strong>Dashboard Pelanggan</strong>  Yuk mulai tembakin orang-orang!</p>

    <div class="row g-4">
        <!-- Katalog Produk -->
        <div class="col-md-4">
            <div class="card text-center">
                <div class="icon-circle bg-primary text-white">
                    <i class="bi bi-box-seam"></i>
                </div>
                <h5 class="mb-2">Katalog Produk</h5>
                <p class="text-muted">Jelajahi produk yang kami jual.</p>
                <a href="katalog.php" class="btn btn-outline-primary mt-2">Lihat Katalog</a>
            </div>
        </div>

        <!-- Keranjang -->
        <div class="col-md-4">
            <div class="card text-center">
                <div class="icon-circle bg-success text-white">
                    <i class="bi bi-cart3"></i>
                </div>
                <h5 class="mb-2">Keranjang</h5>
                <p class="text-muted">Cek & kelola barang yang ingin dibeli.</p>
                <a href="keranjang.php" class="btn btn-outline-success mt-2">Buka Keranjang</a>
            </div>
        </div>

        <!-- Riwayat Pesanan -->
        <div class="col-md-4">
            <div class="card text-center">
                <div class="icon-circle bg-warning text-dark">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h5 class="mb-2">Riwayat Pesanan</h5>
                <p class="text-muted">Lacak dan lihat status pesanan Anda.</p>
                <a href="riwayat_pesanan.php" class="btn btn-outline-warning mt-2">Lihat Riwayat</a>
            </div>
        </div>
    </div>
    
</div>


<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
