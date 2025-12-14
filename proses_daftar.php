<?php
include 'koneksi.php';

$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$no_telepon = mysqli_real_escape_string($conn, $_POST['no_telepon']);
$alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

$cek = mysqli_query($conn, "SELECT * FROM login WHERE email='$email'");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Email sudah terdaftar!'); window.location='daftar.php';</script>";
} else {
    $insert = mysqli_query($conn, "INSERT INTO login (email, password, name, role, no_telepon, alamat) 
        VALUES ('$email', '$password', '$name', 'pelanggan', '$no_telepon', '$alamat')");

    if ($insert) {
        echo "<script>alert('Daftar berhasil, silakan login.'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('Gagal daftar.'); window.location='daftar.php';</script>";
    }
}
?>
