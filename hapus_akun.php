<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$now = date("Y-m-d H:i:s");
mysqli_query($conn, "UPDATE login SET deleted_at = '$now' WHERE id = '$id'");
header("Location: kelola_akun.php");
exit;
?>
