<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $stock = $_POST['stock'];

    $query = "UPDATE products SET stock = '$stock' WHERE id = '$id'";
    mysqli_query($conn, $query);
    header('Location: admin/admin_catalog.php');
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM products WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Edit Stock</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="main-content">
        <div class="container mt-5">
            <h2>Edit Stock</h2>
            <form action="update_stock.php" method="POST">
                <input type="hidden" name="id" value="<?= $product['id']; ?>">
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" class="form-control" id="stock" name="stock" value="<?= $product['stock']; ?>"
                        required>
                </div>
                <button type="submit" class="btn btn-primary">Update Stock</button>
            </form>
        </div>
    </div>
</body>

</html>