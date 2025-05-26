<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Selamat Datang - Sistem Peminjaman Ruangan</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(to right, #74ebd5, #9face6);
      height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
      overflow: hidden;
    }

    .welcome-box {
      background: white;
      padding: 3rem 4rem;
      border-radius: 1.5rem;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
      text-align: center;
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .welcome-box h1 {
      font-size: 2.2rem;
      font-weight: bold;
      color: #3a3a3a;
      margin-bottom: 0.5rem;
    }

    .welcome-box p {
      color: #666;
      font-size: 1rem;
      margin-bottom: 2rem;
    }

    .welcome-box .icon {
      font-size: 4rem;
      color: #66a6ff;
      margin-bottom: 1rem;
      animation: bounce 2s infinite;
    }

    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }

    .btn-custom {
      width: 100%;
      padding: 0.75rem;
      font-size: 1rem;
      border-radius: 0.75rem;
    }

    .btn-login {
      background-color: #66a6ff;
      color: white;
      border: none;
    }

    .btn-login:hover {
      background-color: #4e88dc;
    }

    .btn-register {
      border: 2px solid #66a6ff;
      color: #66a6ff;
    }

    .btn-register:hover {
      background-color: #66a6ff;
      color: white;
    }
  </style>
</head>
<body>
  <div class="welcome-box">
    <div class="icon"><i class="fas fa-building"></i></div>
    <h1>Sistem Peminjaman Ruangan</h1>
    <p>Selamat datang! Silakan login atau registrasi akun terlebih dahulu untuk menggunakan sistem.</p>
    <div class="d-grid gap-2">
      <a href="login.php" class="btn btn-custom btn-login"><i class="fas fa-sign-in-alt me-2"></i> Login</a>
      <a href="register.php" class="btn btn-custom btn-register"><i class="fas fa-user-plus me-2"></i> Registrasi</a>
    </div>
  </div>
</body>
</html>
