<?php
// mengaktifkan session php
// menghubungkan dengan koneksi
// mengaktifkan session php
session_start();

// menghubungkan dengan koneksi
include 'config.php';

// menangkap data yang dikirim dari form
$username = $_POST['username'];
$password = $_POST['password'];

// menyeleksi data admin dengan username yang sesuai
$data = mysqli_query($mysqli, "SELECT * FROM user WHERE username='$username'");

// mengecek apakah ada data yang ditemukan
$user = mysqli_fetch_assoc($data);

if ($user) {
    // memeriksa apakah password yang diinputkan sesuai dengan password terenkripsi di database
    if (password_verify($password, $user['password'])) {
        // jika password cocok, set session dan redirect ke dashboard
        $_SESSION['username'] = $username;
        $_SESSION['status'] = "login";
        header("location:index.php");
    } else {
        // jika password tidak cocok
        header("location:login.php?pesan=gagal");
    }
} else {
    // jika username tidak ditemukan
    header("location:login.php?pesan=gagal");
}
