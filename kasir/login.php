<?php
session_start();
include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    if ($password === $user['password']) {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'Kasir') {
            header('Location: peg/peg_dashboard.php');
        } elseif ($user['role'] === 'Admin') {
            header('Location: admin/admin_dashboard.php');
        }
        exit;
    } else {
        $_SESSION['error_message'] = 'Password salah.';
        header('Location: index.php');
        exit;
    }
} else {
    $_SESSION['error_message'] = 'Invalid username or password';
    header('Location: index.php');
    exit;
}
?>