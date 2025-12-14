<?php
session_start();
include 'koneksi.php';

$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = $_POST['password']; // jangan escape password (karena akan diverifikasi)

$query = "SELECT * FROM login WHERE email='$email' AND deleted_at IS NULL";
$cek = mysqli_query($conn, $query);

if (mysqli_num_rows($cek) > 0) {
    $user = mysqli_fetch_assoc($cek);

    // Cek password dengan password_verify
    if (password_verify($password, $user['password']) || $password == $user['password']) {
        // support login untuk user lama yang belum di-hash

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        switch ($user['role']) {
            case 'owner':
                header('Location: dashboard_owner.php');
                break;
            case 'admin':
                header('Location: dashboard_admin.php');
                break;
            case 'karyawan':
                header('Location: dashboard_karyawan.php');
                break;
            case 'pelanggan':
                header('Location: dashboard_pelanggan.php');
                break;
            default:
                echo "<script>alert('Role tidak dikenali!'); window.location='index.php';</script>";
                break;
        }
    } else {
        echo "<script>alert('Password salah!'); window.location='index.php';</script>";
    }
} else {
    echo "<script>alert('Email tidak ditemukan!'); window.location='index.php';</script>";
}
?>
