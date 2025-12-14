<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit;
}

// Sorting Setup
$allowed_sort = ['nama', 'total_harga'];
$allowed_order = ['asc', 'desc'];

$sort = in_array($_GET['sort'] ?? '', $allowed_sort) ? $_GET['sort'] : 't.id';
$order = in_array(strtolower($_GET['order'] ?? ''), $allowed_order) ? strtoupper($_GET['order']) : 'DESC';

// Convert sort name to DB column
$sort_column = match($sort) {
    'nama' => 'c.nama',
    'total_harga' => 't.total_harga',
    default => 't.id'
};

// Query data
$query = "
    SELECT 
        t.id AS transaksi_id,
        t.total_harga,
        t.metode_pembayaran,
        t.status_pembayaran,
        t.status_pengiriman,
        t.tanggal_transaksi,
        t.bukti_pembayaran,
        c.nama AS nama_customer,
        c.no_telepon,
        c.alamat
    FROM transaksi t
    JOIN customer c ON t.user_id = c.user_id
    ORDER BY $sort_column $order
";
$pesanan = mysqli_query($conn, $query);

// Toggle & Icon Functions
function toggle_order($current_order) {
    return strtolower($current_order) === 'asc' ? 'desc' : 'asc';
}

function get_sort_icon($column, $current_sort, $current_order) {
    if ($column !== $current_sort) return '';
    return strtolower($current_order) === 'asc' ? ' ▲' : ' ▼';
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Pesanan - Ubay Galon</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .content {
            flex: 1;
            padding: 30px;
            padding-left: 280px;
            background-color: #f8f9fa;
        }
        .table-responsive {
            overflow-x: auto;
        }
        th a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>

<?php include 'sidebar_admin.php'; ?>

<div class="content">
    <h3 class="text-center">Data Pesanan</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>
                        <a href="?sort=nama&order=<?= toggle_order($order) ?>">
                            Nama Customer<?= get_sort_icon('nama', $sort, $order) ?>
                        </a>
                    </th>
                    <th>No Telepon</th>
                    <th>Alamat</th>
                    <th>Status Pengiriman</th>
                    <th>Status Pembayaran</th>
                    <th>
                        <a href="?sort=total_harga&order=<?= toggle_order($order) ?>">
                            Total Harga<?= get_sort_icon('total_harga', $sort, $order) ?>
                        </a>
                    </th>
                    <th>Metode Pembayaran</th>
                    <th>Tanggal Transaksi</th>
                    <th>Bukti Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while($row = mysqli_fetch_assoc($pesanan)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['nama_customer']) ?></td>
                    <td><?= htmlspecialchars($row['no_telepon']) ?></td>
                    <td><?= htmlspecialchars($row['alamat']) ?></td>
                    <td><?= htmlspecialchars($row['status_pengiriman']) ?? 'Belum diproses' ?></td>
                    <td><?= htmlspecialchars($row['status_pembayaran']) ?></td>
                    <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['metode_pembayaran']) ?></td>
                    <td><?= date('d-m-Y H:i', strtotime($row['tanggal_transaksi'])) ?></td>
                    <td>
                        <?php if (!empty($row['bukti_pembayaran'])): ?>
                            <a href="uploads/<?= htmlspecialchars($row['bukti_pembayaran']) ?>" target="_blank">
                                <img src="uploads/<?= htmlspecialchars($row['bukti_pembayaran']) ?>" alt="Bukti" style="width:80px; height:auto; border:1px solid #ccc; border-radius:4px;">
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Belum Upload</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="detail_transaksi.php?id=<?= $row['transaksi_id'] ?>" class="btn btn-info btn-sm">Lihat Detail</a>
                        <a href="edit_pesanan.php?id=<?= $row['transaksi_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="hapus_pesanan.php?id=<?= $row['transaksi_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus pesanan ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <a href="dashboard_admin.php" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
    <?php include 'footer.php'; ?>
    
</div>

</body>
</html>
