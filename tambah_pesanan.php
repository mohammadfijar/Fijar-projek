<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$produk = mysqli_query($conn, "SELECT * FROM Produk");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama    = mysqli_real_escape_string($conn, $_POST['nama']);
    $id_produk = $_POST['produk'];
    $jumlah  = (int) $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];
    $status  = $_POST['status'];

    $query = "INSERT INTO Customer (nama_customer, id_produk, jumlah, tanggal, status_pesanan)
              VALUES ('$nama', $id_produk, $jumlah, '$tanggal', '$status')";

    if (mysqli_query($conn, $query)) {
        header("Location: pesanan.php");
        exit;
    } else {
        echo "Gagal tambah pesanan: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pesanan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3>Tambah Pesanan</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Nama Customer</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Produk</label>
            <select name="produk" class="form-control" required>
                <?php while ($row = mysqli_fetch_assoc($produk)): ?>
                    <option value="<?= $row['id_produk'] ?>"><?= $row['nama_produk'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Jumlah</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="Belum Dikirim">Belum Dikirim</option>
                <option value="Sudah Dikirim">Sudah Dikirim</option>
            </select>
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="pesanan.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
