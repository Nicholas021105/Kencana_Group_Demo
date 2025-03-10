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

// Query untuk mengambil data events (tanpa kolom 'name')
// Jika Anda ingin menambahkan kolom name, pastikan tabel events sudah memiliki kolom tersebut dan ubah query di bawah.
$sql = "SELECT id, created_at FROM events";
$result = $conn->query($sql);

$events = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

echo json_encode(["data" => $events]);
$conn->close();
?>
