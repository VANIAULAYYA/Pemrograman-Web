<?php
include '../config.php';
session_start();

// (Opsional) Pastikan admin login

$data = $conn->query("SELECT * FROM ruangan");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manajemen Tempat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h2>Manajemen Tempat</h2>
  <a href="tambah_tempat.php" class="btn btn-success mb-3">+ Tambah Tempat</a>

  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>Nama Ruangan</th>
        <th>Lokasi</th>
        <th>Kapasitas</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($d = $data->fetch_assoc()): ?>
      <tr>
        <td><?= $d['nama_ruangan'] ?></td>
        <td><?= $d['lokasi'] ?></td>
        <td><?= $d['kapasitas'] ?></td>
        <td>
          <a href="edit_tempat.php?id=<?= $d['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
          <a href="hapus_tempat.php?id=<?= $d['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>