<?php
session_start();
include 'koneksi.php';

// Cek login dan parameter ID
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

// Hapus transaksi
mysqli_query($conn, "DELETE FROM transaksi WHERE id = $id");

// Redirect berdasarkan role
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    header("Location: pesanan.php");
} else {
    header("Location: laporan(kary).php");
}
exit;
?>
