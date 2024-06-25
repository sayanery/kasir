<?php
session_start();
include '../db.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../index.php');
    exit;
}

// Mengambil data transaksi dari tabel transactions
$query = "SELECT t.id, p.name AS product_name, t.payment_method, t.created_at 
          FROM transactions t 
          JOIN products p ON t.product_id = p.id
          WHERE t.created_at >= DATE_SUB(NOW(), INTERVAL 1 WEEK)
          ORDER BY t.created_at DESC";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <title>Laporan Penjualan</title>
</head>

<body>
    <?php include 'admin_navbar.php'; ?>
    <div class="main-content">
        <div class="container mt-5">
            <h2>Laporan Penjualan Mingguan</h2>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Nama Produk</th>
                            <th>Metode Pembayaran</th>
                            <th>Tanggal Pembelian</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= $row['product_name']; ?></td>
                                <td><?= $row['payment_method']; ?></td>
                                <td><?= $row['created_at']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Tidak ada transaksi dalam satu minggu terakhir.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>