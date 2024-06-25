<?php
include ('../db.php');

$id = $_GET['id'];
$query = "DELETE FROM products WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if ($conn->query($sql) === TRUE) {
    echo "Item berhasil dihapus";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

mysqli_close($conn);
header("Location: admin_catalog.php?success=Produk berhasil dihapus");
exit();