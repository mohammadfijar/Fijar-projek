<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
    header("Location: produk.php");
    exit;
}

$id = (int) $_GET['id'];

mysqli_query($conn, "DELETE FROM Produk WHERE idproduk = $id");

header("Location: produk.php");
exit;