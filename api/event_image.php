<?php
// Konfigurasi database
$host = "localhost";
$user = "u797315644_root";
$password = "FH^9yUW4^3v|";
$db_name = "u797315644_carousel_db";

// Koneksi ke database
$conn = new mysqli($host, $user, $password, $db_name);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pastikan parameter id ada
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Ambil data gambar dari tabel events berdasarkan id
    $stmt = $conn->prepare("SELECT image FROM events WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($image);
        $stmt->fetch();
        // Asumsikan format gambar JPEG (ubah header Content-Type jika menggunakan format lain)
        header("Content-Type: image/jpeg");
        echo $image;
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "Image not found";
    }
    $stmt->close();
}
$conn->close();
?>
