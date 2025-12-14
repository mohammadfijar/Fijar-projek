<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'owner') {
    header("Location: index.php");
    exit;
}

$aktivitas = mysqli_query($conn, "SELECT * FROM aktivitas_sistem ORDER BY waktu DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Aktivitas Sistem - Dashboard Owner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📊 Aktivitas Sistem</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Waktu</th>
                <th>User</th>
                <th>Role</th>
                <th>Deskripsi Aktivitas</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($aktivitas)) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['waktu'] ?></td>
                    <td><?= $row['nama_user'] ?></td>
                    <td><?= $row['role'] ?></td>
                    <td><?= $row['aktivitas'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
<a href="dashboard_owner.php" class="btn btn-secondary">⬅️ Kembali ke Dashboard</a>