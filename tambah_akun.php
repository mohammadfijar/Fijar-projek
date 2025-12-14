<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // tidak di-hash
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $no_telepon = mysqli_real_escape_string($conn, $_POST['no_telepon']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $query = "INSERT INTO login (name, email, password, role, no_telepon, alamat) 
              VALUES ('$name', '$email', '$password', '$role', '$no_telepon', '$alamat')";

    if (mysqli_query($conn, $query)) {
        header("Location: kelola_akun.php");
        exit;
    } else {
        echo "<script>alert('Gagal menambahkan akun!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Akun</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3>Tambah Akun</h3>
    <form method="POST" autocomplete="off">
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="text" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select" required>
                <option value="">-- Pilih Role --</option>
                <option value="pelanggan">Pelanggan</option>
                <option value="karyawan">Karyawan</option>
                <option value="owner">Owner</option>
            </select>
        </div>
        <div class="mb-3">
            <label>No. Telepon (opsional)</label>
            <input type="text" name="no_telepon" class="form-control">
        </div>
        <div class="mb-3">
            <label>Alamat (opsional)</label>
            <textarea name="alamat" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="kelola_akun.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
