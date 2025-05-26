<?php
include '../config.php';
session_start();

$id = $_GET['id'];
$q = $conn->query("SELECT * FROM ruangan WHERE id = $id");
$data = $q->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = $_POST['nama_ruangan'];
  $lokasi = $_POST['lokasi'];
  $kapasitas = $_POST['kapasitas'];

  $stmt = $conn->prepare("UPDATE ruangan SET nama_ruangan=?, lokasi=?, kapasitas=? WHERE id=?");
  $stmt->bind_param("ssii", $nama, $lokasi, $kapasitas, $id);
  $stmt->execute();
  header("Location: manajemen_tempat.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Tempat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
  <h2>Edit Tempat</h2>
  <form method="post">
    <div class="mb-3">
      <label>Nama Ruangan</label>
      <input type="text" name="nama_ruangan" class="form-control" value="<?= $data['nama_ruangan'] ?>" required>
    </div>
    <div class="mb-3">
      <label>Lokasi</label>
      <input type="text" name="lokasi" class="form-control" value="<?= $data['lokasi'] ?>">
    </div>
    <div class="mb-3">
      <label>Kapasitas</label>
      <input type="number" name="kapasitas" class="form-control" value="<?= $data['kapasitas'] ?>">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="manajemen_tempat.php" class="btn btn-secondary">Batal</a>
  </form>
</div>
</body>
</html>
