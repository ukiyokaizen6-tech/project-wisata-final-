<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
include '../connect.php';

if ($_POST) {
    $name = $_POST['name'];
    $city = $_POST['city'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    
    $stmt = $conn->prepare("INSERT INTO destinations (name, city, price, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $city, $price, $description);
    
    if ($stmt->execute()) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Gagal menambah data";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data - PARIWISAIA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        .container { width: 90%; max-width: 600px; margin: 2rem auto; }
        .form-container { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { margin-bottom: 2rem; color: #2c3e50; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; }
        input, textarea, select { width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 4px; }
        textarea { height: 100px; }
        .btn { padding: 0.7rem 1.5rem; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-submit { background: #3498db; color: white; }
        .btn-cancel { background: #95a5a6; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Tambah Destinasi Wisata</h1>
            
            <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Nama Destinasi:</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Kota:</label>
                    <select name="city" required>
                        <option value="surabaya">Surabaya</option>
                        <option value="makassar">Makassar</option>
                        <option value="semarang">Semarang</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Harga:</label>
                    <input type="number" name="price" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi:</label>
                    <textarea name="description" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-submit">Tambah Data</button>
                    <a href="dashboard.php" class="btn btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>