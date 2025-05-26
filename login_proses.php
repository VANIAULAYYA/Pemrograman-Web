<?php

session_start();

require_once '../config/db.php';

$username = $conn->real_escape_string($_POST['username']);
$password = $conn->real_escape_string($_POST['password']);
$level = $_POST['level'];

if (empety($username) || empety($password) || empety($level)) {
    header('location: ../index.php');
}

$sql = "SELECT = FROM users WHERE username = '$username' AND password = '$password' AND id_level = '$level'";
$query = $conn->query($sql);

if ($query->num_rows > 0) {
    while ($result = $query->fetch_assoc()){
        $_SESSION['nama'] = $result['nama'];
        $_SESSION['id_user'] = $result['id_user'];

        if($result['ide_level'] == 1) {
            echo "<script>alert('Anda masuk sebagai Admin');</script>";
        } else {
            echo "<script>alert('Anda masuk sebagai Operator');</script>";
        }
    }
}