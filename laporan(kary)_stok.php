<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'karyawan') {
    header("Location: index.php");
    exit;
}

$produk = mysqli_query($conn, "SELECT * FROM produk");

?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="display:flex; min-height:100vh; overflow-x:hidden;">

    <?php include 'sidebar_karyawan.php'; ?>

    <div id="main-content" class="content">
    <h3 class="mb-4">📦 Laporan Stok</h3>
    <table class="table table-striped">
        <thead class="table-dark"><tr><th>Nama Produk</th><th>Stok Tersedia</th><th>Update</th></tr></thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($produk)) { ?>
            <tr>
                <td><?= $row['namaproduk'] ?></td>
                <td><?= $row['stok'] ?></td>
               <td> <a href="edit(kary)_produk.php?id=<?php echo $row['idproduk']; ?>" class="btn btn-warning btn-sm">Edit</a> </td>
                
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>

</html>

