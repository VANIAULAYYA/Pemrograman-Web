<?php
include '../config.php';
session_start();

$id = $_GET['id'];
$conn->query("DELETE FROM ruangan WHERE id = $id");

header("Location: manajemen_tempat.php");