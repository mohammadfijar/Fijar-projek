<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
.sidebar {
    width: 250px;
   background: url(assets/img/20.jpg) no-repeat center center fixed;
        background-size: cover;
    padding: 20px;
    height: 100vh;
    color: white;
    transition: transform 0.3s ease;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 1000;
}

.sidebar.closed {
    transform: translateX(-250px);
}

.sidebar a {
    color: white;
    display: block;
    margin: 10px 0;
    text-decoration: none;
    padding: 10px;
    border-radius: 5px;
}

.sidebar a:hover {
    background-color: rgb(134, 160, 17);
}

.sidebar h6 {
    margin-top: 5px;
    font-size: 16px;
}

.toggle-btn {
    position: fixed;
    top: 15px;
    left: 260px;
    z-index: 1100;
    transition: left 0.3s ease;
}

.toggle-btn.closed {
    left: 10px;
}

.content {
    padding: 30px;
    padding-left: 280px; /* ruang saat sidebar terbuka */
    transition: all 0.3s ease;
    flex: 1;
    background-color: #f8f9fa;
}

.content.closed {
    padding-left: 60px; /* ruang saat sidebar ditutup */
}
</style>

<!-- Tombol Toggle -->
<button id="toggleButton" class="btn btn-secondary toggle-btn" onclick="toggleSidebar()">☰</button>

<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <div class="text-center mb-4">
        <h6><?= isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Karyawan' ?></h6>
    </div>
    <a href="dashboard_karyawan.php">🏠 Dashboard</a>
    <a href="laporan(kary)_keuangan.php">💰 Laporan</a>
    <a href="laporan(kary)_stok.php">📦 Update Stok Barang</a>
    <a href="laporan(kary).php">📝 Riwayat Pesanan</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('main-content');
    const toggleBtn = document.getElementById('toggleButton');

    sidebar.classList.toggle('closed');
    content.classList.toggle('closed');
    toggleBtn.classList.toggle('closed');
}
</script>
