<?php
session_start();
session_unset();
session_destroy();
header("Location: ../login.php"); // Asumsikan logout.php ada di folder admin, jadi satu tingkat di atas login.php
exit();
?>
