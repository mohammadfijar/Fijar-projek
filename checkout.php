<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'pelanggan') {
    header('Location: index.php');
    exit;
}

$keranjang = $_SESSION['keranjang'] ?? [];

if (empty($keranjang)) {
    echo "<script>alert('Keranjang kosong!'); window.location='katalog_produk.php';</script>";
    exit;
}

// Ambil data produk
$produk_data = [];
$total_harga = 0;
$ids = implode(',', array_map('intval', array_keys($keranjang)));
$result = mysqli_query($conn, "SELECT * FROM Produk WHERE idproduk IN ($ids)");

while ($row = mysqli_fetch_assoc($result)) {
    $produk_data[$row['idproduk']] = $row;
}

// Validasi stok cukup sebelum checkout
foreach ($keranjang as $idproduk => $jumlah) {
    if (!isset($produk_data[$idproduk]) || $produk_data[$idproduk]['stok'] < $jumlah) {
        $nama_produk = $produk_data[$idproduk]['namaproduk'] ?? 'Produk tidak ditemukan';
        echo "<script>alert('Stok tidak mencukupi untuk: $nama_produk'); window.location='keranjang.php';</script>";
        exit;
    }
}

// Jika form disubmit
if (isset($_POST['checkout'])) {
    $user_id = $_SESSION['user_id'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $no_telepon = mysqli_real_escape_string($conn, $_POST['no_telepon']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $metode_pembayaran = mysqli_real_escape_string($conn, $_POST['metode_pembayaran']);

    // Hitung total harga
    foreach ($keranjang as $idproduk => $jumlah) {
        $produk = $produk_data[$idproduk];
        $harga = $produk['harga'];
        $total_harga += $harga * $jumlah;
    }

    // Simpan transaksi
    $query_transaksi = "INSERT INTO transaksi (user_id, total_harga, metode_pembayaran, status_pembayaran, tanggal_transaksi) 
        VALUES ('$user_id', '$total_harga', '$metode_pembayaran', 'menunggu_verifikasi', NOW())
";
    $insert_transaksi = mysqli_query($conn, $query_transaksi);

    if (!$insert_transaksi) {
        die("Gagal insert transaksi: " . mysqli_error($conn));
    }

    $transaksi_id = mysqli_insert_id($conn);

    // Cek apakah user sudah ada di tabel customer
    $cek_customer = mysqli_query($conn, "SELECT * FROM customer WHERE user_id = '$user_id'");
    if (mysqli_num_rows($cek_customer) == 0) {
        $query_customer = "INSERT INTO customer (user_id, nama, no_telepon, alamat, metode_pembayaran, status_pesanan, created_at, updated_at)
            VALUES ('$user_id', '$nama', '$no_telepon', '$alamat', '$metode_pembayaran', 'sudah_menunggu_formalisasi', NOW(), NOW())";
        mysqli_query($conn, $query_customer);
    }

    // Simpan ke detail_order dan kurangi stok produk
    foreach ($keranjang as $idproduk => $jumlah) {
        $produk = $produk_data[$idproduk];
        $harga = $produk['harga'];

        // Simpan detail order
        $query_detail = "INSERT INTO detail_order (transaksi_id, idproduk, quantity, harga, created_at, updated_at) 
            VALUES ('$transaksi_id', '$idproduk', '$jumlah', '$harga', NOW(), NOW())";
        mysqli_query($conn, $query_detail);

        // Kurangi stok produk
        $update_stok = "UPDATE produk SET stok = stok - $jumlah WHERE idproduk = $idproduk";
        mysqli_query($conn, $update_stok);
    }

    unset($_SESSION['keranjang']);
    echo "<script>alert('Checkout berhasil!'); window.location='riwayat_pesanan.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Checkout - Ubay Galon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">🧾 Checkout Produk</h2>

    <div class="card shadow-sm p-4">
        <h4>Rincian Pesanan:</h4>
        <ul class="list-group mb-3">
            <?php foreach ($keranjang as $id => $jumlah):
                $produk = $produk_data[$id];
                $subtotal = $produk['harga'] * $jumlah;
                $total_harga += $subtotal;
            ?>
            <li class="list-group-item d-flex justify-content-between">
                <div>
                    <?= htmlspecialchars($produk['namaproduk']) ?> (x<?= $jumlah ?>)
                </div>
                <strong>Rp <?= number_format($subtotal, 0, ',', '.') ?></strong>
            </li>
            <?php endforeach; ?>
            <li class="list-group-item d-flex justify-content-between bg-light">
                <strong>Total Bayar</strong>
                <strong>Rp <?= number_format($total_harga, 0, ',', '.') ?></strong>
            </li>
        </ul>

        <form method="post">
            <div class="mb-3">
                <label>Nama Penerima</label>
                <input type="text" name="nama" class="form-control" required value="<?= $_SESSION['name'] ?? '' ?>">
            </div>
            <div class="mb-3">
                <label>No Telepon</label>
                <input type="text" name="no_telepon" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" rows="3" required></textarea>
            </div>
         <div class="mb-3">
    <label>Metode Pembayaran</label>
    <select name="metode_pembayaran" class="form-control" required>
        <option value="QRIS">QRIS</option>
        <option value="COD">COD</option> <!-- PERBAIKAN -->
    </select>
</div>


            <div class="text-center mb-3">
                <img src="uploads/qris.jpg" alt="QRIS" style="max-width: 300px;">
                <p class="text-muted">*Scan kode QR dan ScreenShoot untuk pembayaran</p>
            </div>

            <button type="submit" name="checkout" class="btn btn-success w-100">Konfirmasi Pembayaran</button>
        </form>
    </div>

    <div class="text-center mt-4">
        <a href="keranjang.php" class="btn btn-secondary">⬅️ Kembali ke Keranjang</a>
    </div>
</div>

</body>
</html>
