<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
include '../connect.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM destinations WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: dashboard.php');
    exit;
} else {
    die("Gagal menghapus data");
}
?>