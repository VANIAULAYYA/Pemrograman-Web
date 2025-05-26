<?php
include '../config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = $_POST['nama_ruangan'];
  $lokasi = $_POST['lokasi'];
  $kapasitas = $_POST['kapasitas'];

  $stmt = $conn->prepare("INSERT INTO ruangan (nama_ruangan, lokasi, kapasitas) VALUES (?, ?, ?)");
  $stmt->bind_param("ssi", $nama, $lokasi, $kapasitas);
  $stmt->execute();
  header("Location: manajemen_tempat.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Tambah Tempat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h2>Tambah Tempat</h2>
  <form method="post">
    <div class="mb-3">
      <label>Nama Ruangan</label>
      <input type="text" name="nama_ruangan" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Lokasi</label>
      <input type="text" name="lokasi" class="form-control">
    </div>
    <div class="mb-3">
      <label>Kapasitas</label>
      <input type="number" name="kapasitas" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="manajemen_tempat.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>
</body>
</html>