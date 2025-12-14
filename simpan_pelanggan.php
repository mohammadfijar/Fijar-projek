<?php
include 'koneksi.php';

$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

$insert = mysqli_query($conn, "
    INSERT INTO Customer (nama, password, alamat, status_pesanan, metode_pembayaran) 
    VALUES ('$nama', '$password', '$alamat', 'sedang_diproses', '-')
");

if ($insert) {
    echo "<script>alert('Pendaftaran berhasil! Silahkan login.'); window.location='index.php';</script>";
} else {
    echo "<script>alert('Gagal mendaftar!'); window.location='daftar_pelanggan.php';</script>";
}
?>
