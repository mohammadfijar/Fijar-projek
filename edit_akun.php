<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM login WHERE id = '$id'"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $update_query = "UPDATE login SET name='$name', email='$email', role='$role' WHERE id='$id'";
    mysqli_query($conn, $update_query);
    header("Location: kelola_akun.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h3>Edit Akun</h3>
    <form method="POST">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" value="<?= $data['name'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="<?= $data['email'] ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="owner" <?= $data['role'] === 'owner' ? 'selected' : '' ?>>owner</option>
                <option value="karyawan" <?= $data['role'] === 'karyawan' ? 'selected' : '' ?>>Karyawan</option>
                 <option value="pelanggan" <?= $data['role'] === 'pelanggan' ? 'selected' : '' ?>>pelanggan</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="kelola_akun.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
