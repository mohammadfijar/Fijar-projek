<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'karyawan') {
    header("Location: index.php");
    exit;
}

// Hitung jumlah penjualan
$penjualan = mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi");
$jumlah_penjualan = mysqli_fetch_assoc($penjualan)['total'];

// Hitung penjualan hari ini
$penjualan_hari_ini = mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi WHERE DATE(tanggal_transaksi) = CURDATE()");
$jumlah_penjualan_hari_ini = mysqli_fetch_assoc($penjualan_hari_ini)['total'];

// Hitung total pendapatan
$pendapatan = mysqli_query($conn, "SELECT SUM(total_harga) as total FROM transaksi WHERE status_pembayaran = 'sudah_bayar'");
$total_pendapatan = mysqli_fetch_assoc($pendapatan)['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Karyawan</title>
    <link rel="shortcut icon" href="assets/img/icon/toko.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary: #4e73df;
            --secondary: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
            --light: #f8f9fc;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Nunito', sans-serif;
            background-color: var(--light);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: linear-gradient(90deg, rgb(103, 194, 231), rgb(61, 221, 164));
            color: white;
            text-align: center;
            padding: 12px 0;
        }

        #main-content {
            flex: 1;
            padding: 30px;
            margin-left: 20px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        .card .card-body {
            position: relative;
        }

        .card-icon {
            font-size: 2rem;
            position: absolute;
            top: 15px;
            right: 20px;
            opacity: 0.25;
        }

        .card-primary {
            background: linear-gradient(135deg, var(--primary), #224abe);
            color: white;
        }

        .card-success {
            background: linear-gradient(135deg, var(--secondary), #198754);
            color: white;
        }

        .card-info {
            background: linear-gradient(135deg, var(--info), #0dcaf0);
            color: white;
        }

        .stat-text {
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-number {
            font-size: 1.6rem;
            font-weight: bold;
        }

        .welcome-section {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
        }

        footer {
            background-color: rgb(61, 221, 164);
            color: white;
            text-align: center;
            padding: 12px 0;
        }

        @media (max-width: 768px) {
            #main-content {
                margin-left: 0;
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <?php include 'sidebar_karyawan.php'; ?>

    <div class="main-wrapper">
        <!-- Header -->
        <div class="header">
            <h4>Sistem Penjualan Toko Ubay Galon - Karyawan</h4>
        </div>

        <div id="main-content">
            <div class="welcome-section">
                <h3 class="text-primary fw-bold mb-1">Selamat Datang, <?= htmlspecialchars($_SESSION['name']) ?>!</h3>
                <p class="text-muted">Hari ini: <?= date('l, d F Y') ?></p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-xl-4">
                    <a href="laporan(kary)_keuangan.php?role=karyawan" class="text-decoration-none">
                        <div class="card card-success">
                            <div class="card-body">
                                <div class="stat-text">Total Penjualan</div>
                                <div class="stat-number"><?= $jumlah_penjualan ?></div>
                                <small>Transaksi</small>
                                <i class="bi bi-cart-check card-icon"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-xl-4">
                    <a href="laporan(kary)_keuangan.php?role=karyawan" class="text-decoration-none">
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="stat-text">Penjualan Hari Ini</div>
                                <div class="stat-number"><?= $jumlah_penjualan_hari_ini ?></div>
                                <small>Transaksi</small>
                                <i class="bi bi-cart-plus card-icon"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-6 col-xl-4">
                    <a href="laporan(kary)_keuangan.php?role=karyawan" class="text-decoration-none">
                        <div class="card card-info">
                            <div class="card-body">
                                <div class="stat-text">Total Pendapatan</div>
                                <div class="stat-number">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></div>
                                <small>Sudah Dibayar</small>
                                <i class="bi bi-currency-dollar card-icon"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer>
        &copy; <?= date('Y') ?> All Rights Reserved | Karyawan Dashboard
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
