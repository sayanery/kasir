<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_method = $_POST['payment_method'];
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

    if ($cart) {
        // Mulai transaksi
        mysqli_begin_transaction($conn);

        try {
            foreach ($cart as $product_id => $quantity) {
                // Ambil informasi produk dan periksa stok
                $query = "SELECT * FROM products WHERE id = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, 'i', $product_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $product = mysqli_fetch_assoc($result);
                mysqli_stmt_close($stmt);

                if ($product && $product['stock'] >= $quantity) {
                    // Kurangi stok produk
                    $new_stock = $product['stock'] - $quantity;
                    $query = "UPDATE products SET stock = ? WHERE id = ?";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, 'ii', $new_stock, $product_id);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    // Tambahkan transaksi ke tabel transactions
                    $query = "INSERT INTO transactions (product_id, payment_method, created_at) VALUES (?, ?, NOW())";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, 'is', $product_id, $payment_method);

                    for ($i = 0; $i < $quantity; $i++) {
                        mysqli_stmt_execute($stmt);
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    // Batalkan transaksi jika stok tidak mencukupi
                    mysqli_rollback($conn);
                    echo "<script>alert('Stok produk tidak mencukupi.'); window.location.href = 'admin/admin_checkout.php';</script>";
                    exit;
                }
            }

            // Commit transaksi
            mysqli_commit($conn);

            // Kosongkan keranjang setelah checkout
            unset($_SESSION['cart']);
            echo "<script>alert('Pembayaran berhasil.'); window.location.href = 'admin/admin_dashboard.php';</script>";

        } catch (Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            mysqli_rollback($conn);
            echo "<script>alert('Terjadi kesalahan saat memproses pembayaran.'); window.location.href = 'admin/admin_checkout.php';</script>";
        }

    } else {
        echo "<script>alert('Keranjang belanja kosong.'); window.location.href = 'admin/admin_checkout.php';</script>";
    }
}
?>