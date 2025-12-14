<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Ambil data produk dari database
$produk = mysqli_query($conn, "SELECT * FROM Produk");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Produk - Ubay Galon</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
 <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .content {
            flex: 1;
            padding: 30px;
            padding-left: 290px;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }
        .content.closed {
            padding-left: 100px;
        }
        #toggleButton {
            position: fixed;
            top: 15px;
            left: 250px;
            z-index: 1001;
            transition: all 0.3s ease;
        }
        #toggleButton.closed {
            left: 60px;
        }
        .table-responsive {
            overflow-x: auto;
        }
    </style>

</head>
<body style="display:flex; min-height:100vh; overflow-x:hidden;">
    <?php include 'sidebar_admin.php'; ?>
 <div id="main-content" class="content">

    <h3>Data Produk</h3>
    <a href="tambah_produk.php" class="btn btn-primary mb-3">+ Tambah Produk</a>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while($row = mysqli_fetch_assoc($produk)): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($row['namaproduk']); ?></td>
                <td>Rp <?php echo number_format($row['harga']); ?></td>
                <td><?php echo htmlspecialchars($row['stok']); ?></td>
                <td>
                    <a href="edit_produk.php?id=<?php echo $row['idproduk']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus_produk.php?id=<?php echo $row['idproduk']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="dashboard_admin.php" class="btn btn-secondary">Kembali ke Dashboard</a>

   <?php include 'footer.php'; ?>
</div>

</body>
</html>