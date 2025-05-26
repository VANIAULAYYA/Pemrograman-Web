<?php
include '../config.php';

// Update status jika ada action
if (isset($_GET['id']) && isset($_GET['aksi'])) {
  $id = $_GET['id'];
  $aksi = $_GET['aksi'];

  if ($aksi == 'setujui') {
    $conn->query("UPDATE peminjaman SET status='disetujui' WHERE id=$id");
  } elseif ($aksi == 'tolak') {
    $conn->query("UPDATE peminjaman SET status='ditolak' WHERE id=$id");
  }

  header("Location: permintaan_peminjaman.php");
  exit;
}

// Ambil data
$query = "SELECT p.id, r.nama_ruangan, p.nama_peminjam, p.tanggal, p.jam_mulai, p.jam_selesai, p.status
          FROM peminjaman p
          JOIN ruangan r ON p.id_ruangan = r.id
          ORDER BY p.tanggal DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Permintaan Peminjaman</title>
  <style>
    table { border-collapse: collapse; width: 100%; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
    th { background-color: #f5f5f5; }
    .aksi a { margin-right: 10px; text-decoration: none; padding: 6px 10px; border-radius: 5px; }
    .setujui { background-color: #4CAF50; color: white; }
    .tolak { background-color: #f44336; color: white; }
  </style>
</head>
<body>

<h2>Daftar Permintaan Peminjaman Ruangan</h2>

<table>
  <tr>
    <th>No</th>
    <th>Nama Peminjam</th>
    <th>Ruangan</th>
    <th>Tanggal</th>
    <th>Waktu</th>
    <th>Status</th>
    <th>Keterangan</th>
    <th>Aksi</th>
  </tr>
  <?php
  $no = 1;
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $no++ . "</td>";
    echo "<td>" . htmlspecialchars($row['nama_peminjam']) . "</td>";
    echo "<td>" . htmlspecialchars($row['nama_ruangan']) . "</td>";
    echo "<td>" . $row['tanggal'] . "</td>";
    echo "<td>" . $row['jam_mulai'] . " - " . $row['jam_selesai'] . "</td>";
    echo "<td>" . $row['status'] . "</td>";
    echo "<td class='aksi'>";
    if ($row['status'] == 'Menunggu') {
      echo "<a class='setujui' href='?id=" . $row['id'] . "&aksi=setujui'>Setujui</a>";
      echo "<a class='tolak' href='?id=" . $row['id'] . "&aksi=tolak'>Tolak</a>";
    } else {
      echo "-";
    }
    echo "</td>";
    echo "</tr>";
  }
  ?>
</table>

</body>
</html>
