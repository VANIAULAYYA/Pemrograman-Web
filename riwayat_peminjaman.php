<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'peminjaman';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$nama_penyewa = $_SESSION['nama_penyewa'];

// Get all booking statuses
$statuses = ['Semua', 'Diajukan', 'Disetujui', 'Ditolak', 'Selesai', 'Dibatalkan'];

// Filter by status
$current_status = isset($_GET['status']) ? $_GET['status'] : 'Semua';

// Query to get bookings
$sql = "SELECT p.*, r.nama_ruangan, r.lokasi 
        FROM peminjaman p
        JOIN ruangan r ON p.ruangan_id = r.id
        WHERE p.user_id = :user_id";

if ($current_status != 'Semua') {
    $sql .= " AND p.status = :status";
}

$sql .= " ORDER BY p.tanggal_mulai DESC";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id);

if ($current_status != 'Semua') {
    $stmt->bindParam(':status', $current_status);
}

$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count bookings by status
$status_counts = [];
foreach ($statuses as $status) {
    if ($status == 'Semua') continue;
    
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM peminjaman WHERE user_id = :user_id AND status = :status")
    $stmt->execute([':user_id' => $user_id, ':status' => $status]);
    $status_counts[$status] = $stmt->fetchColumn();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
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

        .status-card {
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .status-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        .status-Diajukan {
            border-left: 5px solid #0dcaf0;
        }
        .status-Disetujui {
            border-left: 5px solid #198754;
        }
        .status-Ditolak {
            border-left: 5px solid #dc3545;
        }
        .status-Selesai {
            border-left: 5px solid #6c757d;
        }
        .status-Dibatalkan {
            border-left: 5px solid #ffc107;
        }
        .badge-status {
            font-size: 0.9rem;
            padding: 5px 10px;
            border-radius: 50px;
        }
        .filter-btn {
            border-radius: 50px;
            margin: 0 5px 10px 0;
            transition: all 0.2s;
        }
        .filter-btn:hover {
            transform: scale(1.05);
        }
        .filter-btn.active {
            font-weight: bold;
            transform: scale(1.05);
        }
        .empty-state {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
        }
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        .timeline:before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #dee2e6;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 15px;
        }
        .timeline-item:before {
            content: '';
            position: absolute;
            left: -30px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #0d6efd;
            border: 2px solid white;
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

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
    <div class="container-fluid">
        <span class="navbar-toggler-icon me-3" onclick="openDrawer()" style="cursor:pointer;"></span>
        <span class="navbar-brand">Sistem Peminjaman Tempat</span>
        <div class="ms-auto text-white">
            <strong>Peminjam</strong>
        </div>
    </div>
</nav>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0"><i class="bi bi-clock-history me-2"></i>Riwayat Peminjaman</h2>
            <a href="ajukan.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Ajukan Baru
            </a>
        </div>

        <!-- Status Filter -->
        <div class="mb-4">
            <div class="d-flex flex-wrap">
                <a href="?status=Semua" 
                   class="btn filter-btn <?= $current_status == 'Semua' ? 'active btn-primary' : 'btn-outline-primary' ?>">
                   Semua <span class="badge bg-secondary ms-1"><?= array_sum($status_counts) ?></span>
                </a>
                <?php foreach ($statuses as $status): ?>
                    <?php if ($status != 'Semua'): ?>
                        <a href="?status=<?= $status ?>" 
                           class="btn filter-btn <?= $current_status == $status ? 'active ' : '' ?>
                           <?php 
                               switch($status) {
                                   case 'Diajukan': echo 'btn-outline-info'; break;
                                   case 'Disetujui': echo 'btn-outline-success'; break;
                                   case 'Ditolak': echo 'btn-outline-danger'; break;
                                   case 'Selesai': echo 'btn-outline-secondary'; break;
                                   case 'Dibatalkan': echo 'btn-outline-warning'; break;
                               }
                           ?>">
                           <?= $status ?> <span class="badge bg-secondary ms-1"><?= $status_counts[$status] ?? 0 ?></span>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card bg-info bg-opacity-10 border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted">Diajukan</h6>
                                <h2 class="mb-0"><?= $status_counts['Diajukan'] ?? 0 ?></h2>
                            </div>
                            <div class="icon bg-info text-white rounded-circle p-3">
                                <i class="bi bi-clock-history"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-success bg-opacity-10 border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted">Disetujui</h6>
                                <h2 class="mb-0"><?= $status_counts['Disetujui'] ?? 0 ?></h2>
                            </div>
                            <div class="icon bg-success text-white rounded-circle p-3">
                                <i class="bi bi-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card bg-danger bg-opacity-10 border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="text-uppercase text-muted">Ditolak</h6>
                                <h2 class="mb-0"><?= $status_counts['Ditolak'] ?? 0 ?></h2>
                            </div>
                            <div class="icon bg-danger text-white rounded-circle p-3">
                                <i class="bi bi-x-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking List -->
        <?php if (count($bookings) > 0): ?>
            <div class="row">
                <?php foreach ($bookings as $booking): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card status-card status-<?= $booking['status'] ?> h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h5 class="card-title mb-1"><?= htmlspecialchars($booking['nama_ruangan']) ?></h5>
                                        <small class="text-muted"><?= htmlspecialchars($booking['lokasi']) ?></small>
                                    </div>
                                    <span class="badge badge-status 
                                        <?php 
                                            switch($booking['status']) {
                                                case 'Diajukan': echo 'bg-info'; break;
                                                case 'Disetujui': echo 'bg-success'; break;
                                                case 'Ditolak': echo 'bg-danger'; break;
                                                case 'Selesai': echo 'bg-secondary'; break;
                                                case 'Dibatalkan': echo 'bg-warning'; break;
                                            }
                                        ?>">
                                        <?= $booking['status'] ?>
                                    </span>
                                </div>
                                
                                <div class="mb-3">
                                    <div class="d-flex mb-2">
                                        <i class="bi bi-calendar me-2"></i>
                                        <div>
                                            <strong>Tanggal:</strong> 
                                            <?= date('d M Y', strtotime($booking['tanggal_mulai'])) ?>
                                            <?php if ($booking['tanggal_mulai'] != $booking['tanggal_selesai']): ?>
                                                - <?= date('d M Y', strtotime($booking['tanggal_selesai'])) ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <i class="bi bi-clock me-2"></i>
                                        <div>
                                            <strong>Waktu:</strong> 
                                            <?= date('H:i', strtotime($booking['waktu_mulai'])) ?> - 
                                            <?= date('H:i', strtotime($booking['waktu_selesai'])) ?>
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <i class="bi bi-card-text me-2"></i>
                                        <div>
                                            <strong>Keterangan:</strong> 
                                            <?= !empty($booking['keterangan']) ? htmlspecialchars($booking['keterangan']) : '-' ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Timeline Status -->
                                <div class="timeline mt-3">
                                    <div class="timeline-item">
                                        <small class="text-muted">Diajukan pada <?= date('d M Y H:i', strtotime($booking['created_at'])) ?></small>
                                    </div>
                                    <?php if ($booking['status'] == 'Disetujui' || $booking['status'] == 'Ditolak'): ?>
                                        <div class="timeline-item">
                                            <small class="text-muted">
                                                <?= $booking['status'] ?> oleh Admin pada <?= date('d M Y H:i', strtotime($booking['updated_at'])) ?>
                                            </small>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($booking['catatan_admin'])): ?>
                                        <div class="timeline-item">
                                            <small class="text-muted">
                                                <strong>Catatan Admin:</strong> <?= htmlspecialchars($booking['catatan_admin']) ?>
                                            </small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="d-flex justify-content-between mt-3 pt-2 border-top">
                                    <?php if ($booking['status'] == 'Diajukan'): ?>
                                        <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#cancelModal<?= $booking['id'] ?>">
                                            <i class="bi bi-x-circle"></i> Batalkan
                                        </button>
                                    <?php elseif ($booking['status'] == 'Disetujui'): ?>
                                        <button class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-printer"></i> Cetak Surat
                                        </button>
                                    <?php else: ?>
                                        <div></div>
                                    <?php endif; ?>
                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal<?= $booking['id'] ?>">
                                        <i class="bi bi-eye"></i> Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Detail Modal -->
                    <div class="modal fade" id="detailModal<?= $booking['id'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Peminjaman</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Informasi Ruangan</h6>
                                            <div class="mb-3">
                                                <p class="mb-1"><strong>Nama Ruangan:</strong></p>
                                                <p><?= htmlspecialchars($booking['nama_ruangan']) ?></p>
                                            </div>
                                            <div class="mb-3">
                                                <p class="mb-1"><strong>Lokasi:</strong></p>
                                                <p><?= htmlspecialchars($booking['lokasi']) ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Detail Peminjaman</h6>
                                            <div class="mb-3">
                                                <p class="mb-1"><strong>Tanggal:</strong></p>
                                                <p>
                                                    <?= date('d M Y', strtotime($booking['tanggal_mulai'])) ?>
                                                    <?php if ($booking['tanggal_mulai'] != $booking['tanggal_selesai']): ?>
                                                        - <?= date('d M Y', strtotime($booking['tanggal_selesai'])) ?>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <p class="mb-1"><strong>Waktu:</strong></p>
                                                <p>
                                                    <?= date('H:i', strtotime($booking['waktu_mulai'])) ?> - 
                                                    <?= date('H:i', strtotime($booking['waktu_selesai'])) ?>
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <p class="mb-1"><strong>Status:</strong></p>
                                                <p>
                                                    <span class="badge 
                                                        <?php 
                                                            switch($booking['status']) {
                                                                case 'Diajukan': echo 'bg-info'; break;
                                                                case 'Disetujui': echo 'bg-success'; break;
                                                                case 'Ditolak': echo 'bg-danger'; break;
                                                                case 'Selesai': echo 'bg-secondary'; break;
                                                                case 'Dibatalkan': echo 'bg-warning'; break;
                                                            }
                                                        ?>">
                                                        <?= $booking['status'] ?>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <p class="mb-1"><strong>Tujuan Kegiatan:</strong></p>
                                        <p><?= !empty($booking['keterangan']) ? htmlspecialchars($booking['keterangan']) : '-' ?></p>
                                    </div>
                                    <?php if (!empty($booking['catatan_admin'])): ?>
                                        <div class="mb-3">
                                            <p class="mb-1"><strong>Catatan Admin:</strong></p>
                                            <p><?= htmlspecialchars($booking['catatan_admin']) ?></p>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($booking['dokumen'])): ?>
                                        <div class="mb-3">
                                            <p class="mb-1"><strong>Dokumen Pendukung:</strong></p>
                                            <a href="<?= htmlspecialchars($booking['dokumen']) ?>" class="btn btn-outline-primary btn-sm" target="_blank">
                                                <i class="bi bi-download"></i> Unduh Dokumen
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cancel Modal -->
                    <div class="modal fade" id="cancelModal<?= $booking['id'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Batalkan Peminjaman</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="cancel_booking.php" method="post">
                                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin membatalkan peminjaman ruang <strong><?= htmlspecialchars($booking['nama_ruangan']) ?></strong> pada tanggal <strong><?= date('d M Y', strtotime($booking['tanggal_mulai'])) ?></strong>?</p>
                                        <div class="mb-3">
                                            <label for="cancelReason" class="form-label">Alasan Pembatalan</label>
                                            <textarea class="form-control" id="cancelReason" name="cancel_reason" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger">Konfirmasi Pembatalan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <img src="https://cdn-icons-png.flaticon.com/512/4076/4076478.png" width="120" class="mb-3">
                <h4 class="text-muted">Tidak ada data peminjaman</h4>
                <p class="text-muted">Anda belum memiliki peminjaman dengan status "<?= $current_status ?>"</p>
                <a href="ajukan.php" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Ajukan Peminjaman Baru
                </a>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tooltip initialization
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        function openDrawer() {
        document.getElementById("sidebar").style.left = "0";
        document.getElementById("overlay").style.display = "block";
    }
    function closeDrawer() {
        document.getElementById("sidebar").style.left = "-250px";
        document.getElementById("overlay").style.display = "none";
    }
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