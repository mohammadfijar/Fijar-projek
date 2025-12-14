<?php
$host = "localhost";       // biasanya tetap localhost
$user = "root";            // username default XAMPP
$pass = "";                // password default kosong (jika tidak diubah)
$db   = "gunshop_fc";      // nama database kamu

$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
