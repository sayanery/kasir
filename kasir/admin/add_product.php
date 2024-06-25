<?php
session_start();
include 'db.php';

$categories = ["makanan & minuman", "kebutuhan rumah tangga", "aksessoris", "persabunan"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['NAME'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];
    $image = $_FILES['image']['NAME'];

    $target_dir = "assets/";
    $target_file = $target_dir . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    $query = "INSERT INTO products (name, price, stock, category, image) VALUES ('$name', '$price', '$stock', '$category', '$image')";
    if (mysqli_query($conn, $query)) {
        header("Location: admin_catalog.php?success=Product added successfully");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <title>Tambah Produk</title>
</head>

<body>
    <?php include 'admin_navbar.php'; ?>
    <div class="main-content">
        <div class="container mt-5">
            <h2>Tambah Produk Baru</h2>
            <form action="add_product.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Nama Produk</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="price">Harga</label>
                    <input type="number" class="form-control" id="price" name="price" required>
                </div>
                <div class="form-group">
                    <label for="stock">Stok</label>
                    <input type="number" class="form-control" id="stock" name="stock" required>
                </div>
                <div class="form-group">
                    <label for="category">Kategori</label>
                    <select class="form-control" id="category" name="category" required>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat; ?>"><?= $cat; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="image">Gambar Produk</label>
                    <input type="file" class="form-control-file" id="image" name="image" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Produk</button>
            </form>
        </div>
    </div>
</body>

</html>