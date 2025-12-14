<?php
session_start();
include 'koneksi.php';

if ($_SESSION['role'] !== 'karyawan') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pesanan = $_POST['id_pesanan'];
    $status = $_POST['status_pengiriman'];
    mysqli_query($conn, "UPDATE Customer SET status_pesanan='$status' WHERE id='$id_pesanan'");
    header("Location: pengiriman.php");
}

$pesanan = mysqli_query($conn, "SELECT * FROM Customer WHERE status_pesanan != 'selesai'");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pengiriman</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-4">
    <h2>Status Pengiriman</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($pesanan)): ?>
            <tr>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['alamat'] ?></td>
                <td><?= $row['status_pesanan'] ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="id_pesanan" value="<?= $row['id'] ?>">
                        <select name="status_pengiriman" class="form-select">
                            <option value="sedang_diproses">Sedang Diproses</option>
                            <option value="selesai">Selesai</option>
                        </select>
                        <button class="btn btn-success mt-2">Update</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
