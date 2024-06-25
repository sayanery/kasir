<?php
session_start();
include 'peg_navbar.php'; // Pastikan file navbar.php dimuat di atas konten account.php
?>

<?php
session_start();
include '../db.php';

$error_message = '';

// Proses form login jika ada data yang dikirimkan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa username dan password
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['loggedin'] = true;
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
    } else {
        $error_message = 'Invalid username or password';
    }
}

// Jika sudah login, tampilkan halaman informasi akun dan formulir
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Account</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="../style.css">
    </head>

    <body>
        <?php include 'peg_navbar.php'; ?>
        <div class="main-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="card-title">Selamat Datang!</h2>
                                <p class="card-text">Selamat datang, <?php echo $_SESSION['username']; ?>!</p>
                                <hr>
                                <h5 class="card-subtitle mb-2 text-muted">Informasi Akun</h5>
                                <p>Nama Pengguna: <?php echo $_SESSION['username']; ?></p>
                                <p>Role: <?php echo $_SESSION['role']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>

    <?php
} else {
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    </head>

    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <h2 class="text-center">Login</h2>
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </body>

    </html>

    <?php
}
?>