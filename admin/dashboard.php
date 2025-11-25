<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
include '../connect.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - PARIWISAIA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; }
        header { background: #2c3e50; color: white; padding: 1rem 0; }
        .header-content { display: flex; justify-content: space-between; align-items: center; }
        .admin-nav { background: #34495e; padding: 1rem 0; }
        .admin-nav ul { display: flex; list-style: none; }
        .admin-nav ul li { margin-right: 2rem; }
        .admin-nav ul li a { color: white; text-decoration: none; }
        .content { padding: 2rem 0; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #ddd; }
        .btn { padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; display: inline-block; }
        .btn-edit { background: #3498db; color: white; }
        .btn-delete { background: #e74c3c; color: white; }
        .btn-add { background: #27ae60; color: white; margin-bottom: 1rem; }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <h1>Dashboard Admin</h1>
                <a href="logout.php" style="color: white;">Logout</a>
            </div>
        </div>
    </header>
    
    <nav class="admin-nav">
        <div class="container">
            <ul>
                <li><a href="dashboard.php">Data Destinasi</a></li>
                <li><a href="tambahdata.php">Tambah Destinasi</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container">
        <div class="content">
            <a href="tambahdata.php" class="btn btn-add">Tambah Destinasi Baru</a>
            
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Destinasi</th>
                        <th>Kota</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $conn->query("SELECT * FROM destinations");
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>".ucfirst($row['city'])."</td>
                            <td>Rp ".number_format($row['price'], 0, ',', '.')."</td>
                            <td>
                                <a href='editdata.php?id={$row['id']}' class='btn btn-edit'>Edit</a>
                                <a href='hapusdata.php?id={$row['id']}' class='btn btn-delete' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>