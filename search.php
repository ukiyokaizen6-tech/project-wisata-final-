<?php
include 'connect.php';

$search = $_GET['q'] ?? '';
$city = $_GET['city'] ?? '';

$query = "SELECT * FROM destinations WHERE 1=1";
$params = [];

if (!empty($search)) {
    $query .= " AND name LIKE ?";
    $params[] = "%$search%";
}

if (!empty($city) && $city != 'all') {
    $query .= " AND city = ?";
    $params[] = $city;
}

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $types = str_repeat('s', count($params));
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian - PARIWISAIA</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; padding: 2rem 0; }
        .search-form { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; }
        input, select { width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 4px; }
        .search-btn { background: #3498db; color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 4px; cursor: pointer; }
        .destination-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; }
        .destination-card { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .card-image { height: 200px; background: #ddd; }
        .card-content { padding: 1.5rem; }
        .book-btn { background: #3498db; color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 4px; cursor: pointer; width: 100%; }
    </style>
</head>
<body>
    <div class="container">
        <div class="search-form">
            <h1>Cari Destinasi Wisata</h1>
            <form method="GET">
                <div class="form-group">
                    <label>Kata Kunci:</label>
                    <input type="text" name="q" value="<?php echo htmlspecialchars($search); ?>">
                </div>
                <div class="form-group">
                    <label>Kota:</label>
                    <select name="city">
                        <option value="all">Semua Kota</option>
                        <option value="surabaya" <?php echo $city == 'surabaya' ? 'selected' : ''; ?>>Surabaya</option>
                        <option value="makassar" <?php echo $city == 'makassar' ? 'selected' : ''; ?>>Makassar</option>
                        <option value="semarang" <?php echo $city == 'semarang' ? 'selected' : ''; ?>>Semarang</option>
                    </select>
                </div>
                <button type="submit" class="search-btn">Cari</button>
            </form>
        </div>

        <h2>Hasil Pencarian</h2>
        <div class="destination-grid">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                    <div class='destination-card'>
                        <div class='card-image'></div>
                        <div class='card-content'>
                            <h3>{$row['name']}</h3>
                            <p><strong>Kota:</strong> ".ucfirst($row['city'])."</p>
                            <p>{$row['description']}</p>
                            <p><strong>Rp ".number_format($row['price'], 0, ',', '.')."</strong></p>
                            <button class='book-btn' onclick=\"window.location.href='details.php?id={$row['id']}'\">Pesan Tiket</button>
                        </div>
                    </div>";
                }
            } else {
                echo "<p>Tidak ada destinasi yang ditemukan.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>