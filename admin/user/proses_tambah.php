<?php
include "../config.php"; // Pastikan file konfigurasi koneksi sudah benar

// Cek tombol tambah sudah diklik atau belum
if (isset($_POST['tambah'])) {

    // Ambil data dari form tambah
    $nama = $_POST['nama'];  // Ambil nama lengkap
    $username = $_POST['username'];          // Ambil username
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // Enkripsi password

    // Buat query untuk menambahkan data ke tabel user
    $sql = "INSERT INTO user (nama, username, password) VALUES ('$nama', '$username', '$password')";

    // Eksekusi query
    $query = mysqli_query($mysqli, $sql);

    // Cek apakah query simpan data berhasil
    if ($query) {
        // Jika berhasil alihkan ke index.php dengan status sukses
        header('Location: index.php?aksi=tambah_data&status=berhasil');
    } else {
        // Jika gagal tampilkan error
        echo "Error: " . mysqli_error($mysqli);
    }
} else {
    die("Akses Dilarang");
}
?>
