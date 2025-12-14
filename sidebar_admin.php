<!-- sidebar_admin.php -->
<style>
    .sidebar {
        width: 250px;
         background: url(assets/img/19.jpg) no-repeat center center fixed;
        background-size: cover;
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        padding: 20px;
        z-index: 1000;
        transition: transform 0.3s ease;
    }

    .sidebar.closed {
        transform: translateX(-100%);
    }

    .sidebar a {
        display: block;
        color: white;
        text-decoration: none;
        margin: 10px 0;
        padding: 10px 15px;
        border-radius: 8px;
        transition: background 0.2s;
    }

    .sidebar a:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .sidebar h6 {
        margin-top: 5px;
        font-size: 16px;
    }

    .sidebar img {
        height: 80px;
        width: 80px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid white;
    }

    .toggle-btn {
        position: fixed;
        top: 15px;
        left: 260px;
        z-index: 1100;
        background-color:rgb(0, 0, 0);
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: left 0.3s ease;
    }

    .toggle-btn.closed {
        left: 20px;
    }

    .content-wrapper.closed {
        margin-left: 50px !important;
    }

    .content-wrapper {
        margin-left: 280px;
    }

    @media (max-width: 768px) {
        .content-wrapper {
            margin-left: 0 !important;
        }

        .toggle-btn {
            left: 20px;
        }
    }
</style>

<!-- Toggle Button -->
<button id="toggleButton" class="toggle-btn" onclick="toggleSidebar()">☰</button>

<!-- Sidebar -->
<div id="sidebar" class="sidebar">
    <div class="text-center mb-4">
        <img src="assets\img\icon\ht1.png" alt="Admin" class="mb-2">
        <h6><?= htmlspecialchars($_SESSION['name']) ?></h6>
    </div>

    <a href="dashboard_admin.php">🏠 Dashboard</a>
    <a href="produk.php">📦 Data Produk</a>
    <a href="kelola_akun.php">👥 Kelola Akun</a>
    <a href="pesanan.php">📝 Data Pesanan</a>
    
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
