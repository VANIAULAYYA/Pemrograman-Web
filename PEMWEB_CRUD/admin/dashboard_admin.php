<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['level'] !== 1) {
    header("Location: ../login.php");
    exit();
}

// Data Dummy untuk Tampilan
$nama_admin = $_SESSION['user']['nama'];
$jumlah_ruangan = 10;
$total_peminjaman = 28;

$aktivitas = [
    ["Menyetujui peminjaman Aula Serbaguna", "2025-05-25"],
    ["Menolak peminjaman Lapangan", "2025-05-24"],
    ["Melihat laporan bulanan", "2025-05-23"]
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        #sidebar {
            height: 100%;
            width: 250px;
            position: fixed;
            z-index: 1050;
            top: 0;
            left: -250px;
            background-color: #343a40;
            overflow-x: hidden;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        #sidebar a {
            padding: 10px 20px;
            text-decoration: none;
            font-size: 16px;
            color: white;
            display: block;
        }

        #sidebar a:hover {
            background-color: #495057;
        }

        #overlay {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 1040;
        }

        .card-info {
            height: 200px;
            color: white;
            border: none;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            border-radius: 12px;
        }

        .card-icon {
            font-size: 48px;
            margin-bottom: 10px;
            margin-top: 20px;
        }

        .aktivitas-list li {
            margin-bottom: 8px;
        }

        .dashboard-section {
            max-height: 100vh;
            overflow-y: hidden;
        }
    </style>
</head>
<body>

<!-- Overlay -->
<div id="overlay" onclick="closeDrawer()"></div>

<!-- Sidebar -->
<div id="sidebar">
    <div>
        <div class="text-center py-4 border-bottom border-secondary">
            <img src="https://via.placeholder.com/80" class="rounded-circle mb-2" alt="Foto Profil">
            <h6 class="text-white mb-0"><?= $nama_admin ?></h6>
            <small class="text-light">Admin</small>
        </div>

        <a href="#"><i class="bi bi-house-door me-2"></i> Dashboard</a>
        <a href="#"><i class="bi bi-calendar-check me-2"></i> Kelola Peminjaman</a>
        <a href="#"><i class="bi bi-door-open me-2"></i> Data Ruangan</a>
        <a href="#"><i class="bi bi-person-lines-fill me-2"></i> Data Penyewa</a>
        <a href="#"><i class="bi bi-gear me-2"></i> Pengaturan</a>
    </div>

    <div class="border-top border-secondary">
        <a href="logout_admin.php" class="text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
    </div>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-toggler-icon me-3" onclick="openDrawer()" style="cursor:pointer;"></span>
        <span class="navbar-brand">Dashboard Admin</span>
        <div class="ms-auto text-white">
            <strong><?= $nama_admin ?></strong>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container py-4 dashboard-section">
    <h3 class="mb-4">Selamat datang, <?= $nama_admin ?>!</h3>

    <!-- Info Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card-info bg-success shadow">
                <div class="card-icon"><i class="bi bi-door-open-fill"></i></div>
                <h5>Jumlah Ruangan</h5>
                <p><strong><?= $jumlah_ruangan ?></strong> ruangan tersedia</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-info bg-primary shadow">
                <div class="card-icon"><i class="bi bi-journal-check"></i></div>
                <h5>Total Peminjaman</h5>
                <p><strong><?= $total_peminjaman ?></strong> peminjaman tercatat</p>
            </div>
        </div>
    </div>

    <!-- Aktivitas dan Info -->
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-activity me-2"></i> Aktivitas Terbaru
                </div>
                <div class="card-body">
                    <ul class="aktivitas-list">
                        <?php foreach ($aktivitas as $a): ?>
                            <li><i class="bi bi-clock me-1"></i> <?= $a[0] ?> <small class="text-muted">(<?= $a[1] ?>)</small></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-info-circle me-2"></i> Informasi Umum
                </div>
                <div class="card-body">
                    <p>• Semua data tersimpan otomatis</p>
                    <p>• Admin bertanggung jawab menyetujui atau menolak peminjaman</p>
                    <p>• Update data ruangan jika ada perubahan</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function openDrawer() {
        document.getElementById("sidebar").style.left = "0";
        document.getElementById("overlay").style.display = "block";
    }
    function closeDrawer() {
        document.getElementById("sidebar").style.left = "-250px";
        document.getElementById("overlay").style.display = "none";
    }
</script>
</body>
</html>
