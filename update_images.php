<?php
// File untuk update nama gambar di database
include 'connect.php';

// Data update gambar
$image_updates = [
    // Surabaya
    ['taman_bungkul.jpg', 'taman_bungkul.jfif'],
    ['house_sampoerna.jpg', 'house_sampoema.jfif'],
    ['monkasel.jpg', 'monumen_kapal_selam.jfif'],
    
    // Makassar
    ['pantai_losari.jpg', 'pantai_losari.jfif'],
    ['benteng_rotterdam.jpg', 'benteng_rotterdam.jfif'],
    ['trans_studio.jpg', 'transstudio_makassari.jfif'],
    
    // Semarang
    ['lawang_sewu.jpg', 'lawang_sewu.jfif'],
    ['kota_lama.jpg', 'kota_lama.jfif'],
    ['sampoo_kong.jpg', 'sam_poo_kong.jfif']
];

foreach ($image_updates as $update) {
    $old_name = $update[0];
    $new_name = $update[1];
    
    $sql = "UPDATE pariwisata SET gambar = ? WHERE gambar = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $new_name, $old_name);
    
    if ($stmt->execute()) {
        echo "Updated: $old_name → $new_name<br>";
    } else {
        echo "Error updating $old_name: " . $stmt->error . "<br>";
    }
    $stmt->close();
}

echo "Update selesai! <a href='index.php'>Kembali ke Beranda</a>";

$conn->close();
?>