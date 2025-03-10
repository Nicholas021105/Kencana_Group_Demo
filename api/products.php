<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Konfigurasi database
$host = "localhost";
$user = "u797315644_root";
$password = "FH^9yUW4^3v|";
$db_name = "u797315644_carousel_db";

// Koneksi ke database
$conn = new mysqli($host, $user, $password, $db_name);
if ($conn->connect_error) {
    die(json_encode(["error" => "Koneksi gagal: " . $conn->connect_error]));
}

// Query untuk mengambil data produk
$sql = "SELECT id, name, category, img1, img2, img3, power, speed, battery, `range`, brake, tire, created_at FROM products";
$result = $conn->query($sql);

$products = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Siapkan array untuk menampung gambar
        $images = [];
        if (!empty($row["img1"])) {
            $images[] = "data:image/jpeg;base64," . base64_encode($row["img1"]);
        }
        if (!empty($row["img2"])) {
            $images[] = "data:image/jpeg;base64," . base64_encode($row["img2"]);
        }
        if (!empty($row["img3"])) {
            $images[] = "data:image/jpeg;base64," . base64_encode($row["img3"]);
        }
        
        // Buat array produk dengan data yang dibutuhkan
        $products[] = [
            "id"         => $row["id"],
            "name"       => $row["name"],
            "category"   => $row["category"],
            "power"      => $row["power"],
            "speed"      => $row["speed"],
            "battery"    => $row["battery"],
            "range"      => $row["range"],
            "brake"      => $row["brake"],
            "tire"       => $row["tire"],
            "created_at" => $row["created_at"],
            "images"     => $images
        ];
    }
}

echo json_encode(["data" => $products]);
$conn->close();
?>
