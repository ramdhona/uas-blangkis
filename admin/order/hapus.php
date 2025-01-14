<?php
include '../header.php';
include '../config.php'; // File koneksi database

// Periksa apakah `id` diberikan melalui URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID tidak ditemukan!";
    exit;
}

// Ambil ID dari URL
$purchase_id = $_GET['id'];

// Query untuk menghapus data pembelian berdasarkan ID
$sql = "DELETE FROM purchase_history WHERE purchase_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $purchase_id);

if ($stmt->execute()) {
    echo "<script>
            alert('Data berhasil dihapus!');
            window.location.href = 'index.php';
          </script>";
} else {
    echo "<script>alert('Gagal menghapus data!');</script>";
}

?>
