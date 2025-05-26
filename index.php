<!doctype html>
<html lang="en">
<head>
  <!-- Meta -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Title -->
  <title>Peminjaman Ruangan</title>

  <!-- Pesan Kesalahan -->
   <?php
   session_start();
   if(isset($_SESSION['eror'])) {
   ?>

  <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Holy guacamole!</strong> You should check in on some of those fields below.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>

  <?php } ?>

  <!-- Bootstrap CSS -->
  <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
    crossorigin="anonymous"
  >

  <!-- Font Awesome -->
  <link 
    rel="stylesheet" 
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
  >

  <!-- Custom CSS -->
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

    .card-header {
      font-size: 1.5rem;
      font-weight: 600;
      text-align: center;
      background: none;
      border: none;
      margin-bottom: 1rem;
    }

    .form-label {
      font-weight: 500;
    }

    .form-control:focus {
      border-color: #66a6ff;
      box-shadow: 0 0 0 0.25rem rgba(102, 166, 255, 0.25);
    }

    .input-group-text {
      background-color: #e9ecef;
      border: none;
    }

    .btn-primary {
      background-color: #66a6ff;
      border: none;
      transition: 0.3s;
    }

    .btn-primary:hover {
      background-color: #4e88dc;
    }
  </style>
</head>
<body>

  <div class="card">
    <div class="card-header">
      <i class="fas fa-door-open me-2"></i> Form Login
    </div>
    <div class="card-body">
      <form method="POST" action="proses/login_proses.php" autocomplete="off">
        
        <!-- Username -->
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input 
              type="text" 
              class="form-control" 
              id="username" 
              name="username" 
              placeholder="Masukkan Username" 
              required 
              autofocus
            >
          </div>
        </div>

        <!-- Password -->
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input 
              type="password" 
              class="form-control" 
              id="password" 
              name="password" 
              placeholder="Masukkan Password" 
              required
            >
          </div>
        </div>

        <!-- Level -->
        <div class="mb-4">
          <label for="level" class="form-label">Level</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-user-shield"></i></span>
            <select class="form-select" id="level" name="level" required>
              <option value="">-- Masuk sebagai --</option>
              <option value="2">Operator</option>
              <option value="1">Admin</option>
            </select>
          </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100">
          <i class="fas fa-sign-in-alt me-1"></i> Masuk
        </button>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script 
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
    crossorigin="anonymous">
  </script>
</body>
</html>
