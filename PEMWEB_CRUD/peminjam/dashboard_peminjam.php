<?php
$nama_penyewa = "Jamal";
$sedang_meminjam = true;
$total_peminjaman = 3;

$detail_peminjaman = [
    "tempat" => "Aula Serbaguna",
    "tanggal" => "2025-06-02",
];

$aktivitas = [
    ["Ajukan peminjaman ruang meeting", "2025-05-25"],
    ["Peminjaman Aula disetujui", "2025-05-23"],
    ["Peminjaman Lapangan ditolak", "2025-05-20"]
];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Peminjam</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar styles */
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

<!-- Sidebar Drawer -->
<div id="sidebar">
    <div>
        <!-- Header Sidebar -->
        <div class="text-center py-4 border-bottom border-secondary">
            <img src="https://via.placeholder.com/80" class="rounded-circle mb-2" alt="Foto Profil">
            <h6 class="text-white mb-0"><?= $nama_penyewa ?></h6>
            <small class="text-light">Peminjam</small>
        </div>

        <!-- Menu Drawer -->
        <a href="#"><i class="bi bi-house-door me-2"></i> Dashboard</a>
        <a href="#"><i class="bi bi-check2-square me-2"></i> Status Peminjaman</a>
        <a href="#"><i class="bi bi-clock-history me-2"></i> Riwayat Peminjaman</a>
        <a href="#"><i class="bi bi-pencil-square me-2"></i> Ajukan Peminjaman</a>
        <a href="#"><i class="bi bi-gear me-2"></i> Setting Akun</a>
    </div>

    <!-- Footer Sidebar -->
    <div class="border-top border-secondary">
        <a href="logout_peminjam.php" class="text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
    </div>
</div>


<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-toggler-icon me-3" onclick="openDrawer()" style="cursor:pointer;"></span>
        <span class="navbar-brand">Sistem Peminjaman Tempat</span>
        <div class="ms-auto text-white">
            <strong>Peminjam</strong>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container py-4 dashboard-section">
    <h3 class="mb-4">Selamat datang, <?= $nama_penyewa ?>!</h3>

    <!-- Info Cards -->
    <div class="row g-3 mb-4">
        <!-- Kiri: Status Peminjaman -->
        <div class="col-md-6">
            <div class="card-info bg-danger shadow">
                <div class="card-icon"><i class="bi bi-calendar2-check-fill"></i></div>
                <?php if ($sedang_meminjam): ?>
                    <h5>Anda sedang meminjam:</h5>
                    <p><strong><?= $detail_peminjaman['tempat'] ?></strong><br>
                    Tanggal: <?= $detail_peminjaman['tanggal'] ?><br>
                <?php else: ?>
                    <h5>Tidak Ada Peminjaman Aktif</h5>
                    <p>Anda belum meminjam tempat apapun saat ini.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Kanan: Total Peminjaman -->
        <div class="col-md-6">
            <div class="card-info bg-primary shadow">
                <div class="card-icon"><i class="bi bi-journal-check"></i></div>
                <h5>Total Peminjaman</h5>
                <p>Anda telah melakukan <strong><?= $total_peminjaman ?></strong> peminjaman.</p>
            </div>
        </div>
    </div>

    <!-- Aktivitas & Info Umum -->
    <div class="row g-3">
        <!-- Aktivitas -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
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

        <!-- Info -->
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <i class="bi bi-info-circle me-2"></i> Informasi Umum
                </div>
                <div class="card-body">
                    <p>• Jam operasional: 07.00 - 21.00 WIB</p>
                    <p>• Ajukan minimal H-1 sebelum tanggal pemakaian</p>
                    <p>• Hubungi admin jika ada perubahan mendadak</p>
                </div>
            </div>
        </div>
    </div>
    </div>

<!-- Bootstrap JS -->
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