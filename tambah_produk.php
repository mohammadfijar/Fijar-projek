<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga = (int) $_POST['harga'];

    $foto = $_FILES['foto']['name'];
    $tmp  = $_FILES['foto']['tmp_name'];
    $folder = "uploads/";

    if ($foto != "") {
        $ext = pathinfo($foto, PATHINFO_EXTENSION);
        $nama_file = uniqid() . '.' . $ext;
        move_uploaded_file($tmp, $folder . $nama_file);
    } else {
        $nama_file = '';
    }

    $query = "INSERT INTO Produk (namaproduk, harga, foto) VALUES ('$nama', $harga, '$nama_file')";
    mysqli_query($conn, $query);
    header("Location: produk.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
    <h3>Tambah Produk</h3>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Upload Foto</label>
            <input type="file" name="foto" class="form-control">
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="produk.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
