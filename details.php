<?php
include 'connect.php';

$id = $_GET['id'] ?? 1;
$query = $conn->prepare("SELECT * FROM destinations WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$destination = $result->fetch_assoc();

if (!$destination) {
    die("Destinasi tidak ditemukan");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $destination['name']; ?> - WONDERTRIP</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        .container { width: 90%; max-width: 800px; margin: 2rem auto; }
        .destination-detail { background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .destination-image { width: 100%; height: 300px; background: #ddd; margin-bottom: 1rem; }
        .booking-form { margin-top: 2rem; }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; }
        input, select { width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 4px; }
        .book-btn { background: #3498db; color: white; border: none; padding: 1rem 2rem; border-radius: 4px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <div class="destination-detail">
            <div class="destination-image"></div>
            <h1><?php echo $destination['name']; ?></h1>
            <p><strong>Kota:</strong> <?php echo ucfirst($destination['city']); ?></p>
            <p><strong>Harga:</strong> Rp <?php echo number_format($destination['price'], 0, ',', '.'); ?></p>
            <p><?php echo $destination['description']; ?></p>
            
            <div class="booking-form">
                <h2>Pemesanan Tiket</h2>
                <form action="process_booking.php" method="POST">
                    <input type="hidden" name="destination_id" value="<?php echo $destination['id']; ?>">
                    <div class="form-group">
                        <label>Nama Lengkap:</label>
                        <input type="text" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Tiket:</label>
                        <input type="number" name="quantity" min="1" value="1" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Kunjungan:</label>
                        <input type="date" name="visit_date" required>
                    </div>
                    <button type="submit" class="book-btn">Pesan Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>