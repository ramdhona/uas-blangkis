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
$nama_lengkap = $_POST['nama_lengkap'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi input
if (empty($nama_lengkap) || empty($username) || empty($password)) {
    die(json_encode(["success" => false, "message" => "Semua field harus diisi."]));
}

// Enkripsi password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Cek apakah username sudah terdaftar
$sql = "SELECT username FROM konsumen WHERE username = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die(json_encode(["success" => false, "message" => "Failed to prepare SQL statement: " . $conn->error]));
}

$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Username sudah terdaftar."]);
} else {
    // Menyimpan data ke dalam database
    $sql = "INSERT INTO konsumen (nama_lengkap, username, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die(json_encode(["success" => false, "message" => "Failed to prepare insert statement: " . $conn->error]));
    }

    $stmt->bind_param("sss", $nama_lengkap, $username, $hashed_password);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Registrasi berhasil!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Terjadi kesalahan saat registrasi."]);
    }
}

// Tutup statement dan koneksi
$stmt->close();
$conn->close();
?>
