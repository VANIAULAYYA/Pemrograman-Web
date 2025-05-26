<?php session_start(); ?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Sistem Peminjaman Ruangan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #89f7fe 0%, #66a6ff 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
    }

    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      padding: 2rem;
      background: #fff;
      width: 100%;
      max-width: 400px;
    }

    .form-control:focus {
      border-color: #66a6ff;
      box-shadow: 0 0 0 0.25rem rgba(102, 166, 255, 0.25);
    }

    .btn-primary {
      background-color: #66a6ff;
      border: none;
    }

    .btn-primary:hover {
      background-color: #4e88dc;
    }
  </style>
</head>
<body>

<?php if (isset($_SESSION['error'])): ?>
  <div class="alert alert-danger alert-dismissible fade show position-absolute top-0 start-50 translate-middle-x mt-3" style="z-index: 1000; width: 90%; max-width: 400px;" role="alert">
    <?= $_SESSION['error']; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
  <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="card">
  <h4 class="text-center mb-3"><i class="fas fa-door-open me-2"></i>Login</h4>
  <form method="POST" action="login_proses.php">
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <div class="input-group">
        <span class="input-group-text"><i class="fas fa-user"></i></span>
        <input type="text" class="form-control" name="username" required autofocus>
      </div>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <div class="input-group">
        <span class="input-group-text"><i class="fas fa-lock"></i></span>
        <input type="password" class="form-control" name="password" required>
      </div>
    </div>

    <div class="mb-4">
      <label for="level" class="form-label">Login Sebagai</label>
      <div class="input-group">
        <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
        <select class="form-select" name="level" id="level" required>
          <option value="">-- Pilih --</option>
          <option value="1">Admin</option>
          <option value="2">Peminjam</option>
        </select>
      </div>
    </div>

    <div class="mb-4 d-none" id="admin-code-group">
      <label for="admin_code" class="form-label">Kode Admin</label>
      <div class="input-group">
        <span class="input-group-text"><i class="fas fa-key"></i></span>
        <input type="text" class="form-control" name="admin_code" placeholder="Masukkan kode khusus admin">
      </div>
    </div>

    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-sign-in-alt me-1"></i> Masuk</button>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const levelSelect = document.getElementById('level');
  const adminCodeGroup = document.getElementById('admin-code-group');

  levelSelect.addEventListener('change', function () {
    if (this.value === '1') {
      adminCodeGroup.classList.remove('d-none');
    } else {
      adminCodeGroup.classList.add('d-none');
    }
  });
</script>
</body>
</html>
