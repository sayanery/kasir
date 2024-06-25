<?php
session_start();
include '../db.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: ../index.php');
    exit;
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$products = [];
if ($cart) {
    $ids = implode(',', array_keys($cart));
    $query = "SELECT * FROM products WHERE id IN ($ids)";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <title>Checkout</title>
</head>

<body>
    <?php include 'peg_navbar.php'; ?>
    <div class="main-content">
        <div class="container mt-5">
            <h2>Keranjang Belanja</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product['NAME']; ?></td>
                            <td>Rp. <?= number_format($product['price'], 0, ',', '.'); ?></td>
                            <td>
                                <button class="btn btn-secondary update-cart" data-id="<?= $product['id']; ?>"
                                    data-action="decrease">-</button>
                                <?= $cart[$product['id']]; ?>
                                <button class="btn btn-secondary update-cart" data-id="<?= $product['id']; ?>"
                                    data-action="increase">+</button>
                            </td>
                            <td>Rp. <?= number_format($product['price'] * $cart[$product['id']], 0, ',', '.'); ?></td>
                            <td>
                                <button class="btn btn-danger update-cart" data-id="<?= $product['id']; ?>"
                                    data-action="remove">Hapus</button>
                            </td>
                        </tr>
                        <?php $total += $product['price'] * $cart[$product['id']]; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3>Total: Rp. <?= number_format($total, 0, ',', '.'); ?></h3>
            <form action="../checkout_process.php" method="post">
                <div class="form-group">
                    <label for="payment_method">Metode Pembayaran:</label>
                    <select class="form-control" id="payment_method" name="payment_method" required>
                        <option value="cash">Cash</option>
                        <option value="debit">Debit</option>
                        <option value="qris">QRIS</option>
                        <option value="credit">Kredit</option>
                    </select>
                </div>
                <div class="form-group" id="payment_amount_group">
                    <label for="payment_amount">Nominal Pembayaran:</label>
                    <input type="number" class="form-control" id="payment_amount" name="payment_amount">
                </div>
                <h3 id="change_display">Kembalian: Rp. 0</h3>
                <button type="submit" class="btn btn-primary">Bayar</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {
            function togglePaymentAmount() {
                if ($('#payment_method').val() === 'cash') {
                    $('#payment_amount_group').show();
                } else {
                    $('#payment_amount_group').hide();
                    $('#payment_amount').val('');
                    $('#change_display').text('Kembalian: Rp. 0');
                }
            }

            togglePaymentAmount();

            $('.update-cart').click(function () {
                var productId = $(this).data('id');
                var action = $(this).data('action');
                $.post('../update_cart.php', { product_id: productId, action: action }, function (response) {
                    location.reload();
                }, 'json');
            });

            $('#payment_method').change(function () {
                togglePaymentAmount();
            });

            $('#payment_amount').on('input', function () {
                var total = <?= $total; ?>;
                var paymentAmount = parseFloat($(this).val());
                var change = paymentAmount - total;
                $('#change_display').text('Kembalian: Rp. ' + new Intl.NumberFormat('id-ID').format(change));
            });
        });
    </script>
</body>

</html>