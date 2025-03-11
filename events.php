<?php
// Konfigurasi URL API
$api_base_url = "https://kj-demo.site/api/";
// Tambahkan timestamp untuk memastikan data terbaru
$timestamp = time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events - Image Carousel Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .preview-image {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Image Carousel Manager</h2>

        <!-- Navigasi Antar File -->
        <nav class="nav mt-4">
            <a class="nav-link" href="slides.php">Slides</a>
            <a class="nav-link active" href="events.php">Events</a>
            <a class="nav-link" href="products.php">Products</a>
        </nav>

        <!-- Konten Events -->
        <div class="mt-4">
            <h4>Manage Events</h4>
            <form action="<?php echo $api_base_url; ?>add_event.php" method="post" enctype="multipart/form-data" class="mb-4">
                <div class="row">
                    <div class="col-md-8">
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Upload Event</button>
                    </div>
                </div>
            </form>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Preview</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Tambahkan timestamp ke URL API untuk mencegah cache
                    $events_json = file_get_contents($api_base_url . "events.php?t=" . $timestamp);
                    $events_data = json_decode($events_json, true);
                    if (isset($events_data['data']) && !empty($events_data['data'])) {
                        foreach ($events_data['data'] as $event) {
                            echo "<tr>";
                            // Tambahkan timestamp ke URL gambar
                            echo "<td><img src='" . $api_base_url . "event_image.php?id=" . $event['id'] . "&t=" . $timestamp . "' alt='Event Image' class='preview-image'></td>";
                            echo "<td>" . $event['created_at'] . "</td>";
                            echo "<td>";
                            echo "<a href='" . $api_base_url . "edit_event.php?id=" . $event['id'] . "' class='btn btn-sm btn-warning me-2'>Edit</a>";
                            echo "<a href='" . $api_base_url . "delete_event.php?id=" . $event['id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus?\");'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>Tidak ada data events</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// Tambahkan header anti-cache untuk halaman itu sendiri
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
?>