<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM login WHERE id = $user_id LIMIT 1";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya - Ubay Galon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color:rgb(27, 146, 214); }
        .profile-card {
            max-width: 600px;
            margin: auto;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card profile-card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">👤 Profil Saya</h4>
        </div>
        <div class="card-body">
            <?php if ($user): ?>
                <p><strong>Nama:</strong> <?= htmlspecialchars($user['name']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                <p><strong>No Telepon:</strong> <?= htmlspecialchars($user['no_telepon']) ?></p>
                <p><strong>Alamat:</strong> <?= nl2br(htmlspecialchars($user['alamat'])) ?></p>
                <p><strong>Role:</strong> <span class="badge bg-info text-dark"><?= ucfirst($user['role']) ?></span></p>

                <!-- Tombol Edit jika ingin dikembangkan -->
                <!-- <a href="edit_profil.php" class="btn btn-warning mt-3">Edit Profil</a> -->

                <a href="dashboard_pelanggan.php" class="btn btn-secondary mt-3">⬅️ Kembali ke Dashboard</a>
            <?php else: ?>
                <div class="alert alert-danger">Data profil tidak ditemukan.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
