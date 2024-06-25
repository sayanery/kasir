<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Dashboard</title>
    <style>
    .card-container {
    display: flex;
    gap: 20px;
    margin-top: 20px;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        text-align: center;
        transition: transform 0.3s, background-color 0.3s;
        width: 150px;
        background-color: #ffe6f2; /* Pink muda */
    }

    .card:hover {
        transform: scale(1.05);
        background-color: #ff99cc; /* Pink tua */
    }

    .card-link {
        color: inherit;
        text-decoration: none;
    }

    .card-body {
        padding: 20px;
    }

    .card-title {
        font-size: 18px;
        font-weight: bold;
        margin: 0;
    }
    </style>
</head>

<body>
    <?php include 'admin_navbar.php'; ?>
    <div class="main-content">
        <div class="container">
            <h1 class="mt-5">Dashboard</h1>
            <div class="card-container">
                <div class="card">
                    <a href="add_product.php" class="card-link">
                        <div class="card-body">
                            <h5 class="card-title">Add Product</h5>
                        </div>
                    </a>
                </div>
                <div class="card">
                    <a href="admin_catalog.php" class="card-link">
                        <div class="card-body">
                            <h5 class="card-title">Katalog</h5>
                        </div>
                    </a>
                </div>
                <div class="card">
                    <a href="admin_checkout.php" class="card-link">
                        <div class="card-body">
                            <h5 class="card-title">Keranjang</h5>
                        </div>
                    </a>
                </div>
                <div class="card">
                    <a href="admin_report.php" class="card-link">
                        <div class="card-body">
                            <h5 class="card-title">Laporan Penjualan</h5>
                        </div>
                    </a>
                </div>
                <div class="card">
                    <a href="../logout.php" class="card-link">
                        <div class="card-body">
                            <h5 class="card-title">Logout</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>