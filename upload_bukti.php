<?php
session_start();
include 'koneksi.php';

if (isset($_POST['upload'])) {
    $transaksi_id = intval($_POST['transaksi_id']); // amankan ID
    if (!isset($_FILES['bukti_pembayaran']) || $_FILES['bukti_pembayaran']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = "File bukti pembayaran tidak ditemukan atau terjadi kesalahan upload.";
        header("Location: riwayat_pesanan.php");
        exit;
    }

    $nama_file = $_FILES['bukti_pembayaran']['name'];
    $tmp_file = $_FILES['bukti_pembayaran']['tmp_name'];
    $folder = 'uploads/';

    $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png'];

    // Cek ekstensi
    if (!in_array($ext, $allowed_ext)) {
        $_SESSION['error'] = "File harus berupa gambar dengan format JPG, JPEG, atau PNG.";
        header("Location: riwayat_pesanan.php");
        exit;
    }

    // Buat nama file unik
    $nama_baru = uniqid('bukti_') . '.' . $ext;
    $path = $folder . $nama_baru;

    // Upload file
    if (move_uploaded_file($tmp_file, $path)) {
        // Update data transaksi: set bukti dan ubah status ke menunggu_verifikasi (semua kecil)
        $transaksi_id_safe = mysqli_real_escape_string($conn, $transaksi_id);
        $nama_baru_safe = mysqli_real_escape_string($conn, $nama_baru);

        $update = mysqli_query($conn, "
            UPDATE transaksi 
            SET bukti_pembayaran = '$nama_baru_safe', status_pembayaran = 'menunggu_verifikasi' 
            WHERE id = $transaksi_id_safe
        ");

        if ($update) {
            $_SESSION['success'] = "Bukti pembayaran berhasil diupload, tunggu verifikasi admin.";
            header("Location: riwayat_pesanan.php");
            exit;
        } else {
            $_SESSION['error'] = "Gagal mengupdate data transaksi di database.";
            header("Location: riwayat_pesanan.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Gagal mengupload file ke server.";
        header("Location: riwayat_pesanan.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Akses ditolak.";
    header("Location: riwayat_pesanan.php");
    exit;
}
