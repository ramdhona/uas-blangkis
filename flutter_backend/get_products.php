<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Database connection settings
$servername = "localhost";
$username = "rcrafted_blangkis";
$password = "blangkisdb";
$dbname = "rcrafted_blangkis";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Base URL for images
$base_url = "https://blangkis.rcrafted.com/admin/assets/img/produk/";


// SQL query to fetch product data
$sql = "SELECT p.*, k.nama_kategori FROM produk p JOIN kategori k ON p.kategori_id = k.id";
$result = $conn->query($sql);

// Prepare products array
$products = [];
while ($row = $result->fetch_assoc()) {
    // Ensure that image URLs are properly encoded
    $row['gambar_produk'] = $base_url . str_replace(' ', '%20', $row['gambar_produk']);
    $products[] = $row;
}

// Return JSON-encoded response
echo json_encode($products);

// Close database connection
$conn->close();
?>
