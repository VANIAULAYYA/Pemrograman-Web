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
    <title>Sistem Peminjaman</title>
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

        #sidebar a:hover, #sidebar a.active {
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

        .sambutan {
        margin-top: 40px;
        margin-bottom: 30px;
        text-align: center;
    }

        .form-section {
            margin-top: 60px;
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
            <img src="<?= $foto_profil_url ?>" class="rounded-circle mb-2 img-fluid" alt="Foto Profil" style="width: 80px; height: 80px; object-fit: cover;">
            <h6 class="text-white mb-0"><?= $nama_penyewa ?></h6>
            <small class="text-light">Penyewa</small>
        </div>

        <!-- Menu Drawer -->
        <a href="dashboard_peminjam.php" class="<?= $halaman_aktif == 'dashboard' ? 'active' : '' ?>"><i class="bi bi-house-door me-2"></i> Dashboard</a>
        <a href="riwayat_peminjaman.php" class="<?= $halaman_aktif == 'status' ? 'active' : '' ?>"><i class="bi bi-clock-history me-2"></i>Riwayat Peminjaman</h2>
        <a href="ajukan_peminjaman.php" class="<?= $halaman_aktif == 'ajukan' ? 'active' : '' ?>"><i class="bi bi-pencil-square me-2"></i> Ajukan Peminjaman</a>
        <a href="editprofil_peminjam.php" class="<?= $halaman_aktif == 'setting' ? 'active' : '' ?>"><i class="bi bi-gear me-2"></i> Setting Akun</a>
    </div>

    <!-- Footer Sidebar -->
    <div class="border-top border-secondary">
        <a href="#" class="text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
    </div>
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
    <div class="container-fluid">
        <span class="navbar-toggler-icon me-3" onclick="openDrawer()" style="cursor:pointer;"></span>
        <span class="navbar-brand fw-bold">SIMPATIK</span>
        <div class="ms-auto text-white">
            <strong>Peminjam</strong>
        </div>
    </div>
</nav>

<div class="container sambutan">
    <h2>Selamat Datang</h2>
    <p>Silakan cek ketersediaan dan ajukan peminjaman tempat.</p>
</div>

<!-- Form Cek & Ajukan Peminjaman -->
<div class="container form-section">
    <div class="row g-4">
        <!-- Cek Ketersediaan (2/3) -->
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-search me-2"></i> Cek Ketersediaan Ruangan
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="waktu" class="form-label">Waktu</label>
                                <input type="time" class="form-control" id="waktu">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Cek</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Ajukan Peminjaman (1/3) -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-pencil-square me-2"></i> Ajukan Peminjaman
                </div>
                <div class="card-body">
                    <form enctype="multipart/form-data">
                        <div class="mb-2">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" placeholder="Nama peminjam">
                        </div>

                        <div class="mb-2">
                            <label for="email" class="form-label">Email Aktif</label>
                            <input type="email" class="form-control" id="email" placeholder="email@example.com">
                        </div>

                        <div class="mb-2">
                            <label for="telepon" class="form-label">No. Telepon</label>
                            <input type="tel" class="form-control" id="telepon" placeholder="08xxxxxxxxxx">
                        </div>

                        <div class="mb-2">
                            <label for="tujuan" class="form-label">Tujuan</label>
                            <textarea class="form-control" id="tujuan" rows="2" placeholder="Contoh: Seminar Teknologi"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <label for="tanggalMulai" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggalMulai">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="jamMulai" class="form-label">Mulai</label>
                                <input type="time" class="form-control" id="jamMulai">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label for="jamSelesai" class="form-label">Selesai</label>
                                <input type="time" class="form-control" id="jamSelesai">
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="lokasi" class="form-label">Tempat</label>
                            <input class="form-control" list="daftar-tempat" id="lokasi" placeholder="Pilih atau ketik tempat">
                            <datalist id="daftar-tempat">
                                <option value="Aula Serbaguna">
                                <option value="Ruang Rapat 1">
                                <option value="Ruang Meeting Lt.2">
                                <option value="Lapangan Terbuka">
                            </datalist>
                        </div>

                        <div class="mb-2">
                            <label for="fileSIK" class="form-label">Upload SIK (PDF)</label>
                            <input class="form-control" type="file" id="fileSIK" accept=".pdf">
                        </div>
                        <div class="mb-2">
                            <label for="fileSPF" class="form-label">Upload SPF (PDF)</label>
                            <input class="form-control" type="file" id="fileSPF" accept=".pdf">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Kirim</button>
                    </form>
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
