<?php
session_start();

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $action = $_POST['action'];

    if (isset($_SESSION['cart'][$product_id])) {
        if ($action === 'increase') {
            $_SESSION['cart'][$product_id]++;
        } elseif ($action === 'decrease') {
            $_SESSION['cart'][$product_id]--;
            if ($_SESSION['cart'][$product_id] <= 0) {
                unset($_SESSION['cart'][$product_id]);
            }
        } elseif ($action === 'remove') {
            unset($_SESSION['cart'][$product_id]);
        }
    }

    $response['success'] = true;
}

echo json_encode($response);
?>