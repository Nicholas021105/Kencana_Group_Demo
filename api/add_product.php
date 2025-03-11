<?php
// Aktifkan pelaporan error untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Batasi ukuran upload untuk mempercepat proses
ini_set('upload_max_filesize', '5M');
ini_set('post_max_size', '15M');

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

// Fungsi untuk menghasilkan UUID sederhana (36 karakter)
function generateUUID() {
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

// Cek apakah request adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mulai pengukuran waktu (opsional untuk debugging)
    $start_time = microtime(true);

    // Generate UUID untuk id
    $id = generateUUID();

    // Ambil data teks
    $name = $_POST['name'] ?? '';
    $category = $_POST['category'] ?? '';
    $power = $_POST['power'] ?? '';
    $speed = $_POST['speed'] ?? '';
    $battery = $_POST['battery'] ?? '';
    $range = $_POST['range'] ?? '';
    $brake = $_POST['brake'] ?? '';
    $tire = $_POST['tire'] ?? '';

    // Proses upload gambar
    $img1 = null;
    $img2 = null;
    $img3 = null;

    if (isset($_FILES['img1']) && $_FILES['img1']['error'] == UPLOAD_ERR_OK) {
        $img1 = file_get_contents($_FILES['img1']['tmp_name']);
        if ($img1 === false) {
            die("Gagal membaca img1.");
        }
    } else {
        echo "Error upload img1: " . ($_FILES['img1']['error'] ?? 'File tidak ditemukan');
        exit();
    }

    if (isset($_FILES['img2']) && $_FILES['img2']['error'] == UPLOAD_ERR_OK) {
        $img2 = file_get_contents($_FILES['img2']['tmp_name']);
        if ($img2 === false) {
            die("Gagal membaca img2.");
        }
    }

    if (isset($_FILES['img3']) && $_FILES['img3']['error'] == UPLOAD_ERR_OK) {
        $img3 = file_get_contents($_FILES['img3']['tmp_name']);
        if ($img3 === false) {
            die("Gagal membaca img3.");
        }
    }

    // Prepared statement untuk menyimpan data
    $stmt = $conn->prepare("INSERT INTO products (id, name, category, img1, img2, img3, power, speed, battery, `range`, brake, tire) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "ssssssssssss",
        $id,
        $name,
        $category,
        $img1,
        $img2,
        $img3,
        $power,
        $speed,
        $battery,
        $range,
        $brake,
        $tire
    );

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        // Redirect tanpa delay
        header("Location: https://kj-demo.site/products.php");
        // Akhiri pengukuran waktu (opsional untuk debugging)
        $end_time = microtime(true);
        //echo "Waktu eksekusi: " . ($end_time - $start_time) . " detik";
        exit();
    } else {
        echo "Error menyimpan data: " . $stmt->error;
        // Akhiri pengukuran waktu (opsional untuk debugging)
        $end_time = microtime(true);
        //echo "Waktu eksekusi: " . ($end_time - $start_time) . " detik";
        $stmt->close();
        $conn->close();
        exit();
    }
} else {
    echo "Metode request tidak valid.";
    $conn->close();
}
?>