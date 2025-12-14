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

    // Cek apakah ada file gambar yang diupload
    $foto = $data['foto']; // default: foto lama
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $newFileName = uniqid('produk_') . '.' . $ext;
        $uploadPath = 'uploads/' . $newFileName;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadPath)) {
            // Hapus gambar lama jika ada
            if (!empty($foto) && file_exists('uploads/' . $foto)) {
                unlink('uploads/' . $foto);
            }
            $foto = $newFileName;
        }
    }

    // Hitung perubahan stok
    $selisih = $stok_update - $stok_awal;
    $jenis = $selisih > 0 ? 'masuk' : ($selisih < 0 ? 'keluar' : null);

    // Update produk termasuk gambar
    $update = mysqli_query($conn, "UPDATE produk SET namaproduk='$nama', harga='$harga', stok='$stok_update', foto='$foto' WHERE idproduk='$id'");

    if ($update && $jenis) {
        $jumlah = abs($selisih);
        mysqli_query($conn, "INSERT INTO stok_history (idproduk, jenis, jumlah, keterangan) VALUES ('$id', '$jenis', '$jumlah', '$keterangan')");
    }

    echo "<script>alert('Produk berhasil diperbarui!'); window.location='produk.php';</script>";
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
    <form method="post" enctype="multipart/form-data">
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
            <textarea name="keterangan" class="form-control" placeholder="Contoh: Barang datang dari supplier / retur"></textarea>
        </div>
        <div class="mb-3">
            <label>Gambar Produk Saat Ini</label><br>
            <?php if ($data['foto']) : ?>
                <img src="uploads/<?= htmlspecialchars($data['foto']) ?>" alt="Gambar Produk" width="150" class="mb-2"><br>
            <?php endif; ?>
            <label>Ganti Gambar Produk (Opsional)</label>
            <input type="file" name="gambar" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="produk.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
