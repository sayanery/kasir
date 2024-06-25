<?php
session_start();
include '../db.php';

$category = isset($_GET['category']) ? $_GET['category'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

$query = "SELECT * FROM products";
$conditions = [];

if ($category) {
    $conditions[] = "category = '$category'";
}
if ($search) {
    $conditions[] = "name LIKE '%$search%'";
}
if ($conditions) {
    $query .= " WHERE " . implode(' AND ', $conditions);
}

$result = mysqli_query($conn, $query);

$categories = ["makanan & minuman", "kebutuhan rumah tangga", "aksessoris", "persabunan"];

$success_message = isset($_GET['success']) ? $_GET['success'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <title>Katalog Produk</title>
</head>

<body>
    <?php include 'admin_navbar.php'; ?>
    <div class="main-content">
        <div class="container mt-5">
            <h2>Katalog Produk</h2>
            <?php if ($success_message): ?>
                    <div class="alert alert-success" role="alert">
                        <?= htmlspecialchars($success_message); ?>
                    </div>
                <?php endif; ?>
                <div class="form-row align-items-center mb-4">
                    <div class="col-auto">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Pilih Kategori
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="admin_catalog.php">Semua Kategori</a>
                                <?php foreach ($categories as $cat): ?>
                                    <a class="dropdown-item" href="admin_catalog.php?category=<?= urlencode($cat); ?>"><?= $cat; ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <form action="admin_catalog.php" method="GET" class="form-inline">
                            <input type="hidden" name="category" value="<?= $category; ?>">
                            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Cari produk"
                                aria-label="Search" value="<?= htmlspecialchars($search); ?>">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Cari</button>
                        </form>
                    </div>
                </div>
                <div class="mb-4">
                    <a href="add_product.php" class="btn btn-primary">Tambah Produk Baru</a>
                </div>
                <div class="row">
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card mb-4">
                                <img src="../assets/<?= $row['image']; ?>" class="card-img-top" alt="<?= $row['NAME']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $row['NAME']; ?></h5>
                                    <p class="card-text">Harga: Rp. <?= number_format($row['price'], 0, ',', '.'); ?></p>
                                    <p class="card-text">Stok: <?= $row['stock']; ?></p>
                                    <button class="btn btn-primary add-to-cart" data-id="<?= $row['id']; ?>">+</button>
                                    <a href="../update_stock.php?id=<?= $row['id']; ?>" class="btn btn-warning">Edit Stok</a>
                                    <a href="edit_product.php?id=<?= $row['id']; ?>" class="btn btn-secondary">Edit Produk</a>
                                    <a href="delete_product.php?id=<?= $row['id']; ?>" class="btn btn-danger">Hapus Produk</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </body>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.add-to-cart').click(function () {
                var productId = $(this).data('id');
                $.post('../add_to_cart.php', { product_id: productId }, function (response) {
                    alert(response.message);
                }, 'json');
            });

            // Display a success alert if redirected with a success message
            var successMessage = "<?= $success_message; ?>";
            if (successMessage) {
                alert(successMessage);
            }
        });
    </script>
</body>
    
</html>