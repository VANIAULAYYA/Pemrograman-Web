<?php
session_start();

// Data user statis
$users = [
    ['username' => 'admin', 'password' => 'admin123', 'level' => 1, 'nama_user' => 'Administrator'],
    ['username' => 'peminjam', 'password' => 'peminjam123', 'level' => 2, 'nama_user' => 'Operator Peminjaman'],
];

// Kode admin
$kodeAdminResmi = "ADMIN-SECRET-2024";

// Ambil data dari form
$username   = trim($_POST['username'] ?? '');
$password   = trim($_POST['password'] ?? '');
$level      = (int) ($_POST['level'] ?? 0);
$admin_code = trim($_POST['admin_code'] ?? '');

// Validasi form kosong
if (empty($username) || empty($password) || empty($level)) {
    $_SESSION['error'] = 'Semua field harus diisi!';
    header("Location: ../login.php");
    exit();
}

// Cek user cocok
foreach ($users as $user) {
    if ($user['username'] === $username && $user['password'] === $password && $user['level'] === $level) {
        if ($level === 1 && $admin_code !== $kodeAdminResmi) {
            $_SESSION['error'] = 'Kode admin salah atau tidak diisi!';
            header("Location: ../login.php");
            exit();
        }

        $_SESSION['user'] = [
            'username' => $username,
            'nama' => $user['nama_user'],
            'level' => $level
        ];

        // Arahkan ke dashboard
        if ($level === 1) {
            header("Location: admin/dashboard_admin.php");
        } else {
            header("Location: peminjam/dashboard_peminjam.php");
        }
        exit();
    }
}

// Gagal login
$_SESSION['error'] = 'Username, password, atau level salah!';
header("Location: ../login.php");
exit();
