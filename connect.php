<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "database_pariwisata";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Buat tabel jika belum ada
$sql_tables = [
    "CREATE TABLE IF NOT EXISTS admin (
        id_admin INT(11) AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        password VARCHAR(255) NOT NULL
    )",
    
    "CREATE TABLE IF NOT EXISTS pariwisata (
        id_wisata INT AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR(150) NOT NULL,
        lokasi VARCHAR(255) NOT NULL,
        deskripsi TEXT NOT NULL,
        harga_tiket INT NOT NULL,
        gambar VARCHAR(255) NOT NULL,
        kota VARCHAR(100) NOT NULL
    )"
];

foreach ($sql_tables as $sql) {
    if (!$conn->query($sql)) {
        echo "Error creating table: " . $conn->error;
    }
}

// Insert admin default jika belum ada
$check_admin = "SELECT * FROM admin WHERE username = 'admin'";
$result = $conn->query($check_admin);
if ($result->num_rows == 0) {
    $insert_admin = "INSERT INTO admin (username, password) VALUES ('admin', MD5('admin123'))";
    $conn->query($insert_admin);
}

// Insert data contoh destinasi wisata jika belum ada
$check_data = "SELECT * FROM pariwisata";
$result = $conn->query($check_data);
if ($result->num_rows == 0) {
    // Data destinasi wisata contoh
    $destinations = [
        // Surabaya
        [
            "Taman Bungkul",
            "Surabaya, Jawa Timur",
            "Taman Bungkul adalah salah satu taman kota terpopuler di Surabaya. Taman ini memiliki fasilitas lengkap seperti area bermain anak, jogging track, dan amphitheater. Taman yang asri ini menjadi tempat favorit warga untuk bersantai dan berolahraga.",
            15000,
            "taman_bungkul.jpg",
            "surabaya"
        ],
        [
            "House of Sampoerna",
            "Surabaya, Jawa Timur", 
            "Museum yang menceritakan sejarah industri rokok di Indonesia. Bangunan bergaya kolonial ini memiliki arsitektur yang menarik dan koleksi foto bersejarah. Pengunjung dapat melihat proses pembuatan rokok secara tradisional.",
            25000,
            "house_sampoerna.jpg",
            "surabaya"
        ],
        [
            "Monumen Kapal Selam",
            "Surabaya, Jawa Timur",
            "Monumen yang dibangun dari kapal selam sungguhan KRI Pasopati 410. Pengunjung dapat masuk dan menjelajahi interior kapal selam untuk merasakan pengalaman unik seperti menjadi awak kapal selam.",
            20000,
            "monkasel.jpg",
            "surabaya"
        ],
        
        // Makassar
        [
            "Pantai Losari",
            "Makassar, Sulawesi Selatan",
            "Pantai Losari adalah ikon kota Makassar yang terkenal dengan pemandangan matahari terbenamnya yang menakjubkan. Tepi pantainya telah ditata dengan promenade yang nyaman untuk jogging dan bersepeda.",
            10000,
            "pantai_losari.jpg",
            "makassar"
        ],
        [
            "Benteng Rotterdam",
            "Makassar, Sulawesi Selatan",
            "Benteng peninggalan Kerajaan Gowa-Tallo yang dibangun pada abad ke-16. Kini benteng ini menjadi museum yang menyimpan berbagai peninggalan sejarah Sulawesi Selatan dengan arsitektur yang megah.",
            20000,
            "benteng_rotterdam.jpg",
            "makassar"
        ],
        [
            "Trans Studio Makassar",
            "Makassar, Sulawesi Selatan",
            "Theme park indoor terbesar di Indonesia Timur dengan berbagai wahana seru dan menarik. Tempat yang cocok untuk keluarga dengan konsep hiburan modern dan edukatif.",
            250000,
            "trans_studio.jpg",
            "makassar"
        ],
        
        // Semarang
        [
            "Lawang Sewu",
            "Semarang, Jawa Tengah",
            "Gedung bersejarah peninggalan Belanda yang terkenal dengan arsitekturnya yang megah dan banyaknya pintu (lawang sewu berarti seribu pintu). Memiliki nilai sejarah yang tinggi dan cerita mistis yang menarik.",
            30000,
            "lawang_sewu.jpg",
            "semarang"
        ],
        [
            "Kota Lama Semarang",
            "Semarang, Jawa Tengah", 
            "Kawasan bersejarah dengan bangunan-bangunan bergaya kolonial Belanda. Area ini telah direvitalisasi menjadi destinasi wisata yang menarik dengan kafe, galeri seni, dan toko suvenir.",
            0,
            "kota_lama.jpg",
            "semarang"
        ],
        [
            "Sam Poo Kong",
            "Semarang, Jawa Tengah",
            "Kelenteng bersejarah yang dibangun untuk menghormati Laksamana Cheng Ho. Arsitektur Tionghoa yang megah dan area yang luas membuat tempat ini cocok untuk wisata religi dan budaya.",
            20000,
            "sampoo_kong.jpg",
            "semarang"
        ]
    ];
    
    // Insert data ke database
    $stmt = $conn->prepare("INSERT INTO pariwisata (nama, lokasi, deskripsi, harga_tiket, gambar, kota) VALUES (?, ?, ?, ?, ?, ?)");
    
    foreach ($destinations as $destination) {
        $stmt->bind_param("sssiss", $destination[0], $destination[1], $destination[2], $destination[3], $destination[4], $destination[5]);
        $stmt->execute();
    }
    
    $stmt->close();
}
?>