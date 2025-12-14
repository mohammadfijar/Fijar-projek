<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$produk = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk = '$id'");
$data = mysqli_fetch_assoc($produk);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['namaproduk']);
    $harga = (int) $_POST['harga'];
    $stok_awal = (int) $data['stok'];
    $stok_update = (int) $_POST['stok'];
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

    // Hitung perubahan stok
    $selisih = $stok_update - $stok_awal;
    $jenis = $selisih > 0 ? 'masuk' : ($selisih < 0 ? 'keluar' : null);

    // Update produk
    $update = mysqli_query($conn, "UPDATE produk SET namaproduk='$nama', harga='$harga', stok='$stok_update' WHERE idproduk='$id'");

    if ($update && $jenis) {
        // Simpan ke riwayat stok
        $jumlah = abs($selisih);
        mysqli_query($conn, "INSERT INTO stok_history (idproduk, jenis, jumlah, keterangan) VALUES ('$id', '$jenis', '$jumlah', '$keterangan')");
    }

    echo "<script>alert('Produk berhasil diperbarui!'); window.location='laporan(kary)_stok.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3>Edit Produk</h3>
    <form method="post">
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="namaproduk" class="form-control" value="<?= htmlspecialchars($data['namaproduk']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Stok Sekarang</label>
            <input type="number" name="stok" class="form-control" value="<?= $data['stok'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Keterangan Perubahan Stok</label>
            <textarea name="keterangan" class="form-control" placeholder="Contoh: Barang datang dari supplier / penyesuaian stok karena retur"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="laporan(kary)_stok.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
