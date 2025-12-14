<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

$jumlah_customer = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM login WHERE role = 'pelanggan' AND deleted_at IS NULL"));
$jumlah_karyawan = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM login WHERE role = 'karyawan' AND deleted_at IS NULL"));
$jumlah_produk = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM Produk"));
$jumlah_pesanan = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transaksi"));
// Hitung total pendapatan
$pendapatan = mysqli_query($conn, "SELECT SUM(total_harga) as total FROM transaksi WHERE status_pembayaran = 'sudah_bayar'");
$total_pendapatan = mysqli_fetch_assoc($pendapatan)['total'] ?? 0;
// Hitung barang masuk
$query_masuk = mysqli_query($conn, "SELECT COUNT(*) AS total_masuk FROM stok_history WHERE jenis='masuk'");
$data_masuk = mysqli_fetch_assoc($query_masuk);
$jumlah_masuk = $data_masuk['total_masuk'];

// Hitung barang keluar
$query_keluar = mysqli_query($conn, "SELECT COUNT(*) AS total_keluar FROM stok_history WHERE jenis='keluar'");
$data_keluar = mysqli_fetch_assoc($query_keluar);
$jumlah_keluar = $data_keluar['total_keluar'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
     <link rel="shortcut icon" href="assets/img/icon/toko.png">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f1f3f9;
            margin: 0;
            padding: 0;
        }

        .main-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(90deg,rgb(33, 58, 107),rgb(9, 22, 46));
            color: white;
           text-align: center;
            padding: 12px 0;
            margin-top: auto;
            align-items: center;
            z-index: 999;
        }

        .header h4 {
            margin: 0;
            font-weight: bold;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-info img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-info span {
            font-size: 14px;
        }

        .content-wrapper {
            flex: 1;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            border: none;
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: bold;
        }

        .card-icon {
            font-size: 2rem;
            opacity: 0.3;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .card-warning { background: linear-gradient(135deg, #f6c23e, #dda20a); color: white; }
        .card-info { background: linear-gradient(135deg, #36b9cc, #258ea1); color: white; }
        .card-primary { background: linear-gradient(135deg, #4e73df, #224abe); color: white; }
        .card-success { background: linear-gradient(135deg, #1cc88a, #17a673); color: white; }

        

        @media (max-width: 768px) {
            .header h4 {
                font-size: 16px;
            }

            .content-wrapper {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

<?php include 'sidebar_admin.php'; ?>
<!-- Footer -->



<div class="main-wrapper">
    <!-- Header -->
    <div class="header">
        <h4>Sistem Penjualan Toko - Admin</h4>
    </div>

    <!-- Konten -->
    <div id="main-content" class="content-wrapper">
        <div class="mb-4">
            <h5 class="fw-bold text-dark">Selamat Datang, <?= htmlspecialchars($_SESSION['name']) ?>!</h5>
            <p class="text-muted">Berikut adalah ringkasan statistik sistem Anda.</p>
        </div>
       

        <div class="row g-4">
            <div class="col-md-6 col-xl-3">
                <a href="kelola_akun.php?role=karyawan" class="text-decoration-none">
                    <div class="card card-warning position-relative p-3">
                        <div class="card-body">
                            <div class="stat-text">Karyawan</div>
                            <div class="stat-number"><?= $jumlah_karyawan ?></div>
                            <i class="bi bi-person-badge-fill card-icon"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-xl-3">
                <a href="kelola_akun.php?role=pelanggan" class="text-decoration-none">
                    <div class="card card-info position-relative p-3">
                        <div class="card-body">
                            <div class="stat-text">Pelanggan</div>
                            <div class="stat-number"><?= $jumlah_customer ?></div>
                            <i class="bi bi-people-fill card-icon"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 col-xl-3">
                <a href="produk.php" class="text-decoration-none">
                    <div class="card card-primary position-relative p-3">
                        <div class="card-body">
                            <div class="stat-text">Produk</div>
                            <div class="stat-number"><?= $jumlah_produk ?></div>
                            <i class="bi bi-box-seam card-icon"></i>
                        </div>
                    </div>
                </a>
            </div>

<div class="col-md-6 col-xl-3">
                    <a href="laporan_pesanan.php?role=admin" class="text-decoration-none">
                        <div class="card card-success position-relative p-3">
                            <div class="card-body">
                                <div class="stat-text">Total Pendapatan</div>
                                <div class="stat-number">Rp <?= number_format($total_pendapatan, 0, ',', '.') ?></div>
                                
                                <i class="bi bi-currency-dollar card-icon"></i>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Kartu Barang Masuk -->
<div class="col-md-6 col-xl-3">
    <a href="laporan_pesanan.php?filter=masuk" class="text-decoration-none">
        <div class="card card-success position-relative p-3">
            <div class="card-body">
                <div class="stat-text">Barang Masuk</div>
                <div class="stat-number"><?= $jumlah_masuk ?></div>
                <i class="bi bi-box-arrow-in-down card-icon"></i>
            </div>
        </div>
    </a>
</div>

<!-- Kartu Barang Keluar -->
<div class="col-md-6 col-xl-3">
    <a href="laporan_pesanan.php?filter=keluar" class="text-decoration-none">
        <div class="card card-danger position-relative p-3">
            <div class="card-body">
                <div class="stat-text">Barang Keluar</div>
                <div class="stat-number"><?= $jumlah_keluar ?></div>
                <i class="bi bi-box-arrow-up card-icon"></i>
            </div>
        </div>
    </a>
</div>


            <div class="col-md-6 col-xl-3">
                <a href="pesanan.php" class="text-decoration-none">
                    <div class="card card-success position-relative p-3">
                        <div class="card-body">
                            <div class="stat-text">Pesanan</div>
                            <div class="stat-number"><?= $jumlah_pesanan ?></div>
                            <i class="bi bi-bag-check-fill card-icon"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    
<?php include 'footer.php'; ?>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
