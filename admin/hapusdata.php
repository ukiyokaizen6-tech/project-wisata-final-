<?php
session_start();
include '../connect.php';

// Cek login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

// Cek apakah ada parameter ID
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = $_GET['id'];

// Ambil data gambar sebelum menghapus
$sql_select = "SELECT gambar FROM pariwisata WHERE id_wisata = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $id);
$stmt_select->execute();
$result = $stmt_select->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $gambar = $row['gambar'];
    
    // Hapus file gambar jika ada
    if ($gambar && file_exists("assets/image/" . $gambar)) {
        unlink("assets/image/" . $gambar);
    }
}
$stmt_select->close();

// Hapus data dari database
$sql_delete = "DELETE FROM pariwisata WHERE id_wisata = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $id);

if ($stmt_delete->execute()) {
    header("Location: dashboard.php?success=Data berhasil dihapus!");
} else {
    header("Location: dashboard.php?error=Gagal menghapus data");
}

$stmt_delete->close();
$conn->close();
?>