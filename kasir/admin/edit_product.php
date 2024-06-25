<?php
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];

    $query = "UPDATE products SET name = '$name', price = '$price', category = '$category', stock = '$stock' WHERE id = '$id'";
    mysqli_query($conn, $query);
    header('Location: admin_catalog.php');
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM products WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);
$categories = ["makanan & minuman", "kebutuhan rumah tangga", "aksessoris", "persabunan"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <?php include 'admin_navbar.php'; ?>
    <div class="main-content">
        <div class="container mt-5">
            <h2>Edit Produk</h2>
            <form action="edit_product.php" method="POST">
                <input type="hidden" name="id" value="<?= $product['id']; ?>">
                <div class="form-group">
                    <label for="name">Nama Produk</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= $product['NAME']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="price">Harga</label>
                    <input type="number" class="form-control" id="price" name="price" value="<?= $product['price']; ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="category">Kategori</label>
                    <select class="form-control" id="category" name="category">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat; ?>" <?= $cat === $product['category'] ? 'selected' : ''; ?>><?= $cat; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock" value="<?= $product['stock']; ?>"
                        required>
                </div>
                <button type="submit" class="btn btn-primary">Update Produk</button>
            </form>
        </div>
    </div>
</body>

</html>