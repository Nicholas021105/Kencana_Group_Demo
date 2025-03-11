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
$sql = "SELECT name, category, power, speed, battery, `range`, brake, tire FROM products WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $category = $conn->real_escape_string($_POST['category']);
    $power = $conn->real_escape_string($_POST['power']);
    $speed = $conn->real_escape_string($_POST['speed']);
    $battery = $conn->real_escape_string($_POST['battery']);
    $range = $conn->real_escape_string($_POST['range']);
    $brake = $conn->real_escape_string($_POST['brake']);
    $tire = $conn->real_escape_string($_POST['tire']);
    
    $img1 = isset($_FILES['img1']) && $_FILES['img1']['error'] == 0 ? file_get_contents($_FILES['img1']['tmp_name']) : null;
    $img2 = isset($_FILES['img2']) && $_FILES['img2']['error'] == 0 ? file_get_contents($_FILES['img2']['tmp_name']) : null;
    $img3 = isset($_FILES['img3']) && $_FILES['img3']['error'] == 0 ? file_get_contents($_FILES['img3']['tmp_name']) : null;

    $update_fields = "name='$name', category='$category', power='$power', speed='$speed', battery='$battery', `range`='$range', brake='$brake', tire='$tire'";
    if ($img1) $update_fields .= ", img1='$img1'";
    if ($img2) $update_fields .= ", img2='$img2'";
    if ($img3) $update_fields .= ", img3='$img3'";
    
    $sql = "UPDATE products SET $update_fields WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: https://kj-demo.site/add_data/products.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required><br>
        <label for="category">Category:</label><br>
        <input type="text" id="category" name="category" value="<?php echo $row['category']; ?>" required><br>
        <label for="power">Power:</label><br>
        <input type="text" id="power" name="power" value="<?php echo $row['power']; ?>" required><br>
        <label for="speed">Speed:</label><br>
        <input type="text" id="speed" name="speed" value="<?php echo $row['speed']; ?>" required><br>
        <label for="battery">Battery:</label><br>
        <input type="text" id="battery" name="battery" value="<?php echo $row['battery']; ?>" required><br>
        <label for="range">Range:</label><br>
        <input type="text" id="range" name="range" value="<?php echo $row['range']; ?>" required><br>
        <label for="brake">Brake:</label><br>
        <input type="text" id="brake" name="brake" value="<?php echo $row['brake']; ?>" required><br>
        <label for="tire">Tire:</label><br>
        <input type="text" id="tire" name="tire" value="<?php echo $row['tire']; ?>" required><br>
        <label for="img1">Image 1 (kosongkan jika tidak ingin mengganti):</label><br>
        <input type="file" id="img1" name="img1" accept="image/jpeg"><br>
        <label for="img2">Image 2 (kosongkan jika tidak ingin mengganti):</label><br>
        <input type="file" id="img2" name="img2" accept="image/jpeg"><br>
        <label for="img3">Image 3 (kosongkan jika tidak ingin mengganti):</label><br>
        <input type="file" id="img3" name="img3" accept="image/jpeg"><br><br>
        <input type="submit" value="Update Product">
    </form>
</body>
</html>

<?php $conn->close(); ?>