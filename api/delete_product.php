<?php
$host = "localhost";
$user = "u797315644_root";
$password = "FH^9yUW4^3v|";
$db_name = "u797315644_carousel_db";

$conn = new mysqli($host, $user, $password, $db_name);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$id = intval($_GET['id']);
$sql = "DELETE FROM products WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    header("Location: https://kj-demo.site/products.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>