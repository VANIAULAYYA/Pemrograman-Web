<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';
session_start();

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID tidak valid.");
}
$id = intval($_GET['id']);

// Ambil data ruangan
$q = $conn->query("SELECT * FROM ruangan WHERE id = $id");
if (!$q || $q->num_rows == 0) {
    die("Data ruangan tidak ditemukan.");
}
$data = $q->fetch_assoc();

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama_ruangan'];
    $lokasi = $_POST['lokasi'];
    $kapasitas = intval($_POST['kapasitas']);

    $stmt = $conn->prepare("UPDATE ruangan SET nama_ruangan=?, lokasi=?, kapasitas=? WHERE id=?");
    if (!$stmt) {
        die("Prepare gagal: " . $conn->error);
    }

    $stmt->bind_param("ssii", $nama, $lokasi, $kapasitas, $id);
    if ($stmt->execute()) {
        header("Location: manajemen_tempat.php");
        exit;
    } else {
        echo "Gagal update: " . $stmt->error;
    }
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
      <input type="text" name="nama_ruangan" class="form-control" value="<?= htmlspecialchars($data['nama_ruangan']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Lokasi</label>
      <input type="text" name="lokasi" class="form-control" value="<?= htmlspecialchars($data['lokasi']) ?>">
    </div>
    <div class="mb-3">
      <label>Kapasitas</label>
      <input type="number" name="kapasitas" class="form-control" value="<?= htmlspecialchars($data['kapasitas']) ?>">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="manajemen_tempat.php" class="btn btn-secondary">Batal</a>
  </form>
</div>
</body>
</html>
