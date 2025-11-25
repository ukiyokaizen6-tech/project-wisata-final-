<?php
session_start();

// Debug session
error_log("Session data: " . print_r($_SESSION, true));

// Cek login dengan lebih strict
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    error_log("Access denied - not logged in");
    header("Location: login.php");
    exit();
}

include '../connect.php';

// Query untuk mengambil data wisata
$sql = "SELECT * FROM pariwisata ORDER BY id_wisata DESC";
$result = $conn->query($sql);

// Hitung total data
$total_wisata = $result->num_rows;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - WonderTrip</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #3498db;
            --secondary: #2ecc71;
            --accent: #e74c3c;
            --dark: #2c3e50;
            --light: #ecf0f1;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f9f9f9;
            color: #333;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Header Styles */
        .admin-header {
            background: linear-gradient(135deg, var(--dark), #34495e);
            color: white;
            padding: 1rem 0;
            box-shadow: var(--shadow);
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo i {
            font-size: 2rem;
        }
        
        .logo h1 {
            font-size: 1.8rem;
            font-weight: 700;
        }
        
        .admin-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .admin-info a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border: 1px solid white;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .admin-info a:hover {
            background-color: white;
            color: var(--dark);
        }
        
        /* Navigation */
        .admin-nav {
            background-color: white;
            box-shadow: var(--shadow);
            padding: 1rem 0;
            margin-bottom: 2rem;
        }
        
        .admin-nav ul {
            display: flex;
            list-style: none;
            gap: 2rem;
            margin: 0;
            padding: 0;
        }
        
        .admin-nav a {
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .admin-nav a:hover,
        .admin-nav a.active {
            background-color: var(--primary);
            color: white;
        }
        
        /* Dashboard Content */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 4px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: var(--shadow);
            text-align: center;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }
        
        /* Table Styles */
        .data-table {
            width: 100%;
            background: white;
            border-radius: 8px;
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .data-table table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table th,
        .data-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        .data-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: var(--dark);
        }
        
        .data-table tr:hover {
            background-color: #f8f9fa;
        }
        
        .table-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }
        
        /* Action Buttons */
        .btn-action {
            padding: 0.4rem 0.8rem;
            border: none;
            border-radius: 4px;
            font-size: 0.8rem;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            margin: 0 0.2rem;
        }
        
        .btn-edit {
            background-color: #f39c12;
            color: white;
        }
        
        .btn-edit:hover {
            background-color: #e67e22;
        }
        
        .btn-delete {
            background-color: #e74c3c;
            color: white;
        }
        
        .btn-delete:hover {
            background-color: #c0392b;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #666;
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #ddd;
        }
        
        /* Alert Messages */
        .alert {
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .admin-nav ul {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .data-table {
                overflow-x: auto;
            }
            
            .dashboard-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="container header-content">
            <div class="logo">
                <i class="fas fa-map-marked-alt"></i>
                <h1>WonderTrip Admin</h1>
            </div>
            <div class="admin-info">
                <span>Halo, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>

    <nav class="admin-nav">
        <div class="container">
            <ul>
                <li><a href="dashboard.php" class="active">Dashboard</a></li>
                <li><a href="tambahdata.php">Tambah Data</a></li>
                <li><a href="../index.php">Lihat Website</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?php
        // Tampilkan pesan sukses jika ada
        if (isset($_GET['success'])) {
            echo '<div class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</div>';
        }
        ?>
        
        <div class="dashboard-header">
            <h2>Dashboard Data Wisata</h2>
            <a href="tambahdata.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Data Baru
            </a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_wisata; ?></div>
                <div class="stat-label">Total Destinasi Wisata</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">3</div>
                <div class="stat-label">Kota Tersedia</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $total_wisata * 150; ?></div>
                <div class="stat-label">Pengunjung Bulan Ini</div>
            </div>
        </div>

        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama Wisata</th>
                        <th>Lokasi</th>
                        <th>Kota</th>
                        <th>Harga Tiket</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $no = 1;
                        while($row = $result->fetch_assoc()) {
                            $gambar_path = "assets/image/" . $row['gambar'];
                            $gambar_url = file_exists($gambar_path) ? $gambar_path : "https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80";
                            
                            echo '
                            <tr>
                                <td>' . $no . '</td>
                                <td>
                                    <img src="' . $gambar_url . '" alt="' . $row['nama'] . '" class="table-image">
                                </td>
                                <td>' . htmlspecialchars($row['nama']) . '</td>
                                <td>' . htmlspecialchars($row['lokasi']) . '</td>
                                <td>' . ucfirst($row['kota']) . '</td>
                                <td>Rp ' . number_format($row['harga_tiket'], 0, ',', '.') . '</td>
                                <td>
                                    <a href="editdata.php?id=' . $row['id_wisata'] . '" class="btn-action btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="hapusdata.php?id=' . $row['id_wisata'] . '" class="btn-action btn-delete" onclick="return confirm(\'Yakin ingin menghapus?\')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>';
                            $no++;
                        }
                    } else {
                        echo '<tr>
                            <td colspan="7" class="empty-state">
                                <i class="fas fa-map-marked-alt"></i>
                                <h3>Belum ada data wisata</h3>
                                <p>Silakan tambah data wisata terlebih dahulu.</p>
                            </td>
                        </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php 
if (isset($conn)) {
    $conn->close(); 
}
?>