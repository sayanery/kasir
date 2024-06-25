<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Sidebar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css">
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <nav class="navbar">
        <div class="logo">
            <i class="bx bx-menu" id="sidebarOpen" aria-label="Open sidebar"></i>
            <img src="../assets/LOGOSAYA.png" alt="Logo" style="height: 50px; margin-left: 10px;">
        </div>
    </nav>

    <nav class="sidebar">
        <div class="menu_content">
            <ul class="menu_items">
                <li class="menu_item">
                    <a href="admin_dashboard.php" class="nav_link">
                        <span class="navlink_icon">
                            <i class="bx bx-home"></i>
                        </span>
                        <span class="navlink">Home</span>
                    </a>
                </li>
                <li class="menu_item">
                    <a href="admin_catalog.php" class="nav_link">
                        <span class="navlink_icon">
                            <i class="bx bx-cog"></i>
                        </span>
                        <span class="navlink">Katalog</span>
                    </a>
                </li>
                <li class="menu_item">
                    <a href="admin_checkout.php" class="nav_link">
                        <span class="navlink_icon">
                            <i class="bx bx-layer"></i>
                        </span>
                        <span class="navlink">Keranjang</span>
                    </a>
                </li>
                <li class="menu_item">
                    <a href="admin_report.php" class="nav_link">
                        <span class="navlink_icon">
                            <i class="bx bx-layer"></i>
                        </span>
                        <span class="navlink">Laporan</span>
                    </a>
                </li>
                <li class="menu_item">
                    <a href="admin_account.php" class="nav_link">
                        <span class="navlink_icon">
                            <i class="bx bx-cloud-upload"></i>
                        </span>
                        <span class="navlink">Akun</span>
                    </a>
                </li>
                <li class="menu_item" style="margin-top: auto;">
                    <a href="../logout.php" class="nav_link">
                        <span class="navlink_icon">
                            <i class="bx bx-log-out"></i>
                        </span>
                        <span class="navlink">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <script src="../script.js"></script>
</body>

</html>
