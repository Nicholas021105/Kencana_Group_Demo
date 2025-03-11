<?php
// Aktifkan pelaporan error untuk debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Ambil data slide berdasarkan id
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM slides WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $slide = $result->fetch_assoc();
    } else {
        die("Slide tidak ditemukan.");
    }
    $stmt->close();
}

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $image = $slide['image']; // Gunakan gambar lama sebagai default

    // Proses gambar baru jika diunggah
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
        if ($image === false) {
            die("Gagal membaca file gambar.");
        }
    } elseif (isset($_FILES['image']) && $_FILES['image']['error'] != UPLOAD_ERR_NO_FILE) {
        echo "Error upload gambar: " . $_FILES['image']['error'];
        exit();
    }

    // Prepared statement untuk update
    $stmt = $conn->prepare("UPDATE slides SET name = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sss", $name, $image, $id);

    if ($stmt->execute()) {
        // Tambahkan header anti-cache
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Location: https://kj-demo.site/slides.php");
        exit();
    } else {
        echo "Error saat menyimpan perubahan: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Slide - Image Carousel Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .preview-image {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Slide</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $id; ?>" method="post" enctype="multipart/form-data" class="mt-4">
            <input type="hidden" name="id" value="<?php echo $slide['id']; ?>">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Slide Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($slide['name']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Slide Image</label>
                    <?php if ($slide['image']) { ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($slide['image']); ?>" alt="Slide Image" class="preview-image">
                    <?php } ?>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="https://kj-demo.site/slides.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>