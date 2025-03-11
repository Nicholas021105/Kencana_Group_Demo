<?php
// Konfigurasi URL API
$api_base_url = "https://kj-demo.site/api/";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Image Carousel Manager</title>
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
            <a class="nav-link" href="events.php">Events</a>
            <a class="nav-link active" href="products.php">Products</a>
        </nav>

        <!-- Konten Products -->
        <div class="mt-4">
            <h4>Manage Products</h4>
            <form action="<?php echo $api_base_url; ?>add_product.php" method="post" enctype="multipart/form-data" class="mb-4">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <input type="text" name="name" placeholder="Product Name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="category" placeholder="Category" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <input type="file" name="img1" class="form-control" accept="image/*" required>
                    </div>
                    <div class="col-md-4">
                        <input type="file" name="img2" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-4">
                        <input type="file" name="img3" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <input type="text" name="power" placeholder="Power" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="speed" placeholder="Speed" class="form-control">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <input type="text" name="battery" placeholder="Battery" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="range" placeholder="Range" class="form-control">
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <input type="text" name="brake" placeholder="Brake" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="tire" placeholder="Tire" class="form-control">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Upload Product</button>
            </form>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Preview</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $products_json = file_get_contents($api_base_url . "products.php");
                    $products_data = json_decode($products_json, true);
                    if (isset($products_data['data']) && !empty($products_data['data'])) {
                        foreach ($products_data['data'] as $product) {
                            echo "<tr>";
                            echo "<td>";
                            foreach ($product['images'] as $img) {
                                echo "<img src='" . $img . "' alt='Product Image' class='preview-image mb-2'>";
                            }
                            echo "</td>";
                            echo "<td>" . $product['name'] . "</td>";
                            echo "<td>" . $product['category'] . "</td>";
                            echo "<td>" . $product['created_at'] . "</td>";
                            echo "<td>";
                            echo "<a href='" . $api_base_url . "edit_product.php?id=" . $product['id'] . "' class='btn btn-sm btn-warning me-2'>Edit</a>";
                            echo "<a href='" . $api_base_url . "delete_product.php?id=" . $product['id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Yakin ingin menghapus?\");'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Tidak ada data products</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>