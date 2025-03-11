<?php
$conn = new mysqli("localhost", "u797315644_root", "FH^9yUW4^3v|", "u797315644_carousel_db");
if ($conn->connect_error) die("Koneksi gagal");

if (!isset($_GET['id'])) {
    http_response_code(400);
    die("Parameter 'id' tidak ditemukan.");
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT image FROM events WHERE id = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $event = $result->fetch_assoc();
    if ($event['image']) {
        header("Content-Type: image/jpeg");
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Pragma: no-cache");
        echo $event['image'];
    } else {
        http_response_code(404);
        die("Gambar tidak tersedia.");
    }
} else {
    http_response_code(404);
    die("Event tidak ditemukan.");
}

$stmt->close();
$conn->close();
?>