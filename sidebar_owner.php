<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<style>
    .sidebar {
        width: 250px;
        background: url(assets/img/bgsenj.jpg) no-repeat center center fixed;
        background-size: cover;
        padding: 20px;
        height: 100vh;
        color: white;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
        transition: transform 0.3s ease;
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
        background-color: #495057;
    }

    .toggle-btn {
        position: fixed;
        top: 15px;
        left: 260px;
        z-index: 1101;
        transition: left 0.3s ease;
    }

    .toggle-btn.closed {
        left: 10px;
    }

    .content {
        padding: 30px;
        padding-left: 280px;
        transition: all 0.3s ease;
        flex: 1;
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    .content.closed {
        padding-left: 60px;
    }
</style>

<!-- Tombol Toggle -->
<button id="toggleButton" class="btn btn-secondary toggle-btn" onclick="toggleSidebar()">☰</button>

<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <div class="text-center mb-4">
        <h5>👑 Owner Panel</h5>
        <p><?= isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Owner' ?></p>
    </div>
    <a href="dashboard_owner.php">🏠 Dashboard</a>
    <a href="laporan_keuangan.php">💰 Laporan Keuangan</a>
    <a href="laporan_stok.php">📦 Laporan Stok</a>
    <a href="laporan(read).php">📝 Laporan Pesanan</a>
    <a href="logout.php" onclick="return confirm('Keluar dari sistem?')">🚪 Logout</a>
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
