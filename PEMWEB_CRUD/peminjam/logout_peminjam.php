<?php
session_start();
session_destroy(); // Hapus semua session login
header("Location: ../login.php"); // Redirect ke halaman login
exit();
