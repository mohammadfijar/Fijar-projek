<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

// Ambil semua akun dengan role tertentu yang tidak dihapus
$akun = mysqli_query($conn, "
    SELECT * FROM login 
    WHERE role IN ('owner', 'karyawan', 'pelanggan') 
    AND deleted_at IS NULL
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
<body>
    <?php include 'sidebar_admin.php'; ?>

    <div id="main-content" class="content">
        <h3 class="mb-4">Kelola Akun</h3>
        <a href="tambah_akun.php" class="btn btn-success mb-3">➕ Tambah Akun</a>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($akun)) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['role']) ?></td>
                            <td>
                                <a href="edit_akun.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                                <a href="hapus_akun.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus akun ini?')">🗑️ Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if (mysqli_num_rows($akun) === 0): ?>
                        <tr><td colspan="4" class="text-center">Tidak ada akun ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php include 'footer.php'; ?>
    </div>
</body>
</html>
