<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header("Location: index.php");
    exit;
}
$akun = mysqli_query($conn, "SELECT * FROM login WHERE (role='owner' OR role='karyawan' OR role = 'pelanggan') AND deleted_at IS NULL");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">Data Akun</h3>
  
    <table class="table table-bordered table-hover">
        <thead class="table-dark"><tr><th>Nama</th><th>Email</th><th>Role</th></tr></thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($akun)) { ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['role'] ?></td>
            
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
<a href="dashboard_owner.php" class="btn btn-secondary">⬅️ Kembali ke Dashboard</a>