
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WonderTrip - Website Pariwisata Indonesia</title>
    <style>
        /* CSS akan dipindahkan ke file terpisah nanti */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background-color: #f5f5f5; }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; }
        
        /* Header */
        header { background: #2c3e50; color: white; padding: 1rem 0; }
        .header-content { display: flex; justify-content: space-between; align-items: center; }
        .logo { font-size: 1.8rem; font-weight: bold; color: white; text-decoration: none; }
        .logo span { color: #3498db; }
        nav ul { display: flex; list-style: none; }
        nav ul li { margin-left: 2rem; }
        nav ul li a { color: white; text-decoration: none; }
        
        /* Hero */
        .hero { background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('assets/image/hero-bg.jpg'); background-size: cover; color: white; padding: 4rem 0; text-align: center; }
        .hero h1 { font-size: 3rem; margin-bottom: 1rem; }
        
        /* City Navigation */
        .city-nav { background: white; padding: 1rem 0; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .city-nav ul { display: flex; justify-content: center; list-style: none; }
        .city-nav ul li { margin: 0 1rem; }
        .city-nav ul li a { padding: 0.5rem 1rem; text-decoration: none; color: #333; border-radius: 4px; }
        .city-nav ul li a.active { background: #3498db; color: white; }
        
        /* Destinations */
        .destinations { padding: 3rem 0; }
        .destination-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 2rem; }
        .destination-card { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .card-image { height: 200px; background: #ddd; }
        .card-content { padding: 1.5rem; }
        .book-btn { background: #3498db; color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 4px; cursor: pointer; width: 100%; }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <a href="index.php" class="logo">WONDER<span>TRIP</span></a>
                <nav>
                    <ul>
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="#destinations">Destinasi</a></li>
                        <li><a href="admin/login.php">Admin</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h1>Jelajahi Keindahan Indonesia</h1>
            <p>Temukan destinasi wisata terbaik di Surabaya, Makassar, dan Semarang</p>
        </div>
    </section>

    <section class="city-nav">
        <div class="container">
            <ul>
                <li><a href="#surabaya" class="active">Surabaya</a></li>
                <li><a href="#makassar">Makassar</a></li>
                <li><a href="#semarang">Semarang</a></li>
            </ul>
        </div>
    </section>

    <section class="destinations">
        <div class="container">
            <h2>Destinasi Wisata Populer</h2>
            <div class="destination-grid">
                <?php
                $destinations = [
                    // Surabaya
                    ["Taman Bungkul", "surabaya", "Rp 25.000", "Taman rekreasi keluarga di pusat kota"],
                    ["House of Sampoerna", "surabaya", "Rp 15.000", "Museum sejarah dan budaya"],
                    ["Monumen Kapal Selam", "surabaya", "Rp 20.000", "Museum kapal selam pertama di Asia"],
                    ["Ciputra Waterpark", "surabaya", "Rp 75.000", "Waterpark terbesar di Surabaya"],
                    ["Kebun Binatang Surabaya", "surabaya", "Rp 30.000", "Kebun binatang tertua di Indonesia"],
                    
                    // Makassar
                    ["Pantai Losari", "makassar", "Gratis", "Pantai ikonik dengan sunset terindah"],
                    ["Benteng Rotterdam", "makassar", "Rp 10.000", "Benteng peninggalan Kerajaan Gowa"],
                    ["Trans Studio Makassar", "makassar", "Rp 250.000", "Theme park indoor terbesar"],
                    ["Pulau Samalona", "makassar", "Rp 150.000", "Pulau dengan keindahan bawah laut"],
                    ["Malino", "makassar", "Rp 50.000", "Wisata alam pegunungan"],
                    
                    // Semarang
                    ["Lawang Sewu", "semarang", "Rp 30.000", "Bangunan bersejarah peninggalan Belanda"],
                    ["Kota Lama", "semarang", "Gratis", "Kawasan heritage dengan arsitektur Eropa"],
                    ["Sam Poo Kong", "semarang", "Rp 20.000", "Klenteng bersejarah"],
                    ["Umbul Sidomukti", "semarang", "Rp 40.000", "Wisata alam dengan kolam renang alami"],
                    ["Brown Canyon", "semarang", "Rp 15.000", "Wisata alam dengan pemandangan unik"]
                ];

                foreach($destinations as $index => $destination) {
                    echo "
                    <div class='destination-card'>
                        <div class='card-image'></div>
                        <div class='card-content'>
                            <h3>{$destination[0]}</h3>
                            <p>{$destination[3]}</p>
                            <p><strong>{$destination[2]}</strong></p>
                            <button class='book-btn' onclick=\"window.location.href='details.php?id=".($index+1)."'\">Pesan Tiket</button>
                        </div>
                    </div>";
                }
                ?>
            </div>
        </div>
    </section>

    <footer style="background: #2c3e50; color: white; padding: 2rem 0; text-align: center;">
        <div class="container">
            <p>&copy; 2025 WONDERTRIP. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>