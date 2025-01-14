<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header('Content-Type: application/json');

// Koneksi ke database
$conn = new mysqli('localhost', 'rcrafted_blangkis', 'blangkisdb', 'rcrafted_blangkis');

// Periksa koneksi
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]));
}

// Ambil data dari POST request
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi input
if (empty($username) || empty($password)) {
    die(json_encode(["success" => false, "message" => "Username or password is missing."]));
}

// Periksa apakah username ada di database
$sql = "SELECT id, nama_lengkap, username, password FROM konsumen WHERE username = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die(json_encode(["success" => false, "message" => "Failed to prepare SQL statement: " . $conn->error]));
}

$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Bind hasil query ke variabel
    $stmt->bind_result($id, $nama_lengkap, $username_db, $password_hash);
    $stmt->fetch();

    // Verifikasi password
    if (password_verify($password, $password_hash)) {
        echo json_encode([
            "success" => true,
            "message" => "Login successful!",
            "data" => [
                "id" => $id,
                "nama_lengkap" => $nama_lengkap,
                "username" => $username_db
            ]
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid password."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Username not found."]);
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();
?>
