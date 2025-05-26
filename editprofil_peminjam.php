<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Profil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
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

    .profile-container {
      position: relative;
      width: 150px;
      height: 150px;
      margin: auto;
    }

    .profile-img {
      width: 100%;
      height: 100%;
      border-radius: 50%;
      object-fit: cover;
    }

    .camera-icon {
      position: absolute;
      bottom: 0;
      right: 0;
      background-color: #ffffffcc;
      border-radius: 50%;
      padding: 8px;
      cursor: pointer;
    }

      .password-toggle {
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 1.2rem;
    color: #6c757d;
    height: 100%;
    display: flex;
    align-items: center;
  justify-content: center;
  height: 100%;
  }

  .position-relative {
    position: relative;
  }

    .field-disabled {
      background-color: #e9ecef;
      cursor: pointer;
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

<div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
  <div class="card p-4 shadow w-100" style="max-width: 700px;">
    <h3 class="text-center mb-4">Edit Profil</h3>

    <div class="text-center mb-4">
      <?php
      $foto = ''; // path foto profil jika ada
      $foto_src = $foto ? $foto : 'https://cdn-icons-png.flaticon.com/512/149/149071.png';
      ?>
      <div class="profile-container">
        <img src="<?= $foto_src ?>" alt="Foto Profil" class="profile-img" id="profilePreview">
        <label class="camera-icon">
          <i class="bi bi-camera-fill fs-5"></i>
          <input type="file" accept="image/*" hidden id="uploadFoto" onchange="previewFoto(event)">
        </label>
      </div>
    </div>

    <form>
      <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" placeholder="Nama Lengkap" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" placeholder="Username Anda" required>
      </div>

      <div class="mb-3 position-relative">
        <label class="form-label">Email</label>
        <input type="text" class="form-control field-disabled" id="triggerEmailModal" value="emailanda@example.com" readonly data-bs-toggle="modal" data-bs-target="#ubahEmailModal">
      </div>

      <div class="mb-3">
        <label class="form-label">Nomor Telepon</label>
        <input type="text" class="form-control" placeholder="08xxxxxxxxxx" required>
      </div>

      <div class="mb-3 position-relative">
        <label class="form-label">Password</label>
        <input type="text" class="form-control field-disabled" value="••••••••" readonly data-bs-toggle="modal" data-bs-target="#ubahPasswordModal">
      </div>

      <div class="text-end">
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Ubah Password -->
<div class="modal fade" id="ubahPasswordModal" tabindex="-1" aria-labelledby="ubahPasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" onsubmit="return validatePassword()">
      <div class="modal-header">
        <h5 class="modal-title" id="ubahPasswordModalLabel">Ubah Kata Sandi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3 position-relative">
          <label class="form-label">Password Sekarang</label>
          <input type="password" class="form-control" id="currentPass" required>
          <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('currentPass', this)"></i>
        </div>

        <div class="mb-3 position-relative">
          <label class="form-label">Password Baru</label>
          <input type="password" class="form-control" id="newPass" required>
          <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('newPass', this)"></i>
        </div>

        <div class="mb-3 position-relative">
          <label class="form-label">Konfirmasi Password Baru</label>
          <input type="password" class="form-control" id="confirmPass" required>
          <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('confirmPass', this)"></i>
        </div>

        <div id="passwordError" class="text-danger small d-none">Password baru tidak boleh sama dengan password lama atau tidak cocok.</div>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Ubah</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal Ubah Email -->
<div class="modal fade" id="ubahEmailModal" tabindex="-1" aria-labelledby="ubahEmailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" onsubmit="return ubahEmail()">
      <div class="modal-header">
        <h5 class="modal-title" id="ubahEmailModalLabel">Ubah Email</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Email Baru</label>
          <input type="email" class="form-control" id="newEmail" required>
        </div>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Ubah</button>
      </div>
    </form>
  </div>
</div>

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function togglePassword(id, icon) {
    const input = document.getElementById(id);
    const isPassword = input.type === "password";
    input.type = isPassword ? "text" : "password";
    icon.classList.toggle("bi-eye");
    icon.classList.toggle("bi-eye-slash");
  }

  function previewFoto(event) {
    const reader = new FileReader();
    reader.onload = function () {
      document.getElementById('profilePreview').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  }

  function validatePassword() {
    const current = document.getElementById('currentPass').value;
    const baru = document.getElementById('newPass').value;
    const konfirmasi = document.getElementById('confirmPass').value;
    const error = document.getElementById('passwordError');

    if (baru === current || baru !== konfirmasi) {
      error.classList.remove("d-none");
      return false;
    }
    error.classList.add("d-none");
    alert('Password berhasil diubah!');
    const modal = bootstrap.Modal.getInstance(document.getElementById('ubahPasswordModal'));
    modal.hide();
    return false;
  }

  function ubahEmail() {
    const emailBaru = document.getElementById('newEmail').value;
    document.getElementById('triggerEmailModal').value = emailBaru;
    alert("Email berhasil diubah!");
    const modal = bootstrap.Modal.getInstance(document.getElementById('ubahEmailModal'));
    modal.hide();
    return false;
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
