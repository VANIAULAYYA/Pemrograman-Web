<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrasi Akun</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border-radius: 1rem;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 450px;
    }
    .card-header {
      font-size: 1.5rem;
      font-weight: bold;
      text-align: center;
      background: none;
      border-bottom: none;
    }
    .btn-primary {
      background-color: #66a6ff;
      border: none;
    }
    .btn-primary:hover {
      background-color: #66a6ff;
    }
  </style>
</head>
<body>

<div class="card p-4">
  <div class="card-header">
    <i class="fas fa-user-plus me-2"></i> Registrasi Akun
  </div>
  <div class="card-body">
    <form method="POST" action="proses/register_proses.php">
      
      <!-- Nama Lengkap -->
      <div class="mb-3">
        <label for="nama" class="form-label">Nama Lengkap</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-user"></i></span>
          <input type="text" class="form-control" name="nama" id="nama" required>
        </div>
      </div>

      <!-- Username -->
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-user-circle"></i></span>
          <input type="text" class="form-control" name="username" id="username" required>
        </div>
      </div>

      <!-- Password -->
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
          <input type="password" class="form-control" name="password" id="password" required>
        </div>
      </div>

      <!-- Konfirmasi Password -->
      <div class="mb-3">
        <label for="confirm_password" class="form-label">Konfirmasi Password</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
          <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
        </div>
      </div>

      <!-- Level -->
      <div class="mb-4">
        <label for="level" class="form-label">Sebagai</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
          <select class="form-select" name="level" id="level" required>
            <option value="">-- Pilih --</option>
            <option value="1">Admin</option>
            <option value="2">Peminjam</option>
          </select>
        </div>
      </div>

      <button type="submit" class="btn btn-primary w-100">
        <i class="fas fa-user-plus me-1"></i> Daftar
      </button>

      <div class="text-center mt-3">
        Sudah punya akun? <a href="index.php">Login di sini</a>
      </div>
    </form>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
