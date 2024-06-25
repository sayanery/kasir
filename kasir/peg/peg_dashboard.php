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
    <link rel="stylrsheet" href="../style.css">
    <title>Dashboard</title>
</head>

<body>
    <?php include 'peg_navbar.php'; ?>
    <div class="main-content">
        <div class="container">
            <h1 class="mt-5">Dashboard</h1>
            <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title">Selamat Datang! <?php echo $_SESSION['username']; ?>!</p></h2>                                <p class="card-text">Selamat datang, 
                            <hr>
                            <a href="peg_checkout.php" class="btn btn-primary">Checkout</a>
                            <a href="../logout.php" class="btn btn-danger">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>