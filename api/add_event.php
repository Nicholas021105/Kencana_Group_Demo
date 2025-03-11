<?php
$host = "localhost";
$user = "u797315644_root";
$password = "FH^9yUW4^3v|";
$db_name = "u797315644_carousel_db";

$conn = new mysqli($host, $user, $password, $db_name);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
        $image = $conn->real_escape_string($image);
        
        $sql = "INSERT INTO events (image) VALUES ('$image')";
        if ($conn->query($sql) === TRUE) {
            header("Location: https://kj-demo.site/events.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Gagal mengupload gambar. Kode error: " . $_FILES['image']['error'];
    }
}

$conn->close();
?>